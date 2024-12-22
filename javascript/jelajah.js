document.addEventListener('DOMContentLoaded', function() {
    // Get current location from URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentLocation = urlParams.get('location') || '';

    // Waktu section toggle
    const waktuHeader = document.querySelector('.waktu-header');
    const waktuContent = document.querySelector('.waktu-content');
    
    waktuHeader.addEventListener('click', function() {
        waktuHeader.classList.toggle('active');
        waktuContent.style.display = waktuContent.style.display === 'none' ? 'block' : 'none';
    });

    // Month selection
    document.querySelectorAll('.month-item').forEach(item => {
        item.addEventListener('click', function() {
            const monthValue = this.dataset.value;
            const urlParams = new URLSearchParams(window.location.search);
            
            if (monthValue) {
                urlParams.set('month', monthValue);
            } else {
                urlParams.delete('month');
            }

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

    // Show waktu content if month is selected
    if (window.location.search.includes('month=')) {
        waktuHeader.classList.add('active');
        waktuContent.style.display = 'block';
    }

    // Lokasi section toggle
    const lokasiHeader = document.querySelector('.lokasi-header');
    const lokasiContent = document.querySelector('.lokasi-content');
    const searchLocation = document.getElementById('searchLocation');
    const locationList = document.getElementById('locationList');

    lokasiHeader.addEventListener('click', function() {
        lokasiHeader.classList.toggle('active');
        lokasiContent.style.display = lokasiContent.style.display === 'none' ? 'block' : 'none';
    });

    // Function to load locations
    function loadLocations(search = '') {
        fetch(`get_locations.php?search=${encodeURIComponent(search)}`)
            .then(response => response.json())
            .then(locations => {
                let html = `
                    <div class="location-item ${!currentLocation ? 'selected' : ''}" data-value="">
                        Semua Lokasi
                    </div>
                `;

                locations.forEach(location => {
                    const isSelected = currentLocation === location;
                    html += `
                        <div class="location-item ${isSelected ? 'selected' : ''}" 
                             data-value="${location}">
                            ${location}
                        </div>
                    `;
                });

                locationList.innerHTML = html;

                // Add click events to location items
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
            })
            .catch(error => console.error('Error:', error));
    }

    // Initial load
    loadLocations();

    // Search with debounce
    let searchTimeout;
    searchLocation.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadLocations(this.value);
        }, 300);
    });

    // Show location content if location is selected
    if (currentLocation) {
        lokasiHeader.classList.add('active');
        lokasiContent.style.display = 'block';
    }

    // Reset filter
    document.getElementById('resetFilter').addEventListener('click', function() {
        window.location.href = 'jelajah.php';
    });

    // Waktu section code...
}); 