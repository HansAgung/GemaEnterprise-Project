<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['valid' => check_session()]);
    exit;
}

function check_session() {
    $timeout_duration = 1800; // Ubah ke 3 detik untuk test cepat

    if (!isset($_SESSION['last_activity'])) {
        return false;
    }

    $elapsed_time = time() - $_SESSION['last_activity'];

    if ($elapsed_time > $timeout_duration) {
        return false;
    }

    $_SESSION['last_activity'] = time();
    return true;
}
?>