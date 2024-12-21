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

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Ambil data pengguna dari database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi CSRF token
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Token CSRF tidak valid");
    }

    // Sanitasi input jika ada
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : $user['name'];
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : $user['email'];
    $phone_number = isset($_POST['phone_number']) ? htmlspecialchars(trim($_POST['phone_number'])) : $user['phone_number'];
    $ktp_number = isset($_POST['ktp_number']) ? htmlspecialchars(trim($_POST['ktp_number'])) : $user['ktp_number'];
    $date_of_birth = isset($_POST['date_of_birth']) ? htmlspecialchars(trim($_POST['date_of_birth'])) : $user['date_of_birth'];
    $gender = isset($_POST['gender']) ? htmlspecialchars(trim($_POST['gender'])) : $user['gender'];

    // Validasi hanya untuk email dan nomor telepon jika diisi
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email tidak valid");
    }
    if (!empty($phone_number) && !preg_match("/^[0-9]{10,15}$/", $phone_number)) {
        die("Nomor telepon tidak valid");
    }

    // Update data pengguna
    $updateStmt = $pdo->prepare("
        UPDATE users 
        SET 
            name = COALESCE(NULLIF(:name, ''), name), 
            email = COALESCE(NULLIF(:email, ''), email), 
            phone_number = COALESCE(NULLIF(:phone_number, ''), phone_number), 
            ktp_number = COALESCE(NULLIF(:ktp_number, ''), ktp_number), 
            date_of_birth = COALESCE(NULLIF(:date_of_birth, ''), date_of_birth), 
            gender = COALESCE(NULLIF(:gender, ''), gender) 
        WHERE user_id = :user_id
    ");
    $updateStmt->bindParam(':name', $name);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':phone_number', $phone_number);
    $updateStmt->bindParam(':ktp_number', $ktp_number);
    $updateStmt->bindParam(':date_of_birth', $date_of_birth);
    $updateStmt->bindParam(':gender', $gender);
    $updateStmt->bindParam(':user_id', $user_id);

    if (!$updateStmt->execute()) {
        echo "Terjadi kesalahan saat memperbarui data.";
        error_log("SQL Error: " . implode(" | ", $updateStmt->errorInfo()));
        die("Terjadi kesalahan saat memperbarui data.");
    } else {
        header("Location: profile.php");
        exit();
    }
}

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
    html,
    body {
        overflow-x: hidden;
        background-color: #f8f9fa;
    }

    .content-header {
        font-size: 24px;
        margin-right: auto;
        margin: 0 40px;
    }

    .profile-container {
        max-width: 90%;
        margin: 30px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        animation: waveEffect 4s ease-out;
    }

    .btn-primary {
        background-color: #0b2341;
        border-color: #0b2341;
    }

    .btn-primary:hover {
        background-color: #031125;
        border-color: #031125;
    }

    .sidebar {
        height: 100vh;
        background-color: #0b2341;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        padding-top: 20px;
        transition: width 0.3s ease;
    }

    .sidebar.shrink {
        width: 80px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 10px 20px;
    }

    .sidebar a i {
        width: 24px;
        text-align: center;
    }

    .sidebar a span {
        margin-left: 10px;
    }

    .sidebar.shrink a span {
        display: none;
    }

    .sidebar a:hover {
        background-color: #031125;
    }

    .sidebar .toggle-button {
        position: absolute;
        bottom: 20px;
        left: 0;
        background-color: #0b2341;
        border: none;
        display: flex;
        padding: 10px 20px;
        color: white;
        width: 100%;
        height: 50px;
        cursor: pointer;
    }

    .sidebar .toggle-button:hover {
        background-color: #031125;
    }

    .sidebar.shrink .toggle-button {
        left: 0;
        justify-content: center;
    }

    .sidebar .toggle-button span {
        margin-left: 10px;
        color: white;
    }

    .sidebar.shrink .toggle-button span {
        display: none;
    }

    .dropdown-profile {
        background-color: white;
        color: #0b2341;
        border-radius: 20px;
        padding: 5px 15px;
        display: flex;
        align-items: center;
        cursor: pointer;
        position: relative;
    }

    .dropdown-profile:hover {
        background-color: #f0f0f0;
    }

    .dropdown-profile img {
        width: 30px;
        height: 30px;
        margin-right: 10px;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        right: auto;
        min-width: 200px;
        z-index: 1050;
        display: none;
        font-size: 14px;
        background-color: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 0.25rem;
        padding: 0.5rem 0;
    }

    .dropdown-profile:hover .dropdown-menu {
        display: block;
    }

    .dropdown-menu a {
        color: #0b2341;
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 1rem;
    }

    .dropdown-menu a:hover {
        background-color: #f0f0f0;
    }

    .dropdown-menu .text-danger {
        color: red;
    }

    .content-container {
        margin-left: 250px;
        transition: margin-left 0.3s ease;
    }

    .content-container.shrink {
        margin-left: 80px;
    }

    .sidebar .logo {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .sidebar.shrink .logo span {
        display: none;
    }

    .sidebar .logo i {
        font-size: 24px;
    }

    .profile-header {
        font-size: 24px;
        margin-bottom: 20px;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 10px;
    }

    .form-control {
        border: none;
        border-bottom: 2px solid #ccc;
        border-radius: 0;
        box-shadow: none;
        transition: all 1, 5s;
    }

    .form-control:focus {
        border-bottom: 2px solid #196dd3;
        box-shadow: none;
    }

    @keyframes waveEffect {
        0% {
            background-color: #ffffff;
        }

        50% {
            background-color: #f2f2f2;
        }

        100% {
            background-color: #ffffff;
        }
    }

    input:focus {
        animation: highlightInput 0.6s ease-in-out;
    }

    @keyframes highlightInput {
        0% {
            background-color: #ffffff;
        }

        50% {
            background-color: #e0f7fa;
        }

        100% {
            background-color: #ffffff;
        }
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
                    <a href="#">Pengaturan <i class="bi bi-chevron-right"></i></a>
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
        <a href="#"><i class="bi bi-gear"></i><span>Pengaturan</span></a>
        <button class="toggle-button" onclick="toggleSidebar()">
            <i class="bi bi-chevron-left text-white"></i><span>Shrink</span>
        </button>
    </div>

    <!-- Profil Container -->
    <div class="content-container">
        <h2 class="content-header">Profil Kamu</h2>
        <div class="profile-container">
            <h2 class="profile-header">Informasi Dasar</h2>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="<?php echo htmlspecialchars($user['name']); ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                        value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                </div>
                <div class="mb-3">
                    <label for="ktp_number" class="form-label">Nomor KTP</label>
                    <input type="text" class="form-control" id="ktp_number" name="ktp_number"
                        value="<?php echo htmlspecialchars($user['ktp_number']); ?>">
                </div>
                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                        value="<?php echo htmlspecialchars($user['date_of_birth']); ?>">
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select class="form-control" id="gender" name="gender">
                        <option value="Laki-laki" <?php if ($user['gender'] === 'Laki-laki') echo 'selected'; ?>>
                            Laki-laki</option>
                        <option value="Perempuan" <?php if ($user['gender'] === 'Perempuan') echo 'selected'; ?>>
                            Perempuan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
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