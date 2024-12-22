<?php
include_once '../connection/connect.php';

try {
    $pdo = getDatabaseConnection();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
// Periksa apakah event_id diberikan
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Ambil data event berdasarkan event_id
    $stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        echo "Event tidak ditemukan.";
        exit;
    }
} else {
    echo "ID event tidak diberikan.";
    exit;
}

// Proses form submission untuk memperbarui event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $organizer_name = $_POST['organizer_name'];
    $event_type = $_POST['event_type'];
    $dress_code = $_POST['dress_code'];
    $min_age = intval($_POST['min_age']);
    $facilities = $_POST['facilities'];

    // Persiapkan query update
    $sql_update = "UPDATE events SET title = ?, description = ?, event_date = ?, location = ?, organizer_name = ?, event_type = ?, dress_code = ?, min_age = ?, facilities = ?, updated_at = NOW() WHERE event_id = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$title, $description, $event_date, $location, $organizer_name, $event_type, $dress_code, $min_age, $facilities, $event_id]);

    echo "<script>alert('Event berhasil diperbarui!'); window.location.href = 'admin-dashboard.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar_footer.css">
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
                    <!-- Tombol Kembali -->
                    <a href="admin-dashboard.php" class="btn btn-outline-light d-flex align-items-center gap-2 px-3">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
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
    <div class="container-fluid mt-6">
        <div class="container-sm mt-4" style="max-width: 900px;"> <!-- Membatasi lebar -->
            <h3 class="mb-4">Edit Event</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($event['description']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="event_date" class="form-label">Event Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" value="<?php echo htmlspecialchars($event['event_date']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="organizer_name" class="form-label">Organizer Name</label>
                    <input type="text" class="form-control" id="organizer_name" name="organizer_name" value="<?php echo htmlspecialchars($event['organizer_name']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="event_type" class="form-label">Event Type</label>
                    <input type="text" class="form-control" id="event_type" name="event_type" value="<?php echo htmlspecialchars($event['event_type']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="dress_code" class="form-label">Dress Code</label>
                    <input type="text" class="form-control" id="dress_code" name="dress_code" value="<?php echo htmlspecialchars($event['dress_code']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="min_age" class="form-label">Min Age</label>
                    <input type="number" class="form-control" id="min_age" name="min_age" value="<?php echo htmlspecialchars($event['min_age']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="facilities" class="form-label">Facilities</label>
                    <textarea class="form-control" id="facilities" name="facilities" rows="4" required><?php echo htmlspecialchars($event['facilities']); ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <a href="admin-dashboard.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
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
                <p class="copyright">&copy; 2024 Beli Tiket (PT Global Loket Sejahtera)</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
