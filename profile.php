<?php
require_once("database.php");

session_start(); // Memulai sesi

// Inisialisasi variabel $account sebagai null secara default
$account = null;

// Fungsi untuk membuat token CSRF
function generate_csrf_token() {
    return bin2hex(random_bytes(32));
}

// Jika token CSRF belum ada, buat token baru dan simpan di sesi
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generate_csrf_token();
}

// Token CSRF dari sesi
$csrf_token = $_SESSION['csrf_token'];

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

// Fungsi untuk memvalidasi token CSRF
function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Jika metode POST digunakan, validasi token CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        echo "Invalid CSRF token.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sambat Rakyat</title>
    <link rel="shortcut icon" href="images/samblog.svg">
    <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- <link href="css/style.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link href="css/stylehome.css" rel="stylesheet"> -->
    <!-- <link href="css/profil.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/animate.min.css"> 
    <title>Profile</title> -->
    <script src="https://unpkg.com/alpinejs" defer></script>

</head>
<body>
<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.11';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
 <!-- NAVBAR -->
 <?php
        if(isset($_GET['status'])) {
    ?>
        <script type="text/javascript">
            $("#successmodalclear").modal();
        </script>
    <?php
        }
    ?>
    <?php
        function isActive($page) {
            return basename($_SERVER['PHP_SELF']) == $page ? 'text-[#3E7D60] font-semibold' : 'text-gray-800 m-2';
        }
    ?>

    <div class="w-full bg-white shadow-lg p-5 flex justify-between items-center z-[100]">
        <!-- Logo and Title Section -->
        <div class="flex items-center ml-14">
            <a href="/">
                <img src="images/samblog.svg" alt="Logo Sambat" class="h-[3vw] transition duration-300 transform hover:scale-110">
            </a>
            <div class="text-2xl font-bold ml-3">
                <h1 class="text-[#3E7D60] hover:text-[#2C6B50] transition-colors duration-300">Sambat Rakyat</h1>
            </div>
        </div>

        <div class="hidden md:flex items-center space-x-8 text-center">
            <a href="index" class="<?= isActive('index.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Home</a>
            <a href="lapor" class="<?= isActive('lapor.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Sambat</a>
            <a href="lihat" class="<?= isActive('lihat.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Lihat Pengaduan</a>
            <a href="community" class="<?= isActive('community.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Komunitas</a>
            <a href="faq" class="<?= isActive('faq.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Tentang</a>
        </div>
           <?php $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
            $email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
            ?>
            <!-- User Authentication Section -->
            <div class="flex items-center space-x-6">
                <?php if ($username): ?>
                    <!-- Account Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-[#3E7D60] font-semibold transition">
                            <img src="https://cdn.tailgrids.com/2.2/assets/core-components/images/account-dropdowns/image-1.jpg" alt="Avatar" class="w-8 h-8 rounded-full">
                            <span><?php echo htmlspecialchars($username); ?></span>
                            <svg class="w-5 h-5 transform" :class="open ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20">
                            <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                <p class="font-semibold"><?php echo htmlspecialchars($username); ?></p>
                                <p class="text-gray-500"><?php echo htmlspecialchars($email); ?></p>
                            </div>
                            <a href="/SAMBATRAKYAT/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">Lihat Profil</a>
                            <a href="/SAMBATRAKYAT/logout.php" class="block px-4 py-2 text-sm text-red-500 hover:bg-gray-100 transition">Log Out</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Login and Register Buttons -->
                    <a href="/SAMBATRAKYAT/login.php">
                        <button class="rounded-md font-semibold px-6 py-2 text-primary bg-white border hover:bg-gray-100 hover:underline transition">Masuk</button>
                    </a>
                    <a href="/SAMBATRAKYAT/signin.php">
                        <button class="rounded-md font-semibold px-6 py-2 text-white bg-[#3E7D60] hover:bg-[#5C8D73] transition">Daftar</button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


    <section class="dashboard-container bg-white rounded-lg shadow-md p-6">
        <div class="dashboard-header bg-[#3E7D60] text-white p-4 rounded-t mb-6 text-center flex flex-col items-center justify-center">
            <h1 class="text-2xl font-semibold">Welcome, <span class="text-uppercase"><?= htmlspecialchars($account['role'], ENT_QUOTES, 'UTF-8'); ?></span>!</h1>
            <h2 class="text-lg font-light">Your Profile</h2>
        </div>
        <div class="px-6 py-4 flex space-x-6">
            <div class="flex-1">
                <!-- Profile Photo Update -->
                <div class="flex flex-col items-center space-y-4 w-3/5 mx-auto">
                    <div class="rounded-full overflow-hidden border border-grey-300 w-40 h-40">
                        <img src="<?= $account['photo'] ? 'uploads/' . $account['photo'] : 'images/default-profile.png' ?>" alt="Profile Photo" class="w-full h-full object-cover">
                    </div>
                    <input type="file" id="profile-photo" name="profile_photo" class="px-4 py-2 border border-gray-300 rounded-lg mt-4 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <button type="button" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Upload Photo</button>
                </div>
            </div>
            <div class="flex-1 ">
                <!-- Profile Form -->
                    <form action="/SAMBATRAKYAT/update" method="POST" class="flex flex-col space-y-6 w-full">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                        
                        <!-- Username -->
                        <div class="flex items-center space-x-4">
                            <label for="username" class="w-1/3 text-gray-700 font-medium">Username:</label>
                            <input type="text" id="username" name="new_username" value="<?= htmlspecialchars($account['username'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Enter a new username" class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        </div>
                        
                        <!-- Email -->
                        <div class="flex items-center space-x-4">
                            <label for="email" class="w-1/3 text-gray-700 font-medium">Email:</label>
                            <input type="email" id="email" name="new_email" value="<?= htmlspecialchars($account['email'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Enter a new email" class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        </div>
                        
                        <!-- New Password -->
                        <div class="flex items-center space-x-4">
                            <label for="new-password" class="w-1/3 text-gray-700 font-medium">New Password:</label>
                            <input type="password" id="new-password" name="new_password" placeholder="Enter new password" class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        </div>
                        
                        <!-- Current Password -->
                        <div class="flex items-center space-x-4">
                            <label for="current-password" class="w-1/3 text-gray-700 font-medium">Current Password:</label>
                            <input type="password" id="current-password" name="current_password" placeholder="Enter current password" required class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        </div>
                        
                        <!-- Confirm New Password -->
                        <div class="flex items-center space-x-4">
                            <label for="retype-password" class="w-1/3 text-gray-700 font-medium">Confirm Password:</label>
                            <input type="password" id="retype-password" name="confirm_password" placeholder="Re-enter new password" class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-3 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600 transition duration-300">Save Changes</button>
                    </form>
                </div>
            </div>
            <div class="flex justify-between space-x-4 my-4">
                <a href="/SAMBATRAKYAT/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">Log Out</a>
                <a href="/SAMBATRAKYAT/delete_account.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-300">Delete Account</a>
            </div>
        </div>
    </section>


        <!-- Footer -->
        <footer class="text-center flex justify-around w-full bg-[#343a40] text-white py-5 ">
                <div class="relative min-h-[1px] px-[15px] float-left w-1/3">
                    <ul class="pl-0 list-none ">
                        <li class="pl-0 list-none ">
                            <i class="fa fa-top fa-map-marker"></i>
                        </li>
                        <li class="pl-0 list-none ">
                            <h4 class="text-[1.2em] mb-[10px]">Kantor</h4>
                        </li>
                    </ul>
                    <p class="text-[0.9em]">
                        Jl. Kabupaten No. 1 Purwokerto
                        <br>Banyumas, Jawa Tengah
                    </p>
                </div>

                <div class="relative min-h-[1px] px-[15px] float-left w-1/3">
                    <ul class="list-none p-0 mb-0">
                        <li class="pl-0 list-none">
                            <i class="fa fa-top fa-rss"></i>
                        </li>
                        <li class="pl-0 list-none">
                            <h4 class="text-[1.2em] mb-[10px]">Sosial Media</h4>
                        </li>
                    </ul>
                    <ul class="list-none flex text-center justify-center p-0 mb-0">
                        <li class="pl-0 list-none">
                            <a class="text-white border border-white mx-0 my-[5px] transition-all duration-300 ease-in-out hover:bg-[#3E7D60] hover:border-[#3E7D60] text-center rounded-circle p-1" href="https://www.facebook.com/betterbanyumas/?ref=embed_page">
                                <i class="fa fa-fw fa-facebook"></i>
                            </a>
                        </li>
                        <li class="pl-0 list-none">
                            <a class="text-white border border-white mx-0 my-[5px] transition-all duration-300 ease-in-out hover:bg-[#3E7D60] hover:border-[#3E7D60] text-center rounded-circle p-1 ml-5" href="https://twitter.com/bmshumas?lang=en">
                                <i class="fa fa-fw fa-twitter"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="relative min-h-[1px] px-[15px] float-left w-1/3">
                    <ul class="pl-0 list-none ">
                        <li class="pl-0 list-none ">
                            <i class="fa fa-top fa-envelope-o"></i>
                        </li>
                        <li class="pl-0 list-none ">
                            <h4 class="text-[1.2em] mb-[10px]">Kontak</h4>
                        </li>
                    </ul>
                    <p class="text-[0.9em]">
                        +62 858-1417-4267 <br>
                        https://www.banyumaskab.go.id/ <br>
                        banyumaspemkab@gmail.com
                    </p>
                </div>
        </footer>
        <!-- /footer -->

    <div class="copyright bg-black">
        <p style="text-align: center; color: white">Copyright &copy; Pemerintahan Kabupaten Banyumas</p>
    </div>
</div>
</body>
</html>