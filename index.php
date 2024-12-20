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
    <link rel="stylesheet" type="text/css" href="css/home.css">
</head>

<body>
    <?php 
        session_start(); 
        $isLoggedIn = isset($_SESSION['user_id']); 
    ?>

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
                        <a href="#" class="d-block" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-2x text-white"></i> <!-- Profile Icon -->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <?php if ($isLoggedIn): ?>
                                <li class="dropdown-header">Beralih ke akun</li>
                                <li><a class="dropdown-item" href="#">Pembeli</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Profil Saya</a></li>
                                <li><a class="dropdown-item" href="#">Dashboard</a></li>
                                <li><a class="dropdown-item" href="#">Event Saya</a></li>
                                <li><a class="dropdown-item" href="#">Informasi Dasar</a></li>
                                <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                                <li><a class="dropdown-item" href="#">Rekening</a></li>
                                <li><a class="dropdown-item text-danger" href="php/logout.php">Keluar</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="login.php">Masuk</a></li>
                                <li><a class="dropdown-item" href="register.php">Daftar</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container py-4">

        <!-- Header Carousel -->
        <div id="headerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#headerCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#headerCarousel" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#headerCarousel" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>

            <!-- Carousel Items -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/carousel1.png" class="d-block w-100" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/carousel2.png" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/carousel3.png" class="d-block w-100" alt="Slide 3">
                </div>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#headerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#headerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Event Pilihan Section -->
        <h3 class="fw-bold mb-4">Event Pilihan</h3>
        <div class="row g-4">
            <!-- Event Card 1 -->
            <div class="col-md-3">
                <div class="card event-card">
                    <img src="assets/images/event1.png" class="card-img-top" alt="Event 1">
                    <div class="card-body">
                        <h6 class="card-title fw-bold">WHISKY LIVE JAKARTA 2025</h6>
                        <p class="card-text mb-1 text-muted">01 Feb - 02 Feb 2025</p>
                        <p class="fw-bold mb-2">Rp350.000</p>
                        <small class="text-muted">Caledonia Live</small>
                    </div>
                </div>
            </div>

            <!-- Event Card 2 -->
            <div class="col-md-3">
                <div class="card event-card">
                    <img src="assets/images/event2.png" class="card-img-top" alt="Event 2">
                    <div class="card-body">
                        <h6 class="card-title fw-bold">CINTA KALA SENJA - BERNADYA</h6>
                        <p class="card-text mb-1 text-muted">18 Dec 2024</p>
                        <p class="fw-bold mb-2">Rp299.000</p>
                        <small class="text-muted">Bengkel Space</small>
                    </div>
                </div>
            </div>

            <!-- Event Card 3 -->
            <div class="col-md-3">
                <div class="card event-card">
                    <img src="assets/images/event3.png" class="card-img-top" alt="Event 3">
                    <div class="card-body">
                        <h6 class="card-title fw-bold">HOLIMOON 2024</h6>
                        <p class="card-text mb-1 text-muted">23 Dec 2024</p>
                        <p class="fw-bold mb-2">Rp125.000</p>
                        <small class="text-muted">Deal Indonesia</small>
                    </div>
                </div>
            </div>

            <!-- Event Card 4 -->
            <div class="col-md-3">
                <div class="card event-card">
                    <img src="assets/images/event4.png" class="card-img-top" alt="Event 4">
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Carnival 2024</h6>
                        <p class="card-text mb-1 text-muted">31 Dec 2024 - 01 Jan 2025</p>
                        <p class="fw-bold mb-2">Rp200.000</p>
                        <small class="text-muted">PT Bintan Resort Cakrawala</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Events Section -->
        <div class="container my-5 py-4" style="background-color: #0b2341; color: white; border-radius: 10px;">
            <h3 class="fw-bold text-center mb-4">Top Events!</h3>
            <div class="d-flex justify-content-around align-items-center">
                <!-- Event 1 -->
                <div class="position-relative text-center">
                    <h1 class="display-1 fw-bold text-white position-absolute top-50 start-50 translate-middle"
                        style="opacity: 0.2; z-index: 0;">1</h1>
                    <img src="assets/images/event1.png" alt="Event 1" class="position-relative rounded-3"
                        style="width: 250px; height: 150px; object-fit: cover; z-index: 1;">
                </div>

                <!-- Event 2 -->
                <div class="position-relative text-center">
                    <h1 class="display-1 fw-bold text-white position-absolute top-50 start-50 translate-middle"
                        style="opacity: 0.2; z-index: 0;">2</h1>
                    <img src="assets/images/event2.png" alt="Event 2" class="position-relative rounded-3"
                        style="width: 250px; height: 150px; object-fit: cover; z-index: 1;">
                </div>

                <!-- Event 3 -->
                <div class="position-relative text-center">
                    <h1 class="display-1 fw-bold text-white position-absolute top-50 start-50 translate-middle"
                        style="opacity: 0.2; z-index: 0;">3</h1>
                    <img src="assets/images/event3.png" alt="Event 3" class="position-relative rounded-3"
                        style="width: 250px; height: 150px; object-fit: cover; z-index: 1;">
                </div>
            </div>
        </div>
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