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

    .lokasi-header {
        transition: all 0.3s
    }

    .waktu-header {
        transition: all 0.3s ease;
    }

    .waktu-header.active i {
        transform: rotate(180deg);
    }

    .month-list {
        max-height: 250px;
        overflow-y: auto;
    }

    .month-item {
        padding: 8px 12px;
        cursor: pointer;
        color: #666;
        transition: all 0.2s ease;
    }

    .month-item:hover {
        color: #ff4d00;
        background-color: #f8f9fa;
        border-radius: 4px;
    }

    .month-item.selected {
        color: #ff4d00;
        font-weight: 500;
        background-color: #fff0eb;
        border-radius: 4px;
    }

    .location-list {
        max-height: 250px;
        overflow-y: auto;
        margin-top: 10px;
    }

    .location-item {
        padding: 8px 12px;
        cursor: pointer;
        color: #666;
        transition: all 0.2s ease;
        display: block;
        text-decoration: none;
    }

    .location-item:hover {
        color: #ff4d00;
        background-color: #f8f9fa;
    }

    .location-item.selected {
        color: #ff4d00;
        font-weight: 500;
    }

    .search-box .input-group {
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }

    .search-box .form-control {
        border: none;
        padding: 8px 12px;
    }

    .search-box .form-control:focus {
        box-shadow: none;
    }

    .search-box .input-group-text {
        background: transparent;
        border: none;
        color: #666;
    }

    .no-events-box {
        border: 2px solid #dee2e6;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        background-color: #f8f9fa;
        margin: 40px auto;
        max-width: 500px;
    }
    
    .no-events-box p {
        color: #dc3545;  /* Warna merah Bootstrap */
        font-size: 1.1rem;
        margin: 0;
        font-weight: 500;
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

    // Ambil nama pengguna jika sudah login
    if ($isLoggedIn) {
        $userId = $_SESSION['user_id'];
        $stmtUser = $pdo->prepare("SELECT name FROM users WHERE user_id = :user_id LIMIT 1");
        $stmtUser->execute(['user_id' => $userId]);
        $user = $stmtUser->fetch();
        $userName = $user ? htmlspecialchars($user['name']) : 'Pengguna';
    } else {
        $userName = null;
    }

    // Get search parameter
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_asc';

    // Base query
    $query = "SELECT event_id, title, event_date, location, organizer_name, event_image_path FROM events";
    $params = [];

    // Add search condition
    if (!empty($search)) {
        $query .= " WHERE title LIKE :search";
        $params[':search'] = "%$search%";
    }

    // Add ORDER BY clause
    switch ($sort) {
        case 'title_asc':
            $query .= " ORDER BY title ASC";
            break;
        case 'title_desc':
            $query .= " ORDER BY title DESC";
            break;
        case 'date_desc':
            $query .= " ORDER BY event_date DESC";
            break;
        default: // date_asc
            $query .= " ORDER BY event_date ASC";
    }

    $stmt = $pdo->prepare($query);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $events = [];
    $userName = 'Pengguna';
}
?>


