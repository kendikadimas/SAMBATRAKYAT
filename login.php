<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'koneksi.php';

$message = "";

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (!empty($email) && !empty($password)) {
        // Cek login sebagai user
        $query_user = "SELECT * FROM users WHERE email = ?";
        $stmt_user = mysqli_prepare($conn, $query_user);
        mysqli_stmt_bind_param($stmt_user, "s", $email);
        mysqli_stmt_execute($stmt_user);
        $result_user = mysqli_stmt_get_result($stmt_user);
        $user = mysqli_fetch_assoc($result_user);

        if ($user && password_verify($password, $user['password'])) {
            // Set session untuk user
            $_SESSION["id"] = $user['id'];
            $_SESSION["username"] = $user['username'];
            $_SESSION["email"] = $user['email'];
            $_SESSION["role"] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin/index.php");
                exit();
            } elseif ($user['role'] === 'user') {
                header("Location: index.php");
                exit();
            } else  {
            // Jika user tidak ditemukan, cek login sebagai instansi
            $query_instansi = "SELECT * FROM instansi WHERE email = ?";
            $stmt_instansi = mysqli_prepare($conn, $query_instansi);
            mysqli_stmt_bind_param($stmt_instansi, "s", $email);
            mysqli_stmt_execute($stmt_instansi);
            $result_instansi = mysqli_stmt_get_result($stmt_instansi);
            $instansi = mysqli_fetch_assoc($result_instansi);

            if ($instansi && password_verify($password, $instansi['password'])) {
                // Set session untuk instansi
                $_SESSION["id"] = $instansi['id'];
                $_SESSION["username"] = $instansi['username'];
                $_SESSION["email"] = $instansi['email'];
                $_SESSION["id_divisi"] = $instansi['id_divisi'];
                $_SESSION["role"] = $instansi['role'];

                if ($instansi['role'] === 'instansi') {
                    header("Location: admin/list_sambat.php");
                    exit();
                }
            } else {
                // Jika login gagal di kedua tabel
                $message = "Email atau Password salah.";
            }
        }
    } else {
        $message = "Semua field wajib diisi.";
    }
}

if (!empty($message)) {
    echo "<script>alert('$message');</script>";
}
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login Page</title>
</head>
<body>
<div class="container">
    <div class="right-section">
    <div class="overlay"></div>
        <div class="text-content">
            <a href="Index.php"><img src="images/samblog.svg" alt="" style="width: 100px; height: 100px;"></a>
            <h1>Sambat Rakyat</h1>
            <p>Membangun Indonesia yang lebih melalui aspirasi dan evaluasi</p>
        </div>
    </div>
    <div class="left-section">
        <h1>LOGIN</h1>
        <form action="" method="POST">
            <div class="box-input">
                <input type="text" name="email" placeholder="Email" required>
            </div>
            <div class="box-input">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <!-- <div class="box-input">
                <select name="role" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div> -->
            <button type="submit" class="btn-input">Login</button>
            <div class="bottom">
                <p>Belum punya akun?
                    <a href="signin.php">Daftar disini</a>
                </p>
            </div>
        </form>
        <?php if (!empty($message)): ?>
            <p class="error"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
