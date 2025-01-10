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

<!-- end navbar -->

<!-- hero -->
    <section style="background-image: url('images/backsginin.png');" class="h-[60vh] bg-cover w-full bg-center bg-no-repeat ">
        <div class="w-1/2 m-auto pt-[10vh]">
            <h1 class="text-white text-[45px] font-bold p-10">Komunitas Sambat Rakyat</h1>
            <p class="text-white text-[20px] font-medium px-10">Temukan diskusi, aksi, dan pendapat masyarakat di sini.</p>
        </div>
    </section>
<!-- end hero section -->

<!-- sambatan -->
<main class="flex w-full">
    <section class="h-auto w-3/4 bg-cover bg-center bg-no-repeat bg-gray-100">
        <h1 class="text-3xl font-bold px-16 pt-8 pb-4 text-left text-gray-800">Sambatan</h1>

    <div class="flex flex-wrap gap-6 px-14 py-3 justify-center w-full border-r-2 border-[#3E7D60] ">
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
    <div class="ml-4 flex-1 relative">
        <!-- Nama dan Tombol -->
        <div class="flex justify-between items-center">
            <h4 class="text-green-700 text-[20px] font-semibold mb-1" style="font-family: monospace;">
                <?php echo htmlspecialchars($key['nama']); ?>
            </h4>
            <div class="flex items-center gap-2">
                <!-- Tombol Upvote -->
                <button class="bg-gray-200 hover:bg-green-300 p-2 rounded-full transition-all duration-300 upvote-btn">
                    <i class="fa fa-arrow-up text-green-700"></i>
                </button>
                <span id="vote-count-<?php echo $key['id']; ?>" class="text-gray-600">
                    <?php echo $key['upvotes'] - $key['downvotes']; ?>
                </span>
                <!-- Tombol Downvote -->
                <button class="bg-gray-200 hover:bg-red-300 p-2 rounded-full transition-all duration-300 downvote-btn">
                    <i class="fa fa-arrow-down text-red-700"></i>
                </button>
            </div>
        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
    // Handle upvote
    document.querySelectorAll('.upvote-btn').forEach(button => {
        button.addEventListener('click', () => {
            const laporanId = button.closest('.flex').dataset.id; // Assuming each card has a data-id attribute
            fetch('upvote.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `laporan_id=${laporanId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const voteCountEl = button.nextElementSibling;
                    voteCountEl.textContent = parseInt(voteCountEl.textContent) + 1;
                }
            });
        });
    });

    // Handle downvote
    document.querySelectorAll('.downvote-btn').forEach(button => {
        button.addEventListener('click', () => {
            const laporanId = button.closest('.flex').dataset.id;
            fetch('downvote.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `laporan_id=${laporanId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const voteCountEl = button.previousElementSibling;
                    voteCountEl.textContent = parseInt(voteCountEl.textContent) - 1;
                }
            });
        });
    });
});

</script>

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

<!-- Bagian Event Mendatang -->
    <section class="h-auto w-1/4 bg-gray-100 py-10">
        <h1 class="text-3xl font-bold px-16 text-left text-gray-800 mb-6">Event</h1>
        <div class="flex flex-wrap justify-center gap-6 px-6 lg:px-16">
            <!-- Card -->
            <div class="w-full bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
                <h3 class="text-lg font-bold mb-2">Event 1</h3>
                <p class="text-sm text-gray-600 mb-4">Deskripsi singkat tentang event.</p>
                <button class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Detail</button>
            </div>
            <div class="w-full bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
                <h3 class="text-lg font-bold mb-2">Event 1</h3>
                <p class="text-sm text-gray-600 mb-4">Deskripsi singkat tentang event.</p>
                <button class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Detail</button>
            </div>
            <div class="w-full bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
                <h3 class="text-lg font-bold mb-2">Event 1</h3>
                <p class="text-sm text-gray-600 mb-4">Deskripsi singkat tentang event.</p>
                <button class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Detail</button>
            </div>
            <div class="w-full bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
                <h3 class="text-lg font-bold mb-2">Event 1</h3>
                <p class="text-sm text-gray-600 mb-4">Deskripsi singkat tentang event.</p>
                <button class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Detail</button>
            </div>
            <!-- Tambahkan card lainnya -->
        </div>
    </section>
