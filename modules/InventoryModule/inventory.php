<?php
// Dummy data untuk tabs
$barang = [
    ['id' => 1, 'nama' => 'Laptop', 'stok' => 10, 'harga' => 5000000],
    ['id' => 2, 'nama' => 'Mouse', 'stok' => 50, 'harga' => 50000],
];

$supplier = [
    ['id' => 1, 'nama' => 'PT ABC', 'kontak' => 'abc@email.com'],
    ['id' => 2, 'nama' => 'CV XYZ', 'kontak' => 'xyz@email.com'],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GemaEnterprise - Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/loginfunc.js"></script>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">GemaEnterprise - Inventory</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="../../index.php">Dashboard</a>
                <button class="btn btn-outline-light ms-2" onclick="logout()">Logout</button>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4">Inventory Management</h2>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="inventoryTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="barang-tab" data-bs-toggle="tab" data-bs-target="#barang" type="button" role="tab">Data Barang</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="supplier-tab" data-bs-toggle="tab" data-bs-target="#supplier" type="button" role="tab">Data Supplier</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan" type="button" role="tab">Laporan</button>
            </li>
        </ul>

        <div class="tab-content mt-3" id="inventoryTabsContent">
            <!-- Tab Barang -->
            <div class="tab-pane fade show active" id="barang" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Data Barang</h4>
                    <button class="btn btn-success" onclick="checkSessionAndAction()">Tambah Barang</button>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($barang as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['nama']; ?></td>
                            <td><?php echo $item['stok']; ?></td>
                            <td>Rp <?php echo number_format($item['harga']); ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="checkSessionAndAction()">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="checkSessionAndAction()">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tab Supplier -->
            <div class="tab-pane fade" id="supplier" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Data Supplier</h4>
                    <button class="btn btn-success" onclick="checkSessionAndAction()">Tambah Supplier</button>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($supplier as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['nama']; ?></td>
                            <td><?php echo $item['kontak']; ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="checkSessionAndAction()">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="checkSessionAndAction()">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tab Laporan -->
            <div class="tab-pane fade" id="laporan" role="tabpanel">
                <h4>Laporan Inventory</h4>
                <p>Di sini bisa tampilkan chart atau laporan.</p>
                <button class="btn btn-info" onclick="checkSessionAndAction()">Generate Laporan</button>
            </div>
        </div>
    </div>

    <!-- Modal untuk session habis -->
    <div class="modal fade" id="sessionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sesi Habis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Sesi kamu telah habis! Silakan login kembali.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='./route.php?page=login'">Login</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
            tab.addEventListener('shown.bs.tab', function () {
                fetch('../../config/check_session.php', { method: 'POST' });
            });
        });

        setInterval(function() {
            fetch('./config/check_session.php', { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                if (!data.valid) {
                    var myModal = new bootstrap.Modal(document.getElementById('sessionModal'));
                    myModal.show();
                }
            })
            .catch(error => console.error('Error checking session'));
        }, 1800); 

        function checkSessionAndAction() {
            fetch('./config/check_session.php', { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                if (!data.valid) {
                    var myModal = new bootstrap.Modal(document.getElementById('sessionModal'));
                    myModal.show();
                } else {
                    alert('Session valid! Aksi berhasil.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error checking session');
            });
        }
    </script>
</body>
</html>