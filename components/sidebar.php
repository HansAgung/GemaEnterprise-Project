<?php
// Deteksi halaman aktif berdasarkan parameter URL
$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
// Array halaman yang masuk dalam kategori management
$mgmt_pages = ['finance', 'product_master', 'marketing', 'procurement'];
// Cek apakah halaman saat ini adalah bagian dari management
$is_mgmt_active = in_array($current_page, $mgmt_pages);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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
        overflow-x: hidden;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 1000;
        border-right: 1px solid rgba(255,255,255,0.05);
    }

    #sidebar::-webkit-scrollbar { width: 0px; }
    #sidebar:hover { width: var(--sidebar-full); }

    .sidebar-header { height: 70px; display: flex; align-items: center; padding: 0 22px; background: rgba(0,0,0,0.2); flex-shrink: 0; }
    .logo-icon { font-size: 28px; font-weight: 800; color: var(--accent-teal); min-width: 30px; }
    .logo-text { margin-left: 15px; font-size: 18px; font-weight: 700; color: #fff; opacity: 0; transition: opacity 0.2s; }
    #sidebar:hover .logo-text { opacity: 1; }

    .sidebar-menu { flex-grow: 1; margin-top: 20px; }
    
    .nav-link-custom { 
        display: flex; 
        align-items: center; 
        padding: 15px 22px; 
        color: #94a3b8; 
        text-decoration: none; 
        transition: 0.2s; 
        border-left: 4px solid transparent; 
        position: relative; 
        cursor: pointer; 
    }
    .nav-link-custom i { font-size: 20px; min-width: 30px; }
    
    .menu-name { margin-left: 15px; opacity: 0; transition: opacity 0.2s; }
    #sidebar:hover .menu-name { opacity: 1; }

    /* STATE: Link Aktif Utama */
    .nav-link-custom.active { 
        background: rgba(0, 209, 178, 0.1); 
        color: var(--accent-teal); 
        border-left-color: var(--accent-teal); 
    }

    /* Modifikasi Khusus Management saat Mini */
    #sidebar:not(:hover) .nav-link-custom.parent-active {
        background: rgba(0, 209, 178, 0.1); 
        color: var(--accent-teal); 
        border-left-color: var(--accent-teal);
    }

    .nav-link-custom:hover { background: rgba(255,255,255,0.05); color: #fff; }

    /* SUBMENU STYLING */
    .submenu {
        background: rgba(0,0,0,0.2);
        overflow: hidden;
    }
    
    .nav-sub-link {
        display: flex;
        align-items: center;
        padding: 10px 22px 10px 52px;
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        transition: 0.2s;
        border-left: 4px solid transparent;
    }
    
    .nav-sub-link:hover, .nav-sub-link.active { 
        color: var(--accent-teal); 
    }

    /* Hilangkan background active submenu jika sidebar sedang mini agar tidak aneh */
    #sidebar:not(:hover) .submenu { display: none; }
    
    .chevron-icon { 
        margin-left: auto; 
        font-size: 12px; 
        transition: transform 0.3s; 
        opacity: 0;
    }
    #sidebar:hover .chevron-icon { opacity: 1; }
    
    .nav-link-custom:not(.collapsed) .chevron-icon {
        transform: rotate(180deg);
    }

    /* Badge & Gold Button */
    .btn-akses-emas {
        background: linear-gradient(45deg, var(--gold-primary), var(--gold-light), var(--gold-primary));
        color: #0d1b2a; border: none; padding: 4px 12px; font-size: 11px; font-weight: 800; border-radius: 4px;
        text-transform: uppercase; cursor: pointer; position: absolute; right: 20px; opacity: 0;
        transition: opacity 0.3s, transform 0.2s; box-shadow: 0 2px 10px rgba(191, 149, 63, 0.3);
    }
    #sidebar:hover .btn-akses-emas { opacity: 1; }

    /* PIN Modal */
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

        <div class="nav-item">
            <a class="nav-link-custom <?= $is_mgmt_active ? 'parent-active' : 'collapsed' ?> <?= ($current_page == 'management') ? 'active' : '' ?>" 
               data-bs-toggle="collapse" 
               href="#mgmtSubmenu" 
               role="button" 
               aria-expanded="<?= $is_mgmt_active ? 'true' : 'false' ?>">
                <i class="bi bi-briefcase"></i>
                <span class="menu-name">Management</span>
                <i class="bi bi-chevron-down chevron-icon"></i>
            </a>
            <div class="collapse <?= $is_mgmt_active ? 'show' : '' ?>" id="mgmtSubmenu">
                <div class="submenu">
                    <a href="?page=finance" class="nav-sub-link <?= ($current_page == 'finance') ? 'active' : '' ?>">
                        <i class="bi bi-graph-up-arrow me-2"></i>Financial Reports
                    </a>
                    <a href="?page=product_master" class="nav-sub-link <?= ($current_page == 'product_master') ? 'active' : '' ?>">
                        <i class="bi bi-box-seam me-2"></i>Product Master
                    </a>
                    <a href="?page=marketing" class="nav-sub-link <?= ($current_page == 'marketing') ? 'active' : '' ?>">
                        <i class="bi bi-megaphone me-2"></i>Promo & Marketing
                    </a>
                    <a href="?page=procurement" class="nav-sub-link <?= ($current_page == 'procurement') ? 'active' : '' ?>">
                        <i class="bi bi-truck me-2"></i>Procurement
                    </a>
                </div>
            </div>
        </div>

        <a href="?page=inventory" class="nav-link-custom <?= ($current_page == 'inventory') ? 'active' : '' ?>">
            <i class="bi bi-archive"></i><span class="menu-name">Inventory</span>
        </a>

        <a href="?page=staff" class="nav-link-custom <?= ($current_page == 'staff') ? 'active' : '' ?>">
            <i class="bi bi-people"></i><span class="menu-name">Data Staff</span>
        </a>

        <a href="?page=branch" class="nav-link-custom <?= ($current_page == 'branch') ? 'active' : '' ?>">
            <i class="bi bi-geo"></i><span class="menu-name">Toko Cabang</span>
        </a>

        <div class="nav-link-custom <?= ($current_page == 'kasir') ? 'active' : '' ?>">
            <i class="bi bi-cart"></i><span class="menu-name">Kasir POS</span>
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
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Seluruh script JavaScript Anda sebelumnya tetap ditaruh di sini tanpa perubahan
</script>