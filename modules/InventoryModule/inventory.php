<?php
// 1. DATA INVENTORY & CABANG
$barang = [
    ['id' => 1, 'nama' => 'Laptop ROG Strix', 'stok' => 12, 'status' => 'Active', 'restock_date' => '2026-01-07'],
    ['id' => 2, 'nama' => 'Mechanical Keyboard V3', 'stok' => 45, 'status' => 'Pending', 'restock_date' => '2026-01-15'],
    ['id' => 3, 'nama' => 'Monitor 24 Inch', 'stok' => 8, 'status' => 'Active', 'restock_date' => '2026-01-22'],
    ['id' => 4, 'nama' => 'Mouse Gaming Wireless', 'stok' => 20, 'status' => 'Active', 'restock_date' => '2026-01-22'],
    ['id' => 5, 'nama' => 'Headset Arctic 7', 'stok' => 15, 'status' => 'Active', 'restock_date' => '2026-01-28'],
    ['id' => 6, 'nama' => 'Webcam Ultra HD', 'stok' => 10, 'status' => 'Active', 'restock_date' => '2026-01-30'],
    ['id' => 7, 'nama' => 'Laptop ROG Strix', 'stok' => 12, 'status' => 'Active', 'restock_date' => '2026-01-07'],
    ['id' => 8, 'nama' => 'Mechanical Keyboard V3', 'stok' => 45, 'status' => 'Pending', 'restock_date' => '2026-01-15'],
    ['id' => 9, 'nama' => 'Monitor 24 Inch', 'stok' => 8, 'status' => 'Active', 'restock_date' => '2026-01-22'],
    ['id' => 10, 'nama' => 'Mouse Gaming Wireless', 'stok' => 20, 'status' => 'Active', 'restock_date' => '2026-01-22'],
    ['id' => 11, 'nama' => 'Headset Arctic 7', 'stok' => 15, 'status' => 'Active', 'restock_date' => '2026-01-28'],
    ['id' => 12, 'nama' => 'Webcam Ultra HD', 'stok' => 10, 'status' => 'Active', 'restock_date' => '2026-01-30'],
];

$cabang = [
    ['nama' => 'Jakarta Selatan', 'persen' => 85, 'color' => '#00d1b2'],
    ['nama' => 'Bandung Tengah', 'persen' => 65, 'color' => '#3b82f6'],
    ['nama' => 'Surabaya City', 'persen' => 45, 'color' => '#f59e0b'],
    ['nama' => 'Medan Area', 'persen' => 30, 'color' => '#ef4444'],
];

