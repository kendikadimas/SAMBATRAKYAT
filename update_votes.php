<?php
require 'koneksi.php'; // Pastikan file koneksi database diimpor

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $laporan_id = $_POST['laporan_id'];
    $action = $_POST['action'];

    if ($laporan_id && ($action === 'upvote' || $action === 'downvote')) {
        // Ambil data laporan saat ini
        $query = $db->prepare("SELECT upvotes, downvotes FROM laporan WHERE id = ?");
        $query->execute([$laporan_id]);
        $laporan = $query->fetch(PDO::FETCH_ASSOC);

        if ($laporan) {
            // Perbarui upvote atau downvote
            if ($action === 'upvote') {
                $upvotes = $laporan['upvotes'] + 1;
                $query = $db->prepare("UPDATE laporan SET upvotes = ? WHERE id = ?");
                $query->execute([$upvotes, $laporan_id]);
            } elseif ($action === 'downvote') {
                $downvotes = $laporan['downvotes'] + 1;
                $query = $db->prepare("UPDATE laporan SET downvotes = ? WHERE id = ?");
                $query->execute([$downvotes, $laporan_id]);
            }

            // Kirim respons JSON
            echo json_encode([
                'success' => true,
                'upvotes' => $upvotes ?? $laporan['upvotes'],
                'downvotes' => $downvotes ?? $laporan['downvotes']
            ]);
            exit;
        }
    }
}

// Jika gagal
echo json_encode(['success' => false]);
?>
