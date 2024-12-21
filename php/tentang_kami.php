<?php
    session_start();
    $isLoggedIn = isset($_SESSION['user_id']);
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
    <link rel="stylesheet" type="text/css" href="css/navbar_footer.css">

    <style>
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                             url('assets/images/about-hero.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
            position: relative;
        }

        .breadcrumb {
            background: transparent;
        }

        .breadcrumb-item a {
            color: white;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #fff;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: white;
        }

        .content-section {
            padding: 50px 0;
        }

        .content-section p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .feature-list {
            margin-top: 20px;
            padding-left: 20px;
        }

        .feature-list li {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="index.php">LOKÉT</a>

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
            <div class="d-flex align-items-center justify-content-end">
                <!-- Jelajah -->
                <a href="#" class="icon-link me-3 d-flex align-items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/2991/2991114.png" alt="Jelajah" class="me-1">
                    Jelajah
                </a>

                <!-- Daftar dan Masuk -->
                <a href="php/register.php" class="btn btn-outline-light me-2">Daftar</a>
                <a href="php/login.php" class="btn btn-primary">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tentang Kami</li>
                </ol>
            </nav>
            <h1 class="display-4 fw-bold mb-4">TENTANG KAMI</h1>
            <p class="lead">LOKÉT merupakan teknologi asal Indonesia yang memiliki misi memberikan teknologi digital bagi penyelenggara event dari berbagai skala.</p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="container">
            <p>LOKÉT adalah platform yang memiliki Ticketing Management Service (TMS) teknologi unggul dalam mendukung seluruh penyelenggaraan event mulai dari distribusi & manajemen tiket, hingga penyediaan laporan analisa event di akhir acara.</p>
            
            <p>Beberapa teknologi yang kami sediakan siap untuk memfasilitasi penyelenggara event dalam setiap tahap persiapan yang meliputi:</p>
            
            <ul class="feature-list">
                <li>Distributor tiket terlengkap yang telah bekerja sama dengan LOKÉT untuk menjual tiket Anda.</li>
                <li>Sistem pembayaran yang beragam dan aman memberikan kemudahan kepada calon pembeli, untuk mendapatkan konversi yang lebih tinggi.</li>
                <li>Gate management yang paling aman dan nyaman untuk akses saat event berlangsung. Sehingga, event dengan jumlah penonton yang besar dapat ditangani dengan mudah.</li>
                <li>Sistem analisis data yang lengkap dan komprehensif setelah acara berlangsung untuk memudahkan penyelenggara event dalam merumuskan strategi event selanjutnya.</li>
            </ul>

            <p class="mt-4">Sudah ada ratusan event yang bekerja sama dengan kami dan semuanya tersebar di seluruh Indonesia. Kini, saatnya meramaikan event Anda pada dunia untuk membawa penonton yang lebih banyak lagi bersama kami!</p>
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
                        <img src="assets/images/logo_bsi.png" alt="Logo BSI" class="mt-2 mb-4">
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
