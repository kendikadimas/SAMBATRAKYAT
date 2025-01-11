<?php
require '../koneksi.php'; // Pastikan koneksi database Anda sudah diatur di file ini

// Ambil input JSON dan decode
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['id'])) {
    $id = intval($data['id']); // Pastikan ID diterima dengan benar sebagai integer

    // Query untuk memperbarui status
    $query = "UPDATE laporan SET status = 'Terposting' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            "success" => true,
            "message" => "Status berhasil diperbarui menjadi Terposting."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Gagal memperbarui status. Silakan coba lagi."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "ID tidak ditemukan."
    ]);
}
?>
