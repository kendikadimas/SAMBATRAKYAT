<?php
# @Author: kelompok 4
# @Date:   20 Desember 2024
# @Copyright: (c) Sambat Rakyat Banyumas 2024

session_start();
unset($_SESSION['admin']); // unset admin session
header("Location: /SAMBATRAKYAT/login.php");
?>
