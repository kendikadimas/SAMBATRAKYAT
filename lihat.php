<?php
# @Author: kelompok 4
# @Date:   20 Desember 2024
# @Copyright: (c) Sambat Rakyat Banyumas 2024
?>
<?php
session_start();
require_once("private/database.php");
$nomorError = "";
global $found, $foundreply;
// jalankan jika tombol cari ditekan
if(isset($_POST['submit'])) {
    $nomor = $_POST['nomor'];
    $is_valid = true;
    // validasi nomor laporan yang di inputankan user
    if (!preg_match("/^[0-9]*$/",$nomor)) { // cek nomor hanya boleh angka
        $nomorError = "Input Hanya Boleh Angka";
        $is_valid = false;
    } else {
        $nomorError = "";
    }
    // jika inpuan valid jalankan
    if ($is_valid) {
        $statement = $db->query("SELECT * FROM laporan LEFT JOIN divisi ON laporan.tujuan = divisi.id_divisi WHERE laporan.id = $nomor");
        // jika laporan tidak ditemukan tampilkan pesan
        if ($statement->rowCount() < 1) {
            $notFound= "Nomor Pengaduan Tidak Ditemukan !";
        }
        // jika  laporan ditemukan
        else {
            // ada laporan ada tangggapan
            $stat = $db->query("SELECT * FROM `tanggapan` WHERE id_laporan = $nomor");
            if ($stat->rowCount() > 0) {
                $foundreply = true;
            }
            // pengaduan ditemukan
            $nomorError = "";
            $found = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Lihat Pengaduan | Sambat Rakyat</title>
    <link rel="shortcut icon" href="images/samblog.svg">
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <!-- <link href="css/style.css" rel="stylesheet">
    <link href="css/lihat.css" rel="stylesheet"> -->
    <!-- jQuery -->
    <!-- <script src="js/jquery.min.js"></script>
    Bootstrap JavaScript 
    <script src="js/bootstrap.js"></script> -->
    <link rel="stylesheet" href="css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <!--Success Modal Saved-->
    <div class="fixed top-0 right-0 bottom-0 left-0 z-[100] overflow-hidden outline-none hidden " id="failedmodal" tabindex="-1" role="dialog">
        <div class="relative w-auto m-[10px] " role="document">
            <div class="realtive mt-[30%] bg-white bg-clip-padding border border-solid border-[#999] rounded-md outline-none shadow-sm  bg-2">
                <div class="p-[15px] border-b-[1px] border-solid border-[#e5e5e5] ">
                    <h4 class="m-0 leading-[1.42857143] text-center text-danger">Gagal</h4>
                </div>
                <div class="relative p-[15px] ">
                    <p class="text-center">Nomor Pengaduan Tidak Ditemukan</p>
                </div>
                <div class="p-[15px] text-right border-t-[1px] border-solid border-[#e5e5e5]">
                    <button type="button" class="inline  text-white bg-[#d9534f] border-[#d43f3a]" onclick="location.href='lihat';" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    // alert pengaduan tidak ditemukan
    if(isset($notFound)) {
        ?>
        <script type="text/javascript">
        $("#failedmodal").modal();
        </script>
        <?php
    }
    ?>

   
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


        <!-- content -->
        <div class="p-5 rounded-lg shadow-md border border-gray-300 mx-auto my-5 w-1/2 h-auto bg-white ">
    <h3 class="text-2xl mb-4 text-center font-bold text-green-700">Lihat Pengaduan</h3>
    <hr class="border border-gray-300 my-2" />
    <div class="flex flex-col items-center">
        <form class="w-full" role="form" method="post">
            <div class="mb-4">
                <label for="nomor" class="block font-medium text-gray-600">Nomor Pengaduan</label>
                <div class="flex items-center mt-1">
                    <span class="inline-flex items-center px-3 bg-gray-200 border border-gray-300 rounded-l">
                        <i class="glyphicon glyphicon-exclamation-sign text-gray-500"></i>
                    </span>
                    <input 
                        type="text" 
                        id="nomor" 
                        name="nomor" 
                        placeholder="Masukkan Nomor Pengaduan" 
                        class="form-control border border-gray-300 rounded-r w-full focus:ring focus:ring-green-300 focus:border-green-500"
                        required>
                </div>
                <p class="text-sm text-red-500 mt-1"><?= @$nomorError ?></p>
            </div>
            <div class="text-center">
                <button 
                    type="submit" 
                    name="submit" 
                    id="submit"
                    class="px-4 py-2 text-white bg-blue-600 rounded shadow-md hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                    Lihat Pengaduan
                </button>
            </div>
        </form>
    </div>

    <?php if ($found): ?>
        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-800">Hasil Pencarian</h3>
            <div class="space-y-6 mt-4">
                <?php foreach ($statement as $key): ?>
                    <?php $tanggal = date('d F Y, H:i:s', strtotime($key['tanggal'])); ?>
                    <div class="p-5 border border-gray-300 rounded-md shadow-md bg-gray-50">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-bold text-gray-700">Laporan</h4>
                            <p class="text-sm text-gray-500"><?= $key['nama_divisi']; ?></p>
                        </div>
                        <div class="flex items-center mb-4">
                            <img class="w-12 h-12 rounded-full border-2 border-green-500" src="images/avatar/avatar1.png" alt="Avatar">
                            <div class="ml-4">
                                <h5 class="text-green-700 font-bold"><?= $key['nama']; ?></h5>
                                <p class="text-sm text-gray-500"><i class="fa fa-calendar"></i> <?= $tanggal; ?></p>
                            </div>
                        </div>
                        <p class="text-gray-700 text-justify"><?= $key['isi']; ?></p>
                        <div class="mt-4">
                            <h4 class="text-md font-semibold text-gray-700">Tindak Lanjut Laporan</h4>
                            <hr class="border border-gray-300 my-2">
                            <?php if ($foundreply): ?>
                                <?php foreach ($stat as $reply): ?>
                                    <?php $tanggal_tanggapan = date('d F Y, H:i:s', strtotime($reply['tanggal_tanggapan'])); ?>
                                    <div class="flex items-start mt-4">
                                        <img class="w-10 h-10 rounded-full border-2 border-blue-500" src="images/avatar/avatar2.png" alt="Avatar Admin">
                                        <div class="ml-4">
                                            <h5 class="text-blue-600 font-bold"><?= $reply['admin']; ?></h5>
                                            <p class="text-sm text-gray-500"><i class="fa fa-calendar"></i> <?= $tanggal_tanggapan; ?></p>
                                            <p class="text-gray-700 mt-2"><?= $reply['isi_tanggapan']; ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-gray-500 text-sm"><i class="fa fa-exclamation-circle"></i> Belum Ada Tanggapan</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <a 
    id="top" 
    href="#" 
    onclick="topFunction()" 
    class="fixed bottom-5 right-5 bg-green-600 text-white p-4 rounded-full shadow-lg hover:bg-green-700 hover:scale-110 transition-all duration-300"
    title="Back to Top"
>
    <i class="fa fa-arrow-circle-up text-[24px]"></i>
</a>

    <script>
        window.onscroll = function () { scrollFunction(); };

        function scrollFunction() {
            const topButton = document.getElementById("top");
            topButton.style.display = (document.documentElement.scrollTop > 100) ? "block" : "none";
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</div>



        <hr>

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



        <!-- shadow -->
    </div>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="js/bootstrap.js"></script>

</body>

</html>
