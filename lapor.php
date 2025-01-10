<?php
# @Author: kelompok 4
# @Date:   20 Desember 2024
# @Copyright: (c) Sambat Rakyat Banyumas 2024
?>
<?php
session_start();
    require_once("private/database.php");
    $statement = $db->query("SELECT id FROM `laporan` ORDER BY id DESC LIMIT 1");
    // $cekk = $statement->fetch(PDO::FETCH_ASSOC);
    if ($statement->rowCount()>0) {
        foreach ($statement as $key ) {
            // get max id from tabel laporan
            $max_id = $key['id']+1;
        }
    }
    if ($statement->rowCount()<1) {
        $max_id = 100;
    }
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Sambat | Sambat Rakyat</title>
    <link rel="shortcut icon" href="images/samblog.svg">
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <!-- <link href="css/style.css" rel="stylesheet">
    <link href="css/lapor.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>

<body>
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
        <div class="max-w-4xl mx-auto p-8 bg-white border border-gray-300 shadow-lg rounded-lg mt-10 mb-10">
    <h3 class="text-primary font-bold text-center text-3xl mb-4">Buat Laporan</h3>
    <hr class="border-t border-gray-300 mb-6" />

    <form class="space-y-6" method="post" action="private/validasi">
        <!-- Nomor Pengaduan -->
        <div class="grid grid-cols-3 gap-4 items-center">                                                                           <label for="nomor" class="font-semibold text-gray-700 col-span-1">Nomor Pengaduan</label>
            <div class="col-span-2">
                <input 
                    type="text" 
                    id="nomor" 
                    name="nomor" 
                    value="<?php echo $max_id; ?>" 
                    class="bg-gray-100 text-gray-500 w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-300"
                    readonly />
            </div>
        </div>

        <!-- Nama -->
        <div class="grid grid-cols-3 gap-4 items-center">
            <label for="nama" class="font-semibold text-gray-700 col-span-1">Nama</label>
            <div class="col-span-2">
                <input 
                    type="text" 
                    id="nama" 
                    name="nama" 
                    placeholder="Nama Lengkap" 
                    value="<?= @$_GET['nama'] ?>" 
                    required
                    class="w-full px-4 py-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-300" />
                <p class="text-sm text-red-500 mt-1"><?= @$_GET['namaError'] ?></p>
            </div>
        </div>

        <!-- Email -->
        <div class="grid grid-cols-3 gap-4 items-center">
            <label for="email" class="font-semibold text-gray-700 col-span-1">Email</label>
            <div class="col-span-2">
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="example@domain.com" 
                    value="<?= @$_GET['email'] ?>" 
                    required
                    class="w-full px-4 py-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-300" />
                <p class="text-sm text-red-500 mt-1"><?= @$_GET['emailError'] ?></p>
            </div>
        </div>

        <!-- Telpon -->
        <div class="grid grid-cols-3 gap-4 items-center">
            <label for="telpon" class="font-semibold text-gray-700 col-span-1">Telpon</label>
            <div class="col-span-2">
                <input 
                    type="text" 
                    id="telpon" 
                    name="telpon" 
                    placeholder="087123456789" 
                    value="<?= @$_GET['telpon'] ?>" 
                    required
                    class="w-full px-4 py-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-300" />
                <p class="text-sm text-red-500 mt-1"><?= @$_GET['telponError'] ?></p>
            </div>
        </div>

        <!-- Alamat -->
        <div class="grid grid-cols-3 gap-4 items-center">
            <label for="alamat" class="font-semibold text-gray-700 col-span-1">Alamat</label>
            <div class="col-span-2">
                <input 
                    type="text" 
                    id="alamat" 
                    name="alamat" 
                    placeholder="Alamat" 
                    value="<?= @$_GET['alamat'] ?>" 
                    required
                    class="w-full px-4 py-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-300" />
                <p class="text-sm text-red-500 mt-1"><?= @$_GET['alamatError'] ?></p>
            </div>
        </div>

        <!-- Tujuan Pengaduan -->
        <div class="grid grid-cols-3 gap-4 items-center">
            <label for="tujuan" class="font-semibold text-gray-700 col-span-1">Tujuan Pengaduan</label>
            <div class="col-span-2">
                <select 
                    id="tujuan" 
                    name="tujuan" 
                    class="w-full px-4 py-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-300">
                    <option value="1">Pelayanan Pendaftaran Penduduk</option>
                    <option value="2">Pelayanan Pencatatan Sipil</option>
                    <option value="3">Pengelolaan Informasi Administrasi Kependudukan</option>
                    <option value="4">Pemanfaatan Data Dan Inovasi Pelayanan</option>
                </select>
            </div>
        </div>

        <!-- Isi Pengaduan -->
        <div class="grid grid-cols-3 gap-4 items-center">
            <label for="pengaduan" class="font-semibold text-gray-700 col-span-1">Isi Pengaduan</label>
            <div class="col-span-2">
                <textarea 
                    id="pengaduan" 
                    name="pengaduan" 
                    placeholder="Tuliskan Isi Pengaduan" 
                    rows="4" 
                    required
                    class="w-full px-4 py-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-300"></textarea>
                <p class="text-sm text-red-500 mt-1"><?= @$_GET['pengaduanError'] ?></p>
            </div>
        </div>

        <!-- Submit -->
        <div class="text-center">
            <button 
                type="submit" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Kirim Pengaduan
            </button>
        </div>

        <!-- Note -->
        <div class="text-center text-sm text-gray-500 mt-4">
            <em>* Catat Nomor Pengaduan Untuk Melihat Status Pengaduan</em>
        </div>
    </form>
</div>

            <!-- link to top -->
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
            // When the user scrolls down 100px from the top of the document, show the button
            window.onscroll = function() {scrollFunction()};
            function scrollFunction() {
                if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                    document.getElementById("top").style.display = "block";
                } else {
                    document.getElementById("top").style.display = "none";
                }
            }
            // When the user clicks on the button, scroll to the top of the document
            function topFunction() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
            </script>
            <!-- link to top -->


            <!-- /.section -->
            <hr>
        </div>

        <!-- Footer -->
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

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="js/bootstrap.js"></script>

</body>

</html>
