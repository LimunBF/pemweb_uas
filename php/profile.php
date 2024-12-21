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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update data pengguna
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $ktp_number = $_POST['ktp_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];

    $updateStmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, phone_number = :phone_number, ktp_number = :ktp_number, date_of_birth = :date_of_birth, gender = :gender WHERE user_id = :user_id");
    $updateStmt->bindParam(':name', $name);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':phone_number', $phone_number);
    $updateStmt->bindParam(':ktp_number', $ktp_number);
    $updateStmt->bindParam(':date_of_birth', $date_of_birth);
    $updateStmt->bindParam(':gender', $gender);
    $updateStmt->bindParam(':user_id', $user_id);
    $updateStmt->execute();

    header("Location: profile.php");
    exit();
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
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
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
            align-items: center;
            justify-content: center;
            color: white;
            width: 100%;
            height: 50px; /* Match other buttons */
            cursor: pointer;
        }
        .sidebar .toggle-button :hover {
            background-color: #031125;
        }
        .sidebar.shrink .toggle-button {
            left: 10px;
        }
        .sidebar .toggle-button span {
            margin-left: 10px;
            color: white;
        }
        .sidebar.shrink .toggle-button span {
            display: none;
        }
        .dropdown-toggle {
            background-color: #0b2341;
            border: none;
            color: white;
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
    </style>
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content-container');
            sidebar.classList.toggle('shrink');
            content.classList.toggle('shrink');
        }
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #0b2341;">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white" href="index.php">LOKÉT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $dropdownName; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="profile.php">Informasi Dasar</a></li>
                        <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="php/logout.php">Keluar</a></li>
                    </ul>
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
        <div class="profile-container">
            <h2 class="text-center mb-4">Profil Kamu</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                </div>
                <div class="mb-3">
                    <label for="ktp_number" class="form-label">Nomor KTP</label>
                    <input type="text" class="form-control" id="ktp_number" name="ktp_number" value="<?php echo htmlspecialchars($user['ktp_number']); ?>">
                </div>
                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo $user['date_of_birth']; ?>">
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select class="form-control" id="gender" name="gender">
                        <option value="Laki-laki" <?php if ($user['gender'] === 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php if ($user['gender'] === 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
