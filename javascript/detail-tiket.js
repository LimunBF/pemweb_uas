const jumlahTiket1 = document.getElementById('jumlahTiket1');
const jumlahTiket2 = document.getElementById('jumlahTiket2');
const daftarTiket = document.querySelector('.list-unstyled');
const totalHarga = document.querySelector('.fs-5 span');

const hargaTiket1 = 500000; // Harga Tiket 1
const hargaTiket2 = 750000; // Harga Tiket 2

const btnBayar = document.getElementById('btnBayar'); // Tombol Selesaikan Pembayaran
const btnCheckout = document.getElementById('btnCheckout');
const btnCheckout2 = document.getElementById('btnCheckout2');
const btnKonfirmasi = document.getElementById('btnKonfirmasi');
const btnPembayaran = document.getElementById('btnPembayaran');
const emailInput = document.getElementById('email');
const emailKonfirmasi = document.getElementById('emailKonfirmasi');
const tabs = document.querySelectorAll('.nav-link');
const currentPage = document.getElementById('currentPage');

// Fungsi untuk memperbarui daftar tiket
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

// Tombol Checkout
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

// Tombol Konfirmasi
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

// Tombol Pembayaran
btnPembayaran.addEventListener('click', () => {
    document.querySelector('#pembayaran-tab').disabled = false;
    document.querySelector('#pembayaran-tab').click();
});

// Aktifkan tombol "Selesaikan Pembayaran" hanya pada tab 4
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        if (tab.id === 'pembayaran-tab') {
            btnBayar.removeAttribute('disabled'); // Aktifkan tombol
        } else {
            btnBayar.setAttribute('disabled', true); // Nonaktifkan tombol
        }

        // Update nama halaman sesuai tab yang aktif
        currentPage.textContent = tab.textContent;
    });
});

// Tombol Checkout 2
btnCheckout2.addEventListener('click', () => {
    const jumlah1 = parseInt(jumlahTiket1.value);
    const jumlah2 = parseInt(jumlahTiket2.value);

    if (jumlah1 === 0 && jumlah2 === 0) {
        alert('Anda belum memilih tiket. Silakan pilih tiket terlebih dahulu.');
        return;
    }

    if (confirm('Apakah Anda yakin ingin melanjutkan ke biodata?')) {
        document.querySelector('#biodata-tab').disabled = false;
        document.querySelector('#biodata-tab').click();
    }
});