</main>

<!-- Bagian Forum Populer -->
<section class="h-auto w-full bg-gray-100 py-10">
    <h1 class="text-3xl font-bold px-16 text-left text-gray-800 mb-6">Forum Populer</h1>
    <div class="w-full overflow-x-auto snap-x snap-mandatory flex gap-6 px-6 lg:px-16 scrollbar-hide">
        <!-- Card Forum -->
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
            <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Pajak 12% dan Isu Terbaru</h3>
                <p class="text-sm text-gray-600 mb-4">Diskusikan isu pajak terbaru dan pendapat Anda.</p>
                <a href="#" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
            </div>
        </div>
        <!-- Card Forum 2 -->
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
            <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Diskusi Terbaru</h3>
                <p class="text-sm text-gray-600 mb-4">Ikut serta dalam diskusi hangat ini.</p>
                <a href="#" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
            </div>
        </div>
        <!-- Tambahkan lebih banyak card forum -->
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
            <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Forum Teknologi</h3>
                <p class="text-sm text-gray-600 mb-4">Bahas teknologi terbaru di sini.</p>
                <a href="#" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
            </div>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
            <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Forum Teknologi</h3>
                <p class="text-sm text-gray-600 mb-4">Bahas teknologi terbaru di sini.</p>
                <a href="#" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
            </div>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
            <img src="images/banyu.jpg" alt="Forum Image" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Forum Teknologi</h3>
                <p class="text-sm text-gray-600 mb-4">Bahas teknologi terbaru di sini.</p>
                <a href="#" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Sentuh aku</a>
            </div>
        </div>
    </div>
</section>

<style>
    .scrollbar-hide {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none; /* Chrome, Safari, and Opera */
    }
</style>


<!-- Bagian Edukasi Masyarakat (Carousel) -->
<section class="h-auto w-full bg-gray-100 py-10">
    <h1 class="text-3xl font-bold px-16 text-left text-gray-800 mb-6">Edukasi Masyarakat</h1>
    <div class="w-full overflow-x-auto snap-x snap-mandatory flex gap-6 px-6 lg:px-16 scrollbar-hide">
        <!-- Card Artikel -->
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
            <img src="images/backbms.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-4">
                <h3 class="text-lg font-bold text-white">Artikel 1</h3>
                <p class="text-sm text-gray-200">Ringkasan artikel edukasi ini untuk Anda.</p>
            </div>
        </div>
        <!-- Card Artikel 2 -->
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
            <img src="images/backbms.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-4">
                <h3 class="text-lg font-bold text-white">Artikel 2</h3>
                <p class="text-sm text-gray-200">Ringkasan artikel edukasi kedua untuk Anda.</p>
            </div>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
            <img src="images/backbms.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-4">
                <h3 class="text-lg font-bold text-white">Artikel 2</h3>
                <p class="text-sm text-gray-200">Ringkasan artikel edukasi kedua untuk Anda.</p>
            </div>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
            <img src="images/backbms.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-4">
                <h3 class="text-lg font-bold text-white">Artikel 2</h3>
                <p class="text-sm text-gray-200">Ringkasan artikel edukasi kedua untuk Anda.</p>
            </div>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
            <img src="images/backbms.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-4">
                <h3 class="text-lg font-bold text-white">Artikel 2</h3>
                <p class="text-sm text-gray-200">Ringkasan artikel edukasi kedua untuk Anda.</p>
            </div>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
            <img src="images/backbms.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-4">
                <h3 class="text-lg font-bold text-white">Artikel 2</h3>
                <p class="text-sm text-gray-200">Ringkasan artikel edukasi kedua untuk Anda.</p>
            </div>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
            <img src="images/backbms.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-4">
                <h3 class="text-lg font-bold text-white">Artikel 2</h3>
                <p class="text-sm text-gray-200">Ringkasan artikel edukasi kedua untuk Anda.</p>
            </div>
        </div>
    </div>
</section>

<style>
    .scrollbar-hide {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none; /* Chrome, Safari, and Opera */
    }
</style>


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