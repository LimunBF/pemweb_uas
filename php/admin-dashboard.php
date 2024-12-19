<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna telah login dan memiliki peran admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php'); // Redirect ke halaman utama jika bukan admin
    exit();
}

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loket_com";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/admin_dashboard.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">Admin Dashboard</a>
                <div class="d-flex">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-4">
        <h1 class="mb-4">Selamat Datang, Admin</h1>

        <!-- Grafik Dinamis -->
        <h2>Statistik</h2>
        <canvas id="chart" style="width: 100%; height: 400px;"></canvas>

        <!-- Tabel Konten Home -->
        <h2 class="mt-5">Konten Halaman Home</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil data dari database (sesuaikan query dengan struktur tabel Anda)
                $sql = "SELECT * FROM konten_home"; // Ubah "konten_home" sesuai dengan nama tabel Anda
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td><input type='text' class='form-control' value='" . $row['judul'] . "' id='judul-" . $row['id'] . "'></td>";
                        echo "<td><textarea class='form-control' id='deskripsi-" . $row['id'] . "'>" . $row['deskripsi'] . "</textarea></td>";
                        echo "<td><img src='assets/images/" . $row['gambar'] . "' alt='" . $row['judul'] . "' width='100'></td>";
                        echo "<td><button class='btn btn-primary save-btn' data-id='" . $row['id'] . "'>Simpan</button></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <!-- Navigasi untuk About Us -->
        <h2 class="mt-5">Navigasi Edit About Us</h2>
        <a href="edit_about_us.php" class="btn btn-info">Edit About Us</a>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Dummy data untuk grafik (ubah sesuai data dari database nanti)
        const ctx = document.getElementById('chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                datasets: [{
                    label: 'Pengunjung',
                    data: [10, 20, 30, 40, 50, 60], // Ganti data ini dengan data dari database
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            }
        });

        // Simpan perubahan konten home
        document.querySelectorAll('.save-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const judul = document.getElementById(`judul-${id}`).value;
                const deskripsi = document.getElementById(`deskripsi-${id}`).value;

                fetch('update_konten_home.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id, judul, deskripsi })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Perubahan berhasil disimpan');
                    } else {
                        alert('Terjadi kesalahan saat menyimpan perubahan');
                    }
                });
            });
        });
    </script>
</body>

</html>
<?php $conn->close(); ?>
