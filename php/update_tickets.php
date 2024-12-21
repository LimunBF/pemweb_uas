<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data JSON yang dikirim oleh JavaScript
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['tickets']) || empty($data['tickets'])) {
        echo json_encode(['success' => false, 'message' => 'Data tiket tidak valid.']);
        exit;
    }

    // Sertakan koneksi ke database
    include_once '../connection/connect.php';

    try {
        $pdo = getDatabaseConnection();
        $pdo->beginTransaction();

        foreach ($data['tickets'] as $ticket) {
            $ticket_id = $ticket['ticket_id'];
            $quantity = (int)$ticket['quantity'];

            if ($quantity > 0) {
                // Perbarui quantity_available di database
                $sql = "UPDATE tickets SET quantity_available = quantity_available - :quantity WHERE ticket_id = :ticket_id AND quantity_available >= :quantity";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'quantity' => $quantity,
                    'ticket_id' => $ticket_id,
                ]);

                if ($stmt->rowCount() === 0) {
                    // Rollback jika ada kesalahan (misalnya stok tidak cukup)
                    $pdo->rollBack();
                    echo json_encode(['success' => false, 'message' => "Stok tiket tidak mencukupi untuk tiket ID: $ticket_id."]);
                    exit;
                }
            }
        }

        $pdo->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Rollback jika terjadi kesalahan
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid.']);
}
?>
