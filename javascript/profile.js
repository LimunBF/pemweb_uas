function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content-container');
    sidebar.classList.toggle('shrink');
    content.classList.toggle('shrink');
}

function showCloseAccount() {
    const closeAccountContainer = document.getElementById('closeAccount');
    const settingItem = document.querySelector('.setting-item');
    closeAccountContainer.style.display = 'block';
    if (settingItem) {
        settingItem.style.display = 'none';
    }
}

function toggleCloseButton() {
    const agreeCheckbox = document.getElementById('agreeCloseAccount');
    const closeButton = document.getElementById('confirmCloseAccount');
    if (agreeCheckbox.checked) {
        closeButton.classList.add('enabled');
        closeButton.classList.remove('disabled');
        closeButton.style.cursor = 'pointer';
        closeButton.disabled = false;
    } else {
        closeButton.classList.remove('enabled');
        closeButton.classList.add('disabled');
        closeButton.style.cursor = 'not-allowed';
        closeButton.disabled = true;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const logoutLink = document.querySelector('.text-danger');
    if (logoutLink) {
        logoutLink.addEventListener('click', (e) => {
            if (!confirm("Apakah Anda yakin ingin keluar?")) {
                e.preventDefault();
            }
        });
    }
});