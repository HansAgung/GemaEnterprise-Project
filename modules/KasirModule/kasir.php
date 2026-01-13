<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir POS - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --accent-teal: #00d1b2;
            --dark-navy: #0d1b2a;
            --sidebar-width: 250px;
        }

        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
            background-color: #f8fafc;
        }

        #wrapper {
            display: flex;
            width: 100vw;
            height: 100vh;
        }

        #page-content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            min-width: 0;
        }

        .kasir-container {
            flex-grow: 1;
            display: flex;
            flex-direction: row;
            gap: 1rem;
            padding: 1rem;
            min-height: 0;
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background: #fff;
            display: flex;
            flex-direction: column;
        }

        .product-section {
            flex: 2;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .product-grid-scroll {
            flex-grow: 1;
            overflow-y: auto;
            padding: 0.5rem;
        }

        .pos-sidebar {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            min-height: 0;
            min-width: 350px;
        }

        .bill-card {
            flex-grow: 1;
            min-height: 0;
        }

        #cart-list {
            flex-grow: 1;
            overflow-y: auto;
            padding-right: 5px;
        }

        .product-card {
            transition: all 0.2s;
            border: 1px solid #f1f5f9;
            height: 145px; /* Sedikit ditambah untuk menampung button */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .product-card:hover {
            border-color: var(--accent-teal);
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 209, 178, 0.1);
        }

        /* Tambahan Style untuk Quantity Button di Card */
        .card-qty-controls {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 5px;
        }
        
        .btn-qty-sm {
            padding: 0;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            border: 1px solid var(--accent-teal);
            background: white;
            color: var(--accent-teal);
            cursor: pointer;
        }

        .btn-qty-sm:hover {
            background: var(--accent-teal);
            color: white;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }

        .total-section { background: #f8fafc; border-radius: 10px; padding: 1rem; }
        .cart-item { border-bottom: 1px dashed #e2e8f0; padding: 8px 0; }
    </style>
</head>
<body>

<?php
$produk = [
    ['id' => 1, 'nama' => 'Nasi Goreng Special', 'harga' => 15000, 'kategori' => 'Makanan', 'img' => '🍳'],
    ['id' => 2, 'nama' => 'Ayam Bakar Madu', 'harga' => 20000, 'kategori' => 'Makanan', 'img' => '🍗'],
    ['id' => 3, 'nama' => 'Mie Goreng Seafood', 'harga' => 18000, 'kategori' => 'Makanan', 'img' => '🍝'],
    ['id' => 4, 'nama' => 'Sate Ayam Madura', 'harga' => 25000, 'kategori' => 'Makanan', 'img' => '🍢'],
    ['id' => 21, 'nama' => 'Es Teh Manis', 'harga' => 5000, 'kategori' => 'Minuman', 'img' => '🍹'],
    ['id' => 22, 'nama' => 'Jus Jeruk Segar', 'harga' => 8000, 'kategori' => 'Minuman', 'img' => '🍊'],
    ['id' => 41, 'nama' => 'Roti Bakar Coklat', 'harga' => 10000, 'kategori' => 'Snack', 'img' => '🍞'],
    ['id' => 43, 'nama' => 'Kentang Goreng McD', 'harga' => 12000, 'kategori' => 'Snack', 'img' => '🍟'],
    // ... data lainnya
];
?>

<div id="wrapper">
    <div class="sidebar-wrapper">
        <?php include './components/sidebar.php'; ?>
    </div>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-2">
            <h5 class="fw-bold m-0 text-dark">Point of Sale (POS)</h5>
        </nav>

        <div class="kasir-container">
            <div class="product-section">
                <div class="card card-custom h-100 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <ul class="nav nav-pills" id="pills-tab">
                            <li class="nav-item"><button class="nav-link active py-1 px-3" onclick="filterCategory('all')">Semua</button></li>
                            <li class="nav-item"><button class="nav-link py-1 px-3" onclick="filterCategory('Makanan')">Makanan</button></li>
                            <li class="nav-item"><button class="nav-link py-1 px-3" onclick="filterCategory('Minuman')">Minuman</button></li>
                            <li class="nav-item"><button class="nav-link py-1 px-3" onclick="filterCategory('Snack')">Snack</button></li>
                        </ul>
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" id="searchProduct" class="form-control bg-light border-0" placeholder="Cari menu...">
                        </div>
                    </div>

                    <div class="product-grid-scroll">
                        <div class="row g-2" id="product-grid">
                            <?php foreach ($produk as $item): ?>
                            <div class="col-md-3 col-sm-4 product-item" data-category="<?= $item['kategori']; ?>">
                                <div class="card card-custom product-card p-2">
                                    <div class="fs-2"><?= $item['img']; ?></div>
                                    <div class="fw-bold small text-dark mt-1 text-truncate w-100"><?= $item['nama']; ?></div>
                                    <div class="text-primary fw-bold small">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></div>
                                    
                                    <div class="card-qty-controls">
                                        <button class="btn-qty-sm" onclick="updateQty(<?= $item['id']; ?>, '<?= $item['nama']; ?>', <?= $item['harga']; ?>, -1)">-</button>
                                        <span class="fw-bold small" id="card-qty-<?= $item['id']; ?>">0</span>
                                        <button class="btn-qty-sm" onclick="updateQty(<?= $item['id']; ?>, '<?= $item['nama']; ?>', <?= $item['harga']; ?>, 1)">+</button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pos-sidebar">
                <div class="card card-custom p-3 bill-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold m-0">Bill Order</h6>
                        <button class="btn btn-sm btn-outline-danger border-0 p-0" onclick="clearCart()"><i class="bi bi-trash fs-5"></i></button>
                    </div>
                    
                    <div id="cart-list">
                        <div class="text-center py-5 text-muted opacity-50" id="empty-cart-msg">
                            <i class="bi bi-cart3 fs-1"></i>
                            <p class="small mt-2">Belum ada pesanan</p>
                        </div>
                    </div>

                    <div class="total-section mt-2">
                        <div class="d-flex justify-content-between mb-1 small text-muted">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 border-top pt-2">
                            <span class="fw-bold text-dark">Total</span>
                            <span class="fw-bold text-primary fs-5" id="total-price">Rp 0</span>
                        </div>
                        <button class="btn btn-primary w-100 fw-bold py-2" onclick="checkout()">PROSES PEMBAYARAN</button>
                    </div>
                </div>

                <div class="card card-custom p-3">
                    <h6 class="fw-bold mb-3 small text-uppercase text-muted"><i class="bi bi-info-circle me-1"></i> Detail Transaksi</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="small fw-bold text-muted">No. TRX</label>
                            <input type="text" class="form-control form-control-sm bg-light border-0 fw-bold" value="TRX-<?= date('dmy'); ?>-001" readonly>
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold text-muted">Tanggal</label>
                            <input type="text" class="form-control form-control-sm bg-light border-0 text-muted" value="<?= date('d/m/Y'); ?>" readonly>
                        </div>
                        <div class="col-12">
                            <label class="small fw-bold text-muted">Nama Customer</label>
                            <input type="text" id="namaCustomer" class="form-control form-control-sm bg-light border-0" placeholder="Input nama...">
                        </div>
                        <div class="col-12">
                            <textarea id="notes" class="form-control form-control-sm bg-light border-0" rows="2" placeholder="Catatan (Meja/Request)..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = [];

    // Fungsi Gabungan untuk Tambah dan Kurang Qty
    function updateQty(id, name, price, change) {
        const index = cart.findIndex(item => item.id === id);

        if (index > -1) {
            cart[index].qty += change;
            if (cart[index].qty <= 0) {
                cart.splice(index, 1);
            }
        } else if (change > 0) {
            cart.push({ id, name, price, qty: 1 });
        }
        
        renderCart();
        syncCardQuantities();
    }

    // Fungsi untuk memperbarui tampilan angka di tiap Card
    function syncCardQuantities() {
        // Reset semua angka di card dulu ke 0
        document.querySelectorAll('[id^="card-qty-"]').forEach(el => el.textContent = '0');
        
        // Isi sesuai data di cart
        cart.forEach(item => {
            const el = document.getElementById(`card-qty-${item.id}`);
            if (el) el.textContent = item.qty;
        });
    }

    function renderCart() {
        const cartList = document.getElementById('cart-list');
        const subtotalEl = document.getElementById('subtotal');
        const totalEl = document.getElementById('total-price');
        
        if (cart.length === 0) {
            cartList.innerHTML = `<div class="text-center py-5 text-muted opacity-50"><i class="bi bi-cart3 fs-1"></i><p class="small mt-2">Belum ada pesanan</p></div>`;
            subtotalEl.textContent = 'Rp 0';
            totalEl.textContent = 'Rp 0';
            return;
        }

        cartList.innerHTML = '';
        let total = 0;

        cart.forEach((item) => {
            const subtotalItem = item.price * item.qty;
            total += subtotalItem;
            cartList.innerHTML += `
                <div class="cart-item d-flex justify-content-between align-items-center">
                    <div style="max-width: 65%;">
                        <div class="small fw-bold text-dark text-truncate">${item.name}</div>
                        <small class="text-muted">${item.qty} x Rp ${item.price.toLocaleString('id-ID')}</small>
                    </div>
                    <div class="text-end">
                        <div class="small fw-bold text-dark">Rp ${subtotalItem.toLocaleString('id-ID')}</div>
                        <button class="btn btn-sm text-danger p-0" onclick="updateQty(${item.id}, '', 0, -1)"><i class="bi bi-dash-circle"></i></button>
                    </div>
                </div>`;
        });

        subtotalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    function clearCart() {
        if(confirm('Hapus semua pesanan?')) {
            cart = [];
            renderCart();
            syncCardQuantities();
        }
    }

    function filterCategory(cat) {
        const buttons = document.querySelectorAll('.nav-link');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');

        const items = document.querySelectorAll('.product-item');
        items.forEach(item => {
            const itemCat = item.getAttribute('data-category');
            item.style.display = (cat === 'all' || itemCat === cat) ? 'block' : 'none';
        });
    }

    document.getElementById('searchProduct').addEventListener('input', function(e) {
        const keyword = e.target.value.toLowerCase();
        const items = document.querySelectorAll('.product-item');
        items.forEach(item => {
            const name = item.querySelector('.fw-bold').textContent.toLowerCase();
            item.style.display = name.includes(keyword) ? 'block' : 'none';
        });
    });

    function checkout() {
        if (cart.length === 0) {
            alert('Pilih produk terlebih dahulu!');
            return;
        }
        const cust = document.getElementById('namaCustomer').value || 'Umum';
        alert(`TRANSAKSI BERHASIL!\nCustomer: ${cust}\nTotal: ${document.getElementById('total-price').textContent}`);
        cart = [];
        document.getElementById('namaCustomer').value = '';
        document.getElementById('notes').value = '';
        renderCart();
        syncCardQuantities();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>