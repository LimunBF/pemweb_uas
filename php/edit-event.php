<?php
// Koneksi ke database
include 'db_connection.php';

// Periksa apakah parameter event_id ada di URL
if (!isset($_GET['event_id'])) {
    header('Location: admin-dashboard.php'); // Redirect jika tidak ada event_id
    exit;
}

$event_id = intval($_GET['event_id']);

// Ambil data event berdasarkan event_id
$sql = "SELECT * FROM events WHERE event_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Event tidak ditemukan!'); window.location.href = 'admin-dashboard.php';</script>";
    exit;
}

$event = $result->fetch_assoc();

// Proses update data jika form disubmit
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

    $sql_update = "UPDATE events SET title = ?, description = ?, event_date = ?, location = ?, organizer_name = ?, event_type = ?, dress_code = ?, min_age = ?, facilities = ?, updated_at = NOW() WHERE event_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('sssssssisi', $title, $description, $event_date, $location, $organizer_name, $event_type, $dress_code, $min_age, $facilities, $event_id);

    if ($stmt_update->execute()) {
        echo "<script>alert('Event berhasil diperbarui!'); window.location.href = 'admin-dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui event!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Edit Event</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($event['description']); ?></textarea>
        </div>

        <!-- Event Date -->
        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <input type="date" class="form-control" id="event_date" name="event_date" value="<?php echo htmlspecialchars($event['event_date']); ?>" required>
        </div>

        <!-- Location -->
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>
        </div>

        <!-- Organizer Name -->
        <div class="mb-3">
            <label for="organizer_name" class="form-label">Organizer Name</label>
            <input type="text" class="form-control" id="organizer_name" name="organizer_name" value="<?php echo htmlspecialchars($event['organizer_name']); ?>" required>
        </div>

        <!-- Event Type -->
        <div class="mb-3">
            <label for="event_type" class="form-label">Event Type</label>
            <input type="text" class="form-control" id="event_type" name="event_type" value="<?php echo htmlspecialchars($event['event_type']); ?>" required>
        </div>

        <!-- Dress Code -->
        <div class="mb-3">
            <label for="dress_code" class="form-label">Dress Code</label>
            <input type="text" class="form-control" id="dress_code" name="dress_code" value="<?php echo htmlspecialchars($event['dress_code']); ?>" required>
        </div>

        <!-- Minimum Age -->
        <div class="mb-3">
            <label for="min_age" class="form-label">Minimum Age</label>
            <input type="number" class="form-control" id="min_age" name="min_age" value="<?php echo htmlspecialchars($event['min_age']); ?>" required>
        </div>

        <!-- Facilities -->
        <div class="mb-3">
            <label for="facilities" class="form-label">Facilities</label>
            <textarea class="form-control" id="facilities" name="facilities" rows="2" required><?php echo htmlspecialchars($event['facilities']); ?></textarea>
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="admin-dashboard.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>