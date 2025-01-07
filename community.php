<?php
session_start();
require_once("private/database.php");
?>
<?php
// fungsi untuk merandom avatar profil
// function RandomAvatar(){
//     $photoAreas = array("avatar1.png", "avatar2.png", "avatar3.png", "avatar4.png", "avatar5.png", "avatar6.png", "avatar7.png", "avatar8.png", "avatar9.png", "avatar10.png", "avatar11.png");
//     $randomNumber = array_rand($photoAreas);
//     $randomImage = $photoAreas[$randomNumber];
//     return $randomImage;
// }
?>
<?php
// Konfigurasi koneksi database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'kp';

// Koneksi ke database
$mysqli = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Ambil jumlah laporan total
$total_laporan_query = "SELECT COUNT(*) AS total_laporan FROM laporan";
$total_laporan_result = $mysqli->query($total_laporan_query);
$total_laporan = $total_laporan_result->fetch_assoc()['total_laporan'];

// Ambil jumlah laporan menunggu
$menunggu_query = "SELECT COUNT(*) AS menunggu FROM laporan WHERE status = 'Menunggu'";
$menunggu_result = $mysqli->query($menunggu_query);
$total_menunggu = $menunggu_result->fetch_assoc()['menunggu'];

// Ambil jumlah laporan selesai
$selesai_query = "SELECT COUNT(*) AS selesai FROM laporan WHERE status = 'Ditanggapi'";
$selesai_result = $mysqli->query($selesai_query);
$total_selesai = $selesai_result->fetch_assoc()['selesai'];

// Tutup koneksi
$mysqli->close();
?>



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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
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

<div class="w-screen bg-white shadow-lg p-5 flex justify-between items-center z-[100]">
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
    <section style="background-image: url('images/backsginin.png');" class="h-[50vh] bg-cover w-screen bg-center bg-no-repeat">
        <div class="w-1/2 m-auto ">
            <h1 class="text-white text-[45px] font-bold p-10">Pojok Komunitas</h1>
            <p class="text-white text-[20px] font-medium px-10">Disini anda bisa anuan</p>
        </div>
    </section>
<!-- end hero section -->

<!-- sambatan -->

    <section class="h-auto w-screen bg-cover bg-center bg-no-repeat bg-gray-100">
        <h1 class="text-3xl font-bold px-16 py-8 text-left text-gray-800">Sambatan</h1>

    <div class="flex flex-wrap gap-5 px-10 py-3 justify-center">
        <?php
        // Ambil semua record dari tabel laporan
        $statement = $db->query("SELECT * FROM `laporan` ORDER BY id DESC");
        foreach ($statement as $key) {
            $mysqldate = $key['tanggal'];
            $phpdate = strtotime($mysqldate);
            $tanggal = date('d F Y, H:i:s', $phpdate);

            // Ambil tanggapan terkait laporan ini
            $laporan_id = $key['id'];
            $replies = $db->prepare("SELECT * FROM `komen` WHERE laporan_id = ?");
            $replies->execute([$laporan_id]);
            $reply_count = $replies->rowCount(); // Hitung jumlah tanggapan
        ?>
            <!-- Card -->
        <div class="flex flex-col sm:flex-row items-start bg-white border border-gray-300 rounded-lg shadow-lg w-1/2 sm:w-[48%] p-4 hover:shadow-2xl transition-shadow duration-300">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <a href="#">
                    <img src="images/avatar/avatar1.png" alt="Avatar" class="rounded-full w-16 h-16 border border-green-500 shadow-sm">
                </a>
            </div>
            <!-- Content -->
            <div class="ml-4 flex-1">
                <h4 class="text-green-700 text-[20px] font-semibold mb-1" style="font-family: monospace;">
                    <?php echo htmlspecialchars($key['nama']); ?>
                </h4>
                <p class="text-gray-500 text-sm mb-2">
                    <i class="fa fa-calendar-alt text-green-600"></i> <?php echo $tanggal; ?>
                </p>
                <hr class="mb-2">
                <p class="text-gray-700 leading-relaxed">
                    <?php echo htmlspecialchars($key['isi']); ?>
                </p>
                <hr class="my-2">

                <!-- Jumlah Tanggapan -->
                <p class="text-sm text-gray-600 mb-2">
                    <i class="fa fa-comments text-green-600"></i> <?php echo $reply_count; ?> Tanggapan
                </p>

                <!-- Tanggapan dan Form -->
                <div>
                    <button class="toggle-replies bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600 transition-all duration-300">
                        Tanggapi
                    </button>
                    <div class="replies tutup mt-4">
                        <h5 class="text-green-700 font-semibold mb-3">Tanggapan:</h5>
                        <div class="space-y-4">
                            <?php foreach ($replies as $reply) { ?>
                                <div class="flex items-start gap-3 p-3 bg-gray-100 rounded-lg shadow-sm">
                                    <img src="images/avatar/avatar2.png" alt="Avatar" class="rounded-full w-10 h-10 border border-green-300">
                                    <div>
                                        <strong class="text-green-700"><?php echo htmlspecialchars($reply['nama']); ?></strong>
                                        <p class="text-gray-600 text-sm mt-1 leading-relaxed"><?php echo htmlspecialchars($reply['isi']); ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Form Tanggapan -->
                        <form action="tambah_tanggapan.php" method="POST" class="mt-6">
                            <input type="hidden" name="laporan_id" value="<?php echo $key['id']; ?>">
                            <div class="mb-4">
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Anda</label>
                                <input type="text" id="nama" name="nama" required
                                    class="block w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div class="mb-4">
                                <label for="isi" class="block text-sm font-medium text-gray-700">Tanggapan</label>
                                <textarea id="isi" name="isi" rows="2" required
                                    class="block w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-green-500 focus:border-green-500"></textarea>
                            </div>
                            <button type="submit"
                                class="bg-green-700 text-white py-2 px-4 rounded hover:bg-green-600 transition-all duration-300">Kirim Tanggapan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>

        <script>
            // JavaScript untuk toggle visibilitas komentar dan form
            document.addEventListener('DOMContentLoaded', function () {
                const toggleButtons = document.querySelectorAll('.toggle-replies');
                toggleButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const repliesDiv = this.nextElementSibling;
                        if (repliesDiv.classList.contains('tutup')) {
                            repliesDiv.classList.remove('tutup');
                            this.textContent = 'Sembunyikan Tanggapan';
                        } else {
                            repliesDiv.classList.add('tutup');
                            this.textContent = 'Tanggapi';
                        }
                    });
                });
            });
            </script>

        <style>
        /* Gaya untuk menyembunyikan komentar dan form */
        .tutup {
            display: none;
        }

        /* Kartu utama */
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
        }

        /* Warna tambahan */
        .bg-gray-100 {
            background-color: #f9f9f9;
        }
        </style>


