<?php
session_start(); 
$isLoggedIn = isset($_SESSION['user_id']); 

// Include the database connection file
include_once '../connection/connect.php';

// Get the database connection
$pdo = getDatabaseConnection();

// Query untuk mengambil events
$stmt = $pdo->prepare("SELECT event_id, title, event_date, location, organizer_name, event_image_path FROM events LIMIT 10");
$stmt->execute();
$events = $stmt->fetchAll();

// Periksa apakah pengguna sudah login
if ($isLoggedIn) {
    // Ambil user_id dari session
    $userId = $_SESSION['user_id'];

    // Query untuk mengambil nama pengguna berdasarkan user_id
    $stmtUser = $pdo->prepare("SELECT name FROM users WHERE user_id = :user_id LIMIT 1");
    $stmtUser->execute(['user_id' => $userId]);
    $user = $stmtUser->fetch();

    // Pastikan nama pengguna ditemukan
    $userName = $user ? htmlspecialchars($user['name']) : 'Pengguna';
} else {
    $userName = null;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - LOKÉT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/navbar_footer.css">
    <link rel="stylesheet" type="text/css" href="../css/tentang_kami.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="../index.php">BÉLI TIKÉT</a>

            <!-- Search Bar -->
            <div class="mx-auto" style="width: 40%;">
                <div class="input-group">
                    <input type="text" class="form-control search-bar" placeholder="Cari event seru di sini"
                        id="searchInput" aria-label="Search">
                    <button class="btn btn-primary d-flex align-items-center justify-content-center" type="button" style="width: 40px;">
                        <img src="https://cdn-icons-png.flaticon.com/512/54/54481.png" alt="Cari" width="16" height="16">
                    </button>
                </div>
            </div>

            <!-- Menu Kanan -->
            <div class="d-flex align-items-center gap-3">
                <!-- Jelajah -->
                <a href="../jelajah.php" class="btn btn-outline-light d-flex align-items-center gap-2 px-3">
                    <i class="bi bi-compass"></i>
                    <span>Jelajah</span>
                </a>

                <?php if (!$isLoggedIn): ?>
                <!-- Daftar dan Masuk -->
                <a href="register.php" class="btn btn-outline-light px-3">Daftar</a>
                <a href="login.php" class="btn btn-primary px-3">Masuk</a>
                <?php else: ?>
                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <a href="#" class="btn btn-light d-flex align-items-center gap-2 px-3" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user-circle fa-lg"></i>
                        <span><?php echo $userName ? htmlspecialchars($userName) : 'Profil'; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li class="dropdown-header">Halo, <?php echo $userName ? htmlspecialchars($userName) : 'Pengguna'; ?></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Tiket Saya</a></li>
                        <li><a class="dropdown-item" href="profile.php">Informasi Dasar</a></li>
                        <li><a class="dropdown-item" href="pengaturan.php">Pengaturan</a></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">Keluar</a></li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tentang Kami</li>
                </ol>
            </nav>
            <?php
            // Membaca isi file hero_text.txt
            echo file_get_contents('../file_txt/hero_text.txt');
            ?>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="container">
            <h2>Mengapa Memilih Kami?</h2>
            <?php
            // Membaca isi file content.txt
            $content = file_get_contents('../file_txt/content_text.txt');
            echo $content;
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>    
        <div class="footer">
            <div class="container">
                <div class="row">
                    <!-- Keamanan dan Privasi -->
                    <div class="security-section text-center mt-4">
                        <h5>Keamanan dan Privasi</h5>
                        <img src="../assets/images/logo_bsi.png" alt="Logo BSI" class="mt-2 mb-4">
                    </div>

                    <!-- Social Media Icons -->
                    <div class="social-media-section text-center">
                        <h5>Ikuti Kami</h5>
                        <div class="social-icons mt-3">
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-tiktok"></i></a>
                            <a href="#"><i class="bi bi-twitter-x"></i></a>
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                            <a href="#"><i class="bi bi-youtube"></i></a>
                            <a href="#"><i class="bi bi-facebook"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-links">
                    <a href="tentang_kami.php">Tentang Kami</a>
                    <span>•</span>
                    <a href="#">Blog</a>
                    <span>•</span>
                    <a href="#">Kebijakan Privasi</a>
                    <span>•</span>
                    <a href="#">Kebijakan Cookie</a>
                    <span>•</span>
                    <a href="#">Panduan</a>
                    <span>•</span>
                    <a href="#">Hubungi Kami</a>
                </div>
                <p class="copyright">&copy; 2024 Loket (PT Global Loket Sejahtera)</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
