<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
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
        <a href="community" class="<?= isActive('artikel.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Komunitas</a>
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

<div class="container mx-auto px-4">
    <!-- Hero Section -->
    <section 
        style="background-image: url('images/detart3.jpg');" 
        class="relative h-[100vh] bg-cover w-full bg-center bg-no-repeat flex items-center justify-center">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <!-- Content -->
        <div class="relative text-center text-white px-6 md:px-0">
            <h1 class="text-[40px] md:text-[60px] font-bold leading-tight">
                Pengaduan Masyarakat
            </h1>
            <p class="text-[18px] md:text-[24px] font-medium mt-4">
                Solusi Mudah untuk Menyampaikan Aspirasi dan Keluhan Anda        </p>
        </div>
    </section>



    <!-- Introduction -->
    <section class="bg-white rounded-lg shadow-md p-6 mt-8">
    <h2 class="text-2xl font-semibold text-gray-800">Apa Itu Pengaduan Masyarakat?</h2>
    <p class="mt-4 text-gray-600 text-justify">
        Pengaduan masyarakat merupakan sebuah mekanisme resmi yang disediakan oleh pemerintah maupun pihak swasta untuk 
        memberikan akses kepada masyarakat dalam menyampaikan keluhan, kritik, atau aspirasi mereka terkait berbagai 
        layanan dan kebijakan yang diberikan. Melalui pengaduan masyarakat, individu memiliki kesempatan untuk berperan 
        aktif dalam proses perbaikan pelayanan publik, sehingga tercipta komunikasi yang lebih transparan, efektif, 
        dan akuntabel antara masyarakat dan penyelenggara layanan.
    </p>
    <p class="mt-4 text-gray-600 text-justify">
        Layanan ini tidak hanya mencakup penyampaian keluhan atas layanan yang dirasakan kurang memuaskan, tetapi juga 
        kritik yang bersifat membangun serta masukan yang dapat membantu peningkatan kualitas suatu layanan. Dengan 
        adanya sistem pengaduan ini, diharapkan setiap laporan yang masuk dapat ditindaklanjuti dengan langkah konkret 
        oleh pihak yang bertanggung jawab. Hal ini penting untuk menciptakan lingkungan pelayanan publik yang lebih baik 
        dan responsif terhadap kebutuhan masyarakat.
    </p>
    <p class="mt-4 text-gray-600 text-justify">
        Selain itu, mekanisme pengaduan masyarakat juga berperan dalam meningkatkan kesadaran masyarakat terhadap hak-hak 
        mereka sebagai penerima layanan. Dengan memanfaatkan teknologi modern, sistem pengaduan masyarakat kini hadir dalam 
        berbagai bentuk, mulai dari aplikasi digital hingga layanan berbasis website, yang dirancang untuk mempermudah akses 
        dan mempercepat proses pelaporan. Semua ini dilakukan demi mendukung terciptanya masyarakat yang lebih inklusif 
        dan berkeadilan.
    </p>
</section>


<section class="bg-white rounded-lg shadow-md p-6 mt-6">
    <h2 class="text-2xl font-semibold text-gray-800">Manfaat Layanan Pengaduan</h2>
    <ul class="list-disc list-inside mt-4 text-gray-600 text-justify space-y-4">
        <li>
            <strong>Mempermudah masyarakat dalam menyampaikan keluhan.</strong>  
            Layanan pengaduan masyarakat memberikan akses yang lebih mudah dan terstruktur bagi masyarakat untuk menyampaikan keluhan 
            terkait pelayanan publik. Dengan hadirnya mekanisme ini, masyarakat tidak perlu lagi merasa bingung atau tidak tahu harus 
            melapor ke mana jika menghadapi permasalahan. Baik melalui platform digital maupun konvensional, layanan ini memastikan bahwa 
            semua keluhan dapat diterima secara efektif dan terorganisir.
        </li>
        <li>
            <strong>Meningkatkan transparansi dan akuntabilitas pemerintah.</strong>  
            Salah satu manfaat utama dari layanan pengaduan adalah meningkatkan keterbukaan antara pemerintah dan masyarakat. 
            Dengan adanya sistem ini, setiap laporan yang masuk dapat dipantau dan ditindaklanjuti secara terbuka, sehingga masyarakat 
            dapat mengetahui bagaimana proses penyelesaiannya. Hal ini juga mendorong pemerintah atau instansi terkait untuk lebih bertanggung 
            jawab dalam menangani setiap keluhan yang diajukan.
        </li>
        <li>
            <strong>Mendorong perbaikan kualitas layanan publik.</strong>  
            Pengaduan masyarakat berfungsi sebagai sumber masukan yang berharga untuk instansi publik. Dengan mendengarkan suara masyarakat, 
            pemerintah atau pihak terkait dapat mengidentifikasi kelemahan dalam layanan yang diberikan dan mencari solusi untuk memperbaikinya. 
            Hal ini tidak hanya meningkatkan kualitas layanan, tetapi juga membangun kepercayaan masyarakat terhadap pemerintah atau institusi 
            yang bertanggung jawab atas pelayanan tersebut.
        </li>
        <li>
            <strong>Meningkatkan partisipasi masyarakat dalam pengelolaan layanan publik.</strong>  
            Layanan pengaduan memberikan ruang bagi masyarakat untuk lebih aktif berpartisipasi dalam pengelolaan pelayanan publik. 
            Partisipasi ini tidak hanya dalam bentuk menyampaikan keluhan, tetapi juga memberikan ide atau kritik yang membangun untuk 
            menciptakan inovasi baru yang dapat meningkatkan kualitas layanan secara keseluruhan.
        </li>
        <li>
            <strong>Menyediakan data yang berguna untuk analisis dan pengambilan keputusan.</strong>  
            Setiap pengaduan yang masuk dapat menjadi bagian dari data yang berharga untuk analisis lebih lanjut. Data ini dapat digunakan 
            untuk mengidentifikasi tren permasalahan, area yang memerlukan perbaikan, serta kebutuhan masyarakat yang harus diakomodasi. 
            Dengan memanfaatkan data ini, pemerintah atau instansi terkait dapat membuat kebijakan yang lebih tepat sasaran dan berfokus pada 
            kebutuhan nyata masyarakat.
        </li>
    </ul>
</section>

    <!-- Image Gallery -->
    <section class="flex flex-wrap justify-between gap-4 mt-8">
        <img src="images/artikel1.png" alt="Mekanisme Pengaduan" class="w-[48%] rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
        <img src="images/artikel2.png" alt="Layanan Digital" class="w-[48%] rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
    </section>

    <!-- Call to Action -->
    <section class="bg-gray-800 text-white text-center rounded-lg shadow-md p-8 mt-8">
        <h2 class="text-2xl font-bold">Siap Mengajukan Pengaduan?</h2>
        <p class="mt-4 text-gray-300">
            Ayo manfaatkan layanan pengaduan masyarakat untuk menyuarakan pendapat Anda. Klik tombol di bawah ini 
            untuk mulai menyampaikan aspirasi Anda!
        </p>
        <a href="lapor">
        <button class="mt-6 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-all duration-300">
            Ajukan Pengaduan
        </button>
        </a>
    </section>
</div>
 

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

</body>
</html>