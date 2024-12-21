<?php
session_start();

// Periksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../connection/connect.php';
    $pdo = getDatabaseConnection();

    // Ambil data dari form
    $email = $_POST['email'];
    $password_input = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if ($password_input !== $confirm_password) {
        $error = "Kata sandi dan konfirmasi kata sandi tidak cocok.";
    } else {
        try {
            // Periksa apakah email sudah terdaftar
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $error = "Email sudah terdaftar. Silakan gunakan email lain.";
            } else {
                // Hash password
                $hashed_password = password_hash($password_input, PASSWORD_DEFAULT);

                // Siapkan dan eksekusi pernyataan untuk memasukkan data baru
                $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->execute();

                // Redirect ke halaman login setelah berhasil registrasi
                header("Location: login.php?register=success");
                exit();
            }
        } catch(PDOException $e) {
            echo "Koneksi gagal: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Lokét</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            max-width: 400px;
            margin: 80px auto;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="../index.php">LOKÉT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">   
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="register.php">Daftar</a>
                    </li>   
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Masuk</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Form Registrasi -->
    <div class="register-container">
        <h2 class="text-center mb-4">Registrasi Akun Baru</h2>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
        <p class="mt-3 text-center">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; 2024 Lokét. Semua Hak Dilindungi.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
