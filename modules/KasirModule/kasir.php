<?php
// Dummy data produk untuk kasir
$produk = [
    ['id' => 1, 'nama' => 'Nasi Goreng', 'harga' => 15000, 'kategori' => 'Makanan'],
    ['id' => 2, 'nama' => 'Ayam Bakar', 'harga' => 20000, 'kategori' => 'Makanan'],
    ['id' => 3, 'nama' => 'Es Teh', 'harga' => 5000, 'kategori' => 'Minuman'],
    ['id' => 4, 'nama' => 'Jus Jeruk', 'harga' => 8000, 'kategori' => 'Minuman'],
    ['id' => 5, 'nama' => 'Roti', 'harga' => 10000, 'kategori' => 'Snack'],
    ['id' => 6, 'nama' => 'Coklat', 'harga' => 12000, 'kategori' => 'Snack'],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier - GemaEnterprise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/GemaEnterprise/assets/js/loginfunc.js"></script>
    <script src="/GemaEnterprise/assets/js/checksession.js"></script>
    <!-- <link rel="stylesheet" href="/GemaEnterprise/assets/css/inventoryPage.css"> -->
    <style>
         body { color: #2150b5ff; }
        .product-btn { height: 80px; font-size: 1.2rem; margin: 5px; }
        .cart-item { display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #ddd; }
        .total { font-size: 1.5rem; font-weight: bold; }
        .checkout-btn { font-size: 1.5rem; padding: 15px; }
    </style>
</head>
<body class="bg-light">
    <!-- Sidebar -->
    <div class="d-flex">
        <?php include '../../components/sidebar.php'; ?>

        <div class="flex-grow-1">
            <?php $pageTitle = 'Cashier'; ?>
            <!-- Navbar -->
            <?php include '../../components/navbar.php'; ?>

            <div class="container-fluid mt-4">
                <div class="row">
                    <!-- Panel Kiri: Produk -->
                    <div class="col-md-8">
                        <h3 class="mb-3">Pilih Produk</h3>
                        <!-- Search/Input Barcode -->
                        <div class="mb-3">
                            <input type="text" class="form-control" id="searchProduct" placeholder="Cari produk atau scan barcode">
                        </div>
                        <!-- Kategori Tabs -->
                        <ul class="nav nav-tabs" id="productTabs">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#semua">Semua</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#makanan">Makanan</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#minuman">Minuman</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#snack">Snack</button>
                            </li>
                        </ul>
                        <div class="tab-content mt-3">
                            <div class="tab-pane fade show active" id="semua">
                                <div class="row">
                                    <?php foreach ($produk as $item): ?>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-primary product-btn w-100" onclick="addToCart(<?php echo $item['id']; ?>, '<?php echo $item['nama']; ?>', <?php echo $item['harga']; ?>)">
                                            <?php echo $item['nama']; ?><br>Rp <?php echo number_format($item['harga']); ?>
                                        </button>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- Tab lainnya bisa diisi serupa -->
                            <div class="tab-pane fade" id="makanan">
                                <div class="row">
                                    <?php foreach (array_filter($produk, function($p) { return $p['kategori'] == 'Makanan'; }) as $item): ?>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-primary product-btn w-100" onclick="addToCart(<?php echo $item['id']; ?>, '<?php echo $item['nama']; ?>', <?php echo $item['harga']; ?>)">
                                            <?php echo $item['nama']; ?><br>Rp <?php echo number_format($item['harga']); ?>
                                        </button>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="minuman">
                                <div class="row">
                                    <?php foreach (array_filter($produk, function($p) { return $p['kategori'] == 'Minuman'; }) as $item): ?>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-primary product-btn w-100" onclick="addToCart(<?php echo $item['id']; ?>, '<?php echo $item['nama']; ?>', <?php echo $item['harga']; ?>)">
                                            <?php echo $item['nama']; ?><br>Rp <?php echo number_format($item['harga']); ?>
                                        </button>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="snack">
                                <div class="row">
                                    <?php foreach (array_filter($produk, function($p) { return $p['kategori'] == 'Snack'; }) as $item): ?>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-primary product-btn w-100" onclick="addToCart(<?php echo $item['id']; ?>, '<?php echo $item['nama']; ?>', <?php echo $item['harga']; ?>)">
                                            <?php echo $item['nama']; ?><br>Rp <?php echo number_format($item['harga']); ?>
                                        </button>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Kanan: Keranjang -->
                    <div class="col-md-4">
                        <h3>Keranjang Belanja</h3>
                        <div id="cart" class="border p-3" style="height: 400px; overflow-y: auto;">
                            <!-- Items akan ditambah di sini -->
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between total">
                                <span>Total:</span>
                                <span id="total">Rp 0</span>
                            </div>
                            <button class="btn btn-success w-100 checkout-btn mt-3" onclick="checkout()">Bayar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../components/modal.php'; ?>

    <script>
        let cart = [];
        let total = 0;

        function addToCart(id, name, price) {
            const existing = cart.find(item => item.id === id);
            if (existing) {
                existing.qty++;
            } else {
                cart.push({ id, name, price, qty: 1 });
            }
            updateCart();
        }

        function updateCart() {
            const cartDiv = document.getElementById('cart');
            cartDiv.innerHTML = '';
            total = 0;
            cart.forEach(item => {
                total += item.price * item.qty;
                cartDiv.innerHTML += `
                    <div class="cart-item">
                        <span>${item.name} x${item.qty}</span>
                        <span>Rp ${ (item.price * item.qty).toLocaleString() }</span>
                    </div>
                `;
            });
            document.getElementById('total').textContent = 'Rp ' + total.toLocaleString();
        }

        function checkout() {
            if (cart.length === 0) {
                alert('Keranjang kosong!');
                return;
            }
            showReusableModal('Checkout', `Total: Rp ${total.toLocaleString()}<br>Konfirmasi pembayaran?`, 'Ya', () => {
                alert('Pembayaran berhasil! Struk dicetak.');
                cart = [];
                updateCart();
            });
        }
    </script>
</body>
</html>