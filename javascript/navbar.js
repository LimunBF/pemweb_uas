const searchInput = document.getElementById('searchInput');

searchInput.addEventListener('input', function () {
    if (this.value.length > 0) {
        this.style.setProperty('--placeholder-color', '#ffffff');
    } else {
        this.style.setProperty('--placeholder-color', '#a0b8d8');
    }
});
