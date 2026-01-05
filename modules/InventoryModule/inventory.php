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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/GemaEnterprise/assets/js/loginfunc.js"></script>
    <script src="/GemaEnterprise/assets/js/checksession.js"></script>
    <link rel="stylesheet" href="/GemaEnterprise/assets/css/inventoryPage.css">
</head>
<body class="bg-dark text-light">
    <!-- Sidebar -->
    <div class="d-flex">
        <?php include './components/sidebar.php'; ?>

        <div class="flex-grow-1">
            <!-- Navbar -->
            <?php include './components/navbar.php'; ?>

            <div class="container mt-4">
                <h2 class="mb-4">Inventory Management</h2>

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
                    <div class="tab-pane fade show active" id="barang" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Data Barang</h4>
                            <button class="btn btn-success" onclick="checkSessionAndAction()">Tambah Barang</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-dark">
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
                    </div>

                    <div class="tab-pane fade" id="supplier" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Data Supplier</h4>
                            <button class="btn btn-success" onclick="checkSessionAndAction()">Tambah Supplier</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-dark">
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
                    </div>

                    <div class="tab-pane fade" id="laporan" role="tabpanel">
                        <h4>Laporan Inventory</h4>
                        <p>Di sini bisa tampilkan chart atau laporan.</p>
                        <button class="btn btn-info" onclick="checkSessionAndAction()">Generate Laporan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../components/modal.php'; ?>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const toggle = document.getElementById('sidebarToggle');
            const isOpen = sidebar.style.left === '0px';
            sidebar.style.left = isOpen ? '-250px' : '0px';
            overlay.style.display = isOpen ? 'none' : 'block';
            toggle.className = isOpen ? 'navbar-toggler-icon' : 'bi bi-x';
            toggle.style.fontSize = isOpen ? '1rem' : '1.5rem';
        }
    </script>
</body>
</html>