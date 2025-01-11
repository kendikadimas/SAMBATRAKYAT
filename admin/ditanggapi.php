<?php
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $laporan_id = $_POST['laporan_id'];
    $nama = $_POST['nama'];
    $isi = $_POST['isi'];
    $tanggal = date('Y-m-d H:i:s');

    // Validasi input
    if (!empty($laporan_id) && !empty($isi)) {
        // Simpan tanggapan ke tabel `komen`
        $query_tanggapan = $conn->prepare("INSERT INTO komen (laporan_id, nama, isi, tanggal) VALUES (?, ?, ?, ?)");
        $query_tanggapan->bind_param("isss", $laporan_id, $nama, $isi, $tanggal);

        if ($query_tanggapan->execute()) {
            // Perbarui status di tabel `laporan`
            $query_update_status = $conn->prepare("UPDATE laporan SET status = 'Ditanggapi' WHERE id = ?");
            $query_update_status->bind_param("i", $laporan_id);

            if ($query_update_status->execute()) {
                // Redirect dengan pesan sukses
                header("Location: list_sambat.php?success=Tanggapan berhasil dikirim!");
                exit;
            } else {
                echo "Error saat mengubah status laporan: " . $conn->error;
            }
        } else {
            echo "Error saat menyimpan tanggapan: " . $conn->error;
        }
    } else {
        echo "Isi tanggapan tidak boleh kosong.";
    }
}
?>
