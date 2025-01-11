<?php
require 'database.php'; // Pastikan file koneksi database ada

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['laporan_id'])) {
    $laporan_id = intval($_POST['laporan_id']);

    // Tambahkan 1 pada kolom `downvotes` berdasarkan ID laporan
    $stmt = $db->prepare("UPDATE laporan SET downvotes = downvotes + 1 WHERE id = ?");
    if ($stmt->execute([$laporan_id])) {
        // Ambil nilai terbaru untuk selisih upvotes - downvotes
        $query = $db->prepare("SELECT upvotes - downvotes AS selisih FROM laporan WHERE id = ?");
        $query->execute([$laporan_id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'selisih' => $result['selisih']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menambah downvote']);
    }
}
?>
