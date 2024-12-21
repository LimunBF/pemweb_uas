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
    <link rel="stylesheet" type="text/css" href="../css/admin-dashboard.css">
    <link rel="stylesheet" type="text/css" href="../css/navbar_footer.css">
    <style>
        /* Custom Pagination Styling */
        .custom-pagination .page-item .custom-page-link {
            background-color: #152c52;
            color: #a0b8d8;
            border: none;
            padding: 10px 15px;
            margin: 0 5px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .custom-pagination .page-item .custom-page-link:hover {
            background-color: #2f80ed;
            color: white;
        }

        .custom-pagination .page-item.active .custom-page-link {
            background-color: #0b2341;
            color: white;
            font-weight: bold;
            border: 2px solid #2f80ed;
        }
    </style>
</head>

<body>
    <header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="#">LOKÉT</a>
            <!-- Menu Kanan -->
            <div style="color: white;" class="d-flex align-items-center">
            </div>
        </div>
    </nav>
    </header>

    <div class="container my-4">
        <h1 class="mb-4">Selamat Datang, Admin</h1><br>

        <h4>Data Event</h4>
        <?php
        // Variabel untuk pagination
        $limit = 5; // Jumlah data per halaman
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
        $offset = ($currentPage - 1) * $limit; // Hitung offset

        try {
            // Hitung total data
            $sqlCount = "SELECT COUNT(*) as total FROM events";
            $resultCount = $conn->query($sqlCount);
            $totalData = $resultCount->fetch_assoc()['total'];
            $totalPages = ceil($totalData / $limit); // Hitung jumlah halaman

            // Ambil data sesuai halaman
            $sql = "SELECT * FROM events LIMIT $limit OFFSET $offset";
            $result = $conn->query($sql);
        ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Title</th>
                    <th>Event Date</th>
                    <th>Location</th>
                    <th>Organizer Name</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['event_id'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['event_date'] . "</td>";
                        echo "<td>" . $row['location'] . "</td>";
                        echo "<td>" . $row['organizer_name'] . "</td>";
                        echo "<td>";
                        echo "<a href='edit-event.php?event_id=" . $row['event_id'] . "' class='btn btn-warning btn-sm me-2'>Edit</a>";
                        echo "<button class='btn btn-danger btn-sm' onclick='hapusEvent(" . $row['event_id'] . ")'>Hapus</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data event.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Navigasi Pagination -->
        <nav>
            <ul class="pagination justify-content-center custom-pagination">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link custom-page-link" href="?page=<?php echo $currentPage - 1; ?>">&laquo; Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i == $currentPage) ? 'active custom-active' : ''; ?>">
                        <a class="page-link custom-page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link custom-page-link" href="?page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <?php
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Kesalahan: " . $e->getMessage() . "</div>";
        }
        ?>

        <!-- Grafik Dinamis -->
        <div class="mb-4">
            <h4>Tiket Terlaris</h4>
            <canvas id="topTicketsChart" style="width: 100%; height: 400px;"></canvas>
        </div>
        <div class="mb-4">
            <h4>Penjualan Bulanan</h4>
            <canvas id="monthlySalesChart" style="width: 100%; height: 400px;"></canvas>
        </div>

        <div class="container mt-5">

    </div>

        <!-- Navigasi untuk About Us -->
        <h2 class="mt-5">Edit Tentang Kami</h2>
        <a href="tentang_kami.php" class="btn btn-info">Go To Tentang Kami</a>
    </div>

    <footer>
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-links">
                    <a href="php/tentang_kami.php">Tentang Kami</a>
                    <span>•</span>
                    <a href="#">Blog</a>
                    <span>•</span>
                    <a href="#">Kebijakan Privasi</a>
                    <span>•</span>
                    <a href="#">Kebijakan Cookie</a>
                    <span>•</span>
                    <a href="#">Panduan</a>
                    <span>•</span>
                    <a href="#">Hubungi Kami</a>
                </div>
                <p class="copyright">&copy; 2024 Loket (PT Global Loket Sejahtera)</p>
            </div>
        </div>
    </footer>

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
        document.addEventListener("DOMContentLoaded", function () {
            // Dummy data untuk Tiket Terlaris
            const ticketLabels = ['Tiket A', 'Tiket B', 'Tiket C', 'Tiket D', 'Tiket E'];
            const ticketData = [120, 80, 150, 90, 60]; // Data dummy, ganti dengan data dari database

            const ctxTopTickets = document.getElementById('topTicketsChart').getContext('2d');
            const topTicketsChart = new Chart(ctxTopTickets, {
                type: 'bar',
                data: {
                    labels: ticketLabels,
                    datasets: [{
                        label: 'Tiket Terjual',
                        data: ticketData,
                        backgroundColor: ['#0b2341', '#0b2341', '#0b2341', '#0b2341', '#0b2341'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Dummy data untuk Penjualan Bulanan
            const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const monthlyData = [300, 400, 350, 500, 450, 600, 550, 700, 400, 800, 750, 900]; // Data dummy, ganti dengan data dari database

            const ctxMonthlySales = document.getElementById('monthlySalesChart').getContext('2d');
            const monthlySalesChart = new Chart(ctxMonthlySales, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Penjualan Bulanan',
                        data: monthlyData,
                        borderColor: '#FF6384',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
<?php $conn->close(); ?>
