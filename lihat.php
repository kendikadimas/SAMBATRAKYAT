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
            $stat = $db->query("SELECT * FROM tanggapan WHERE id_laporan = $nomor");
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
    <script src="https://unpkg.com/alpinejs" defer></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Pastikan tinggi minimum sesuai layar */
        }

        .main-content {
            flex: 1; /* Konten utama mengambil ruang yang tersedia */
        }

        footer {
            margin-top: auto; /* Pastikan footer berada di bagian bawah */
        }
    </style>

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

    <!-- Mobile Menu Toggle Button -->
    <div class="md:hidden flex items-center space-x-4">
        <button class="text-gray-800 p-2 rounded-md hover:text-[#3E7D60] focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </div>


        <!-- content -->
        <div class="p-6 rounded-lg shadow-lg border border-gray-200 mx-auto my-8 w-3/5 h- bg-gradient-to-r from-white to-gray-100 flex flex-col">
            <h3 class="text-3xl mb-2 text-center font-extrabold text-green-800">Lihat Pengaduan</h3>
            <hr class="border-b border-green-500 my-4" />
            <div class="flex flex-col items-center flex-grow mb-5">
                <form class="w-full" role="form" method="post">
                    <div class="mb-6">
                        <label for="nomor" class="block text-lg font-medium text-gray-700">Nomor Pengaduan</label>
                        <input 
                            type="text" 
                            id="nomor" 
                            name="nomor" 
                            placeholder="Masukkan Nomor Pengaduan" 
                            class="w-full border border-gray-400 rounded p-2 focus:ring focus:ring-green-400 focus:border-green-600"
                            required>
                        <p class="text-sm text-red-600 mt-2"><?= @$nomorError ?></p>
                    </div>
                    <div class="text-center">
                        <button 
                            type="submit" 
                            name="submit" 
                            id="submit"
                            class="px-5 py-3 text-white bg-blue-700 rounded-full shadow-lg hover:bg-blue-800 focus:outline-none focus:ring focus:ring-blue-400">
                            Lihat Pengaduan
                        </button>
                    </div>
                </form>
            </div>

            <?php if ($found): ?>
                <div class="mt-5 p-6 rounded-lg ">
                    <h3 class="text-2xl font-bold text-gray-900">Hasil Pencarian</h3>
                    <div class="space-y-8 mt-6">
                        <?php foreach ($statement as $key): ?>
                            <?php $tanggal = date('d F Y, H:i:s', strtotime($key['tanggal'])); ?>
                            <div class="p-6 rounded-lg shadow-md bg-white mb-6">
                                <div class="flex justify-between items-center mb-6 mt-3">
                                    <h4 class="text-xl font-bold text-gray-800">Laporan</h4>
                                    <p class="text-sm text-gray-600"><?= $key['nama_divisi']; ?></p>
                                </div>
                                <div class="flex items-center mb-6">
                                    <img class="w-14 h-14 rounded-full border-2 border-green-600" src="images/avatar/avatar1.png" alt="Avatar">
                                    <div class="ml-6">
                                        <h5 class="text-green-800 font-bold"><?= $key['nama']; ?></h5>
                                        <p class="text-sm text-gray-600"><i class="fa fa-calendar"></i> <?= $tanggal; ?></p>
                                    </div>
                                </div>
                                <p class="text-gray-800 text-justify"><?= $key['isi']; ?></p>
                                <div class="mt-6">
                                    <h4 class="text-lg font-semibold text-gray-800">Tindak Lanjut Laporan</h4>
                                    <hr class="border-t-2 border-gray-300 my-3">
                                    <?php if ($foundreply): ?>
                                        <?php foreach ($stat as $reply): ?>
                                            <?php $tanggal_tanggapan = date('d F Y, H:i:s', strtotime($reply['tanggal_tanggapan'])); ?>
                                            <div class="flex items-start mt-6">
                                                <img class="w-12 h-12 rounded-full border-2 border-blue-600" src="images/avatar/avatar2.png" alt="Avatar Admin">
                                                <div class="ml-6">
                                                    <h5 class="text-blue-700 font-bold"><?= $reply['admin']; ?></h5>
                                                    <p class="text-sm text-gray-600"><i class="fa fa-calendar"></i> <?= $tanggal_tanggapan; ?></p>
                                                    <p class="text-gray-800 mt-3"><?= $reply['isi_tanggapan']; ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-gray-600 text-sm"><i class="fa fa-exclamation-circle"></i> Belum Ada Tanggapan</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

       <!-- Footer -->
       <footer class="text-center flex justify-around w-full bg-[#343a40] text-white py-5">
        <div class="relative min-h-[1px] px-[15px] float-left w-1/3">
            <ul class="pl-0 list-none">
                <li><i class="fa fa-top fa-map-marker"></i></li>
                <li><h4 class="text-[1.2em] mb-[10px]">Kantor</h4></li>
            </ul>
            <p class="text-[0.9em]">Jl. Kabupaten No. 1 Purwokerto<br>Banyumas, Jawa Tengah</p>
        </div>

        <div class="relative min-h-[1px] px-[15px] float-left w-1/3">
            <ul class="list-none p-0 mb-0">
                <li><i class="fa fa-top fa-rss"></i></li>
                <li><h4 class="text-[1.2em] mb-[10px]">Sosial Media</h4></li>
            </ul>
            <ul class="list-none flex text-center justify-center p-0 mb-0">
                <li><a class="text-white border border-white mx-0 my-[5px] hover:bg-[#3E7D60]" href="https://www.facebook.com/betterbanyumas"><i class="fa fa-fw fa-facebook"></i></a></li>
                <li><a class="text-white border border-white mx-0 my-[5px] hover:bg-[#3E7D60]" href="https://twitter.com/bmshumas"><i class="fa fa-fw fa-twitter"></i></a></li>
            </ul>
        </div>

        <div class="relative min-h-[1px] px-[15px] float-left w-1/3">
            <ul class="pl-0 list-none">
                <li><i class="fa fa-top fa-envelope-o"></i></li>
                <li><h4 class="text-[1.2em] mb-[10px]">Kontak</h4></li>
            </ul>
            <p class="text-[0.9em]">+62 858-1417-4267<br>https://www.banyumaskab.go.id/<br>banyumaspemkab@gmail.com</p>
        </div>
    </footer>

    <div class="copyright bg-black">
        <p style="text-align: center; color: white">Copyright &copy; Pemerintahan Kabupaten Banyumas</p>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

</body>

</html>