<section class="h-auto w-screen bg-gray-100 py-10">
    <h1 class="text-3xl font-bold px-16 text-left text-gray-800 mb-6">Forum Populer</h1>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper px-4 lg:px-16">
            <!-- Card Forum -->
            <div class="swiper-slide">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
                    <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Pajak 12% dan Isu Terbaru</h3>
                        <p class="text-sm text-gray-600 mb-4">Diskusikan isu pajak terbaru dan pendapat Anda.</p>
                        <a href="#" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
                    <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Pajak 12% dan Isu Terbaru</h3>
                        <p class="text-sm text-gray-600 mb-4">Diskusikan isu pajak terbaru dan pendapat Anda.</p>
                        <a href="#" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
                    <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Pajak 12% dan Isu Terbaru</h3>
                        <p class="text-sm text-gray-600 mb-4">Diskusikan isu pajak terbaru dan pendapat Anda.</p>
                        <a href="#" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
                    <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Pajak 12% dan Isu Terbaru</h3>
                        <p class="text-sm text-gray-600 mb-4">Diskusikan isu pajak terbaru dan pendapat Anda.</p>
                        <a href="#" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
                    <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Pajak 12% dan Isu Terbaru</h3>
                        <p class="text-sm text-gray-600 mb-4">Diskusikan isu pajak terbaru dan pendapat Anda.</p>
                        <a href="#" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
                    </div>
                </div>
            </div>
            <!-- Tambahkan lebih banyak slide -->
        </div>
        <!-- Navigasi -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Bagian Event Mendatang -->
<section class="h-auto w-screen bg-gray-100 py-10">
    <h1 class="text-3xl font-bold px-16 text-left text-gray-800 mb-6">Event Mendatang</h1>
    <div class="flex flex-wrap justify-center gap-6 px-6 lg:px-16">
        <!-- Card -->
        <div class="w-1/3 bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
            <h3 class="text-lg font-bold mb-2">Event 1</h3>
            <p class="text-sm text-gray-600 mb-4">Deskripsi singkat tentang event.</p>
            <button class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Detail</button>
        </div>
        <div class="w-1/3 bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
            <h3 class="text-lg font-bold mb-2">Event 1</h3>
            <p class="text-sm text-gray-600 mb-4">Deskripsi singkat tentang event.</p>
            <button class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Detail</button>
        </div>
        <div class="w-1/3 bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
            <h3 class="text-lg font-bold mb-2">Event 1</h3>
            <p class="text-sm text-gray-600 mb-4">Deskripsi singkat tentang event.</p>
            <button class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Detail</button>
        </div>
        <!-- Tambahkan card lainnya -->
    </div>
</section>

<!-- Bagian Edukasi Masyarakat -->
<section class="h-auto w-screen bg-gray-100 py-10">
    <h1 class="text-3xl font-bold px-16 text-left text-gray-800 mb-6">Edukasi Masyarakat</h1>
    <div class="flex flex-wrap justify-center gap-6 px-6 lg:px-16">
        <!-- Card Artikel -->
        <div class="w-full md:w-1/2 lg:w-1/3 bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
            <h3 class="text-lg font-bold mb-2">Artikel 1</h3>
            <p class="text-sm text-gray-600 mb-4">Ringkasan artikel edukasi.</p>
            <button class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Baca Selengkapnya</button>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/3 bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
            <h3 class="text-lg font-bold mb-2">Artikel 1</h3>
            <p class="text-sm text-gray-600 mb-4">Ringkasan artikel edukasi.</p>
            <button class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Baca Selengkapnya</button>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/3 bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
            <h3 class="text-lg font-bold mb-2">Artikel 1</h3>
            <p class="text-sm text-gray-600 mb-4">Ringkasan artikel edukasi.</p>
            <button class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Baca Selengkapnya</button>
        </div>
        <!-- Tambahkan card lainnya -->
    </div>
</section>

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

<script>
    const swiper = new Swiper('.mySwiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });
</script>

</body>
</html>