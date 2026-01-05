<?php
session_start();
require_once '../../config/connection.php'; 

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$method = $input['method'] ?? '';
$params = $input['params'] ?? [];

$response = ['success' => false, 'message' => 'Method tidak ditemukan'];

switch ($method) {
    case 'login':
        $username = $params['username'] ?? '';
        $password = $params['password'] ?? '';

        if (!$username || !$password) {
            $response['message'] = 'Username dan password diperlukan';
            break;
        }

        $username = mysqli_real_escape_string($conn, $username);
        
        $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        $user = mysqli_fetch_assoc($query);

        if ($user && $password == $user['password']) {
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['last_activity'] = time();
            $response = ['success' => true, 'message' => 'Login berhasil'];
        } else {
            $response['message'] = 'Username atau password salah';
        }
        break;

    case 'logout':
        session_destroy(); 
        $response = ['success' => true, 'message' => 'Logout berhasil'];
        break;
}

echo json_encode($response);
exit;
?>