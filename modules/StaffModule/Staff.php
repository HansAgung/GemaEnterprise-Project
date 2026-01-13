<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Module - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --accent-teal: #00d1b2;
            --dark-navy: #0d1b2a;
            --soft-bg: #f8fafc;
        }

        body {
            background-color: var(--soft-bg);
            height: 100vh;
            overflow: hidden;
        }

        #wrapper { display: flex; height: 100vh; }
        #page-content-wrapper { flex-grow: 1; display: flex; flex-direction: column; overflow: hidden; }

        .staff-container {
            flex-grow: 1;
            display: flex;
            padding: 1.5rem;
            gap: 1.5rem;
            min-height: 0;
        }

        /* Section Kiri: Detail (6.5) */
        .staff-detail-section {
            flex: 6.5;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Section Kanan: List (3.5) */
        .staff-list-section {
            flex: 3.5;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .scrollable-list {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem;
        }

        /* Styling Item List */
        .staff-item {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .staff-item:hover {
            background-color: #f1f5f9;
        }

        .staff-item.active {
            background-color: #e6fcf9;
            border-color: var(--accent-teal);
        }

        .avatar-circle {
            width: 45px;
            height: 45px;
            background: var(--accent-teal);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .detail-avatar {
            width: 120px;
            height: 120px;
            background: var(--accent-teal);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 20px;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }
    </style>
</head>
<body>

<?php
$staff_data = [
    ['id' => 1, 'nama' => 'Budi Santoso', 'posisi' => 'Store Manager', 'email' => 'budi.s@pos.com', 'phone' => '0812-3456-7890', 'status' => 'Aktif', 'join' => '12 Jan 2022', 'avatar' => 'BS'],
    ['id' => 2, 'nama' => 'Siti Aminah', 'posisi' => 'Kasir Utama', 'email' => 'siti.a@pos.com', 'phone' => '0812-3456-7891', 'status' => 'Aktif', 'join' => '05 Feb 2022', 'avatar' => 'SA'],
    ['id' => 3, 'nama' => 'Andi Wijaya', 'posisi' => 'Inventory Staff', 'email' => 'andi.w@pos.com', 'phone' => '0812-3456-7892', 'status' => 'Aktif', 'join' => '10 Mar 2022', 'avatar' => 'AW'],
    ['id' => 4, 'nama' => 'Dewi Lestari', 'posisi' => 'Kasir', 'email' => 'dewi.l@pos.com', 'phone' => '0812-3456-7893', 'status' => 'Cuti', 'join' => '20 Apr 2022', 'avatar' => 'DL'],
    ['id' => 5, 'nama' => 'Eko Prasetyo', 'posisi' => 'Warehouse', 'email' => 'eko.p@pos.com', 'phone' => '0812-3456-7894', 'status' => 'Aktif', 'join' => '15 Mei 2022', 'avatar' => 'EP'],
    ['id' => 6, 'nama' => 'Fitriani', 'posisi' => 'Admin Keuangan', 'email' => 'fitri@pos.com', 'phone' => '0812-3456-7895', 'status' => 'Aktif', 'join' => '01 Jun 2022', 'avatar' => 'FT'],
    ['id' => 7, 'nama' => 'Gilang Ramadhan', 'posisi' => 'Delivery', 'email' => 'gilang@pos.com', 'phone' => '0812-3456-7896', 'status' => 'Aktif', 'join' => '12 Jul 2022', 'avatar' => 'GR'],
    ['id' => 8, 'nama' => 'Hany Safitri', 'posisi' => 'Kasir', 'email' => 'hany@pos.com', 'phone' => '0812-3456-7897', 'status' => 'Aktif', 'join' => '25 Agu 2022', 'avatar' => 'HS'],
    ['id' => 9, 'nama' => 'Indra Kesuma', 'posisi' => 'Security', 'email' => 'indra@pos.com', 'phone' => '0812-3456-7898', 'status' => 'Aktif', 'join' => '02 Sep 2022', 'avatar' => 'IK'],
    ['id' => 10, 'nama' => 'Joko Susilo', 'posisi' => 'Cleaning Service', 'email' => 'joko@pos.com', 'phone' => '0812-3456-7899', 'status' => 'Off', 'join' => '18 Okt 2022', 'avatar' => 'JS'],
    ['id' => 11, 'nama' => 'Karin Amalia', 'posisi' => 'Marketing', 'email' => 'karin@pos.com', 'phone' => '0812-3456-7800', 'status' => 'Aktif', 'join' => '11 Nov 2022', 'avatar' => 'KA'],
    ['id' => 12, 'nama' => 'Lutfi Hakim', 'posisi' => 'IT Support', 'email' => 'lutfi@pos.com', 'phone' => '0812-3456-7801', 'status' => 'Aktif', 'join' => '01 Des 2022', 'avatar' => 'LH']
];
?>

<div id="wrapper">
    <div class="sidebar-wrapper">
        <?php include './components/sidebar.php'; ?>
    </div>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-3">
            <div class="d-flex align-items-center">
                <i class="bi bi-people-fill fs-4 me-2 text-primary"></i>
                <h5 class="fw-bold m-0">Staff Management</h5>
            </div>
        </nav>

        <div class="staff-container">
            <div class="staff-detail-section" id="detail-view">
                </div>

            <div class="staff-list-section">
                <div class="p-3 border-bottom">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-0" id="searchStaff" placeholder="Cari staff...">
                    </div>
                </div>
                <div class="scrollable-list" id="staffList">
                    <?php foreach ($staff_data as $index => $s): ?>
                    <div class="staff-item d-flex align-items-center" 
                         id="item-<?= $index; ?>"
                         onclick="showDetail(<?= htmlspecialchars(json_encode($s)); ?>, <?= $index; ?>)">
                        <div class="avatar-circle me-3"><?= $s['avatar']; ?></div>
                        <div>
                            <div class="fw-bold text-dark small"><?= $s['nama']; ?></div>
                            <div class="text-muted" style="font-size: 0.75rem;"><?= $s['posisi']; ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Data dari PHP ke JS
    const allStaff = <?= json_encode($staff_data); ?>;

    function showDetail(data, index) {
        // Update styling list
        document.querySelectorAll('.staff-item').forEach(el => el.classList.remove('active'));
        document.getElementById(`item-${index}`).classList.add('active');

        // Render Detail
        const detailView = document.getElementById('detail-view');
        const statusClass = data.status === 'Aktif' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning';
        
        detailView.innerHTML = `
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="detail-avatar">${data.avatar}</div>
                <span class="status-badge ${statusClass} fw-bold">${data.status}</span>
            </div>
            
            <h3 class="fw-bold text-dark mb-1">${data.nama}</h3>
            <p class="text-primary fw-semibold mb-4">${data.posisi}</p>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="text-muted small d-block">Email Address</label>
                    <div class="fw-bold"><i class="bi bi-envelope me-2"></i>${data.email}</div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small d-block">Phone Number</label>
                    <div class="fw-bold"><i class="bi bi-telephone me-2"></i>${data.phone}</div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small d-block">Tanggal Bergabung</label>
                    <div class="fw-bold"><i class="bi bi-calendar-event me-2"></i>${data.join}</div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small d-block">Employee ID</label>
                    <div class="fw-bold"><i class="bi bi-hash me-2"></i>EMP-00${data.id}</div>
                </div>
            </div>

            <div class="mt-auto pt-5 border-top">
                <button class="btn btn-outline-primary me-2"><i class="bi bi-pencil-square me-1"></i> Edit Data</button>
                <button class="btn btn-outline-danger"><i class="bi bi-trash me-1"></i> Nonaktifkan</button>
            </div>
        `;
    }

    // Search Functionality
    document.getElementById('searchStaff').addEventListener('input', function(e) {
        const val = e.target.value.toLowerCase();
        document.querySelectorAll('.staff-item').forEach(item => {
            const name = item.innerText.toLowerCase();
            item.style.display = name.includes(val) ? 'flex' : 'none';
        });
    });

    // Otomatis pilih index 0 saat halaman pertama kali dibuka
    window.onload = () => {
        if (allStaff.length > 0) {
            showDetail(allStaff[0], 0);
        }
    };
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>