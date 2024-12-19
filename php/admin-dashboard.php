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
        <div class="container mt-5">
            <h2>Data Event</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Title</th>
                        <th>Event Date</th>
                        <th>Location</th>
                        <th>Organizer Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        // Gunakan koneksi yang sama
                        $sql = "SELECT * FROM events";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['event_id'] . "</td>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['event_date'] . "</td>";
                                echo "<td>" . $row['location'] . "</td>";
                                echo "<td>" . $row['organizer_name'] . "</td>";
                                echo "<td>" . $row['created_at'] . "</td>";
                                echo "<td>" . $row['updated_at'] . "</td>";
                                echo "<td>";
                                echo "<a href='edit_detail.php?event_id=" . $row['event_id'] . "' class='btn btn-warning btn-sm me-2'>Edit</a>";
                                echo "<button class='btn btn-danger btn-sm' onclick='hapusEvent(" . $row['event_id'] . ")'>Hapus</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Tidak ada data event.</td></tr>";
                        }
                    } catch(Exception $e) {
                        echo "<tr><td colspan='8'>Kesalahan: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Navigasi untuk About Us -->
        <h2 class="mt-5">Navigasi Edit About Us</h2>
        <a href="our-team.php" class="btn btn-info">Edit About Us</a>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        //fungsi pop-up hapus event
        function hapusEvent(eventId) {
            if (confirm('Yakin akan menghapus event ini?')) {
                fetch('hapus-event.php', { 
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, 
                    body: new URLSearchParams({ event_id: eventId }) 
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Event berhasil dihapus');
                        location.reload();
                    } else {
                        console.error('Kesalahan respons:', data);
                        alert('Terjadi kesalahan saat menghapus event');
                    }
                })
                .catch(error => {
                    console.error('Error saat parsing JSON:', error);
                    alert('Terjadi kesalahan saat memproses permintaan.');
                });
            }
        }
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
