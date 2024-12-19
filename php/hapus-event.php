<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna memiliki peran admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["success" => false, "error" => "Akses ditolak."]);
    exit();
}

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loket_com";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Koneksi ke database gagal: " . $conn->connect_error]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id']) && is_numeric($_POST['event_id'])) {
    $event_id = (int) $_POST['event_id'];

    // Gunakan prepared statement
    $stmt = $conn->prepare("DELETE FROM events WHERE event_id = ? LIMIT 1");
    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Kesalahan saat menghapus event: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Permintaan tidak valid."]);
}

$conn->close();
