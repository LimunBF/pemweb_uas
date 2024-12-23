// Selectors for dynamic updates
const daftarTiketContainer = document.querySelector('.list-unstyled');
const totalHargaElement = document.querySelector('.fs-5 span');
const btnBayar = document.getElementById('btnBayar');
const btnCheckout = document.getElementById('btnCheckout');
const btnKonfirmasi = document.getElementById('btnKonfirmasi');
const emailInput = document.getElementById('email');
const emailKonfirmasi = document.getElementById('emailKonfirmasi');
const tabs = document.querySelectorAll('.nav-link');

// Automatically get all dropdowns dynamically
const ticketDropdowns = document.querySelectorAll('[id^="jumlahTiket"]');

// Disable "Bayar" button initially
btnBayar.setAttribute('disabled', true);

// Function to update ticket summary dynamically
function updateTicketSummary() {
    const selectedTickets = [];
    let totalPrice = 0;

    // Iterate over all ticket dropdowns
    ticketDropdowns.forEach(dropdown => {
        const ticketId = dropdown.id.replace('jumlahTiket', '');
        const quantity = parseInt(dropdown.value);
        const ticketElement = document.querySelector(`[data-ticket-id="${ticketId}"]`);

        if (quantity > 0 && ticketElement) {
            const ticketType = ticketElement.dataset.ticketType;
            const ticketPrice = parseInt(ticketElement.dataset.ticketPrice);

            // Add ticket details to the summary
            selectedTickets.push({
                ticketType,
                quantity,
                price: ticketPrice,
                totalPrice: ticketPrice * quantity,
            });

            // Update total price
            totalPrice += ticketPrice * quantity;
        }
    });

    // Render the ticket summary
    renderTicketSummary(selectedTickets, totalPrice);
}

// Function to render the ticket summary in the UI
function renderTicketSummary(tickets, totalPrice) {
    // Clear existing ticket list
    daftarTiketContainer.innerHTML = '';

    if (tickets.length > 0) {
        tickets.forEach(ticket => {
            const listItem = document.createElement('li');
            listItem.className = 'mb-2';
            listItem.innerHTML = `${ticket.ticketType}: <strong>${ticket.quantity}</strong> x Rp ${ticket.price.toLocaleString('id-ID')}`;
            daftarTiketContainer.appendChild(listItem);
        });

        totalHargaElement.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
    } else {
        daftarTiketContainer.innerHTML = '<li class="mb-2">Belum ada tiket yang dipilih.</li>';
        totalHargaElement.textContent = 'Rp 0';
    }
}

// Initialize the ticket summary when the page loads
updateTicketSummary();

// Add change listeners to all dropdowns to update the summary
ticketDropdowns.forEach(dropdown => {
    dropdown.addEventListener('change', updateTicketSummary);
});

// Checkout button logic
btnCheckout.addEventListener('click', () => {
    if (Array.from(ticketDropdowns).every(dropdown => parseInt(dropdown.value) === 0)) {
        alert('Pilih setidaknya satu tiket sebelum melanjutkan.');
        return;
    }

    document.querySelector('#biodata-tab').disabled = false;
    document.querySelector('#biodata-tab').click();
});

// Confirmation button logic
btnKonfirmasi.addEventListener('click', (e) => {
    e.preventDefault();

    const namaInput = document.getElementById('nama').value;
    const emailInputValue = emailInput.value;

    if (!namaInput || !emailInputValue) {
        alert('Masukkan nama dan email terlebih dahulu.');
        return;
    }

    // Display email in confirmation tab
    emailKonfirmasi.textContent = emailInputValue;

    // Store user details in sessionStorage
    sessionStorage.setItem('user_name', namaInput);
    sessionStorage.setItem('email', emailInputValue);

    // Move to confirmation tab
    document.querySelector('#konfirmasi-tab').disabled = false;
    document.querySelector('#konfirmasi-tab').click();
});

// Payment button logic
btnPembayaran.addEventListener('click', () => {
    // Enable the payment tab and navigate to it
    document.querySelector('#pembayaran-tab').disabled = false;
    document.querySelector('#pembayaran-tab').click();
});

// Handle tab navigation to enable/disable "Bayar" button
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        if (tab.id === 'pembayaran-tab') {
            btnBayar.removeAttribute('disabled'); // Enable "Bayar" button
        } else {
            btnBayar.setAttribute('disabled', true); // Disable "Bayar" button
        }
    });
});

// Disable the "Bayar" button initially until tab 4 is active
btnBayar.setAttribute('disabled', true);
