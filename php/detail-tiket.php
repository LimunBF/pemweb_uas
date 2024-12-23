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

$userName = '';
$userEmail = '';

if ($isLoggedIn) {
    // Jika login, ambil nama dan email dari database
    $userId = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("SELECT name, email FROM users WHERE user_id = :user_id LIMIT 1");
        $stmt->execute(['user_id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userName = htmlspecialchars($user['name']); // Sanitasi nama
            $userEmail = htmlspecialchars($user['email']); // Sanitasi email
            // Jika nama kosong, jangan set readonly
            $isNameEditable = empty($user['name']); 
        }
    } catch (PDOException $e) {
        // Jika terjadi kesalahan database, kosongkan nama dan email
        $userName = '';
        $userEmail = '';
        $isNameEditable = true; // Nama bisa diedit jika tidak ditemukan
    }
}

$message = '';
if ($isLoggedIn) {
    if (empty($userName) && empty($userEmail)) {
        $message = 'Nama dan email belum terisi. Harap lengkapi data Anda.';
    } elseif (empty($userName)) {
        $message = 'Nama belum terisi. Harap lengkapi data Anda.';
    } elseif (empty($userEmail)) {
        $message = 'Email belum terisi. Harap lengkapi data Anda.';
    } else {
        $message = 'Data di atas akan diisi otomatis jika Anda sudah login.';
    }
} else {
    $message = 'Isi nama dan email untuk melanjutkan.';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand fw-bold" href="../index.php">BÉLI TIKÉT</a>
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
                        <a href="#" class="btn btn-light d-flex align-items-center gap-2 px-3" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-circle-user fa-lg"></i>
                            <span><?php echo $userName ? htmlspecialchars($userName) : 'Profil'; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li class="dropdown-header">Halo,
                                <?php echo $userName ? htmlspecialchars($userName) : 'Pengguna'; ?></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="riwayat.php">Tiket Saya</a></li>
                            <li><a class="dropdown-item" href="profile.php">Informasi Dasar</a></li>
                            <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                            <li><a class="dropdown-item text-danger" href="logout.php">Keluar</a></li>
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
                        <button class="nav-link active" id="tiket-tab" data-bs-toggle="tab" data-bs-target="#tiket"
                            type="button" role="tab">1. Pilih Tiket</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="biodata-tab" data-bs-toggle="tab" data-bs-target="#biodata"
                            type="button" role="tab" disabled>2. Biodata</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="konfirmasi-tab" data-bs-toggle="tab" data-bs-target="#konfirmasi"
                            type="button" role="tab" disabled>3. Konfirmasi</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pembayaran-tab" data-bs-toggle="tab" data-bs-target="#pembayaran"
                            type="button" role="tab" disabled>4. Pembayaran</button>
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
                                <input type="text" class="form-control" id="nama" placeholder="Masukkan nama lengkap"
                                    value="<?php echo $userName; ?>"
                                    <?php echo $isLoggedIn && !$isNameEditable ? 'readonly' : ''; ?> required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Masukkan email lengkap"
                                    value="<?php echo $userEmail; ?>" <?php echo $isLoggedIn ? 'readonly' : ''; ?>
                                    required>
                            </div>
                            <button class="btn btn-gradient" id="btnKonfirmasi">Lanjutkan</button>
                        </form>
                        <p class="text-muted" style="margin-top: 10px;"><?php echo $message; ?></p>
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
                    <button class="btn btn-gradient2 w-100 mt-3" id="btnBayar" disabled>Selesaikan
                        Pembayaran</button>
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
    document.getElementById("btnBayar").addEventListener("click", function() {
        const selectedTickets = [];
        <?php foreach ($tickets as $ticket): ?>
        const jumlahTiket<?php echo $ticket['ticket_id']; ?> = document.getElementById(
            "jumlahTiket<?php echo $ticket['ticket_id']; ?>").value;
        selectedTickets.push({
            ticket_id: "<?php echo $ticket['ticket_id']; ?>",
            quantity: jumlahTiket<?php echo $ticket['ticket_id']; ?>,
        });
        <?php endforeach; ?>

        const validTickets = selectedTickets.filter(ticket => ticket.quantity > 0);
        if (validTickets.length === 0) {
            alert('Pilih setidaknya satu tiket sebelum melanjutkan.');
            return;
        }

        // Kirim data ke server untuk mengupdate stok tiket
        fetch("../php/update_tickets.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    tickets: validTickets
                }),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert("Stok tiket berhasil diperbarui!");
                    // Lanjutkan ke proses insert_order.php
                    processOrder(validTickets);
                } else {
                    alert("Gagal memperbarui stok tiket: " + data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat memperbarui stok tiket.");
            });
    });

    // Fungsi untuk memproses pesanan
    function processOrder(validTickets) {
        const userName = sessionStorage.getItem('user_name');
        const email = sessionStorage.getItem('email');

        if (!userName || !email) {
            alert('Masukkan biodata lengkap terlebih dahulu.');
            return;
        }

        fetch("../php/insert_order.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    tickets: validTickets,
                    user_name: userName,
                    email: email,
                }),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert("Order berhasil dibuat! ID Order: " + data.order_id);
                    const currentEventId = "<?php echo $event_id; ?>";
                    window.location.href =
                        `http://localhost/UAS/pemweb_uas/php/tiket-page.php?event_id=${currentEventId}`;
                } else {
                    alert("Gagal membuat order: " + data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat membuat order.");
            });
    }




    // Tangkap nama dan email dari tab Biodata saat tombol Konfirmasi ditekan
    document.getElementById("btnKonfirmasi").addEventListener("click", (e) => {
        e.preventDefault();

        // Ambil nilai input dari nama dan email
        const namaInput = document.getElementById("nama").value;
        const emailInput = document.getElementById("email").value;

        // Validasi input
        if (!namaInput || !emailInput) {
            alert("Masukkan nama dan email terlebih dahulu.");
            return;
        }

        // Simpan ke sessionStorage agar dapat diakses oleh tombol Bayar
        sessionStorage.setItem("user_name", namaInput);
        sessionStorage.setItem("email", emailInput);

        // Lanjutkan ke tab berikutnya
        document.querySelector("#konfirmasi-tab").disabled = false;
        document.querySelector("#konfirmasi-tab").click();
    });
    </script>

</body>

</html>