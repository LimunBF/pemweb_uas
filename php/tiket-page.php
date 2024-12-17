<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judul Konser</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- HEADER DAN NAVIGASI -->
<header class="bg-primary text-white py-3">
    <div class="container">
        <div class="row">
            <!-- Kolom 1: Brand Logo -->
            <div class="col-12 col-md-2 mb-3 mb-md-0">
                <div class="h4 fw-bold mb-0">EVENTURE</div>
            </div>

            <!-- Kolom 2: Search Bar dan Navigation Links -->
            <div class="col-12 col-md-8 mb-3 mb-md-0">
                <!-- Search Bar -->
                <form class="d-flex w-100 mb-2" role="search">
                    <input class="form-control me-2 w-100" type="search" placeholder="Cari konser..." aria-label="Search">
                    <button class="btn btn-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <!-- Navigation Links -->
                <nav class="w-100">
                    <a href="#" class="text-white me-3">#hashtag_trending1</a>
                    <a href="#" class="text-white me-3">#hashtag_trending2</a>
                    <a href="#" class="text-white">#hashtag_trending3</a>
                </nav>
            </div>

            <!-- Kolom 3: Explore Button -->
            <div class="col-12 col-md-1 mb-3 mb-md-0">
                <button class="btn btn-light">Explore</button>
            </div>

            <!-- Kolom 4: Login Button -->
            <div class="col-12 col-md-1 text-md-end">
                <button class="btn btn-light">Masuk</button>
            </div>
        </div>
    </div>
</header>

<!-- MAIN CONTENT -->
<main class="flex-grow-1 container my-4">
    <div class="row gx-4 gy-4 align-items-stretch">
        <!-- Judul Konser dan Banner -->
        <div class="col-md-8">
            <div class="bg-light p-4 rounded">
                <h1 class="fw-bold">Judul Konser</h1>
                <img src="assets/image-placeholder.png" class="img-fluid rounded mt-3" alt="Banner Konser">
            </div>
        </div>

        <!-- Deskripsi Konser -->
        <div class="col-md-4">
            <div class="bg-light p-4 rounded shadow">
                <h3 class="fw-bold mb-3">Deskripsi</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam facilisis leo id augue ullamcorper vulputate. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                <button class="btn btn-gradient mt-3 px-4">Beli Tiket</button>
            </div>
        </div>
    </div>
</main>

<!-- FOOTER -->
<footer class="bg-primary text-white py-3 text-center mt-4">
    <p class="mb-0">&copy; 2024 EVENTURE. All rights reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
