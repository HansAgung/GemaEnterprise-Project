document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
    tab.addEventListener('shown.bs.tab', function () {
        fetch('./config/check_session.php', { method: 'POST' });
    });
});

setInterval(function() {
    fetch('./config/check_session.php', { method: 'POST' })
    .then(response => response.json())
    .then(data => {
        if (!data.valid) {
            showReusableModal('Sesi Habis', 'Sesi kamu telah habis! Silakan login kembali.', 'Login', () => window.location.href = '../../index.php?page=login');
        }
    })
    .catch(error => console.error('Error checking session'));
}, 1800); // Ubah ke 2 detik

function checkSessionAndAction() {
    fetch('./config/check_session.php', { method: 'POST' })
    .then(response => response.json())
    .then(data => {
        if (!data.valid) {
            showReusableModal('Sesi Habis', 'Sesi kamu telah habis! Silakan login kembali.', 'Login', () => window.location.href = '../../index.php?page=login');
        } else {
            alert('Session valid! Aksi berhasil.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error checking session');
    });
}
    