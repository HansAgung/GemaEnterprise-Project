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
            --sidebar-width: 250px; /* Sesuaikan dengan lebar sidebar.php anda */
        }

        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden; /* Mencegah scroll seluruh halaman */
            background-color: #f8fafc;
        }

        /* Layout Utama */
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

        /* Container Kasir */
        .kasir-container {
            flex-grow: 1;
            display: flex;
            flex-direction: row;
            gap: 1rem;
            padding: 1rem;
            min-height: 0; /* Penting untuk internal scroll */
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background: #fff;
            display: flex;
            flex-direction: column;
        }

        /* Area Kiri: Produk */
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

        /* Area Kanan: Sidebar POS */
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

        /* Kartu Produk */
        .product-card {
            transition: all 0.2s;
            cursor: pointer;
            border: 1px solid #f1f5f9;
            height: 130px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .product-card:hover {
            border-color: var(--accent-teal);
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 209, 178, 0.1);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }

        .total-section { background: #f8fafc; border-radius: 10px; padding: 1rem; }
        .cart-item { border-bottom: 1px dashed #e2e8f0; padding: 8px 0; }
    </style>
</head>
<body>

<?php
// Data Dummy Produk (Sama seperti sebelumnya)
$produk = [
        // --- MAKANAN ---
        ['id' => 1, 'nama' => 'Nasi Goreng Special', 'harga' => 15000, 'kategori' => 'Makanan', 'img' => '🍳'],
        ['id' => 2, 'nama' => 'Ayam Bakar Madu', 'harga' => 20000, 'kategori' => 'Makanan', 'img' => '🍗'],
        ['id' => 3, 'nama' => 'Mie Goreng Seafood', 'harga' => 18000, 'kategori' => 'Makanan', 'img' => '🍝'],
        ['id' => 4, 'nama' => 'Sate Ayam Madura', 'harga' => 25000, 'kategori' => 'Makanan', 'img' => '🍢'],
        ['id' => 5, 'nama' => 'Bakso Mercon', 'harga' => 15000, 'kategori' => 'Makanan', 'img' => '🥣'],
        ['id' => 6, 'nama' => 'Nasi Padang Komplit', 'harga' => 22000, 'kategori' => 'Makanan', 'img' => '🍛'],
        ['id' => 7, 'nama' => 'Gado-Gado Betawi', 'harga' => 12000, 'kategori' => 'Makanan', 'img' => '🥗'],
        ['id' => 8, 'nama' => 'Soto Ayam Lamongan', 'harga' => 15000, 'kategori' => 'Makanan', 'img' => '🍲'],
        ['id' => 9, 'nama' => 'Ikan Bakar Nila', 'harga' => 35000, 'kategori' => 'Makanan', 'img' => '🐟'],
        ['id' => 10, 'nama' => 'Rawon Daging', 'harga' => 25000, 'kategori' => 'Makanan', 'img' => '🥘'],
        ['id' => 11, 'nama' => 'Nasi Uduk Betawi', 'harga' => 10000, 'kategori' => 'Makanan', 'img' => '🍚'],
        ['id' => 12, 'nama' => 'Bebek Goreng Kremes', 'harga' => 28000, 'kategori' => 'Makanan', 'img' => '🦆'],
        ['id' => 13, 'nama' => 'Capcay Seafood', 'harga' => 17000, 'kategori' => 'Makanan', 'img' => '🥦'],
        ['id' => 14, 'nama' => 'Kwetiau Goreng Sapi', 'harga' => 20000, 'kategori' => 'Makanan', 'img' => '🍜'],
        ['id' => 15, 'nama' => 'Pempek Kapal Selam', 'harga' => 15000, 'kategori' => 'Makanan', 'img' => '🥟'],
        ['id' => 16, 'nama' => 'Gulai Kambing', 'harga' => 30000, 'kategori' => 'Makanan', 'img' => '🐐'],
        ['id' => 17, 'nama' => 'Ayam Geprek Level 5', 'harga' => 15000, 'kategori' => 'Makanan', 'img' => '🌶️'],
        ['id' => 18, 'nama' => 'Pepes Ikan Mas', 'harga' => 18000, 'kategori' => 'Makanan', 'img' => '🍃'],
        ['id' => 19, 'nama' => 'Nasi Kuning Ultah', 'harga' => 15000, 'kategori' => 'Makanan', 'img' => '🎂'],
        ['id' => 20, 'nama' => 'Tongseng Sapi', 'harga' => 25000, 'kategori' => 'Makanan', 'img' => '🥩'],

        // --- MINUMAN ---
        ['id' => 21, 'nama' => 'Es Teh Manis', 'harga' => 5000, 'kategori' => 'Minuman', 'img' => '🍹'],
        ['id' => 22, 'nama' => 'Jus Jeruk Segar', 'harga' => 8000, 'kategori' => 'Minuman', 'img' => '🍊'],
        ['id' => 23, 'nama' => 'Kopi Susu Gula Aren', 'harga' => 12000, 'kategori' => 'Minuman', 'img' => '☕'],
        ['id' => 24, 'nama' => 'Es Degan Murni', 'harga' => 10000, 'kategori' => 'Minuman', 'img' => '🥥'],
        ['id' => 25, 'nama' => 'Thai Tea Original', 'harga' => 10000, 'kategori' => 'Minuman', 'img' => '🧋'],
        ['id' => 26, 'nama' => 'Soda Gembira', 'harga' => 12000, 'kategori' => 'Minuman', 'img' => '🥤'],
        ['id' => 27, 'nama' => 'Jus Alpukat Kocok', 'harga' => 15000, 'kategori' => 'Minuman', 'img' => '🥑'],
        ['id' => 28, 'nama' => 'Wedang Jahe Hangat', 'harga' => 7000, 'kategori' => 'Minuman', 'img' => '🍵'],
        ['id' => 29, 'nama' => 'Es Campur Spesial', 'harga' => 15000, 'kategori' => 'Minuman', 'img' => '🍧'],
        ['id' => 30, 'nama' => 'Green Tea Latte', 'harga' => 15000, 'kategori' => 'Minuman', 'img' => '🍃'],
        ['id' => 31, 'nama' => 'Es Doger', 'harga' => 10000, 'kategori' => 'Minuman', 'img' => '🥣'],
        ['id' => 32, 'nama' => 'Lemon Tea Ice', 'harga' => 7000, 'kategori' => 'Minuman', 'img' => '🍋'],
        ['id' => 33, 'nama' => 'Kopi Hitam Mantap', 'harga' => 5000, 'kategori' => 'Minuman', 'img' => '🖤'],
        ['id' => 34, 'nama' => 'Es Milo Dinosaurus', 'harga' => 12000, 'kategori' => 'Minuman', 'img' => '🦖'],
        ['id' => 35, 'nama' => 'Jus Mangga Arumanis', 'harga' => 10000, 'kategori' => 'Minuman', 'img' => '🥭'],
        ['id' => 36, 'nama' => 'Mineral Water 600ml', 'harga' => 4000, 'kategori' => 'Minuman', 'img' => '💧'],
        ['id' => 37, 'nama' => 'Cappuccino Hot', 'harga' => 15000, 'kategori' => 'Minuman', 'img' => '🥛'],
        ['id' => 38, 'nama' => 'Es Cincau Serut', 'harga' => 8000, 'kategori' => 'Minuman', 'img' => '🧊'],
        ['id' => 39, 'nama' => 'Jus Sirsak Madu', 'harga' => 12000, 'kategori' => 'Minuman', 'img' => '🍐'],
        ['id' => 40, 'nama' => 'Matcha Cold Brew', 'harga' => 18000, 'kategori' => 'Minuman', 'img' => '🧤'],

        // --- SNACK ---
        ['id' => 41, 'nama' => 'Roti Bakar Coklat', 'harga' => 10000, 'kategori' => 'Snack', 'img' => '🍞'],
        ['id' => 42, 'nama' => 'Coklat Bar Premium', 'harga' => 12000, 'kategori' => 'Snack', 'img' => '🍫'],
        ['id' => 43, 'nama' => 'Kentang Goreng McD', 'harga' => 12000, 'kategori' => 'Snack', 'img' => '🍟'],
        ['id' => 44, 'nama' => 'Pisang Goreng Keju', 'harga' => 10000, 'kategori' => 'Snack', 'img' => '🍌'],
        ['id' => 45, 'nama' => 'Donat Hias Cantik', 'harga' => 7000, 'kategori' => 'Snack', 'img' => '🍩'],
        ['id' => 46, 'nama' => 'Martabak Manis Mini', 'harga' => 15000, 'kategori' => 'Snack', 'img' => '🥞'],
        ['id' => 47, 'nama' => 'Dimsum Ayam (4pcs)', 'harga' => 15000, 'kategori' => 'Snack', 'img' => '🍱'],
        ['id' => 48, 'nama' => 'Siomay Bandung', 'harga' => 12000, 'kategori' => 'Snack', 'img' => '🥟'],
        ['id' => 49, 'nama' => 'Tahu Bakso Goreng', 'harga' => 10000, 'kategori' => 'Snack', 'img' => '🧊'],
        ['id' => 50, 'nama' => 'Mendoan Purwokerto', 'harga' => 10000, 'kategori' => 'Snack', 'img' => '🥓'],
        ['id' => 51, 'nama' => 'Sosis Bakar Jumbo', 'harga' => 15000, 'kategori' => 'Snack', 'img' => '🌭'],
        ['id' => 52, 'nama' => 'Burger Mini', 'harga' => 12000, 'kategori' => 'Snack', 'img' => '🍔'],
        ['id' => 53, 'nama' => 'Sandwich Sehat', 'harga' => 15000, 'kategori' => 'Snack', 'img' => '🥪'],
        ['id' => 54, 'nama' => 'Croissant Butter', 'harga' => 18000, 'kategori' => 'Snack', 'img' => '🥐'],
        ['id' => 55, 'nama' => 'Pukis Lumer', 'harga' => 10000, 'kategori' => 'Snack', 'img' => '🧁'],
        ['id' => 56, 'nama' => 'Onion Ring Crispy', 'harga' => 12000, 'kategori' => 'Snack', 'img' => '⭕'],
        ['id' => 57, 'nama' => 'Singkong Keju', 'harga' => 10000, 'kategori' => 'Snack', 'img' => '🥔'],
        ['id' => 58, 'nama' => 'Kue Cubit ½ Matang', 'harga' => 10000, 'kategori' => 'Snack', 'img' => '🥠'],
        ['id' => 59, 'nama' => 'Bakwan Jagung Manis', 'harga' => 8000, 'kategori' => 'Snack', 'img' => '🌽'],
        ['id' => 60, 'nama' => 'Macaroni Schotel', 'harga' => 20000, 'kategori' => 'Snack', 'img' => '🧀'],
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
                                <div class="card card-custom product-card p-2" onclick="addToCart(<?= $item['id']; ?>, '<?= $item['nama']; ?>', <?= $item['harga']; ?>)">
                                    <div class="fs-2"><?= $item['img']; ?></div>
                                    <div class="fw-bold small text-dark mt-1 text-truncate w-100"><?= $item['nama']; ?></div>
                                    <div class="text-primary fw-bold small">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></div>
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
                        <button class="btn btn-primary w-100 fw-bold py-2" onclick="checkout()">
                            PROSES PEMBAYARAN
                        </button>
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

            </div> </div> </div> </div> 

<script>
    let cart = [];

    function addToCart(id, name, price) {
        const existing = cart.find(item => item.id === id);
        if (existing) {
            existing.qty++;
        } else {
            cart.push({ id, name, price, qty: 1 });
        }
        renderCart();
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

        cart.forEach((item, index) => {
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
                        <button class="btn btn-sm text-danger p-0" onclick="removeFromCart(${index})"><i class="bi bi-dash-circle"></i></button>
                    </div>
                </div>`;
        });

        subtotalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    function removeFromCart(index) {
        if(cart[index].qty > 1) {
            cart[index].qty--;
        } else {
            cart.splice(index, 1);
        }
        renderCart();
    }

    function clearCart() {
        if(confirm('Hapus semua pesanan?')) {
            cart = [];
            renderCart();
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
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>