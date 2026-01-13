<?php
$suppliers = [
    [
        'id' => 1, 
        'name' => 'PT. Sembako Jaya', 
        'category' => 'Food & Beverage', 
        'contact' => 'Andi Suhendra', 
        'phone' => '0812-3456-7890', 
        'email' => 'sales@sembakojaya.com',
        'initials' => 'SJ', 
        'color' => '#4e73df',
        'address' => 'Jl. Industri No. 12, Jakarta'
    ],
    [
        'id' => 2, 
        'name' => 'Gudang Elektronik', 
        'category' => 'Hardware & IT', 
        'contact' => 'Budi Santoso', 
        'phone' => '0855-7788-9900', 
        'email' => 'support@gudangelektronik.id',
        'initials' => 'GE', 
        'color' => '#1cc88a',
        'address' => 'Mangga Dua Mall Lt. 3, Jakarta'
    ],
    [
        'id' => 3, 
        'name' => 'Logistik Sentosa', 
        'category' => 'General Service', 
        'contact' => 'Santi Wijaya', 
        'phone' => '0899-0011-2233', 
        'email' => 'info@logistiksentosa.co.id',
        'initials' => 'LS', 
        'color' => '#f6c23e',
        'address' => 'Kawasan MM2100, Bekasi'
    ],
];

$procurement_orders = [
    [
        'id' => 'PO-8821', 
        'item' => 'Minyak Goreng 2L', 
        'supplier' => 'PT. Sembako Jaya', 
        'qty' => 50, 
        'price' => 35000,
        'status' => 'Received', 
        'date' => '12 Jan 2024',
        'image' => 'https://via.placeholder.com/40'
    ],
    [
        'id' => 'PO-8822', 
        'item' => 'Scanner Zebra X1', 
        'supplier' => 'Gudang Elektronik', 
        'qty' => 5, 
        'price' => 2450000,
        'status' => 'Received', 
        'date' => '10 Jan 2024',
        'image' => 'https://via.placeholder.com/40'
    ],
    [
        'id' => 'PO-8823', 
        'item' => 'Beras Premium 10kg', 
        'supplier' => 'PT. Sembako Jaya', 
        'qty' => 20, 
        'price' => 145000,
        'status' => 'Received', 
        'date' => '09 Jan 2024',
        'image' => 'https://via.placeholder.com/40'
    ],
    [
        'id' => 'PO-8824', 
        'item' => 'Laptop Thinkpad X1', 
        'supplier' => 'Gudang Elektronik', 
        'qty' => 2, 
        'price' => 18000000,
        'status' => 'Pending', 
        'date' => '13 Jan 2024',
        'image' => 'https://via.placeholder.com/40'
    ],
];

// Helper function untuk format rupiah jika dibutuhkan di tampilan
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}
?>