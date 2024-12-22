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

// Ambil data pengguna dari database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$dropdownName = !empty($user['name']) ? htmlspecialchars($user['name']) : 'Profil Anda';

// Tentukan halaman aktif untuk highlight
$current_page = basename($_SERVER['PHP_SELF']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    // Hapus akun dari database
    $deleteStmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
    $deleteStmt->bindParam(':user_id', $user_id);
    if ($deleteStmt->execute()) {
        // Logout dan redirect dengan delay ke halaman utama
        session_destroy();
        echo "<script>
            alert('Akun berhasil dihapus. Anda akan dialihkan ke halaman utama.');
            setTimeout(() => {
                window.location.href = '../index.php';
            }, 2000);
            
        </script>";
        exit();
    } else {
        $error_message = "Gagal menghapus akun. Silakan coba lagi nanti.";
    }
}
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
        .profile-container {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        <a href="../Jelajah.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
            <i class="bi bi-house"></i><span>Jelajah Event</span>
        </a>
        <a href="riwayat.php" class="<?php echo $current_page == 'tickets.php' ? 'active' : ''; ?>">
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


    <div class="content-container">
        <h2 class="content-header">Profil Kamu</h2>
        <div class="profile-container">
            <h2 class="profile-header">Pengaturan</h2>
            <div class="setting-item">
                <div class="setting-header">Tutup Akun</div>
                <div class="setting-action">
                    <i class="bi bi-chevron-right text-danger" onclick="showCloseAccount()" title="Tutup Akun"></i>
                </div>
            </div>
            <div id="closeAccount" class="close-account-container" style="display: none;">
                <h3>Tutup Akun</h3>
                <p>Harap baca syarat dan ketentuan berikut dengan teliti sebelum menutup akun kamu.</p>
                <h4>Menutup Akun</h4>
                <ul>
                    <li>Data pribadi</li>
                    <li>Keterlibatan dari kampanye promosi</li>
                    <li>Bagi event creator, riwayat eventmu akan hilang setelah penutupan akun</li>
                </ul>
                <form method="POST">
                    <div>
                        <input type="checkbox" id="agreeCloseAccount" onclick="toggleCloseButton()">
                        <label for="agreeCloseAccount">Saya dengan sadar setuju untuk menutup akun.</label>
                    </div>
                    <button id="confirmCloseAccount" class="disabled" name="delete_account" disabled>Tutup Akun</button>
                </form>
                <?php if (!empty($error_message)) : ?>
                    <div class="alert alert-danger mt-3"> <?php echo $error_message; ?> </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../javascript/profile.js"></script>
</body>

</html>
