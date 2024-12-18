<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/navbar_footer.css">
</head>

<body>
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
                            <img src="https://cdn-icons-png.flaticon.com/512/54/54481.png" alt="Cari" width="16"
                                height="16">
                        </button>
                    </div>
                </div>

                <!-- Menu Kanan -->
                <div class="d-flex align-items-center">
                    <!-- Buat Event -->
                    <a href="#" class="icon-link">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Buat Event">
                        Buat Event
                    </a>

                    <!-- Jelajah -->
                    <a href="#" class="icon-link">
                        <img src="https://cdn-icons-png.flaticon.com/512/2991/2991114.png" alt="Jelajah">
                        Jelajah
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="d-block" id="dropdownMenuButton" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fas fa-user-circle fa-2x text-white"></i> <!-- Profile Icon -->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li class="dropdown-header">Beralih ke akun</li>
                            <li><a class="dropdown-item" href="#">Pembeli</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Dashboard</a></li>
                            <li><a class="dropdown-item" href="#">Event Saya</a></li>
                            <li><a class="dropdown-item" href="#">Informasi Dasar</a></li>
                            <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                            <li><a class="dropdown-item" href="#">Rekening</a></li>
                            <li><a class="dropdown-item text-danger" href="#">Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Hashtags -->
        <div class="py-2 bg-dark text-center">
            <a href="#" class="text-light text-decoration-none mx-2">#Promo_Indodana</a>
            <a href="#" class="text-light text-decoration-none mx-2">#LOKETScreen</a>
            <a href="#" class="text-light text-decoration-none mx-2">#LOKET_Promo</a>
            <a href="#" class="text-light text-decoration-none mx-2">#LoketAttraction</a>
            <a href="#" class="text-light text-decoration-none mx-2">#CigarettesAfterSex</a>
            <a href="#" class="text-light text-decoration-none mx-2">#KeshiTour</a>
        </div>
    </header>

    <div style="height: 100vh;">

    </div>

    <!-- Footer -->
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

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="javascript/navbar.js"></script>
</body>

</html>