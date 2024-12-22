<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include koneksi ke database
include '../connection/connect.php';
$pdo = getDatabaseConnection();

// Tentukan halaman aktif untuk highlight
$current_page = basename($_SERVER['PHP_SELF']);

// Ambil data pengguna dari database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute(); // Tambahkan eksekusi
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Tentukan nama untuk dropdown
$dropdownName = !empty($user['name']) ? htmlspecialchars($user['name']) : 'Profil Anda';

// Ambil data riwayat tiket pengguna dari tabel purchase_history
$stmt = $pdo->prepare("SELECT ph.*, e.title AS event_title, e.event_date, t.ticket_type 
                       FROM purchase_history ph
                       JOIN events e ON ph.event_id = e.event_id
                       JOIN tickets t ON ph.ticket_id = t.ticket_id
                       WHERE ph.user_id = :user_id 
                       ORDER BY ph.purchase_date DESC");

$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kamu - BÉLI TIKÉT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/profile.css" rel="stylesheet">
    <style>
    .nav-tabs {
        border-bottom: none;
    }

    .nav-tabs .nav-link {
        border: none;
        font-weight: bold;
        color: #6c757d;
        padding: 15px 100px;
        border-bottom: 3px solid white;
        margin-right: 15px;
        /* Tambahkan jarak antar tombol */
    }

    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #007bff;
        font-weight: bold;
        padding: 15px 100px;
        margin-right: 15px;
        /* Pastikan jarak konsisten */
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="fw-bold text-black"></span>
            <div class="dropdown-profile">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile">
                <span><?php echo $dropdownName; ?></span>
                <div class="dropdown-menu">
                    <a href="../Jelajah.php">Jelajah <i class="bi bi-chevron-right"></i></a>
                    <a href="riwayat.php">Tiket Saya <i class="bi bi-chevron-right"></i></a>
                    <a href="profile.php">Informasi Dasar <i class="bi bi-chevron-right"></i></a>
                    <a href="pengaturan.php">Pengaturan <i class="bi bi-chevron-right"></i></a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="text-danger">Keluar <i class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="../index.php" class="logo">
            <i class="bi bi-house"></i><span>BÉLI TIKÉT</span>
        </a>
        <a href="../Jelajah.php" class="<?php echo $current_page == 'Jelajah.php' ? 'active' : ''; ?>">
            <i class="bi bi-house"></i><span>Jelajah Event</span>
        </a>
        <a href="riwayat.php" class="<?php echo $current_page == 'riwayat.php' ? 'active' : ''; ?>">
            <i class="bi bi-ticket-perforated"></i><span>Tiket Saya</span>
        </a>
        <a href="profile.php" class="<?php echo $current_page == 'profile.php' ? 'active' : ''; ?>">
            <i class="bi bi-person"></i><span>Informasi Dasar</span>
        </a>
        <a href="pengaturan.php" class="<?php echo $current_page == 'pengaturan.php' ? 'active' : ''; ?>">
            <i class="bi bi-gear"></i><span>Pengaturan</span>
        </a>
        <button class="toggle-button" onclick="toggleSidebar()">
            <i class="bi bi-chevron-left text-white"></i><span>Shrink</span>
        </button>
    </div>


    <!-- Konten Utama -->
    <div class="content-container">
        <h2 class="content-header">Profil Kamu</h2>
        <div class="container mt-5">
            <h2 class="mb-4" style="font-size: 24px;">Tiket Saya</h2>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#active-events" data-bs-toggle="tab">Event Aktif</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#past-events" data-bs-toggle="tab">Event Lalu</a>
                </li>
            </ul>

            <div class="tab-content mt-4">
                <!-- Event Aktif -->
                <div class="tab-pane fade show active" id="active-events">
                    <?php if (empty($purchases)) : ?>
                    <p>Tidak ada riwayat pembelian tiket.</p>
                    <?php else : ?>
                    <?php foreach ($purchases as $purchase) : ?>
                    <?php if (strtotime($purchase['event_date']) > time()) : ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($purchase['event_title']); ?>
                            </h5>
                            <p class="card-text">
                                <strong>Tanggal:</strong> <?php echo htmlspecialchars($purchase['event_date']); ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Event Lalu -->
                <div class="tab-pane fade" id="past-events">
                    <?php if (empty($purchases)) : ?>
                    <p>Tidak ada event lalu.</p>
                    <?php else : ?>
                    <?php foreach ($purchases as $purchase) : ?>
                    <?php if (strtotime($purchase['event_date']) <= time()) : ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($purchase['event_title']); ?>
                            </h5>
                            <p class="card-text">
                                <strong>Tanggal:</strong> <?php echo htmlspecialchars($purchase['event_date']); ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../javascript/profile.js"></script>
</body>

</html>