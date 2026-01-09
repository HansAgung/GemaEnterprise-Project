<?php
// Deteksi halaman aktif berdasarkan parameter URL
$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    :root {
        --sidebar-mini: 70px;
        --sidebar-full: 250px;
        --accent-teal: #00d1b2;
        --sidebar-bg: #0d1b2a;
        --gold-primary: #bf953f;
        --gold-light: #fcf6ba;
    }

    #sidebar {
        width: var(--sidebar-mini);
        height: 100vh;
        background: var(--sidebar-bg);
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 1000;
        border-right: 1px solid rgba(255,255,255,0.05);
    }

    #sidebar:hover { width: var(--sidebar-full); }

    .sidebar-header { height: 70px; display: flex; align-items: center; padding: 0 22px; background: rgba(0,0,0,0.2); }
    .logo-icon { font-size: 28px; font-weight: 800; color: var(--accent-teal); min-width: 30px; }
    .logo-text { margin-left: 15px; font-size: 18px; font-weight: 700; color: #fff; opacity: 0; transition: opacity 0.2s; }
    #sidebar:hover .logo-text { opacity: 1; }

    .sidebar-menu { flex-grow: 1; margin-top: 20px; }
    .nav-link-custom { display: flex; align-items: center; padding: 15px 22px; color: #94a3b8; text-decoration: none; transition: 0.2s; border-left: 4px solid transparent; position: relative; }
    .nav-link-custom i { font-size: 20px; min-width: 30px; }
    .menu-name { margin-left: 15px; opacity: 0; transition: opacity 0.2s; }
    #sidebar:hover .menu-name { opacity: 1; }

    .nav-link-custom.active { background: rgba(0, 209, 178, 0.1); color: var(--accent-teal); border-left-color: var(--accent-teal); }
    .nav-link-custom:hover { background: rgba(255,255,255,0.05); color: #fff; }

    /* Tombol Akses Emas */
    .btn-akses-emas {
        background: linear-gradient(45deg, var(--gold-primary), var(--gold-light), var(--gold-primary));
        color: #0d1b2a; border: none; padding: 4px 12px; font-size: 11px; font-weight: 800; border-radius: 4px;
        text-transform: uppercase; cursor: pointer; position: absolute; right: 20px; opacity: 0;
        transition: opacity 0.3s, transform 0.2s; box-shadow: 0 2px 10px rgba(191, 149, 63, 0.3);
    }
    #sidebar:hover .btn-akses-emas { opacity: 1; }
    .btn-akses-emas:hover { transform: scale(1.05); }

    /* PIN Modal Styling */
    .pin-container { display: flex; justify-content: center; gap: 15px; margin: 25px 0; }
    .pin-dot { width: 18px; height: 18px; border: 2px solid #cbd5e1; border-radius: 50%; transition: all 0.2s; }
    .pin-dot.active { background-color: var(--accent-teal); border-color: var(--accent-teal); transform: scale(1.2); }
    #pinInputHidden { position: absolute; opacity: 0; pointer-events: none; }
</style>

<nav id="sidebar">
    <div class="sidebar-header">
        <span class="logo-icon">G</span>
        <span class="logo-text">EMA ENTERPRISE</span>
    </div>

    <div class="sidebar-menu">
        <a href="?page=dashboard" class="nav-link-custom <?= ($current_page == 'dashboard') ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2"></i><span class="menu-name">Dashboard</span>
        </a>
        <a href="?page=inventory" class="nav-link-custom <?= ($current_page == 'inventory') ? 'active' : '' ?>">
            <i class="bi bi-archive"></i><span class="menu-name">Inventory</span>
        </a>
        <div class="nav-link-custom <?= ($current_page == 'kasir') ? 'active' : '' ?>">
            <i class="bi bi-cart"></i><span class="menu-name">Kasir</span>
            <button class="btn-akses-emas" onclick="showPinModal()">Akses</button>
        </div>
    </div>

    <div class="sidebar-footer mb-3">
        <a href="#" onclick="logout()" class="nav-link-custom text-danger">
            <i class="bi bi-box-arrow-left"></i><span class="menu-name">Logout</span>
        </a>
    </div>
</nav>

<div class="modal fade" id="modalPin" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius: 15px; background: #fff;">
            <div class="modal-body text-center p-4">
                <i class="bi bi-shield-lock-fill text-warning mb-3" style="font-size: 3rem; display: block;"></i>
                <h5 class="fw-bold text-dark font-sans">PIN Karyawan</h5>
                <p class="text-muted small">Input 4 digit akses kasir</p>
                <div class="pin-container" id="pinDisplay">
                    <div class="pin-dot"></div><div class="pin-dot"></div><div class="pin-dot"></div><div class="pin-dot"></div>
                </div>
                <input type="password" id="pinInputHidden" maxlength="4" pattern="\d*" inputmode="numeric" autocomplete="off">
                <div class="d-grid"><button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let myPinModal = null;

    function showPinModal() {
        const modalEl = document.getElementById('modalPin');
        const pinInp = document.getElementById('pinInputHidden');

        // Pastikan library bootstrap sudah terdefinisi sebelum digunakan
        if (typeof bootstrap !== 'undefined') {
            if (!myPinModal) {
                myPinModal = new bootstrap.Modal(modalEl);
            }
            
            pinInp.value = "";
            updateDots(0);
            myPinModal.show();
            
            modalEl.addEventListener('shown.bs.modal', () => {
                pinInp.focus();
            }, { once: true });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const pinInput = document.getElementById('pinInputHidden');
        if (pinInput) {
            pinInput.addEventListener('input', (e) => {
                updateDots(e.target.value.length);
                if (e.target.value.length === 4) {
                    if (e.target.value === "1234") {
                        window.location.href = "?page=kasir";
                    } else {
                        alert("PIN Salah!");
                        e.target.value = "";
                        updateDots(0);
                    }
                }
            });
        }
    });

    function updateDots(count) {
        document.querySelectorAll('.pin-dot').forEach((dot, i) => {
            dot.classList.toggle('active', i < count);
        });
    }
</script>