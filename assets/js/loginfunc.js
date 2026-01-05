
function clearformdata() {
    document.getElementById('user').value = "";
    document.getElementById('pass').value = "";
}

function login(e) {
    e.preventDefault();

    const username = document.getElementById('user').value;
    const password = document.getElementById('pass').value;

    if (!username || !password) {
        alert("Username dan password harus diisi!");
        return;
    }

    const data = {
        method: 'login',
        params: {
            username: username,
            password: password
        }
    };

    fetch('modules/AuthModule/loginpage_slave.php', { 
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
        .then(response => {
            return response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (err) {
                    console.log("Respon server bukan JSON:", text);
                    throw new Error("Server mengirim respon cacat (bukan JSON)");
                }
            });
        })
        .then(result => {
            if (result.success) {
                alert(result.message);
                window.location.href = './route.php?page=inventory'; 
            } else {
                alert(result.message); 
            }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Terjadi kesalahan koneksi!");
    });
}

function logout() {
    const data = {
        method: 'logout',
        params: {} 
    };

    fetch('modules/AuthModule/loginpage_slave.php', { 
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert(result.message);
            window.location.href = './route.php?page=login';
        } else {
            alert(result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Terjadi kesalahan!");
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    if (form) {
        form.addEventListener('submit', login);
    }
});