<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instansi</title>
    <link rel="shortcut icon" href="images/samblog.svg">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- jQuery --> 
    <script src="js/jquery.min.js"></script> 
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css"> 
    <link rel="stylesheet" href="css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- NAVBAR -->
    <?php
    // if(isset($_GET['status'])) {
    ?>
    <script type="text/javascript">
        $("#successmodalclear").modal();
    </script>
<?php
    
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

    <!-- Navigation Links Section -->
    <div class="hidden md:flex items-center space-x-8 text-center">
        <a href="index" class="<?= isActive('index.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Home</a>
        <a href="lapor" class="<?= isActive('lapor.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Sambat</a>
        <a href="lihat" class="<?= isActive('lihat.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Lihat Pengaduan</a>
        <a href="cara" class="<?= isActive('cara.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Profil Dinas</a>
        <a href="faq" class="<?= isActive('faq.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Tentang</a>
    </div>

    <!-- User Authentication Buttons Section -->
    <div class="flex items-center space-x-6">
        <?php
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
        ?>

        <?php if ($username): ?>
            <a href="/SAMBATRAKYAT/profile.php">
                <button class="border-0 rounded-md font-semibold px-6 py-3 text-white bg-[#3E7D60] hover:bg-[#5C8D73] transition duration-300 transform hover:scale-105">
                    <?= htmlspecialchars($username) ?>
                </button>
            </a>
        <?php else: ?>
            <a href="/SAMBATRAKYAT/login.php">
                <button class="border-0 rounded-md font-semibold px-6 py-3 text-primary bg-white hover:bg-[#f0f0f0] hover:underline transition duration-300 transform hover:scale-105">Masuk</button>
            </a>
            <a href="/SAMBATRAKYAT/signin.php">
                <button class="border-0 rounded-md font-semibold px-6 py-3 text-white bg-[#3E7D60] hover:bg-[#5C8D73] transition duration-300 transform hover:scale-105">Daftar</button>
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Mobile Menu Toggle Button -->
<div class="md:hidden flex items-center space-x-4">
    <button class="text-gray-800 p-2 rounded-md hover:text-[#3E7D60] focus:outline-none">
        <i class="fas fa-bars"></i>
    </button>
</div>

<!-- end navbar -->
<!-- answer report page -->
<div  style="background-image: url('../images/backsginin.png');" class="h-[40vh] w-auto bg-cover bg-center bg-no-repeat p-10 mb-[350px]">
    <!-- Bagian Pertanyaan -->
    <div class="bg-white shadow-lg rounded-lg p-6 m-auto w-5/6 z-50 pt-10">
        <div class="flex items-center gap-4 mb-4 ml-10">
            <img src="https://via.placeholder.com/50" alt="Profile" class="w-20 h-20 rounded-full">
            <div>
                <div class="flex items-center justify-between ml-10">
                    <div>
                        <h3 class="font-bold text-green-700 text-xl">Dimas Kendika Fazrulfalah</h3>
                        <p class="text-sm text-gray-500">02 January 2025, 09:43:09</p>
                        <p class="text-gray-700 text-lg ml-auto">Ini gmn ya daftarnya</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Tanggapan -->
    <div class="bg-white shadow-lg rounded-lg p-6 m-auto w-5/6 mt-2">
        <h4 class="font-bold text-gray-700 text-lg mb-3">Tanggapan Anda</h4>
        <textarea 
            class="w-full p-4 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500" 
            rows="5" 
            placeholder="Tulis tanggapan Anda di sini..."
        ></textarea>
        <div class="flex justify-end mt-4">
            <button class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition duration-300">
                Kirim
            </button>
        </div>
    </div>
</div>
        </div>
   <!-- Footer -->
   <footer class="text-center flex justify-around w-full bg-[#343a40] text-white py-5">
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
<!-- /copyright -->