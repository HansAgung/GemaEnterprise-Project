<?php
// Pastikan path ini benar sesuai struktur folder Anda
include_once 'config/data_dummy.php'; 

// Data tambahan jika belum ada di data_dummy.php
// if (!isset($suppliers)) {
//     $suppliers = [
//         ['id' => 1, 'name' => 'PT. Sembako Jaya', 'category' => 'Food & Beverage', 'initials' => 'SJ', 'color' => '#4e73df'],
//         ['id' => 2, 'name' => 'Gudang Elektronik', 'category' => 'Hardware', 'initials' => 'GE', 'color' => '#1cc88a'],
//         ['id' => 3, 'name' => 'Logistik Sentosa', 'category' => 'Service', 'initials' => 'LS', 'color' => '#f6c23e'],
//     ];
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procurement - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --accent-teal: #00d1b2;
            --dark-navy: #1a202c;
            --soft-bg: #f8fafc;
            --brand-light: #1b6d5b;
            --sidebar-width: 250px;
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--soft-bg); height: 100vh; overflow: hidden; }

        #wrapper { display: flex; height: 100vh; }
        #page-content-wrapper { flex-grow: 1; display: flex; flex-direction: column; overflow: hidden; }

        /* Layout Split: Kiri (Table), Kanan (Vendors) */
        .main-container { flex-grow: 1; display: flex; padding: 1.5rem; gap: 1.5rem; min-height: 0; }

        /* Section Kiri: Tabel (6.5) */
        .table-section {
            flex: 6.5; background: #fff; border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex; flex-direction: column; overflow: hidden;
        }

        /* Section Kanan: Vendor List (3.5) */
        .vendor-section {
            flex: 3.5; background: #fff; border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex; flex-direction: column; min-height: 0;
        }

        /* Header Sidebar Tabel & Vendor */
        .header-box { padding: 20px; border-bottom: 1px solid #f1f5f9; }

        /* Button Modern Full */
        .btn-modern-full {
            width: 100%; display: flex; justify-content: center; align-items: center; gap: 10px;
            background: var(--accent-teal); color: white; border: none; padding: 12px;
            border-radius: 12px; font-size: 13px; font-weight: 600; transition: 0.3s;
            margin-bottom: 15px;
        }
        .btn-modern-full:hover { transform: translateY(-2px); filter: brightness(1.1); }

        /* Table Styling */
        .modern-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .modern-table th { 
            background: #f8fafc; padding: 16px 20px; font-size: 11px; 
            text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px;
        }
        .modern-table td { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; font-size: 14px; vertical-align: middle; }
        
        /* Memberikan Padding Kiri pada baris pertama agar rapi */
        .modern-table th:first-child, .modern-table td:first-child { padding-left: 32px; }
        .modern-table th:last-child, .modern-table td:last-child { padding-right: 32px; }

        /* Stats Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; padding: 0 24px 24px; }
        .stat-mini { background: #f8fafc; padding: 15px; border-radius: 15px; border: 1px solid #edf2f7; }

        /* Vendor Cards */
        .vendor-item {
            padding: 12px 20px; border-radius: 12px; margin: 0 15px 8px;
            cursor: pointer; transition: 0.2s; border: 1px solid transparent;
        }
        .vendor-item:hover { background: #f1f5f9; }
        .vendor-item.active { background: var(--dark-navy); color: white; }

        .status-pill { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }
        .status-pending { background: #fff8e1; color: #b45309; }
        .status-received { background: #ecfdf5; color: #047857; }

        .btn-export-pdf {
            background: #e74c3c; color: white; border: none; padding: 8px 16px;
            border-radius: 50px; font-size: 12px; font-weight: 600; transition: 0.2s;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }
    </style>
</head>
<body>

<div id="wrapper">
    <div class="sidebar-wrapper">
        <?php include './components/sidebar.php'; ?>
    </div>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-3">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="d-flex align-items-center">
                    <i class="bi bi-cart-check-fill fs-4 me-2 text-primary"></i>
                    <h5 class="fw-bold m-0">Procurement Management</h5>
                </div>
                <button class="btn-export-pdf">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
                </button>
            </div>
        </nav>

        <div class="main-container">
            <div class="table-section">
                <div class="p-4">
                    <h6 class="fw-bold mb-1" id="activeVendorName">Supplier Transactions</h6>
                    <p class="text-muted small">Riwayat pengadaan barang dari vendor terpilih</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-mini">
                        <small class="text-muted d-block">Total PO</small>
                        <span class="fw-bold h5 mb-0" id="stat-total">0</span>
                    </div>
                    <div class="stat-mini">
                        <small class="text-muted d-block">Pending</small>
                        <span class="fw-bold h5 mb-0 text-warning" id="stat-pending">0</span>
                    </div>
                    <div class="stat-mini">
                        <small class="text-muted d-block">Received</small>
                        <span class="fw-bold h5 mb-0 text-success" id="stat-received">0</span>
                    </div>
                </div>

                <div style="overflow-y: auto; flex-grow: 1;">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="poTable">
                            </tbody>
                    </table>
                </div>
            </div>

            <div class="vendor-section">
                <div class="header-box">
                    <h6 class="fw-bold mb-3">Vendor List</h6>
                    <button class="btn-modern-full">
                        <span>Tambah Supplier</span>
                        <i class="bi bi-plus-lg"></i>
                    </button>
                    <div class="position-relative mt-2">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="vSearch" class="form-control ps-5 border-0 bg-light" placeholder="Cari vendor..." style="border-radius: 10px; font-size: 13px; height: 42px;">
                    </div>
                </div>
                
                <div class="py-3" style="overflow-y: auto;" id="vendorList">
                    <?php foreach ($suppliers as $index => $s): ?>
                    <div class="vendor-item d-flex align-items-center <?= $index == 0 ? 'active' : '' ?>" 
                         onclick="switchVendor('<?= $s['name'] ?>', this)">
                        <div class="avatar-circle me-3" style="background: <?= $s['color'] ?>; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">
                            <?= $s['initials'] ?>
                        </div>
                        <div style="min-width: 0;">
                            <div class="fw-bold small text-truncate"><?= $s['name'] ?></div>
                            <div class="text-muted" style="font-size: 10px;"><?= $s['category'] ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const orderData = <?= json_encode($procurement_orders ?? []); ?>;

    function switchVendor(name, element) {
        document.querySelectorAll('.vendor-item').forEach(c => c.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('activeVendorName').innerText = name;

        const filtered = orderData.filter(o => o.supplier === name);
        
        // Update Stats
        document.getElementById('stat-total').innerText = filtered.length;
        document.getElementById('stat-pending').innerText = filtered.filter(o => o.status === 'Pending').length;
        document.getElementById('stat-received').innerText = filtered.filter(o => o.status === 'Received').length;

        renderTable(filtered);
    }

    function renderTable(data) {
        const tbody = document.getElementById('poTable');
        if (data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-5 text-muted small">Tidak ada data pengadaan.</td></tr>`;
            return;
        }

        tbody.innerHTML = data.map(o => `
            <tr>
                <td class="fw-bold text-primary">#${o.id}</td>
                <td>
                    <div class="fw-bold">${o.item}</div>
                    <div class="text-muted" style="font-size: 11px;">Ref: LOG-SEC-24</div>
                </td>
                <td><span class="fw-bold">${o.qty}</span> <small class="text-muted">Unit</small></td>
                <td><span class="status-pill ${o.status === 'Pending' ? 'status-pending' : 'status-received'}">${o.status}</span></td>
                <td class="text-muted small">${o.date}</td>
                <td class="text-end">
                    <button class="btn btn-sm btn-light rounded-3 px-2"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-sm btn-light rounded-3 px-2"><i class="bi bi-printer"></i></button>
                </td>
            </tr>
        `).join('');
    }

    // Search Vendor
    document.getElementById('vSearch').addEventListener('input', (e) => {
        const val = e.target.value.toLowerCase();
        document.querySelectorAll('.vendor-item').forEach(card => {
            const name = card.querySelector('.fw-bold').innerText.toLowerCase();
            card.style.display = name.includes(val) ? 'flex' : 'none';
        });
    });

    window.onload = () => {
        const first = document.querySelector('.vendor-item.active');
        if(first) first.click();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>