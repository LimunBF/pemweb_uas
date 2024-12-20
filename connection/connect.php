<?php
function getDatabaseConnection() {
    // Konfigurasi database
    $host = 'localhost'; // Host database
    $dbName = 'loket_com'; // Nama database
    $username = 'root'; // Username database
    $password = ''; // Password database

    try {
        // Membuat koneksi menggunakan PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $username, $password);

        // Mengatur mode error PDO ke Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Mengatur mode fetch default ke associative array
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Mengembalikan objek PDO jika koneksi berhasil
        return $pdo;
    } catch (PDOException $e) {
        // Menangani kesalahan koneksi dan menampilkan pesan
        die('Koneksi ke database gagal: ' . $e->getMessage());
    }
}
?>