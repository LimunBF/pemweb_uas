<?php
session_start();

// Periksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ganti dengan kredensial database Anda
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "loket_com";

    // Ambil data dari form
    $email = $_POST['email'];
    $password_input = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if ($password_input !== $confirm_password) {
        $error = "Kata sandi dan konfirmasi kata sandi tidak cocok.";
    } else {
        try {
            // Membuat koneksi menggunakan PDO
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Atur mode error PDO ke exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Periksa apakah email sudah terdaftar
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $error = "Email sudah terdaftar. Silakan gunakan email lain.";
            } else {
                // Hash password
                $hashed_password = password_hash($password_input, PASSWORD_DEFAULT);

                // Siapkan dan eksekusi pernyataan untuk memasukkan data baru
                $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
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
<html lang="en">
<head>
    <!-- ... (sama seperti di template Anda) ... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Informasi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar (sama seperti di template) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistem Informasi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Form Registrasi -->
    <div class="container my-5">
        <h2 class="text-center">Registrasi Akun Baru</h2>
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
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
        <p class="mt-3">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
    </div>

    <!-- Footer (sama seperti di template) -->
    <footer class="bg-light text-center py-4">
        <p class="mb-0">
            <a href="php/our-team.php" class="text-dark">© 2024 Sistem Informasi. All Rights Reserved.</a>
        </p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
