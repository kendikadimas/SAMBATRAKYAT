<?php
require 'koneksi.php';

$query = "SELECT * FROM forum_chat WHERE id_topik = 1 ORDER BY waktu ASC";
$result = mysqli_query($conn, $query);

$chats = [];
while ($row = mysqli_fetch_assoc($result)) {
    $chats[] = $row;
}

echo json_encode($chats);
?>
