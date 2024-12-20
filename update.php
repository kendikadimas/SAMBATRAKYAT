<?php
require_once("private/database.php");
session_start();

// Validasi CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token.");
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

try {
    // Ambil data dari form
    $new_username = trim($_POST['new_username']);
    $new_email = trim($_POST['new_email']);
    $new_password = $_POST['new_password'];
    $current_password = $_POST['current_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (empty($current_password)) {
        throw new Exception("Current password is required.");
    }

    // Periksa kata sandi saat ini
    $query = "SELECT password FROM users WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($current_password, $user['password'])) {
        throw new Exception("Current password is incorrect.");
    }

    // Update username dan email
    $update_query = "UPDATE users SET username = :new_username, email = :new_email WHERE username = :username";
    $stmt = $db->prepare($update_query);
    $stmt->bindValue(':new_username', $new_username, PDO::PARAM_STR);
    $stmt->bindValue(':new_email', $new_email, PDO::PARAM_STR);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Update password jika ada
    if (!empty($new_password)) {
        if ($new_password !== $confirm_password) {
            throw new Exception("New password and confirm password do not match.");
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $password_query = "UPDATE users SET password = :new_password WHERE username = :username";
        $stmt = $db->prepare($password_query);
        $stmt->bindValue(':new_password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindValue(':username', $new_username, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Update sesi username jika berubah
    $_SESSION['username'] = $new_username;

    header("Location: profile.php?status=success");
    exit;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>
