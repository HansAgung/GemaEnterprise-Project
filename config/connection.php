<?php
$host = 'localhost';
$user = 'root';
$pass = 'test123';
$db   = 'gema_enterprise';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>