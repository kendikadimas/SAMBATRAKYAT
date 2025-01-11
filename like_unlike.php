<?php
require 'database.php'; // Ganti dengan file koneksi database Anda

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $laporan_id = $_POST['laporan_id']; // Ambil ID laporan
    $action = $_POST['action']; // Ambil aksi (like atau unlike)

    // Validasi ID laporan
    if (!is_numeric($laporan_id)) {
        echo json_encode(['status' => 'error', 'message' => 'ID laporan tidak valid']);
        exit;
    }

    try {
        // Pastikan laporan ada di database
        $stmt = $db->prepare("SELECT * FROM laporan WHERE id = ?");
        $stmt->execute([$laporan_id]);
        $laporan = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$laporan) {
            echo json_encode(['status' => 'error', 'message' => 'Laporan tidak ditemukan']);
            exit;
        }

        // Proses aksi
        if ($action === 'like') {
            $update = $db->prepare("UPDATE laporan SET likes = likes + 1 WHERE id = ?");
            $update->execute([$laporan_id]);
            $newCount = $laporan['likes'] + 1;
            echo json_encode(['status' => 'success', 'likes' => $newCount, 'unlikes' => $laporan['unlikes']]);
        } elseif ($action === 'unlike') {
            $update = $db->prepare("UPDATE laporan SET unlikes = unlikes + 1 WHERE id = ?");
            $update->execute([$laporan_id]);
            $newCount = $laporan['unlikes'] + 1;
            echo json_encode(['status' => 'success', 'likes' => $laporan['likes'], 'unlikes' => $newCount]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }
}