<!-- Navbar -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="#">BÉLI TIKÉT</a>
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
            <div class="d-flex align-items-center gap-3">
                <!-- Home -->
                <a href="index.php" class="btn btn-outline-light d-flex align-items-center gap-2 px-3">
                    <i class="bi bi-house"></i>
                    <span>Home</span>
                </a>

                <?php if (!$isLoggedIn): ?>
                    <!-- Daftar dan Masuk -->
                    <a href="php/register.php" class="btn btn-outline-light px-3">Daftar</a>
                    <a href="php/login.php" class="btn btn-primary px-3">Masuk</a>
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
                            <li><a class="dropdown-item" href="php/riwayat.php">Tiket Saya</a></li>
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
                        <i class="fas fa-sync-alt" style="color: #ff4d00; cursor: pointer;" id="resetFilter"></i>
                    </h5>
                    
                    <!-- Lokasi Section -->
                    <div class="mt-4 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center lokasi-header" style="cursor: pointer;">
                            <h6 class="mb-0" style="color: <?php echo isset($_GET['location']) ? '#ff4d00' : 'inherit'; ?>">Lokasi</h6>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        
                        <div class="lokasi-content mt-3" style="display: none;">
                            <div class="search-box mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari lokasi ..." id="searchLocation">
                                    <span class="input-group-text bg-white border-start-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="location-list" id="locationList">
                                <!-- Default locations -->
                                <div class="location-item <?php echo !isset($_GET['location']) ? 'selected' : ''; ?>" data-value="">
                                    Semua Lokasi
                                </div>
                                <?php
                                // Daftar kota default
                                $defaultCities = [
                                    'Bali',
                                    'Bandung',
                                    'DKI Jakarta',
                                    'Kota Yogyakarta',
                                    'Surabaya',
                                    'Malang',
                                    'Semarang',
                                    'Medan',
                                    'Makassar',
                                    'Palembang'
                                ];

                                foreach ($defaultCities as $city) {
                                    $isSelected = isset($_GET['location']) && $_GET['location'] === $city;
                                    ?>
                                    <div class="location-item <?php echo $isSelected ? 'selected' : ''; ?>" data-value="<?php echo $city; ?>">
                                        <?php echo $city; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Waktu Section -->
                    <div class="mt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center waktu-header" style="cursor: pointer;">
                            <h6 class="mb-0" style="color: <?php echo isset($_GET['month']) ? '#ff4d00' : 'inherit'; ?>">Waktu</h6>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        
                        <div class="waktu-content mt-3" style="display: none;">
                            <div class="month-list" id="monthList">
                                <?php
                                // Array untuk nama bulan dalam bahasa Indonesia
                                $monthNames = [
                                    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                ];
                                
                                $currentYear = date('Y');
                                
                                // Loop untuk setiap bulan dalam tahun ini
                                for ($month = 1; $month <= 12; $month++) {
                                    $monthValue = sprintf("%d-%02d", $currentYear, $month);
                                    $isSelected = isset($_GET['month']) && $_GET['month'] === $monthValue;
                                    ?>
                                    <div class="month-item <?php echo $isSelected ? 'selected' : ''; ?>" 
                                         data-value="<?php echo $monthValue; ?>">
                                        <?php echo $monthNames[$month]; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-end mb-4">
                <div class="dropdown">
                    <?php
                    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_asc';
                    $sortText = [
                        'date_asc' => 'Waktu Mulai (Terdekat)',
                        'date_desc' => 'Waktu Mulai (Terjauh)',
                        'title_asc' => 'Nama Event (A-Z)',
                        'title_desc' => 'Nama Event (Z-A)'
                    ];
                    ?>
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <?php echo $sortText[$sort] ?? 'Waktu Mulai (Terdekat)'; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item <?php echo $sort === 'date_asc' ? 'active' : ''; ?>" 
                               href="?sort=date_asc<?php echo isset($_GET['location']) ? '&location='.$_GET['location'] : ''; ?>">
                               Waktu Mulai (Terdekat)</a></li>
                        <li><a class="dropdown-item <?php echo $sort === 'date_desc' ? 'active' : ''; ?>" 
                               href="?sort=date_desc<?php echo isset($_GET['location']) ? '&location='.$_GET['location'] : ''; ?>">
                               Waktu Mulai (Terjauh)</a></li>
                        <li><a class="dropdown-item <?php echo $sort === 'title_asc' ? 'active' : ''; ?>" 
                               href="?sort=title_asc<?php echo isset($_GET['location']) ? '&location='.$_GET['location'] : ''; ?>">
                               Nama Event (A-Z)</a></li>
                        <li><a class="dropdown-item <?php echo $sort === 'title_desc' ? 'active' : ''; ?>" 
                               href="?sort=title_desc<?php echo isset($_GET['location']) ? '&location='.$_GET['location'] : ''; ?>">
                               Nama Event (Z-A)</a></li>
                    </ul>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event) : ?>
                        <div class="col">
                            <a href="php/tiket-page.php?event_id=<?php echo $event['event_id']; ?>" class="card event-card">
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
                        <div class="no-events-box">
                            <p>Tidak ada event yang tersedia saat ini.</p>
                        </div>
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
            <p class="copyright">&copy; 2024 Beli Tiket (PT Global Loket Sejahtera)</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="javascript/navbar.js"></script>
<script src="javascript/jelajah.js"></script>
<script>
    document.getElementById('searchInput').addEventListener('input', async (e) => {
    const searchQuery = e.target.value.trim();

    // Kirim permintaan ke server untuk pencarian
    const response = await fetch(`?search=${encodeURIComponent(searchQuery)}`);
    const html = await response.text();

    // Ambil elemen yang memuat daftar event dan perbarui kontennya
    const eventContainer = document.querySelector('.row.row-cols-1.row-cols-md-4.g-4');
    const parser = new DOMParser();
    const newDoc = parser.parseFromString(html, 'text/html');
    const newEvents = newDoc.querySelector('.row.row-cols-1.row-cols-md-4.g-4').innerHTML;

    eventContainer.innerHTML = newEvents;
});

</script>
</body>
</html> 