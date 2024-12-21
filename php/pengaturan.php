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

$dropdownName = !empty($user['name']) ? htmlspecialchars($user['name']) : 'User';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kamu - Lokét</title>
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

        .setting-item {
            padding: 15px;
            margin-bottom: 10px;
            background-color: #eef3fc;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .setting-header {
            font-weight: bold;
            font-size: 16px;
        }

        .setting-description {
            font-size: 14px;
            color: #6c757d;
            margin-top: 5px;
        }

        .setting-toggle input[type="checkbox"] {
            transform: scale(1.5);
        }

        .setting-action i {
            font-size: 24px;
            cursor: pointer;
        }

        .setting-action i:hover {
            color: #dc3545;
        }

        .close-account-container {
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-top: 20px;
        }

        .close-account-container h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .close-account-container ul {
            list-style-type: disc;
            padding-left: 20px;
            margin-bottom: 15px;
        }

        .close-account-container button {
            background-color: #e0e0e0;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: not-allowed;
            transition: background-color 0.3s ease;
        }

        .close-account-container button.enabled {
            cursor: pointer;
            background-color: #007bff;
        }

        .close-account-container button.enabled:hover {
            background-color: #0056b3;
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
                    <a href="../index.php">Jelajah <i class="bi bi-chevron-right"></i></a>
                    <a href="#">Tiket Saya <i class="bi bi-chevron-right"></i></a>
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
        <div class="logo">
            <i class="bi bi-house"></i><span>LOKÉT</span>
        </div>
        <a href="../index.php"><i class="bi bi-house"></i><span>Jelajah Event</span></a>
        <a href="#"><i class="bi bi-ticket-perforated"></i><span>Tiket Saya</span></a>
        <a href="profile.php"><i class="bi bi-person"></i><span>Informasi Dasar</span></a>
        <a href="pengaturan.php"><i class="bi bi-gear"></i><span>Pengaturan</span></a>
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
                <div>
                    <input type="checkbox" id="agreeCloseAccount" onclick="toggleCloseButton()">
                    <label for="agreeCloseAccount">Saya dengan sadar setuju untuk menutup akun.</label>
                </div>
                <button id="confirmCloseAccount" class="disabled">Tutup Akun</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content-container');
        sidebar.classList.toggle('shrink');
        content.classList.toggle('shrink');
    }

    function showCloseAccount() {
        const closeAccountContainer = document.getElementById('closeAccount');
        const settingItem = document.querySelector('.setting-item');
        closeAccountContainer.style.display = 'block';
        if (settingItem) {
            settingItem.style.display = 'none';
        }
    }

    function toggleCloseButton() {
        const agreeCheckbox = document.getElementById('agreeCloseAccount');
        const closeButton = document.getElementById('confirmCloseAccount');
        if (agreeCheckbox.checked) {
            closeButton.classList.add('enabled');
            closeButton.classList.remove('disabled');
            closeButton.style.cursor = 'pointer';
            closeButton.disabled = false;
        } else {
            closeButton.classList.remove('enabled');
            closeButton.classList.add('disabled');
            closeButton.style.cursor = 'not-allowed';
            closeButton.disabled = true;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const logoutLink = document.querySelector('.text-danger');
        if (logoutLink) {
            logoutLink.addEventListener('click', (e) => {
                if (!confirm("Apakah Anda yakin ingin keluar?")) {
                    e.preventDefault();
                }
            });
        }
    });
    </script>
</body>

</html>
