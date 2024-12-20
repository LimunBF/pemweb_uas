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
    <title>Detail Tiket</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/navbar_footer.css">
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" href="../css/detail-tiket.css">

</head>
<body class="d-flex flex-column min-vh-100">

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
<main class="container my-4 flex-grow-1">
    <div class="row gx-4">
        <!-- TAB NAVIGATION -->
    <div class="col-md-8">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tiket-tab" data-bs-toggle="tab" data-bs-target="#tiket" type="button" role="tab">1. Pilih Tiket</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="biodata-tab" data-bs-toggle="tab" data-bs-target="#biodata" type="button" role="tab" disabled>2. Biodata</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="konfirmasi-tab" data-bs-toggle="tab" data-bs-target="#konfirmasi" type="button" role="tab" disabled>3. Konfirmasi</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pembayaran-tab" data-bs-toggle="tab" data-bs-target="#pembayaran" type="button" role="tab" disabled>4. Pembayaran</button>
        </li>
    </ul>

    <!-- TAB CONTENT -->
    <div class="tab-content">
        <!-- TAB 1: Pilih Tiket -->
        <div class="tab-pane fade show active" id="tiket" role="tabpanel">
            <h3 class="fw-bold mb-3">Pilih Tiket</h3>
            <div class="mb-4">
                <h5>Jenis Tiket 1</h5>
                <p>Harga: Rp 500.000</p>
                <select class="form-select w-auto" id="jumlahTiket1">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
            </div>
            <div class="mb-4">
                <h5>Jenis Tiket 2</h5>
                <p>Harga: Rp 750.000</p>
                <select class="form-select w-auto" id="jumlahTiket2">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
            </div>
            <button class="btn btn-gradient" id="btnCheckout">Checkout</button>
        </div>

        <!-- TAB 2: Biodata -->
        <div class="tab-pane fade" id="biodata" role="tabpanel">
            <h3 class="fw-bold mb-3">Isi Biodata</h3>
            <form>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <button class="btn btn-gradient" id="btnKonfirmasi">Lanjutkan</button>
            </form>
        </div>

        <!-- TAB 3: Konfirmasi -->
        <div class="tab-pane fade" id="konfirmasi" role="tabpanel">
            <h3 class="fw-bold mb-3">Konfirmasi</h3>
            <p>Email: <strong id="emailKonfirmasi"></strong></p>
            <p>Metode Pembayaran:</p>
            <select class="form-select w-auto mb-3">
                <option>Transfer Bank</option>
                <option>Virtual Account</option>
                <option>E-Wallet</option>
            </select>
            <button class="btn btn-gradient" id="btnPembayaran">Bayar Sekarang</button>
        </div>

        <!-- TAB 4: Pembayaran -->
        <div class="tab-pane fade" id="pembayaran" role="tabpanel">
            <h3 class="fw-bold mb-3">Pembayaran</h3>
            <div class="bg-payment">
                <p>Batas Waktu Pembayaran: <strong>24 Jam</strong></p>
                <p>Silakan lakukan pembayaran sebelum batas waktu habis.</p>
            </div>
        </div>
    </div>
    </div>
    
    <div class="col-md-4">
    <div class="p-4 rounded bg-primary text-white shadow">
                <h4 class="fw-bold mb-4">Daftar Tiket yang Dipesan</h4>
                <p>Tiket yang Anda pilih akan muncul di sini.</p>
                <ul class="list-unstyled">
                    <li class="mb-2">Jenis Tiket 1: <strong>2</strong> x Rp 500.000</li>
                    <li class="mb-2">Jenis Tiket 2: <strong>1</strong> x Rp 750.000</li>
                </ul>
                <hr class="bg-light">
                <p class="fs-5 fw-bold">Total: <span>Rp 1.750.000</span></p>
                <button class="btn btn-gradient2 w-100 mt-3">Checkout</button>
            </div>
    </div>
    </div>
</main>

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
<script src="../javascript/detail-tiket.js"></script>

</body>
</html>
