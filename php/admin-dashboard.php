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

$topTicketsData = [];
$sql = "
    SELECT 
        events.title AS event_title,
        tickets.ticket_type AS ticket_type,
        SUM(purchase_history.quantity) AS total_quantity
    FROM 
        purchase_history
    INNER JOIN 
        events ON purchase_history.event_id = events.event_id
    INNER JOIN 
        tickets ON purchase_history.ticket_id = tickets.ticket_id
    GROUP BY 
        events.title, tickets.ticket_type
    ORDER BY 
        total_quantity DESC
    LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $topTicketsData[] = [
            'label' => $row['event_title'] . ' - ' . $row['ticket_type'], // Gabungkan event title dan ticket type
            'quantity' => $row['total_quantity']
        ];
    }
}

// Ekstrak label dan data untuk grafik
$ticketLabels = array_column($topTicketsData, 'label');
$ticketQuantities = array_column($topTicketsData, 'quantity');
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
</head>

<body>
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand fw-bold" href="../index.php">BÉLI TIKÉT</a>

                <!-- Menu Kanan -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="btn btn-light d-flex align-items-center gap-2 px-3" id="dropdownMenuButton" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fas fa-circle-user fa-lg"></i>
                            <span>Admin</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li class="dropdown-header">Halo, Admin</li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php">Keluar</a></li>
                        </ul>
                    </div>
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

        <!-- Grafik Tiket Terlaris -->
        <div class="mb-4">
            <h4>Tiket Terlaris</h4>
            <canvas id="topTicketsChart" style="width: 100%; height: 400px;"></canvas>
        </div>
    </div>

    <footer>
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-links">
                    <a href="tentang_kami.php">Tentang Kami</a>
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
                <p class="copyright">&copy; 2024 Beli Tiket (PT Global Loket Sejahtera)</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Data Tiket dari PHP
        const ticketLabels = <?php echo json_encode($ticketLabels); ?>;
        const ticketData = <?php echo json_encode($ticketQuantities); ?>;

        // Render Chart
        const ctxTopTickets = document.getElementById('topTicketsChart').getContext('2d');
        const topTicketsChart = new Chart(ctxTopTickets, {
            type: 'bar',
            data: {
                labels: ticketLabels,
                datasets: [{
                    label: 'Tiket Terjual',
                    data: ticketData,
                    backgroundColor: ['#0b2341', '#1d4d7e', '#2f80ed', '#0b2341', '#1d4d7e'],
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
    </script>
</body>

</html>

<?php $conn->close(); ?>