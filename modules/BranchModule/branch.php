<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Management - Gema Enterprise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --accent-teal: #00d1b2;
            --dark-navy: #0d1b2a;
            --soft-bg: #f1f5f9;
        }

        body { background-color: var(--soft-bg); height: 100vh; overflow: hidden; font-family: 'Inter', sans-serif; }
        #wrapper { display: flex; height: 100vh; }
        #page-content-wrapper { flex-grow: 1; display: flex; flex-direction: column; overflow: hidden; }

        .branch-container {
            flex-grow: 1;
            display: flex;
            padding: 1.5rem;
            gap: 1rem;
            min-height: 0;
        }

        /* Kiri: Peta (7) */
        .map-section {
            flex: 7;
            background: #fff;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .island-selector {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 10;
            background: rgba(255,255,255,0.9);
            padding: 8px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            backdrop-filter: blur(5px);
        }

        .island-btn {
            border: none;
            background: transparent;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748b;
            transition: 0.3s;
        }

        .island-btn.active {
            background: var(--accent-teal);
            color: white;
        }

        .map-canvas {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8fafc;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            border-radius: 20px;
            margin: 10px;
            position: relative;
            overflow: hidden;
            border: 2px solid #e2e8f0;
            transition: background-image 0.5s ease-in-out;
        }

        /* Marker Cabang */
        .branch-marker {
            position: absolute;
            width: 18px;
            height: 18px;
            background: #ff3860;
            border: 3px solid white;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(255,56,96,0.5);
            transition: transform 0.3s;
        }
        .branch-marker:hover { transform: scale(1.5); z-index: 100; }
        .marker-label {
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--dark-navy);
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            white-space: nowrap;
            pointer-events: none;
        }

        /* Kanan: Detail (3) */
        .detail-section {
            flex: 3;
            background: #fff;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            padding: 0;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .store-slider { height: 200px; border-radius: 20px 20px 0 0; background: #e2e8f0; }
        .carousel-item { height: 200px; }
        .carousel-item i { font-size: 4rem; color: #94a3b8; }

        .profit-switcher {
            background: #f1f5f9;
            padding: 4px;
            border-radius: 10px;
            display: inline-flex;
            width: 100%;
        }
        .switch-btn {
            flex: 1;
            border: none;
            padding: 6px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            background: transparent;
            color: #64748b;
            transition: 0.2s;
        }
        .switch-btn.active { background: #fff; color: var(--accent-teal); box-shadow: 0 2px 5px rgba(0,0,0,0.05); }

        .stat-card {
            background: var(--soft-bg);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .cash-display {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--dark-navy);
            letter-spacing: -1px;
        }
    </style>
</head>
<body>

<div id="wrapper">
    <div class="sidebar-wrapper">
        <?php include './components/sidebar.php'; ?>
    </div>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-light bg-white border-bottom px-4 py-3">
            <h5 class="fw-bold m-0"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Branch Analysis</h5>
        </nav>

        <div class="branch-container">
            <div class="map-section">
                <div class="island-selector">
                    <button class="island-btn active" onclick="changeRegion('Sumatera')">Sumatera</button>
                    <button class="island-btn" onclick="changeRegion('Jawa')">Jawa</button>
                    <button class="island-btn" onclick="changeRegion('Kalimantan')">Kalimantan</button>
                    <button class="island-btn" onclick="changeRegion('Sulawesi')">Sulawesi</button>
                    <button class="island-btn" onclick="changeRegion('Papua')">Papua</button>
                </div>

                <div class="map-canvas" id="mapCanvas">
                    <div id="regionTitle" style="position:absolute; bottom:20px; right:30px; font-size: 3rem; font-weight: 900; opacity: 0.05; text-transform: uppercase;">Sumatera</div>
                    <div id="markersContainer"></div>
                </div>
            </div>

            <div class="detail-section">
                <div id="storeCarousel" class="carousel slide store-slider" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active d-flex align-items-center justify-content-center bg-light">
                            <i class="bi bi-shop"></i>
                        </div>
                        <div class="carousel-item d-flex align-items-center justify-content-center bg-secondary-subtle">
                            <i class="bi bi-buildings"></i>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#storeCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#storeCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

                <div class="p-4">
                    <h5 class="fw-bold mb-1" id="branchName">-</h5>
                    <p class="text-muted small mb-4"><i class="bi bi-geo-alt"></i> <span id="branchAddr">-</span></p>

                    <label class="small fw-bold text-muted mb-2">Laporan Keuntungan</label>
                    <div class="profit-switcher mb-3">
                        <button class="switch-btn active" onclick="toggleProfit(this, 'W')">Mingguan</button>
                        <button class="switch-btn" onclick="toggleProfit(this, 'M')">Bulanan</button>
                        <button class="switch-btn" onclick="toggleProfit(this, 'Y')">Tahunan</button>
                    </div>

                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small fw-bold text-muted">Net Profit</span>
                            <span class="badge bg-success-subtle text-success">+12.5%</span>
                        </div>
                        <div class="cash-display" id="profitVal">Rp 0</div>
                    </div>

                    <div class="stat-card" style="background: var(--dark-navy); color: white;">
                        <span class="small fw-bold opacity-50">Total Kas Toko</span>
                        <div class="cash-display text-white mt-1" id="cashVal">Rp 0</div>
                    </div>

                    <div class="mt-4">
                        <h6 class="fw-bold small mb-3">Branch Manager</h6>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">AD</div>
                            <div>
                                <div class="fw-bold small">Arya Dirgantara</div>
                                <div class="text-muted" style="font-size: 11px;">Manager since 2021</div>
                            </div>
                        </div>
                    </div>

                    <button class="btn w-100 mt-5 fw-bold py-2" style="background: var(--accent-teal); color: white;">Buka Laporan Detail</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const branchData = {
        'Sumatera': [
            { id: 1, name: 'Gema - Medan Utama', addr: 'Jl. Sudirman No. 12, Medan', x: '45%', y: '25%', cash: '850.400.000', profit: '45.200.000' },
            { id: 2, name: 'Gema - Palembang', addr: 'Kawasan Rajawali, Palembang', x: '65%', y: '65%', cash: '420.000.000', profit: '22.100.000' }
        ],
        'Jawa': [
            { id: 4, name: 'Gema - Jakarta HQ', addr: 'Sudirman Central Business', x: '25%', y: '35%', cash: '2.450.000.000', profit: '150.800.000' },
            { id: 5, name: 'Gema - Surabaya', addr: 'Jl. Tunjungan, Surabaya', x: '75%', y: '50%', cash: '980.000.000', profit: '65.200.000' }
        ],
        'Kalimantan': [
            { id: 6, name: 'Gema - Balikpapan', addr: 'Sudirman St, Balikpapan', x: '55%', y: '50%', cash: '560.000.000', profit: '34.000.000' }
        ],
        'Sulawesi': [
            { id: 7, name: 'Gema - Makassar', addr: 'Pantai Losari, Makassar', x: '45%', y: '70%', cash: '670.000.000', profit: '41.200.000' }
        ],
        'Papua': [] 
    };

    function changeRegion(region) {
        // 1. Ganti Gambar Background Peta dari Assets
        const mapCanvas = document.getElementById('mapCanvas');
        const fileName = region.toLowerCase() + '.jpg';
        mapCanvas.style.backgroundImage = `url('assets/images/${fileName}')`;

        // 2. Update UI Tombol
        document.querySelectorAll('.island-btn').forEach(btn => {
            btn.classList.toggle('active', btn.innerText === region);
        });

        document.getElementById('regionTitle').innerText = region;
        
        // 3. Render Titik Cabang (Markers)
        const container = document.getElementById('markersContainer');
        container.innerHTML = '';

        const branches = branchData[region];
        if (branches.length === 0) {
            container.innerHTML = '<div class="text-muted opacity-50" style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%)">Tidak ada cabang di wilayah ini</div>';
            resetDetail();
        } else {
            branches.forEach(b => {
                const marker = document.createElement('div');
                marker.className = 'branch-marker';
                marker.style.left = b.x;
                marker.style.top = b.y;
                marker.innerHTML = `<div class="marker-label">${b.name}</div>`;
                marker.onclick = () => updateDetail(b);
                container.appendChild(marker);
            });
            // Auto click cabang pertama
            updateDetail(branches[0]);
        }
    }

    function updateDetail(branch) {
        document.getElementById('branchName').innerText = branch.name;
        document.getElementById('branchAddr').innerText = branch.addr;
        document.getElementById('cashVal').innerText = 'Rp ' + branch.cash;
        document.getElementById('profitVal').innerText = 'Rp ' + branch.profit;
        
        // Reset profit switcher ke mingguan saat ganti cabang
        const weeklyBtn = document.querySelector('.switch-btn[onclick*="W"]');
        toggleProfit(weeklyBtn, 'W', false);
    }

    function resetDetail() {
        document.getElementById('branchName').innerText = "Tidak Ada Cabang";
        document.getElementById('branchAddr').innerText = "-";
        document.getElementById('cashVal').innerText = "Rp 0";
        document.getElementById('profitVal').innerText = "Rp 0";
    }

    function toggleProfit(btn, type, updateUI = true) {
        document.querySelectorAll('.switch-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        if(updateUI) {
            // Logika hitung dummy (Mingguan x4 = Bulanan, dst)
            const baseProfit = 45200000; 
            let factor = type === 'W' ? 1 : (type === 'M' ? 4 : 48);
            let newVal = baseProfit * factor;
            document.getElementById('profitVal').innerText = 'Rp ' + newVal.toLocaleString('id-ID');
        }
    }

    window.onload = () => changeRegion('Sumatera');
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>