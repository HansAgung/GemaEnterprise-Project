<?php
session_start();
require_once 'config/check_session.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// Cek session, jika habis tampilkan modal
$session_valid = check_session();
// Debug: Uncomment untuk test force habis
// $_SESSION['last_activity'] = time() - 15; $session_valid = check_session();
// Debug: echo "Session valid: " . ($session_valid ? 'true' : 'false') . "<br>";
if (!$session_valid) {
    // Destroy session jika habis
    session_unset();
    session_destroy();
    // Tampilkan modal
    echo "
    <div class='modal fade' id='sessionModal' tabindex='-1' aria-labelledby='sessionModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='sessionModalLabel'>Sesi Habis</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    Waktu habis, Ulanggg!!
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-primary' onclick='window.location.href=\"?page=login\"'>Login</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('sessionModal'));
            myModal.show();
        });
    </script>
    ";
    // Set page ke login
    $page = 'login';
}

switch($page){
    case 'login':
        include "modules/AuthModule/login.php";
        break;
    case 'inventory':
        include 'modules/InventoryModule/inventory.php';
        break;
    case 'kasir':
        include "modules/KasirModule/kasir.php";
        break;
    default:
        echo "<!DOCTYPE html><html><head><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' rel='stylesheet'><script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js'></script></head><body>";
        echo "<h1>Halo selamat Datang!</h1>";
        echo "<button onclick='logout()'>Logout</button>";
        echo "</body></html>";
        break;
}
?>