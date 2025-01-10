<?php
require_once("database.php");

session_start(); // Memulai sesi

// Inisialisasi variabel $account sebagai null secara default
$account = null;
$photoBase64 = null;
$imageType = null;
$defaultPhoto = "https://cdn.tailgrids.com/2.2/assets/core-components/images/account-dropdowns/image-1.jpg";
// Fungsi untuk membuat token CSRF
function generate_csrf_token() {
    return bin2hex(random_bytes(32));
}
// Periksa apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    try {
        // Query ke database untuk mendapatkan detail pengguna
        $query = "SELECT id, username, email, role, photo FROM users WHERE username = :username";
        $stmt = $db->prepare($query); // Menggunakan PDO
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        
        $stmt->execute();

        // Jika data pengguna ditemukan, simpan ke $account
        if ($stmt->rowCount() > 0) {
            $account = $stmt->fetch(PDO::FETCH_ASSOC);
            $photoData = $account['photo']; // Data gambar dari kolom BLOB

            if ($photoData) {
                // Identifikasi tipe gambar
                $imageType = "image/jpeg"; // Default ke JPEG
                if (strpos($photoData, "\x89PNG") === 0) {
                    $imageType = "image/png"; // Cek untuk PNG
                }

                // Encode ke Base64
                $photoBase64 = base64_encode($photoData);
            }
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Koneksi ke database
    $koneksi = new mysqli('localhost', 'root', '', 'kp');

    if (isset($_FILES['photo'])) {
        
        $tmpName = $_FILES['photo']['tmp_name'];
        $imageType = $_FILES['photo']['type'];
    
        $validImage = ['image/jpg', 'image/jpeg', 'image/png'];
    
        // Validasi format file
        if (in_array($imageType, $validImage)) {
            if (is_uploaded_file($tmpName)) {
                $imageData = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
    
                $query = "UPDATE USERS SET photo='$imageData' WHERE username = '$username'";
    
                if (mysqli_query($koneksi, $query)) {
                    echo "
                    <script>
                        alert('Data berhasil ditambahkan!');
                    </script>";
                } else {
                    echo "<script>alert('Gagal menambahkan data: " . mysqli_error($koneksi) . "');</script>";
                }
            } else {
                echo "<script>alert('Format gambar harus jpg, jpeg, atau png!')</script>";
            }
        }
        $koneksi -> close();    
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
                        <?php if ($photoBase64): ?>
                            <!-- Tampilkan gambar pengguna jika sudah diunggah -->
                            <img src="data:<?php echo $imageType; ?>;base64,<?php echo $photoBase64; ?>" 
                                alt="User Avatar" 
                                class="w-8 h-8 rounded-full">
                        <?php else: ?>
                            <!-- Tampilkan gambar default jika pengguna belum mengunggah foto -->
                            <img src="<?php echo $defaultPhoto; ?>" 
                                alt="Default Avatar" 
                                class="w-8 h-8 rounded-full">
                        <?php endif; ?>
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
<div class="flex flex-row min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-100 p-6 shadow-md">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Account Settings</h2>
        <ul class="space-y-4">
            <!-- Menu Items -->
            <li>
                <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                    <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                </svg>
                <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                </a>
            </li>
            <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                  <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                  <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Change Password</span>
            </a>
         </li>
            <li>
                <a href="/SAMBATRAKYAT/logout.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Log out</span>
                </a>
            </li>
            <li>
            <!-- Wrapper untuk Alpine.js -->
    <div x-data="{ open: false }">

                <!-- Button untuk membuka modal -->
            <button 
                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                @click="open = true">
                <!-- Ikon -->
                <svg 
                    class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" 
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 448 512" 
                    aria-hidden="true">
                    <path 
                        fill="currentColor" 
                        d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z">
                    </path>
                </svg>
                <!-- Teks -->
                <span class="flex-1 ms-3 whitespace-nowrap">Delete Account</span>
            </button>

<!-- Modal -->
<div 
    x-show="open" 
    @click.away="open = false" 
    @keydown.escape.window="open = false" 
    class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50">
    
    <div 
        class="relative bg-white rounded-lg shadow dark:bg-gray-700 w-full max-w-md">
        <!-- Tombol close -->
        <button 
            @click="open = false" 
            type="button" 
            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
        <!-- Konten Modal -->
        <div class="p-4 md:p-5 text-center">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this account?</h3>
            <a href="/SAMBATRAKYAT/delete_account.php">
            <button 
                @click="open = false" 
                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Yes, I'm sure
            </button>
            </a>
            <button 
                @click="open = false" 
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                No, cancel
            </button>
        </div>
    </div>
</div>
</div>

            </li>
        </ul>
    </aside>


    <!-- Main Content -->
    <section class="flex-1 dashboard-container bg-white rounded-lg shadow-md p-6">
        <div class="dashboard-header bg-[#3E7D60] text-white p-4 rounded-t mb-6 text-center flex flex-col items-center justify-center">
            <h1 class="text-2xl font-semibold">Welcome, <span class="text-uppercase"><?= htmlspecialchars($account['username'], ENT_QUOTES, 'UTF-8'); ?></span>!</h1>
            <h2 class="text-lg font-light">Your Profile</h2>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="flex-1">
                <div class="flex flex-col items-center space-y-4 w-3/5 mx-auto">
                    <div class="rounded-full overflow-hidden border border-grey-300 w-40 h-40">
                    <div class="rounded-full overflow-hidden border border-grey-300 w-40 h-40">
                    <?php if ($photoBase64): ?>
                            <!-- Tampilkan gambar pengguna jika sudah diunggah -->
                            <img src="data:<?php echo $imageType; ?>;base64,<?php echo $photoBase64; ?>" 
                                alt="User Avatar"> 
                              
                        <?php else: ?>
                            <!-- Tampilkan gambar default jika pengguna belum mengunggah foto -->
                            <img src="<?php echo $defaultPhoto; ?>" 
                                alt="Default Avatar"
                                class="w-full h-full"> 
                            
                        <?php endif; ?>
                    </div>
                    </div>
                    <input type="file" id="photo" name="photo" class="px-4 py-2 border border-gray-300 rounded-lg mt-4 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Upload Photo</button>
                </div>
            </div>
        </form>
              <!-- Header -->
              <div>
                <h2 class="text-xl font-semibold text-gray-900">Personal Info</h2>
          
            <!-- Profile Form -->
            <div class="flex-1">
                <form action="/SAMBATRAKYAT/update" method="POST" class="flex flex-col space-y-6 w-full">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                    <!-- Username -->
                    <div class="flex items-center space-x-4">
                        <label for="username" class="w-64 text-gray-700 font-medium">Username:</label>
                        <input type="text" id="username" name="new_username" value="<?= htmlspecialchars($account['username'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Enter a new username" class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>
                    <!-- Email -->
                    <div class="flex items-center space-x-4">
                        <label for="email" class="w-64 text-gray-700 font-medium">Email:</label>
                        <input type="email" id="email" name="new_email" value="<?= htmlspecialchars($account['email'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Enter a new email" class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>

                    <h2 class="text-xl font-semibold text-gray-900">Change Password</h2>
                    <!-- Current Password -->
                    <div class="flex items-center space-x-4">
                        <label for="current-password" class="w-64 text-gray-700 font-medium">Current Password:</label>
                        <input type="password" id="current-password" name="current_password" placeholder="Enter current password" required class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>
                    <!-- New Password -->
                    <div class="flex items-center space-x-4">
                        <label for="new-password" class="w-64 text-gray-700 font-medium">New Password:</label>
                        <input type="password" id="new-password" name="new_password" placeholder="Enter new password" class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>
                    <!-- Confirm New Password -->
                    <div class="flex items-center space-x-4">
                        <label for="retype-password" class="w-64 text-gray-700 font-medium">Confirm Password:</label>
                        <input type="password" id="retype-password" name="confirm_password" placeholder="Re-enter new password" class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600 transition duration-300">Save Changes</button>
                </form>
            </div>
        </div>
        </div>
    </section>
</div>

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