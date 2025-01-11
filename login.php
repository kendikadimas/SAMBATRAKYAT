<?php
session_start();
require 'koneksi.php';

$message = "";

if (isset($_POST["email"]) && isset($_POST["password"])) {
    // Ambil data dari form
    $username = trim($_POST["email"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validasi email, password
    if (!empty($email) && !empty($password)) {
        // Query untuk memeriksa pengguna di database
        $query_sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query_sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            // Login berhasil, set session
            $_SESSION["id"] = $user['id']; // Set ID user
            $_SESSION["username"] = $user['username'];
            $_SESSION["email"] = $user['email'];

            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                $_SESSION["role"] = 'admin';
                header("Location: admin/index.php");
            } elseif ($user['role'] === 'user') {
                $_SESSION["role"] = 'user';
                header("Location: index.php");
            } elseif ($user['role'] === 'instansi') {
                $_SESSION["id_instansi"] = $user['id']; // Tambahan untuk instansi
                $_SESSION["role"] = 'instansi';
                header("Location: admin/list_sambat.php");
            } else {
                $message = "Role tidak valid.";
            }
            exit();
        } else {
            $message = "Email atau Password salah.";
        }
    } else {
        $message = "Semua field wajib diisi.";
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
            <a href="Index.php"><img src="images/pemkab.png" alt="" style="width: 100px; height: 100px;"></a>
            <h1>Sambat Rakyat</h1>
            <p>Membangun Banyumas yang lebih melalui aspirasi dan evaluasi</p>
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
