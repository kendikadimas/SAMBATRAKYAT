<?php
require 'koneksi.php';

$password = password_hash('admin123', PASSWORD_BCRYPT);
$query = "INSERT INTO users (username, email, password, role) VALUES ('admin', 'admin@gmail.com', '$password', 'admin')";

if (mysqli_query($conn, $query)) {
    echo "Admin berhasil ditambahkan.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
