<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['user_id']); // Cek apakah sesi user_id ada

// Koneksi ke database
include '../connection/connect.php';

try {
    // Mendapatkan koneksi database
    $pdo = getDatabaseConnection();

    // Ambil event_id dari URL
    $event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;

    if ($event_id) {
        // Query untuk mendapatkan detail event
        $stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
        $stmt->execute([$event_id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$event) {
            die('Event tidak ditemukan');
        }
    } else {
        die('Event tidak ditentukan');
    }
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['title']) ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/navbar_footer.css">
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" href="../css/tiket-page.css">
</head>
<body>

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
            <!-- Judul Event dan Banner -->
            <div class="col-md-8">
                <div class="bg-light p-4 rounded">
                    <h1 class="fw-bold"><?= htmlspecialchars($event['title']) ?></h1>
                    <img src="<?= htmlspecialchars($event['event_image_path']) ?>" class="img-fluid rounded mt-3" alt="Banner Event">
                </div>

                <!-- Tab Navigasi -->
                <div class="mt-4">
                    <ul class="nav nav-tabs" id="eventTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="deskripsi-tab" data-bs-toggle="tab" data-bs-target="#deskripsi" type="button" role="tab" aria-controls="deskripsi" aria-selected="true">
                                DESKRIPSI
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="detail-event-tab" data-bs-toggle="tab" data-bs-target="#detail-event" type="button" role="tab" aria-controls="detail-event" aria-selected="false">
                                DETAIL EVENT
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-4" id="eventTabContent">
                        <!-- Tab: Deskripsi -->
                        <div class="tab-pane fade show active" id="deskripsi" role="tabpanel" aria-labelledby="deskripsi-tab">
                            <h4 class="fw-bold"><?= htmlspecialchars($event['title']) ?></h4>
                            <p>
                                <?= nl2br(htmlspecialchars($event['description'])) ?>
                            </p>
                        </div>

                        <!-- Tab: Detail Event -->
                        <div class="tab-pane fade" id="detail-event" role="tabpanel" aria-labelledby="detail-event-tab">
                            <h4 class="fw-bold">Detail Event</h4>
                            <ul>
                                <li><strong>Jenis Event:</strong> <?= htmlspecialchars($event['event_type']) ?></li>
                                <li><strong>Dress Code:</strong> <?= htmlspecialchars($event['dress_code']) ?></li>
                                <li><strong>Usia Minimum:</strong> <?= htmlspecialchars($event['min_age']) ?> tahun</li>
                                <li><strong>Fasilitas:</strong> <?= htmlspecialchars($event['facilities']) ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi Event -->
            <div class="col-md-4">
                <div class="event-card p-4 rounded shadow text-center">
                    <h4 class="fw-bold"><?= htmlspecialchars($event['title']) ?></h4>
                    <div class="event-details my-3">
                        <p><i class="bi bi-calendar-event"></i> <?= date("d M Y", strtotime($event['event_date'])) ?></p>
                        <p><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($event['location']) ?></p>
                    </div>
                    <!-- Garis Pemisah -->
                    <div class="event-divider"></div>
                    <div class="event-organizer mt-4">
                        <p class="text-muted">Diselenggarakan oleh</p>
                        <h5 class="fw-bold text-primary"><?= htmlspecialchars($event['organizer_name']) ?></h5>
                    </div>
                    <button class="btn btn-gradient mt-3 px-4" onclick="window.location.href='detail-tiket.php'">Beli Tiket</button>
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
            <div class="d-inline-flex flex-wrap justify-content-center align-items-center" style="gap: 10px;">
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
