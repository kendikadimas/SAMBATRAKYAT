<?php
// Sertakan file koneksi
require 'koneksi.php'; // Pastikan path file ini benar

// Cek apakah data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $laporan_id = $_POST['laporan_id'];
    $nama = $conn->real_escape_string($_POST['nama']); // Escaping input untuk keamanan
    $tanggapan = $conn->real_escape_string($_POST['isi']); // Escaping input untuk keamanan

    try {
        // Query untuk menyimpan tanggapan
        $sql = "INSERT INTO komen (laporan_id, nama, isi) VALUES ('$laporan_id', '$nama', '$tanggapan')";
        
        // Eksekusi query
        if ($conn->query($sql) === TRUE) {
            // Redirect kembali ke halaman index
            header("Location: index.php");
            exit;
        } else {
            // Jika gagal, lempar error
            throw new Exception("Error saat menyimpan tanggapan: " . $conn->error);
        }
    } catch (Exception $e) {
        // Tangani error
        die("Error: " . $e->getMessage());
    }
}
?>
