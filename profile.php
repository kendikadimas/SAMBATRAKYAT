<?php
require_once("private/database.php");

session_start(); // Memulai sesi

// Inisialisasi variabel $account sebagai null secara default
$account = null;

// Periksa apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    try {
        // Query ke database untuk mendapatkan detail pengguna
        $query = "SELECT id, username, email, role FROM users WHERE username = :username";
        $stmt = $db->prepare($query); // Menggunakan PDO
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Jika data pengguna ditemukan, simpan ke $account
        if ($stmt->rowCount() > 0) {
            $account = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        // Menangani kesalahan koneksi atau query
        echo "Database error: " . $e->getMessage();
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Sambat Rakyat</title>
    <link rel="shortcut icon" href="images/samblog.svg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/stylehome.css" rel="stylesheet">
    <link href="css/profil.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="js/bootstrap.js"></script>
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css">
    <title>profile</title>
</head>
<body>
<div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.11';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <!--Success Modal Saved-->
    <div class="modal fade" id="successmodalclear" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm " role="document">
            <div class="modal-content bg-2">
                <div class="modal-header ">
                    <h4 class="modal-title text-center text-green">Sukses</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">Pengaduan Berhasil Di Kirim</p>
                    <p class="text-center">Untuk Mengetahui Status Pengaduan</p>
                    <p class="text-center">Silahkan Buka Menu <a href="lihat">Lihat Pengaduan</a> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn button-green" onclick="location.href='index';" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($_GET['status'])) {
    ?>
    <script type="text/javascript">
        $("#successmodalclear").modal();
    </script>
    <?php
        }
    ?>
    <!-- body -->
    <div class="shadow">
        <!-- navbar -->
        <div class="navbar">
            <div class="main-logo">
                <a href="/">
                    <img src="images/samblog.svg" alt="Logo Sambat" class="main-logo">
                </a>
                <div class="sub-tem">
                    <h1>Sambat rakyat</h1>
                </div>
            </div>

            <div class="menu">
                <a href="index" target="_top">HOME</a>
                <a href="lapor" target="_top">SAMBAT</a>
                <a href="lihat" target="_top">LIHAT PENGADUAN</a>
                <a href="cara" target="_top">PROFIL DINAS</a>
                <a href="faq" target="_top">TENTANG</a>
            </div>

        <?php
        

        // Check if the user is logged in by checking if 'username' is stored in the session
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        } else {
            $username = null;
        }
        ?>

        <?php if ($username) : ?> 
            <div class="logsig">
                <a href="/SAMBATRAKYAT/profile.php">
                    <button class="login-new-btn">
                        <?= htmlspecialchars($username) ?>
                    </button>
                </a>
            </div>
        <?php else: ?>

            <div class="logsig">
                <a href="/SAMBATRAKYAT/login.php">
                    <button class="login-btn">Masuk</button>
                </a>
                <a href="/SAMBATRAKYAT/signin.php">
                    <button class="signup-btn">Daftar</button>
                </a>
            </div>
        <?php endif;?>

        </div>
        <!-- end navbar -->

        <section class="dashboard-container">
    <div class="dashboard-header">
        <h1>Welcome, <span><?= htmlspecialchars($account['role'], ENT_QUOTES, 'UTF-8'); ?></span>!</h1>
        <h2>Your Profile</h2>
    </div>

    <div class="profile-section">
        <form action="/dashboard/update" method="POST" class="profile-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="new-username" 
                    value="<?= htmlspecialchars($account['username'], ENT_QUOTES, 'UTF-8'); ?>" 
                    placeholder="Enter a new username">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="new-email" 
                    value="<?= htmlspecialchars($account['email'], ENT_QUOTES, 'UTF-8'); ?>" 
                    placeholder="Enter a new email">
            </div>

            <div class="form-group">
                <label for="new-password">New Password:</label>
                <input type="password" id="new-password" name="new-password" placeholder="Enter new password">
            </div>

            <div class="form-group">
                <label for="current-password">Current Password:</label>
                <input type="password" id="current-password" name="current-password" 
                    placeholder="Enter current password" required>
            </div>

            <div class="form-group">
                <label for="retype-password">Confirm New Password:</label>
                <input type="password" id="retype-password" name="confirm-password" 
                    placeholder="Re-enter new password" required>
            </div>

            <button type="submit" class="btn-save-profile">Save Changes</button>
        </form>
    </div>

    <div class="action-buttons">
        <a href="/SAMBATRAKYAT/logout" class="btn-logout">Log Out</a>

        <form action="/account/delete" method="POST" class="delete-account-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($account['id'], ENT_QUOTES, 'UTF-8'); ?>">
            <button type="submit" class="btn-delete-account">Delete Account</button>
        </form>
    </div>
</section>












        
       <!-- Footer -->
       <footer class="footer text-center">
            <div class="row">
                <div class="col-md-4 mb-5 mb-lg-0">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-map-marker"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Kantor</h4>
                        </li>
                    </ul>
                    <p class="mb-0">
                        Jl. Kabupaten No. 1 Purwokerto
                        <br>Banyumas, Jawa Tengah
                    </p>
                </div>
                <div class="col-md-4 mb-5 mb-lg-0">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-rss"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Sosial Media</h4>
                        </li>
                    </ul>
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://www.facebook.com/dispendukcapilbkl/">
                                <i class="fa fa-fw fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://twitter.com/disdukcapilbkl">
                                <i class="fa fa-fw fa-twitter"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-envelope-o"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Kontak</h4>
                        </li>
                    </ul>
                    <p class="mb-0">
                        +62 858-1417-4267 <br>
                        https://www.banyumaskab.go.id/ <br>
                        banyumaspemkab@gmail.com
                    </p>
                </div>
            </div>
        </footer>
        <!-- /footer -->

    <div class="copyright" style="background-color: black">
        <p style="text-align: center; color: white">v-1.0 | Copyright &copy; Pemerintahan Kabupaten Banyumas</p>
    </div>
    <!-- shadow -->
</body>
</html>