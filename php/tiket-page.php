<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['user_id']); // Cek apakah sesi user_id ada
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judul Konser</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/navbar_footer.css">
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" href="../css/tiket-page.css">
</head>
<body>

<!--KONEKSI KE DATABASE-->
<?php
// Sertakan file koneksi
include '../connection/connect.php';

try {
    // Mendapatkan koneksi database
    $pdo = getDatabaseConnection();
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>

<!-- HEADER DAN NAVIGASI -->
<header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand fw-bold" href="#">LOKÉT</a>
                <!-- Search Bar -->
                <div class="mx-auto" style="width: 40%;">
                    <div class="input-group">
                        <input type="text" class="form-control search-bar" placeholder="Cari event seru di sini"
                            id="searchInput" aria-label="Search">
                        <button class="btn btn-primary" type="button">
                            <img src="https://cdn-icons-png.flaticon.com/512/54/54481.png" alt="Cari" width="16" height="16">
                        </button>
                    </div>
                </div>

                <!-- Menu Kanan -->
                <div class="d-flex align-items-center">
                    <!-- Buat Event -->
                    <a href="#" class="icon-link me-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Buat Event">
                        Buat Event
                    </a>

                    <!-- Jelajah -->
                    <a href="#" class="icon-link me-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/2991/2991114.png" alt="Jelajah">
                        Jelajah
                    </a>

                    <?php if (!$isLoggedIn): ?>
                        <!-- Daftar dan Masuk -->
                        <a href="../php/register.php" class="btn btn-outline-light me-2">Daftar</a>
                        <a href="../php/login.php" class="btn btn-primary">Masuk</a>
                    <?php else: ?>
                        <!-- Profile Dropdown -->
                        <div class="dropdown">
                            <a href="#" class="d-block" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle fa-2x text-white"></i> <!-- Profile Icon -->
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-header">Profil Anda</li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Tiket Saya</a></li>
                                <li><a class="dropdown-item" href="#">Informasi Dasar</a></li>
                                <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                                <li><a class="dropdown-item text-danger" href="php/logout.php">Keluar</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
</header>

<!-- MAIN CONTENT -->
<div class="container py-4">
<main class="flex-grow-1 container my-4">
    <div class="row gx-4 gy-4 align-items-stretch">
        <!-- Judul Konser dan Banner -->
        <div class="col-md-8">
            <div class="bg-light p-4 rounded">
                <h1 class="fw-bold">Judul Konser</h1>
                <img src="assets/image-placeholder.png" class="img-fluid rounded mt-3" alt="Banner Konser">
            </div>
        </div>

        <!-- Deskripsi Konser -->
        <div class="col-md-4">
            <div class="bg-light p-4 rounded shadow">
                <h3 class="fw-bold mb-3">Deskripsi</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam facilisis leo id augue ullamcorper vulputate. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                <button class="btn btn-gradient mt-3 px-4"  onclick="window.location.href='detail-tiket.php'">Beli Tiket</button>
            </div>
        </div>
    </div>
</main>
</div>

<!-- FOOTER -->
<footer>
        <div class="footer">
            <!-- Keamanan dan Privasi -->
            <h5 class="text-white mb-3">Keamanan dan Privasi</h5>
            <img src="assets/images/logo_bsi.png" alt="Logo BSI" class="mb-4">

            <!-- Social Media Icons -->
            <div class="footer-icons">
                <a href="#" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="#" target="_blank"><i class="bi bi-tiktok"></i></a>
                <a href="#" target="_blank"><i class="bi bi-x"></i></a>
                <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                <a href="#" target="_blank"><i class="bi bi-youtube"></i></a>
                <a href="#" target="_blank"><i class="bi bi-facebook"></i></a>
            </div>
        </div>

        <!-- Footer Bottom Section -->
        <div class="footer-bottom">
            <div class="container">
                <div div class="d-inline-flex flex-wrap justify-content-center align-items-center" style="gap: 10px;">
                    <a href="php/our-team.php" style="text-decoration: none; color: #d1d9e6;">Tentang Kami</a>
                    <span>•</span>
                    <a href="#" style="text-decoration: none; color: #d1d9e6;">Blog</a>
                    <span>•</span>
                    <a href="#" style="text-decoration: none; color: #d1d9e6;">Kebijakan Privasi</a>
                    <span>•</span>
                    <a href="#" style="text-decoration: none; color: #d1d9e6;">Kebijakan Cookie</a>
                    <span>•</span>
                    <a href="#" style="text-decoration: none; color: #d1d9e6;">Panduan</a>
                    <span>•</span>
                    <a href="#" style="text-decoration: none; color: #d1d9e6;">Hubungi Kami</a>
                </div>
                <p class="mb-0 mt-2">&copy; 2024 Loket (PT Global Loket Sejahtera)</p>
            </div>
        </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../javascript/navbar.js"></script>
</body>
</html>