$restock_json = json_encode($barang);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GemaEnterprise - Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root { --accent-teal: #00d1b2; --bg-light: #f8fafc; }

        body, html { height: 100vh; overflow: hidden; background-color: var(--bg-light); font-family: 'Inter', sans-serif; margin: 0; }

        .app-container { display: flex; height: 100vh; overflow: hidden; }
    
        .main-content { flex-grow: 1; overflow: hidden; display: flex; flex-direction: column; padding: 20px; gap: 15px; }

        /* Stat Card Styling */
        .stat-card {
            background: #fff; border-radius: 16px; padding: 12px 15px; display: flex; align-items: center; 
            gap: 12px; border: 1px solid #e2e8f0; transition: all 0.3s ease; height: 100%;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.05); }
        .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        
        .icon-value { background: rgba(0, 209, 178, 0.1); color: #00d1b2; }
        .icon-cat { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .icon-surplus { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .icon-alert { background: rgba(244, 63, 94, 0.1); color: #f43f5e; animation: pulse-red 2s infinite; }

        @keyframes pulse-red { 0% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.4); } 70% { box-shadow: 0 0 0 10px rgba(244, 63, 94, 0); } 100% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0); } }

        /* Main Card Layout */
        .main-card { background: #fff; border-radius: 15px; padding: 15px; height: 100%; border: 1px solid #e2e8f0; display: flex; flex-direction: column; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .scroll-area { 
    overflow-y: auto; 
    flex-grow: 1; 
    padding-right: 5px;
    min-height: 0; /* KUNCI UTAMA: Memungkinkan flex child untuk mengecil lebih kecil dari kontennya */
}

/* Pastikan header tabel tetap terlihat saat di-scroll */
.sticky-top {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: white !important;
}
        .scroll-area::-webkit-scrollbar { width: 4px; }
        .scroll-area::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        /* Calendar & Ticket */
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; text-align: center; }
        .day-num { font-size: 11px; padding: 6px 0; border-radius: 6px; cursor: pointer; position: relative; }
        .day-num.active { background: var(--accent-teal); color: white; font-weight: bold; }
        .day-num.has-event::after { content: ''; position: absolute; bottom: 3px; left: 50%; transform: translateX(-50%); width: 4px; height: 4px; background: #f43f5e; border-radius: 50%; }

        .ticket-card {
            background: #fff9f0; border-left: 4px solid #f59e0b; border-radius: 8px;
            padding: 10px; margin-top: 10px; display: flex; align-items: center; gap: 10px;
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn { from { transform: translateY(10px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        .progress { height: 6px; border-radius: 10px; }
    </style>
</head>
<body>

<div class="app-container">
    <div class="sidebar-wrapper">
        <?php include './components/sidebar.php'; ?>
    </div>

    <div class="main-content">
        <div class="row g-3" style="flex: 0 0 auto;">
            <div class="col-3">
                <div class="stat-card">
                    <div class="stat-icon icon-value"><i class="bi bi-wallet2"></i></div>
                    <div><small class="text-muted d-block" style="font-size: 11px;">Stock Value</small><h6 class="fw-bold mb-0">Rp 185M</h6></div>
                </div>
            </div>
            <div class="col-3">
                <div class="stat-card">
                    <div class="stat-icon icon-cat"><i class="bi bi-box-seam"></i></div>
                    <div><small class="text-muted d-block" style="font-size: 11px;">Categories</small><h6 class="fw-bold mb-0"><?= count($barang) ?> Items</h6></div>
                </div>
            </div>
            <div class="col-3">
                <div class="stat-card">
                    <div class="stat-icon icon-surplus"><i class="bi bi-graph-up-arrow"></i></div>
                    <div><small class="text-muted d-block" style="font-size: 11px;">Surplus</small><h6 class="fw-bold mb-0 text-success">+12.5%</h6></div>
                </div>
            </div>
            <div class="col-3">
                <div class="stat-card">
                    <div class="stat-icon icon-alert"><i class="bi bi-bell-fill"></i></div>
                    <div><small class="text-muted d-block" style="font-size: 11px;">Alerts</small><h6 class="fw-bold mb-0 text-danger">3 Critical</h6></div>
                </div>
            </div>
        </div>

        <div class="row g-3" style="flex: 1 1 45%; min-height: 0;">
            <div class="col-8">
                <div class="main-card">
                    <h6 class="fw-bold mb-2">Inventory Analytics</h6>
                    <div style="flex-grow: 1;"><canvas id="engagementChart"></canvas></div>
                </div>
            </div>
            <div class="col-4">
                <div class="main-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 id="cal-title" class="fw-bold mb-0 small">Januari 2026</h6>
                        <div class="btn-group"><button class="btn btn-sm py-0" onclick="changeMonth(-1)"><i class="bi bi-chevron-left"></i></button><button class="btn btn-sm py-0" onclick="changeMonth(1)"><i class="bi bi-chevron-right"></i></button></div>
                    </div>
                    <div class="calendar-grid" id="cal-body"></div>
                    <div id="ticket-container">
                        <div class="text-muted text-center mt-3 small" style="font-size: 10px;">Click marked date for ticket</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3" style="flex: 1 1 35%; min-height: 0;">
            <div class="col-4">
                <div class="main-card">
                    <h6 class="fw-bold mb-2 small">Branch Performance (%)</h6>
                    <div class="scroll-area">
                        <?php foreach($cabang as $c): ?>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1" style="font-size: 11px;"><span><?= $c['nama'] ?></span><span class="fw-bold"><?= $c['persen'] ?>%</span></div>
                                <div class="progress"><div class="progress-bar" style="width: <?= $c['persen'] ?>%; background-color: <?= $c['color'] ?>"></div></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-8 h-100"> <div class="main-card">
        <h6 class="fw-bold mb-2 small">Live Inventory Management</h6>
        <div class="scroll-area">
            <table class="table table-sm table-hover mb-0" style="font-size: 12px;">
                <thead class="sticky-top bg-white" style="box-shadow: 0 2px 2px -1px rgba(0,0,0,0.05);">
                    <tr>
                        <th class="py-2">ITEM</th>
                        <th class="py-2">STATUS</th>
                        <th class="py-2">RESTOCK TARGET</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($barang as $b): ?>
                        <tr>
                            <td class="fw-bold py-2"><?= $b['nama'] ?></td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <?= $b['status'] ?>
                                </span>
                            </td>
                            <td><?= $b['restock_date'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const inventoryAgenda = <?= $restock_json ?>;
    let viewDate = new Date();

    function renderCalendar() {
        const body = document.getElementById('cal-body');
        const title = document.getElementById('cal-title');
        body.innerHTML = '';
        ['Mo','Tu','We','Th','Fr','Sa','Su'].forEach(d => body.innerHTML += `<div class="fw-bold text-muted" style="font-size:10px">${d}</div>`);
        const year = viewDate.getFullYear(), month = viewDate.getMonth();
        title.innerText = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' }).format(viewDate);
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        let gap = (firstDay === 0) ? 6 : firstDay - 1;
        for (let i = 0; i < gap; i++) body.innerHTML += `<div></div>`;
        for (let d = 1; d <= daysInMonth; d++) {
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            const hasEvent = inventoryAgenda.some(item => item.restock_date === dateStr);
            const isToday = new Date().toDateString() === new Date(year, month, d).toDateString();
            body.innerHTML += `<div class="day-num ${isToday?'active':''} ${hasEvent?'has-event':''}" onclick="showTicket('${dateStr}')">${d}</div>`;
        }
    }

    function showTicket(date) {
        const container = document.getElementById('ticket-container');
        const match = inventoryAgenda.find(i => i.restock_date === date);
        if (match) {
            container.innerHTML = `
                <div class="ticket-card">
                    <i class="bi bi-ticket-detailed-fill text-warning fs-4"></i>
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 11px;">Restock: ${match.nama}</div>
                        <div class="text-muted" style="font-size: 9px;">Target Date: ${date}</div>
                    </div>
                </div>`;
        } else {
            container.innerHTML = `<div class="text-muted text-center mt-3 small" style="font-size: 10px;">No specific event</div>`;
        }
    }

    function changeMonth(s) { viewDate.setMonth(viewDate.getMonth() + s); renderCalendar(); }

    document.addEventListener('DOMContentLoaded', () => {
        renderCalendar();
        const ctx = document.getElementById('engagementChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0, 209, 178, 0.3)');
        gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                datasets: [{
                    data: [45, 55, 42, 85, 60, 92, 58, 88, 52, 98, 72, 85],
                    borderColor: '#00d1b2', borderWidth: 3, fill: true, backgroundColor: gradient, tension: 0.5, pointRadius: 0
                }]
            },
            options: { maintainAspectRatio: false, plugins: { legend: { display: false } },
                scales: { x: { grid: { display: false }, ticks: { font: { size: 10 } } }, y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } } }
            }
        });
    });
</script>
</body>
</html>