<?php
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $laporan_id = $_POST['laporan_id'];
    $nama = $_POST['nama'];
    $isi = $_POST['isi'];
    $tanggal = date('Y-m-d H:i:s');

    if (!empty($laporan_id) && !empty($isi)) {
        $query = $conn->prepare("INSERT INTO komen (laporan_id, nama, isi, tanggal) VALUES (?, ?, ?, ?)");
        $query->execute([$laporan_id, $nama, $isi, $tanggal]);

        header("Location: instansi.php?id=$laporan_id&status=success");
        exit;
    } else {
        echo "Isi tanggapan tidak boleh kosong.";
    }
}
?>
