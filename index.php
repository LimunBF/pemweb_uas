<?php
session_start(); 
$isLoggedIn = isset($_SESSION['user_id']); 

// Include the database connection file
include_once 'connection/connect.php';

// Get the database connection
$pdo = getDatabaseConnection();

// Query untuk mengambil event default (tidak terpengaruh pencarian)
$query = "SELECT event_id, title, event_date, location, organizer_name, event_image_path 
          FROM events 
          ORDER BY event_date ASC LIMIT 8";

$stmt = $pdo->prepare($query);
$stmt->execute();
$events = $stmt->fetchAll();

// Periksa apakah pengguna sudah login
if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $stmtUser = $pdo->prepare("SELECT name FROM users WHERE user_id = :user_id LIMIT 1");
    $stmtUser->execute(['user_id' => $userId]);
    $user = $stmtUser->fetch();
    $userName = $user ? htmlspecialchars($user['name']) : 'Pengguna';
} else {
    $userName = null;
}

// Query untuk mengambil 3 event dengan gambar secara acak
$stmtTopEvents = $pdo->prepare("SELECT event_id, event_image_path 
                                FROM events 
                                WHERE event_image_path IS NOT NULL 
                                ORDER BY RAND() LIMIT 3");
$stmtTopEvents->execute();
$topEvents = $stmtTopEvents->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/navbar_footer.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
</head>

<body>
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand fw-bold" href="#">BÉLI TIKÉT</a>
                <!-- Search Bar -->
                <div class="mx-auto" style="width: 40%;">
                    <form action="jelajah.php" method="get" class="input-group">
                        <input type="text" name="search" class="form-control search-bar" placeholder="Cari event seru di sini"
                            id="searchInput" aria-label="Search">
                        <button class="btn btn-primary" type="submit">
                            <img src="https://cdn-icons-png.flaticon.com/512/54/54481.png" alt="Cari" width="16" height="16">
                        </button>
                    </form>
                </div>

                <!-- Menu Kanan -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Jelajah -->
                    <a href="jelajah.php" class="btn btn-outline-light d-flex align-items-center gap-2 px-3">
                        <i class="bi bi-compass"></i>
                        <span>Jelajah</span>
                    </a>

                    <?php if (!$isLoggedIn): ?>
                    <!-- Daftar dan Masuk -->
                    <a href="php/register.php" class="btn btn-outline-light px-3">Daftar</a>
                    <a href="php/login.php" class="btn btn-primary px-3">Masuk</a>
                    <?php else: ?>
                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="btn btn-light d-flex align-items-center gap-2 px-3" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg"></i>
                            <span><?php echo $userName ? htmlspecialchars($userName) : 'Profil'; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li class="dropdown-header">Halo,
                                <?php echo $userName ? htmlspecialchars($userName) : 'Pengguna'; ?></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="php/riwayat.php">Tiket Saya</a></li>
                            <li><a class="dropdown-item" href="php/profile.php">Informasi Dasar</a></li>
                            <li><a class="dropdown-item" href="php/pengaturan.php">Pengaturan</a></li>
                            <li><a class="dropdown-item text-danger" href="php/logout.php">Keluar</a></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </nav>
    </header>

    <div class="container py-4">

        <!-- Header Carousel -->
        <div id="headerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <?php
            // Query untuk mengambil 3 event dengan gambar secara acak
            $stmtCarousel = $pdo->prepare("SELECT event_id, event_image_path FROM events WHERE event_image_path IS NOT NULL ORDER BY RAND() LIMIT 3");
            $stmtCarousel->execute();
            $carouselImages = $stmtCarousel->fetchAll();
            ?>

            <!-- Indicators -->
            <div class="carousel-indicators">
                <?php foreach ($carouselImages as $index => $image): ?>
                <button type="button" data-bs-target="#headerCarousel" data-bs-slide-to="<?php echo $index; ?>"
                    class="<?php echo $index === 0 ? 'active' : ''; ?>"
                    aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                    aria-label="Slide <?php echo $index + 1; ?>"></button>
                <?php endforeach; ?>
            </div>

            <!-- Carousel Items -->
            <div class="carousel-inner">
                <?php foreach ($carouselImages as $index => $image): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <!-- Tambahkan link agar gambar bisa diklik -->
                    <a href="php/tiket-page.php?event_id=<?php echo $image['event_id']; ?>">
                        <img src="<?php echo htmlspecialchars($image['event_image_path']); ?>" class="d-block w-100"
                            alt="Event Image">
                    </a>
                </div>
                <?php endforeach; ?>
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
            <?php if (!empty($events)): ?>
            <?php foreach ($events as $event): ?>
            <div class="col-md-3">
                <a href="php/tiket-page.php?event_id=<?php echo $event['event_id']; ?>" class="card event-card">
                    <img src="<?php echo htmlspecialchars($event['event_image_path']); ?>" class="card-img-top"
                        alt="Event Image">
                    <div class="card-body">
                        <h6 class="card-title fw-bold"><?php echo htmlspecialchars($event['title']); ?></h6>
                        <p class="card-text mb-1 text-muted">
                            <?php echo date('d M Y', strtotime($event['event_date'])); ?>
                        </p>
                        <p class="fw-bold mb-2">
                            <?php echo htmlspecialchars($event['location']); ?>
                        </p>
                        <small class="text-muted">
                            <?php echo htmlspecialchars($event['organizer_name']); ?>
                        </small>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="text-muted">Tidak ada event tersedia saat ini.</p>
            <?php endif; ?>
        </div>

        <!-- Tombol Lihat Semua -->
        <div class="text-center mt-4">
            <a href="jelajah.php" class="btn btn-outline-primary px-4">
                Lihat Semua Event
            </a>
        </div>

        <!-- Top Events Section -->
        <div class="container my-5 py-4" style="background-color: #0b2341; color: white; border-radius: 10px;">
            <h3 class="fw-bold text-center mb-4">Top Events!</h3>
            <div class="d-flex justify-content-around align-items-center">
                <?php foreach ($topEvents as $index => $event): ?>
                <div class="d-flex align-items-center gap-3">
                    <!-- Angka -->
                    <div class="text-center">
                        <h1 class="display-1 fw-bold text-white" style="opacity: 0.9;">
                            <?php echo $index + 1; ?>
                        </h1>
                    </div>
                    <!-- Gambar -->
                    <div class="position-relative text-center" style="width: 300px;">
                        <a href="php/tiket-page.php?event_id=<?php echo $event['event_id']; ?>">
                            <img src="<?php echo htmlspecialchars($event['event_image_path']); ?>"
                                alt="Event <?php echo $index + 1; ?>" class="position-relative rounded-3"
                                style="width: 100%; height: auto; object-fit: contain; z-index: 1; border: 2px solid white;">
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
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

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="javascript/navbar.js"></script>
    </body>

</html>



    <!-- <script>
    document.getElementById('searchInput').addEventListener('input', async (e) => {
        const searchQuery = e.target.value.trim();

        // Kirim permintaan ke server untuk pencarian
        const response = await fetch(`?search=${encodeURIComponent(searchQuery)}`);
        const html = await response.text();

        // Ambil elemen yang memuat daftar event dan perbarui kontennya
        const eventContainer = document.querySelector('.row.g-4');
        const parser = new DOMParser();
        const newDoc = parser.parseFromString(html, 'text/html');
        const newEvents = newDoc.querySelector('.row.g-4').innerHTML;

        eventContainer.innerHTML = newEvents;
    });
    </script> -->