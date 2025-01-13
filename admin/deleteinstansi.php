<?php

include "../koneksi.php";
        if (isset($_POST['Hapus'])) {
            $id = $_POST['id'];
        
            if (!empty($id)) {
                // Hapus data berdasarkan ID
                $deleteInstansi = $conn->prepare("DELETE FROM instansi WHERE id = ?");
                $deleteInstansi->bind_param("i", $id);
                
                if ($deleteInstansi->execute()) {
                    echo "<script>alert('Data berhasil dihapus!');</script>";
                } else {
                    echo "<script>alert('Gagal menghapus data.');</script>";
                }
            } else {
                echo "<script>alert('ID tidak valid.');</script>";
            }}

            ?>
