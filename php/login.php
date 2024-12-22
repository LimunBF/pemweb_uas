<?php
session_start();

// Periksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../connection/connect.php';
    $pdo = getDatabaseConnection();

    try {
        // Siapkan dan eksekusi pernyataan
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();

        // Periksa apakah pengguna ada
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $passwordCorrect = false;

            // Verifikasi password (hash atau plaintext)
            if (password_verify($_POST['password'], $user['password'])) {
                $passwordCorrect = true; // Password cocok dengan hash
            } elseif ($_POST['password'] === $user['password']) {
                $passwordCorrect = true; // Password cocok dengan plaintext

                // Perbarui password plaintext ke hash
                $newHashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
                $updateStmt->bindParam(':password', $newHashedPassword);
                $updateStmt->bindParam(':email', $user['email']);
                $updateStmt->execute();
            }

            // Jika password benar
            if ($passwordCorrect) {
                // Set session
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];

                // Arahkan berdasarkan role
                if ($user['role'] === 'admin') {
                    header("Location: admin-dashboard.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            } else {
                $error = "Email atau kata sandi salah.";
            }
        } else {
            $error = "Email atau kata sandi salah.";
        }
    } catch (PDOException $e) {
        echo "Koneksi gagal: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BÉLI TIKÉT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
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
            <a class="navbar-brand fw-bold" href="../index.php">BÉLI TIKÉT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn bg-lightnav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary me-2" href="register.php">Daftar</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-daftar-masuk-active btn-outline-light me-2 active" aria-current="page" href="login.php">Masuk</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Form Login -->
    <div class="login-container">
        <h2 class="text-center mb-4">Masuk ke Akun Anda</h2>
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
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
        <p class="mt-3 text-center">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; 2024 BÉLI TIKÉT. Semua Hak Dilindungi.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
