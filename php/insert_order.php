<?php
// Start session
session_start();

// Ambil data dari frontend
$data = json_decode(file_get_contents('php://input'), true);

// Validasi data tiket
if (!isset($data['tickets']) || empty($data['tickets'])) {
    die(json_encode(['success' => false, 'message' => 'Data tiket tidak valid.']));
}

// Cek apakah pengguna login
$isLoggedIn = isset($_SESSION['user_id']);

// Ambil informasi pengguna jika tidak login
if (!$isLoggedIn) {
    $user_name = $data['user_name'] ?? null;
    $email = $data['email'] ?? null;

    if (!$user_name || !$email) {
        die(json_encode(['success' => false, 'message' => 'Nama dan email diperlukan untuk pengguna tanpa login.']));
    }
}

// Koneksi ke database
include_once '../connection/connect.php';
try {
    $pdo = getDatabaseConnection();
} catch (PDOException $e) {
    die(json_encode(['success' => false, 'message' => 'Koneksi gagal: ' . $e->getMessage()]));
}

$total_price = 0;

// Ambil semua ticket_id dari data yang diterima
$ticket_ids = array_column($data['tickets'], 'ticket_id');

// Ambil data tiket dari database
$sql = "SELECT ticket_id, event_id, price FROM tickets WHERE ticket_id IN (" . implode(',', array_fill(0, count($ticket_ids), '?')) . ")";
$stmt = $pdo->prepare($sql);
$stmt->execute($ticket_ids);
$ticket_data_map = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $ticket_data_map[$row['ticket_id']] = $row;
}

// Hitung total harga dan validasi tiket
foreach ($data['tickets'] as $ticket) {
    $ticket_id = $ticket['ticket_id'];
    $quantity = $ticket['quantity'];

    if (isset($ticket_data_map[$ticket_id]) && $quantity > 0) {
        $total_price += $ticket_data_map[$ticket_id]['price'] * $quantity;
    } else {
        die(json_encode(['success' => false, 'message' => "Tiket dengan ID $ticket_id tidak valid."]));
    }
}

// Mulai transaksi
$pdo->beginTransaction();

try {
    // Buat entry ke tabel orders
    if ($isLoggedIn) {
        // Untuk pengguna login
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO orders (user_id, total_price, payment_status, created_at, updated_at) 
                VALUES (:user_id, :total_price, 'completed', NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'total_price' => $total_price,
        ]);
        $order_id = $pdo->lastInsertId();
    } else {
        // Untuk pengguna tanpa login
        $sql = "INSERT INTO orders (user_id, total_price, payment_status, created_at, updated_at) 
                VALUES (NULL, :total_price, 'completed', NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'total_price' => $total_price,
        ]);
        $order_id = $pdo->lastInsertId();
    }

    // Insert ke tabel purchase_history atau purchase_history_nl
    if ($isLoggedIn) {
        $sql = "INSERT INTO purchase_history (user_id, order_id, event_id, ticket_id, purchase_date, quantity, total_price) 
                VALUES (:user_id, :order_id, :event_id, :ticket_id, NOW(), :quantity, :total_price)";
    } else {
        $sql = "INSERT INTO purchase_history_nl (user_name, email, order_id, event_id, ticket_id, purchase_date, quantity, total_price) 
                VALUES (:user_name, :email, :order_id, :event_id, :ticket_id, NOW(), :quantity, :total_price)";
    }
    $stmt = $pdo->prepare($sql);

    foreach ($data['tickets'] as $ticket) {
        $ticket_id = $ticket['ticket_id'];
        $quantity = $ticket['quantity'];

        $ticket_data = $ticket_data_map[$ticket_id];
        $event_id = $ticket_data['event_id'];
        $price = $ticket_data['price'];
        $total_price_per_ticket = $price * $quantity;

        if ($isLoggedIn) {
            $stmt->execute([
                'user_id' => $user_id,
                'order_id' => $order_id,
                'event_id' => $event_id,
                'ticket_id' => $ticket_id,
                'quantity' => $quantity,
                'total_price' => $total_price_per_ticket,
            ]);
        } else {
            $stmt->execute([
                'user_name' => $user_name,
                'email' => $email,
                'order_id' => $order_id, // Ini diambil dari tabel orders
                'event_id' => $event_id,
                'ticket_id' => $ticket_id,
                'quantity' => $quantity,
                'total_price' => $total_price_per_ticket,
            ]);
        }
    }

    // Commit transaksi
    $pdo->commit();

    // Respons sukses
    echo json_encode(['success' => true, 'order_id' => $order_id]);
} catch (PDOException $e) {
    // Rollback jika terjadi error
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data: ' . $e->getMessage()]);
}
?>
