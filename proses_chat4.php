<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Session username tidak tersedia']);
    exit();
}


// Baca input JSON
$input = json_decode(file_get_contents('php://input'), true);

$chat = isset($input['chat']) ? trim($input['chat']) : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$topik = "Lingkungan"; // Topik tetap
$id_topik = 4; // ID tetap untuk topik ini

if (!empty($chat) && !empty($username)) {
    $query = "INSERT INTO forum_chat (id_topik, topik, chat, username) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'isss', $id_topik, $topik, $chat, $username);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Chat berhasil dikirim']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengirim chat']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Chat atau Username kosong']);
}

?>
