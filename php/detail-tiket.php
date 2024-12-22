<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['user_id']); // Cek apakah sesi user_id ada

// Mengambil event_id dari URL
$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;

if ($event_id) {
    // Koneksi ke database
    include_once '../connection/connect.php'; // atau require_once
    try {
        $pdo = getDatabaseConnection();
    } catch (PDOException $e) {
        die("Koneksi gagal: " . $e->getMessage());
    }

    // Mengambil data tiket berdasarkan event_id
    $sql = "SELECT * FROM tickets WHERE event_id = :event_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['event_id' => $event_id]);
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    die("Event ID tidak valid.");
}
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
                                <i class="fas fa-user-circle fa-2x text-white"></i> <!-- Profile Icon -->
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
            <?php if ($tickets): ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <div class="mb-4">
                                    <h5><?php echo htmlspecialchars($ticket['ticket_type']); ?></h5>
                                    <p>Harga: Rp <?php echo number_format($ticket['price'], 0, ',', '.'); ?></p>
                                    <select class="form-select w-auto" id="jumlahTiket<?php echo $ticket['ticket_id']; ?>">
                                        <?php for ($i = 0; $i <= $ticket['quantity_available']; $i++): ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Tidak ada tiket tersedia untuk event ini.</p>
                        <?php endif; ?>
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
                <button class="btn btn-gradient2 w-100 mt-3" id="btnBayar" disabled>Selesaikan Pembayaran</button>
            </div>
    </div>
    </div>
</main>

<!-- FOOTER -->
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../javascript/navbar.js"></script>
<script src="../javascript/detail-tiket.js"></script>
<script>
    document.getElementById("btnBayar").addEventListener("click", function () {
    const selectedTickets = [];
    <?php foreach ($tickets as $ticket): ?>
    const jumlahTiket<?php echo $ticket['ticket_id']; ?> = document.getElementById("jumlahTiket<?php echo $ticket['ticket_id']; ?>").value;
    selectedTickets.push({
        ticket_id: "<?php echo $ticket['ticket_id']; ?>",
        quantity: jumlahTiket<?php echo $ticket['ticket_id']; ?>,
    });
    <?php endforeach; ?>

    // Kirim data ke server menggunakan AJAX
    fetch("../php/update_tickets.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            tickets: selectedTickets,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert("Pembayaran berhasil, stok tiket telah diperbarui!");
                location.reload();
            } else {
                alert("Gagal memproses pembayaran: " + data.message);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Terjadi kesalahan. Silakan coba lagi.");
        });
});

</script>

</body>
</html>
