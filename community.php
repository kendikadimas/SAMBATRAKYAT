<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komunitas</title>
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

<!-- hero -->
        <section style="background-image: url('images/backsginin.png');" class="h-[50vh] w-screen bg-cover bg-center bg-no-repeat">
            <div class="w-1/2 m-auto ">
                <h1 class="text-white text-[45px] font-bold p-10">Pojok Komunitas</h1>
                <p class="text-white text-[20px] font-medium px-10">Disini anda bisa anuan</p>
            </div>
        </section>
        <section class="h-[50vh] w-screen bg-cover bg-center bg-no-repeat bg-gray-100">
    <h1 class="text-3xl font-bold p-10 text-center text-gray-800">Forum Populer</h1>
    <div class="flex flex-wrap justify-center w-full">
        <!-- Card 1 -->
        <div class="w-full md:w-1/3 p-6">
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-300 hover:border-green-600 transition-all duration-300">
                <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">
                        Pajak 12% dan Isu Terbaru
                    </h3>
                    <p class="text-gray-600">
                        Bergabunglah untuk berdiskusi mengenai topik ini dan berbagi pendapat.
                    </p>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-white bg-green-600 px-6 py-2 rounded-3xl hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="w-full md:w-1/3 p-6">
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-300 hover:border-green-600 transition-all duration-300">
                <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">
                        Dampak Kebijakan Pajak
                    </h3>
                    <p class="text-gray-600">
                        Mari berdiskusi tentang kebijakan pajak terbaru dan dampaknya pada masyarakat.
                    </p>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-white bg-green-600 px-6 py-2 rounded-3xl hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="w-full md:w-1/3 p-6">
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-300 hover:border-green-600 transition-all duration-300">
                <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">
                        Isu Ekonomi Terkini
                    </h3>
                    <p class="text-gray-600">
                        Diskusikan berbagai isu ekonomi terkini dan solusinya bersama komunitas.
                    </p>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-white bg-green-600 px-6 py-2 rounded-3xl hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



</body>
</html>