<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .nav-tabs .nav-link {
            color: #3c4c8c;
            font-weight: bold;
        }
        .nav-tabs .nav-link.active {
            background-color: #3c4c8c;
            color: #fff;
        }
        .tab-content {
            border: 1px solid #dee2e6;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .bg-payment {
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
        }
        .bg-primary {
            background-color: #3c4c8c !important; /* Menimpa warna default Bootstrap */
            color: white !important; /* Warna teks tetap putih */
        }
        /* Gradient Background untuk tombol "Beli Tiket" */
        .btn-gradient {
            background: linear-gradient(to top right, #3c4c8c, #ecddd9, #f1b0bb); /* Gradasi awal */
            color: white; /* Warna teks putih */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            transition: background-position 0.3s ease, color 0.3s ease; /* Transisi untuk posisi latar belakang dan warna teks */
            background-size: 200% 200%; /* Mengatur ukuran latar belakang untuk efek pergerakan */
            background-position: bottom left; /* Posisi awal latar belakang */
        }
        /* Hover Effect: Gradasi bergerak dan berubah menjadi #3c4c8c */
        .btn-gradient:hover {
            background-position: top right; /* Menggerakkan latar belakang saat hover */
            background: linear-gradient(to top right, #3c4c8c, #3c4c8c, #3c4c8c); /* Gradasi berubah menjadi satu warna */
            color: #ecddd9; /* Warna teks saat hover */
        }
        /* Gradient Background untuk tombol "Beli Tiket" */
        .btn-gradient2 {
            background: linear-gradient(to top right, #FFFFFF, #FFFFFF, #FFFFFF); /* Gradasi awal */
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            transition: background-position 0.3s ease, color 0.3s ease; /* Transisi untuk posisi latar belakang dan warna teks */
            background-size: 200% 200%; /* Mengatur ukuran latar belakang untuk efek pergerakan */
            background-position: bottom left; /* Posisi awal latar belakang */
        }
        .btn-gradient2:hover {
            background-position: top right; /* Menggerakkan latar belakang saat hover */
            background: linear-gradient(to top right, #3c4c8c, #ecddd9, #f1b0bb); /* Gradasi berubah menjadi satu warna */
            color: #FFFFFF; /* Warna teks saat hover */
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- HEADER -->
<header class="bg-primary text-white py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="h4 fw-bold mb-0">EVENTURE</div>
        <div id="currentPage" class="fw-normal fs-5">Pilih Tiket</div>
    </div>
</header>

<!-- MAIN CONTENT -->
<main class="container my-4 flex-grow-1">
    <div class="row gx-4">
        <!-- TAB NAVIGATION -->
    <div class="col-md-8">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tiket-tab" data-bs-toggle="tab" data-bs-target="#tiket" type="button" role="tab">1. Pilih Tiket</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="biodata-tab" data-bs-toggle="tab" data-bs-target="#biodata" type="button" role="tab" disabled>2. Biodata</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="konfirmasi-tab" data-bs-toggle="tab" data-bs-target="#konfirmasi" type="button" role="tab" disabled>3. Konfirmasi</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pembayaran-tab" data-bs-toggle="tab" data-bs-target="#pembayaran" type="button" role="tab" disabled>4. Pembayaran</button>
        </li>
    </ul>

    <!-- TAB CONTENT -->
    <div class="tab-content">
        <!-- TAB 1: Pilih Tiket -->
        <div class="tab-pane fade show active" id="tiket" role="tabpanel">
            <h3 class="fw-bold mb-3">Pilih Tiket</h3>
            <div class="mb-4">
                <h5>Jenis Tiket 1</h5>
                <p>Harga: Rp 500.000</p>
                <select class="form-select w-auto" id="jumlahTiket1">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
            </div>
            <div class="mb-4">
                <h5>Jenis Tiket 2</h5>
                <p>Harga: Rp 750.000</p>
                <select class="form-select w-auto" id="jumlahTiket2">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
            </div>
            <button class="btn btn-gradient" id="btnCheckout">Checkout</button>
        </div>

        <!-- TAB 2: Biodata -->
        <div class="tab-pane fade" id="biodata" role="tabpanel">
            <h3 class="fw-bold mb-3">Isi Biodata</h3>
            <form>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <button class="btn btn-gradient" id="btnKonfirmasi">Lanjutkan</button>
            </form>
        </div>

        <!-- TAB 3: Konfirmasi -->
        <div class="tab-pane fade" id="konfirmasi" role="tabpanel">
            <h3 class="fw-bold mb-3">Konfirmasi</h3>
            <p>Email: <strong id="emailKonfirmasi"></strong></p>
            <p>Metode Pembayaran:</p>
            <select class="form-select w-auto mb-3">
                <option>Transfer Bank</option>
                <option>Virtual Account</option>
                <option>E-Wallet</option>
            </select>
            <button class="btn btn-gradient" id="btnPembayaran">Bayar Sekarang</button>
        </div>

        <!-- TAB 4: Pembayaran -->
        <div class="tab-pane fade" id="pembayaran" role="tabpanel">
            <h3 class="fw-bold mb-3">Pembayaran</h3>
            <div class="bg-payment">
                <p>Batas Waktu Pembayaran: <strong>24 Jam</strong></p>
                <p>Silakan lakukan pembayaran sebelum batas waktu habis.</p>
            </div>
        </div>
    </div>
    </div>
    
    <div class="col-md-4">
    <div class="p-4 rounded bg-primary text-white shadow">
                <h4 class="fw-bold mb-4">Daftar Tiket yang Dipesan</h4>
                <p>Tiket yang Anda pilih akan muncul di sini.</p>
                <ul class="list-unstyled">
                    <li class="mb-2">Jenis Tiket 1: <strong>2</strong> x Rp 500.000</li>
                    <li class="mb-2">Jenis Tiket 2: <strong>1</strong> x Rp 750.000</li>
                </ul>
                <hr class="bg-light">
                <p class="fs-5 fw-bold">Total: <span>Rp 1.750.000</span></p>
                <button class="btn btn-gradient2 w-100 mt-3">Checkout</button>
            </div>
    </div>
    </div>
</main>

<!-- FOOTER -->
<footer class="bg-primary text-white py-3 text-center">
    <p class="mb-0">&copy; 2024 EVENTURE. All rights reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script>
    const jumlahTiket1 = document.getElementById('jumlahTiket1');
    const jumlahTiket2 = document.getElementById('jumlahTiket2');
    const daftarTiket = document.querySelector('.list-unstyled');
    const totalHarga = document.querySelector('.fs-5 span');

    const hargaTiket1 = 500000; // Harga Tiket 1
    const hargaTiket2 = 750000; // Harga Tiket 2

    function updateDaftarTiket() {
        const jumlah1 = parseInt(jumlahTiket1.value);
        const jumlah2 = parseInt(jumlahTiket2.value);

        // Kosongkan daftar tiket
        daftarTiket.innerHTML = '';

        let total = 0;

        // Tambahkan tiket 1 jika jumlahnya lebih dari 0
        if (jumlah1 > 0) {
            daftarTiket.innerHTML += `
                <li class="mb-2">Jenis Tiket 1: <strong>${jumlah1}</strong> x Rp ${hargaTiket1.toLocaleString('id-ID')}</li>
            `;
            total += jumlah1 * hargaTiket1;
        }

        // Tambahkan tiket 2 jika jumlahnya lebih dari 0
        if (jumlah2 > 0) {
            daftarTiket.innerHTML += `
                <li class="mb-2">Jenis Tiket 2: <strong>${jumlah2}</strong> x Rp ${hargaTiket2.toLocaleString('id-ID')}</li>
            `;
            total += jumlah2 * hargaTiket2;
        }

        // Update total harga
        totalHarga.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    // Event listener untuk mendeteksi perubahan dropdown
    jumlahTiket1.addEventListener('change', updateDaftarTiket);
    jumlahTiket2.addEventListener('change', updateDaftarTiket);

    // Inisialisasi daftar tiket pada saat halaman pertama kali dimuat
    updateDaftarTiket();

    const btnCheckout = document.getElementById('btnCheckout');
    const btnKonfirmasi = document.getElementById('btnKonfirmasi');
    const btnPembayaran = document.getElementById('btnPembayaran');
    const emailInput = document.getElementById('email');
    const emailKonfirmasi = document.getElementById('emailKonfirmasi');
    const tabs = document.querySelectorAll('.nav-link');
    const currentPage = document.getElementById('currentPage');

    btnCheckout.addEventListener('click', () => {
        const jumlah1 = parseInt(jumlahTiket1.value);
        const jumlah2 = parseInt(jumlahTiket2.value);

        // Validasi apakah ada tiket yang dipilih
        if (jumlah1 === 0 && jumlah2 === 0) {
            alert('Pilih setidaknya satu tiket sebelum melanjutkan.');
            return;
        }

        document.querySelector('#biodata-tab').disabled = false;
        document.querySelector('#biodata-tab').click();
    });

    btnKonfirmasi.addEventListener('click', (e) => {
        e.preventDefault();

        // Validasi email sebelum melanjutkan
        if (!emailInput.value) {
            alert('Masukkan email terlebih dahulu.');
            return;
        }

        emailKonfirmasi.textContent = emailInput.value;
        document.querySelector('#konfirmasi-tab').disabled = false;
        document.querySelector('#konfirmasi-tab').click();
    });

    btnPembayaran.addEventListener('click', () => {
        document.querySelector('#pembayaran-tab').disabled = false;
        document.querySelector('#pembayaran-tab').click();
    });

    // Fungsi untuk mengganti nama halaman
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            currentPage.textContent = tab.textContent; // Ubah teks header sesuai tab
        });
    });
</script>

</body>
</html>
