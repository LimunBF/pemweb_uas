<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajah Event - Loket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/navbar_footer.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    
    <style>
    .card {
        border-radius: 10px;
        border: 1px solid #eee;
    }

    .filter-section {
        border-top: 1px solid #eee;
        padding-top: 15px;
    }

    .form-check-input {
        width: 3em;
        height: 1.5em;
    }

    .dropdown-toggle {
        border: 1px solid #ddd;
        padding: 8px 15px;
    }

    .card-img-top {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        height: 200px;
        object-fit: cover;
    }
    </style>
</head>
<body>
<?php
    session_start();
    $isLoggedIn = isset($_SESSION['user_id']); 
    
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=loket_com", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT event_id, title, event_date, location, organizer_name, event_image_path FROM events ORDER BY event_date ASC");
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        $events = [];
    }
?>

<!-- Navbar -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="index.php">LOKÉT</a>
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
                <a href="jelajah.php" class="icon-link me-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/2991/2991114.png" alt="Jelajah">
                    Jelajah
                </a>

                <?php if (!$isLoggedIn): ?>
                    <!-- Daftar dan Masuk -->
                    <a href="php/register.php" class="btn btn-outline-light me-2">Daftar</a>
                    <a href="php/login.php" class="btn btn-primary">Masuk</a>
                <?php else: ?>
                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="d-block" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-2x text-white"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li class="dropdown-header">Profil Anda</li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Tiket Saya</a></li>
                            <li><a class="dropdown-item" href="php/profile.php">Informasi Dasar</a></li>
                            <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                            <li><a class="dropdown-item text-danger" href="php/logout.php">Keluar</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between">
                        Filter
                        <i class="fas fa-sync-alt"></i>
                    </h5>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span>Event Online</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="eventOnlineSwitch">
                        </div>
                    </div>

                    <div class="filter-section mt-3">
                        <h6 class="d-flex justify-content-between">
                            Lokasi
                            <i class="fas fa-chevron-down"></i>
                        </h6>
                    </div>

                    <div class="filter-section mt-3">
                        <h6 class="d-flex justify-content-between">
                            Format
                            <i class="fas fa-chevron-down"></i>
                        </h6>
                    </div>

                    <div class="filter-section mt-3">
                        <h6 class="d-flex justify-content-between">
                            Topik
                            <i class="fas fa-chevron-down"></i>
                        </h6>
                    </div>

                    <div class="filter-section mt-3">
                        <h6 class="d-flex justify-content-between">
                            Waktu
                            <i class="fas fa-chevron-down"></i>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-end mb-4">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Waktu Mulai (Terdekat)
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Waktu Mulai (Terdekat)</a></li>
                        <li><a class="dropdown-item" href="#">Harga (Terendah)</a></li>
                        <li><a class="dropdown-item" href="#">Harga (Tertinggi)</a></li>
                    </ul>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event) : ?>
                        <div class="col">
                            <a href="tiket-page.php?event_id=<?php echo $event['event_id']; ?>" class="card event-card">
                                <img src="<?= htmlspecialchars($event['event_image_path']) ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($event['title']) ?>">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold"><?= htmlspecialchars($event['title']) ?></h6>
                                    <p class="card-text mb-1 text-muted">
                                        <?= date('d M Y', strtotime($event['event_date'])) ?>
                                    </p>
                                    <p class="fw-bold mb-2">
                                        <?= htmlspecialchars($event['location']) ?>
                                    </p>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($event['organizer_name']) ?>
                                    </small>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center">Tidak ada event yang tersedia saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
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
                <a href="php/tentang_kami.php">Tentang Kami</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="javascript/navbar.js"></script>
</body>
</html> 