<?php
// Konfigurasi koneksi database
$host = 'localhost'; // Ganti dengan host database Anda
$dbname = 'kp'; // Ganti dengan nama database Anda
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda (kosongkan jika tidak ada password)

try {
    // Membuat koneksi ke database menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Mengatur opsi PDO untuk menampilkan error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengatur mode fetch sebagai associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Tangani kesalahan koneksi
    die("Database connection failed: " . $e->getMessage());
}
?>
