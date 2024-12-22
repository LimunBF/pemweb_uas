document.addEventListener('DOMContentLoaded', function() {
    // Get current parameters from URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentLocation = urlParams.get('location') || '';

    // Lokasi section toggle
    const lokasiHeader = document.querySelector('.lokasi-header');
    const lokasiContent = document.querySelector('.lokasi-content');
    const searchLocation = document.getElementById('searchLocation');
    const locationList = document.getElementById('locationList');

    // Daftar kota yang selalu ditampilkan
    const defaultCities = [
        'Semua Lokasi',
        'Jakarta',
        'Bandung',
        'Surabaya',
        'Yogyakarta'
    ];

    // Daftar semua kota (termasuk yang hanya muncul saat pencarian)
    const allCities = [
        'Semua Lokasi',
        'Jakarta',
        'Bandung',
        'Surabaya',
        'Yogyakarta',
        'Bali',
        'Malang',
        'Semarang',
        'Medan',
        'Makassar',
        'Palembang',
        'Bogor',
        'Depok',
        'Tangerang',
        'Bekasi'
    ];

    // Function untuk memfilter dan menampilkan lokasi
    function filterLocations(searchText = '') {
        const searchLower = searchText.toLowerCase().trim();
        
        // Gunakan defaultCities jika tidak ada pencarian
        const citiesToShow = searchLower === '' ? defaultCities : allCities;
        
        // Filter kota berdasarkan input pencarian
        const filteredCities = citiesToShow.filter(city => 
            city.toLowerCase().includes(searchLower) || city === 'Semua Lokasi'
        );

        // Render hasil pencarian
        let html = '';
        filteredCities.forEach(city => {
            const value = city === 'Semua Lokasi' ? '' : city;
            const isSelected = currentLocation === value;
            html += `
                <div class="location-item ${isSelected ? 'selected' : ''}" 
                     data-value="${value}">
                    ${city}
                </div>
            `;
        });

        // Tampilkan pesan jika tidak ada hasil
        if (filteredCities.length === 1 && searchLower !== '') {
            html += `
                <div class="text-muted p-3">
                    Tidak ada lokasi yang sesuai
                </div>
            `;
        }

        locationList.innerHTML = html;
        addLocationClickEvents();
    }

    // Function untuk menambahkan event click ke setiap item lokasi
    function addLocationClickEvents() {
        document.querySelectorAll('.location-item').forEach(item => {
            item.addEventListener('click', function() {
                const value = this.dataset.value;
                const urlParams = new URLSearchParams(window.location.search);
                
                if (value) {
                    urlParams.set('location', value);
                } else {
                    urlParams.delete('location');
                }

                // Preserve other parameters
                const sort = urlParams.get('sort');
                if (sort) {
                    urlParams.set('sort', sort);
                }
                
                const month = urlParams.get('month');
                if (month) {
                    urlParams.set('month', month);
                }

                window.location.search = urlParams.toString();
            });
        });
    }

    // Event listener untuk input pencarian dengan debounce
    let searchTimeout;
    searchLocation.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterLocations(e.target.value);
        }, 300);
    });

    // Toggle lokasi section
    lokasiHeader.addEventListener('click', function() {
        lokasiHeader.classList.toggle('active');
        const isVisible = lokasiContent.style.display === 'block';
        lokasiContent.style.display = isVisible ? 'none' : 'block';
        
        if (!isVisible) {
            filterLocations(''); // Reset dan tampilkan semua lokasi
            searchLocation.value = ''; // Reset input pencarian
            searchLocation.focus(); // Focus ke input pencarian
        }
    });

    // Show location content if location is selected
    if (currentLocation) {
        lokasiHeader.classList.add('active');
        lokasiContent.style.display = 'block';
        filterLocations(''); // Tampilkan semua lokasi
    }

    // Reset filter
    document.getElementById('resetFilter').addEventListener('click', function() {
        window.location.href = 'jelajah.php';
    });

    // Waktu section
    const waktuHeader = document.querySelector('.waktu-header');
    const waktuContent = document.querySelector('.waktu-content');
    const monthList = document.getElementById('monthList');
    const currentMonth = urlParams.get('month') || '';

    // Daftar nama bulan
    const months = [
        { value: '2024-01', name: 'Januari' },
        { value: '2024-02', name: 'Februari' },
        { value: '2024-03', name: 'Maret' },
        { value: '2024-04', name: 'April' },
        { value: '2024-05', name: 'Mei' },
        { value: '2024-06', name: 'Juni' },
        { value: '2024-07', name: 'Juli' },
        { value: '2024-08', name: 'Agustus' },
        { value: '2024-09', name: 'September' },
        { value: '2024-10', name: 'Oktober' },
        { value: '2024-11', name: 'November' },
        { value: '2024-12', name: 'Desember' }
    ];

    // Function untuk menampilkan daftar bulan
    function renderMonths() {
        let html = '';
        months.forEach(month => {
            const isSelected = currentMonth === month.value;
            html += `
                <div class="month-item ${isSelected ? 'selected' : ''}" 
                     data-value="${month.value}">
                    ${month.name}
                </div>
            `;
        });
        monthList.innerHTML = html;
        addMonthClickEvents();
    }

    // Function untuk menambahkan event click ke setiap bulan
    function addMonthClickEvents() {
        document.querySelectorAll('.month-item').forEach(item => {
            item.addEventListener('click', function() {
                const monthValue = this.dataset.value;
                const urlParams = new URLSearchParams(window.location.search);

                // Set parameter month
                urlParams.set('month', monthValue);

                // Preserve other parameters
                const sort = urlParams.get('sort');
                if (sort) {
                    urlParams.set('sort', sort);
                }
                
                const location = urlParams.get('location');
                if (location) {
                    urlParams.set('location', location);
                }

                window.location.search = urlParams.toString();
            });
        });
    }

    // Toggle waktu section
    waktuHeader.addEventListener('click', function() {
        waktuHeader.classList.toggle('active');
        const isVisible = waktuContent.style.display === 'block';
        waktuContent.style.display = isVisible ? 'none' : 'block';
        
        if (!isVisible) {
            renderMonths(); // Render daftar bulan saat dibuka
        }
    });

    // Show waktu content if month is selected
    if (currentMonth) {
        waktuHeader.classList.add('active');
        waktuContent.style.display = 'block';
        renderMonths();
    }
});