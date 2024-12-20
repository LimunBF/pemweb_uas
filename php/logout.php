<?php
// Mulai sesi
session_start();

// Hapus semua variabel sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect pengguna ke halaman login
header("Location: ../index.php");
exit();
