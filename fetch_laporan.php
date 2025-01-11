<?php
require 'koneksi.php';

try {
    // Ambil semua laporan dengan urutan berdasarkan jumlah like
    $statement = $db->query("SELECT * FROM `laporan` ORDER BY likes DESC, id DESC");
    $laporan = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'laporan' => $laporan]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
}
