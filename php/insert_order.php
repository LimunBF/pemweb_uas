<?php
// Start session
session_start();

// Cek apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['user_id']); // Cek apakah sesi user_id ada

if (!$isLoggedIn) {
    die("Anda harus login terlebih dahulu.");
}

// Ambil data dari frontend
$data = json_decode(file_get_contents('php://input'), true);

// Pastikan data tiket yang valid
if (!isset($data['tickets']) || empty($data['tickets'])) {
    die("Data tiket tidak valid.");
}

// Koneksi ke database
include_once '../connection/connect.php';
try {
    $pdo = getDatabaseConnection();
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Ambil data user_id dan hitung total harga
$user_id = $_SESSION['user_id'];
$total_price = 0;

foreach ($data['tickets'] as $ticket) {
    $ticket_id = $ticket['ticket_id'];
    $quantity = $ticket['quantity'];

    // Ambil harga tiket berdasarkan ticket_id
    $sql = "SELECT price FROM tickets WHERE ticket_id = :ticket_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['ticket_id' => $ticket_id]);
    $ticket_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ticket_data) {
        $total_price += $ticket_data['price'] * $quantity;
    }
}

// Insert data ke tabel orders
try {
    $sql = "INSERT INTO orders (user_id, total_price, payment_status, created_at, updated_at) 
            VALUES (:user_id, :total_price, 'completed', NOW(), NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'user_id' => $user_id,
        'total_price' => $total_price,
    ]);

    // Ambil order_id yang baru saja dimasukkan
    $order_id = $pdo->lastInsertId();

    // Beri respons sukses
    echo json_encode(['success' => true, 'order_id' => $order_id]);
} catch (PDOException $e) {
    // Beri respons error
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan order: ' . $e->getMessage()]);
}

// Beri response bahwa data telah berhasil disimpan
//echo json_encode(['success' => true, 'order_id' => $order_id]);
?>