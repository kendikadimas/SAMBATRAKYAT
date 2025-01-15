<?php
session_start();
require_once("private/database.php");
include("koneksi.php");


// Cek apakah pengguna login atau tidak
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : "Pengunjung";

// Inisialisasi variabel default
$account = null;
$photoBase64 = null;
$imageType = null;
$defaultPhoto = "https://cdn.tailgrids.com/2.2/assets/core-components/images/account-dropdowns/image-1.jpg";
$username = $_SESSION['username'] ?? null; // Gunakan null coalescing operator untuk menghindari error jika session kosong

// Jika username tersedia, ambil data pengguna
if ($username) {
    // Gunakan prepared statement untuk keamanan
    $query = $conn->prepare("SELECT photo FROM users WHERE username = ?");
    if ($query === false) {
        die("Kesalahan dalam query: " . $conn->error);
    }

    // Bind parameter dan eksekusi query
    $query->bind_param("s", $username);
    $query->execute();

    // Ambil hasil query
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        $account = $result->fetch_assoc();

        // Periksa apakah kolom `photo` berisi data
        if (!empty($account['photo'])) {
            $photoBase64 = base64_encode($account['photo']); // Encode gambar ke base64
        } else {
            $photoBase64 = null; // Atur null jika foto kosong
        }
    }

    // Tutup statement
    $query->close();
}

// Tutup koneksi database utama
$conn->close();

// Konfigurasi koneksi database untuk statistik laporan
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'kp';
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

// Tutup koneksi statistik laporan
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Sambat Rakyat</title>
    <link rel="shortcut icon" href="images/samblog.svg">
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <!-- <link href="css/style.css" rel="stylesheet">
    <link href="css/stylehome.css" rel="stylesheet"> -->
    <!-- jQuery -->
    <!-- <script src="js/jquery.min.js"></script> -->
    <!-- Bootstrap JavaScript -->
    <!-- <script src="js/bootstrap.js"></script> -->
    <!-- Animate CSS -->
    <!-- <link rel="stylesheet" href="css/animate.min.css"> -->
    <link rel="stylesheet" href="css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <style>
    .animate-border {
        width: 0; /* Default width 0 untuk animasi */
    }

    .animate-border.active {
        width: 100%; /* Lebar penuh setelah scroll */
    }
</style>
</head>
<body>
    <!-- <div id="fb-root"></div> -->
    <!-- <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.11';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script> -->

    <!--Success Modal Saved-->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 transition-opacity duration-300 hidden" id="successmodalclear">
    <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
        <!-- Modal Header -->
        <div class="text-center border-b border-gray-300 pb-4">
            <h4 class="text-xl font-bold text-green-500">Sukses</h4>
        </div>

        <!-- Modal Body -->
        <div class="mt-4 text-center space-y-2">
            <p class="text-gray-700">Pengaduan Berhasil Dikirim</p>
            <p class="text-gray-700">Untuk Mengetahui Status Pengaduan</p>
            <p class="text-gray-700">
                Silahkan Buka Menu 
                <a href="lihat" class="text-blue-500 underline">Lihat Pengaduan</a>
            </p>
        </div>

        <!-- Modal Footer -->
        <div class="mt-6 flex justify-end">
            <button 
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition" 
                onclick="location.href='index';">
                Tutup
            </button>
        </div>
    </div>
</div>
<!-- <script>
    const modal = document.getElementById('successmodalclear');
    modal.classList.add('hidden'); // Untuk menyembunyikan
    modal.classList.remove('hidden'); // Untuk menampilkan

</script> -->

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
            <a href="lihat" class="<?= isActive('lihat.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Lihat Sambatan</a>
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
                        <?php if (!empty($_SESSION['photo'])): ?>
                            <!-- Tampilkan gambar pengguna jika sudah diunggah -->
                            <img src="data:image/jpeg;base64,<?php echo $_SESSION['photo']; ?>" 
                                alt="User Avatar" 
                                class="w-8 h-8 rounded-full object-cover">
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

    <!-- Mobile Menu Toggle Button -->
    <div class="md:hidden flex items-center space-x-4">
        <button class="text-gray-800 p-2 rounded-md hover:text-[#3E7D60] focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </div>



<!-- HERO -->
        <section class="z-100">
            <div class="flex items-center justify-between p-[50px] h-screen bg-[#F9F9F9] font-family-poppins">
                <div class="w-1/2 text-left ml-[50px] mb-[100px] ">
                    <h3 class="text-[28px] text-[#555] mb-4">Selamat Datang di</h3>
                    <h1 class="text-[84px] font-bold text-[#555]">Website</h1>
                    <h1 class="text-[84px] font-bold text-[#3E7D60]">Sambat Rakyat</h1>
                    <p class="text-[20px] text-[#666] leading-[1.8] mb-5">Platform penyaluran aspirasi dan keluh kesah bagi <br>
                    masyarakat Indonesia</p>
                    <a href="lapor" class="text-white bg-[#3E7D60] px-6 py-4 rounded-md text-xl font-semibold mt-5">Buat Sambatan</a>
                </div>

                <div class="max-w-[40%]">
                    <img src="images/orang.png" alt="orang" class="w-full object-cover rounded-lg">
                </div>
            </div>
        </section>
        <!-- END HERO SECTION -->

        <!-- TOTAL LAPORAN -->
        <section class="bg-[#3E7D60] px-10 py-5 text-center flex relative text-white justify-center items-center rounded-t-[80px] " style="background-image: url('images/cover_hijau.png');">
            <div class="flex justify-center items-center flex-col mx-0 my-5 stat">
                <h2 class="text-[80px] font-bold m-0"><?php echo $total_laporan; ?></h2>
                <p class="text-[20px] m-3 text-[#EDEDED]">Total Laporan</p>
            </div>
            <div class="flex justify-center items-center flex-col mx-0 my-5 stat">
                <h2 class="text-[80px] font-bold m-0"><?php echo $total_menunggu; ?></h2>
                <p class="text-[20px] m-3 text-[#EDEDED]">Menunggu</p>
            </div>
            <div class="flex justify-center items-center flex-col mx-0 my-5 stat">
                <h2 class="text-[80px] font-bold m-0"><?php echo $total_selesai; ?></h2>
                <p class="text-[20px] m-3 text-[#EDEDED]">Selesai</p>
            </div>
        </section>
        <!-- END TOTAL LAPORAN -->

        <!-- ABOUT SECTION -->
        <section class="flex items-center justify-center p-[90px] bg-white text-[#333] h-screen">
            <div class="flex-1 flex justify-center items-center">
                <img src="images/about.png" alt="about" class="max-w-[80%] h-auto rounded-[10px]">
            </div>
            <div class="max-w-[600px] flex flex-col justify-center">
                <h2 class="text-[32px] font-bold"><span style="color:#3E7D60">Tentang</span></h2>
                <h2 class="text-[32px] font-bold">Sambat Rakyat</h2>
                <p class="text-[16px] leading-[1.8] mb-4 mt-5">
                    Sambat Rakyat adalah sebuah platform pengaduan masyarakat berbasis website yang dirancang
                    untuk mempermudah warga dalam menyampaikan keluhan atau aspirasi mereka kepada pemerintah
                    secara cepat, transparan, dan efisien. Platform ini bertujuan untuk menjembatani komunikasi
                    antara masyarakat dan pemerintah dengan menyediakan proses pelaporan yang mudah diakses
                    serta transparan. Melalui Sambat Rakyat, pengguna dapat membuat laporan secara langsung,
                    memantau status dan perkembangan pengaduannya, serta menerima notifikasi atau umpan balik
                    terkait tindak lanjut yang diambil pemerintah.
                </p>
                <p class="italic font-normal text-[14px] text-[#303030] mt-5 pl-2 border-l-4 border-[#3E7D60]">
    NKRI tak berarti penyeragaman, melainkan perwujudan kesetaraan dan kesejahteraan.
</p>
                <p>Najwa Sihab</p>
            </div>
        </section>
        <!-- END ABOUT SECTION -->

 <!-- LAPORAN TERBARU -->
 <div class="container mx-auto p-8">
    <h3 
        class="relative ml-8 text-left text-3xl font-bold h3-custom inline-block section-title" 
        data-animate="false">
        <span style="color:#3E7D60">Sambatan</span> Populer
        <span class="absolute bottom-0 left-0 w-0 h-[4px] bg-[#3E7D60] transition-all duration-700 ease-in-out animate-border"></span>
    </h3>
    <hr class="my-4">
    <div class="flex flex-wrap gap-6 px-14 py-3 justify-center w-full">
        <?php
        // Ambil kategori dari GET
        $kategori = isset($_GET['kategori']) ? intval($_GET['kategori']) : '';

        // Query berdasarkan kategori
        $query = "SELECT * FROM `laporan`";
        if (!empty($kategori)) {
            $query .= " WHERE tujuan = ?";
            $statement = $db->prepare($query);
            $statement->execute([$kategori]);
        } else {
            $query .= " ORDER BY likes DESC, id DESC";
            $statement = $db->query($query);
        }

        // Tampilkan data laporan
        foreach ($statement as $key) {
            $mysqldate = $key['tanggal'];
            $phpdate = strtotime($mysqldate);
            $tanggal = date('d F Y, H:i:s', $phpdate);

            $laporan_id = $key['id'];
            $replies = $db->prepare("SELECT * FROM `komen` WHERE laporan_id = ?");
            $replies->execute([$laporan_id]);
            $reply_count = $replies->rowCount();
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
        <div class="flex justify-between items-center">
            <h4 class="text-green-700 text-[20px] font-semibold mb-1" style="font-family: monospace;">
                <?php echo htmlspecialchars($key['nama']); ?>
            </h4>
            <div class="flex items-center gap-2">
                <!-- Tombol Like -->
                <button class="like-btn bg-gray-200 hover:bg-green-300 p-2 rounded-full transition-all duration-300" 
                        data-id="<?php echo $key['id']; ?>" data-action="like">
                    <i class="fa fa-thumbs-up text-green-700"></i>
                </button>
                <span id="like-count-<?php echo $key['id']; ?>" class="text-gray-600">
                    <?php echo $key['likes']; ?>
                </span>

                <!-- Tombol Unlike -->
                <button class="unlike-btn bg-gray-200 hover:bg-red-300 p-2 rounded-full transition-all duration-300" 
                        data-id="<?php echo $key['id']; ?>" data-action="unlike">
                    <i class="fa fa-thumbs-down text-red-700"></i>
                </button>
                <span id="unlike-count-<?php echo $key['id']; ?>" class="text-gray-600">
                    <?php echo $key['unlikes']; ?>
                </span>
            </div>
        </div>
        <p class="text-gray-500 text-sm mb-2">
            <i class="fa fa-calendar-alt text-green-600"></i> <?php echo $tanggal; ?>
        </p>
        <p class="text-gray-700 leading-relaxed">
            <?php echo htmlspecialchars($key['isi']); ?>
        </p>
        <p class="text-sm text-gray-600 mb-2">
            <i class="fa fa-comments text-green-600"></i> <?php echo $reply_count; ?> Komentar
        </p>
        <?php if ($isLoggedIn): ?>
    <!-- Tombol Komentar jika login -->
    <button class="toggle-replies bg-[#3E7D60] text-white py-1 px-3 rounded hover:bg-green-600 transition-all duration-300 mb-2">
        Komen
    </button>
    <!-- Tanggapan dan Form -->
    <div class="replies tutup mt-4">
        <h5 class="text-green-700 font-semibold mb-3">Komentar:</h5>
        <div class="space-y-4">
            <?php foreach ($replies as $reply): ?>
                <div class="flex items-start gap-3 p-3 bg-gray-100 rounded-lg shadow-sm">
                    <img src="images/avatar/avatar2.png" alt="Avatar" class="rounded-full w-10 h-10 border border-green-300">
                    <div>
                        <strong class="text-green-700"><?php echo htmlspecialchars($reply['nama']); ?></strong>
                        <p class="text-gray-600 text-sm mt-1 leading-relaxed"><?php echo htmlspecialchars($reply['isi']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Form Tanggapan -->
        <form action="tambah_tanggapan_home.php" method="POST" class="mt-6">
            <input type="hidden" name="laporan_id" value="<?php echo $key['id']; ?>">
            <input type="hidden" name="nama" value="<?php echo htmlspecialchars($username); ?>"> <!-- Nama diambil dari sesi -->
            <textarea id="isi" name="isi" rows="2" required
                class="block w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-green-500 focus:border-green-500"
                placeholder="Tulis tanggapan Anda..."></textarea>
            <button type="submit"
                class="bg-green-700 text-white py-2 px-4 rounded hover:bg-green-600 transition-all duration-300 mt-4">
                Kirim Komentar
            </button>
        </form>
    </div>
<?php else: ?>
    <!-- Tombol Komentar jika belum login -->
    <a href="login.php" class="bg-[#3E7D60] text-white py-1 px-3 rounded hover:bg-green-600 transition-all duration-300 mb-2 block text-center">
        Login untuk Komen
    </a>
<?php endif; ?>


    </div>
</div>

        <?php } ?>
    </div>
</section>

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
                            this.textContent = 'Sembunyikan Komentar';
                        } else {
                            repliesDiv.classList.add('tutup');
                            this.textContent = 'Komen';
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




<!-- End Laporan Terbaru -->


                <!-- Social Media Feed
                <div class="col-md-4 relative min-h-[1px] pr-[15px] pl-[15px] float-left w-1/3">
                    <br>
                    header text social-feed -->
                    <!-- <h3 class="text-center h3-custom"><span style="color:#3E7D60">Social</span> Feed</h3>
                    <hr class="custom-line"/>
                    end header text social-feed -->
                    <!-- Twitter Feed -->
                    <!-- <div class="box">
                        <div class="box-icon shadow">
                            <span class="fa fa-2x fa-twitter"></span>
                        </div>
                        <div class="info">
                            <h3 class="text-center">twitter</h3>
                            <a class="twitter-timeline" href="https://twitter.com/bmshumas?lang=en" data-width="500" data-height="300">Tweets by Humas Pemkab Banyumas</a>
                            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </div>
                    </div> -->
                    <!-- End Twitter Feed -->
                    <!-- <hr> -->
                    <!-- Facebook Feed -->
                    <!-- <div class="box">
                        <div class="box-icon shadow">
                            <span class="fa fa-2x fa-facebook"></span>
                        </div>
                        <div class="info">
                            <h3 class="text-center">facebook</h3>
                            <div class="fb-page" data-height="300" data-width="500" data-href="https://www.facebook.com/betterbanyumas" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                <blockquote cite="https://www.facebook.com/betterbanyumas" class="fb-xfbml-parse-ignore">
                                    <a href="https://www.facebook.com/betterbanyumas">Pemerintahan Kabupaten Banyumas</a>
                                </blockquote>
                            </div>
                        </div>
                    </div> -->
                    <!-- End Facebook Feed -->
                    <!-- <hr> -->
                    <!-- Facebook Feed -->
                    <!-- <div class="box"> -->
                        <!-- End Facebook Feed -->
                    <!-- </div> -->
                    <!-- End Social Media Feed 
                </div> -->
                <!-- end row 
            </div>-->

            <!-- Section Header -->
            <div class="text-center mb-[100px] mt-[50px]">
    <h3 
        class="relative ml-8 text-left text-3xl font-bold h3-custom inline-block section-title" 
        data-animate="false">
        <span style="color:#3E7D60">Kritik</span> & Saran
        <span class="absolute bottom-0 left-0 w-0 h-[4px] bg-[#3E7D60] transition-all duration-700 ease-in-out animate-border"></span>
    </h3>
</div>

<!-- Kritik & Saran Section -->
<section class="flex justify-center items-center bg-white">
    <div 
        class="bg-white mb-[250px] p-[30px] flex items-center w-screen max-w-full h-[267px] shadow-[0px_4px_6px_rgba(0,0,0,0.1)] text-primary" 
        style="background-image: url('images/cover_hijau.png'); background-size: cover; background-repeat: no-repeat;"
    >
        <!-- Gambar -->
        <img src="images/orang.png" alt="kritik" class="max-w-full mb-5">

        <!-- Form -->
        <form class="pt-[7px] flex w-full gap-2" role="form" method="post" action="index.php">
            <input 
                type="text" 
                class="w-9/12 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" 
                id="kritik" 
                name="kritik" 
                placeholder="Tuliskan kritik dan saran untuk website"
            >
            <button 
                type="submit" 
                class="px-4 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition duration-300"
            >
                Kirim
            </button>
        </form>
    </div>
</section>



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
                    Jl. Raya Mayjen Sungkono No.KM 5
                        <br>Purbalingga, Jawa Tengah 53371
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
                            <a class="text-white border border-white mx-0 my-[5px] transition-all duration-300 ease-in-out hover:bg-[#3E7D60] hover:border-[#3E7D60] text-center rounded-full p-2 flex items-center justify-center w-8 h-8" 
                            href="https://www.facebook.com/betterbanyumas/?ref=embed_page">
                                <i class="fa fa-fw fa-facebook"></i>
                            </a>
                        </li>
                        <li class="pl-0 list-none">
                            <a class="text-white border border-white mx-0 my-[5px] transition-all duration-300 ease-in-out hover:bg-[#3E7D60] hover:border-[#3E7D60] text-center rounded-full p-2 flex items-center justify-center w-8 h-8 ml-5" 
                            href="https://twitter.com/bmshumas?lang=en">
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
                        sambatrakyat@gmail.com
                    </p>
                </div>
        </footer>
        <!-- /footer -->

    <div class="copyright bg-black">
        <p style="text-align: center; color: white">Copyright &copy; GACORIAN</p>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil semua elemen yang ingin di-observe
        const elementsToObserve = document.querySelectorAll('.kritik-text h1, .h3-custom');

        // Intersection Observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('scrolled'); // Tambahkan class
                } else {
                    entry.target.classList.remove('scrolled'); // Hapus class jika keluar viewport
                }
            });
        }, { threshold: 0.8 }); // Aktifkan ketika 80% elemen terlihat

        // Observasi setiap elemen
        elementsToObserve.forEach(element => {
            observer.observe(element);
        });
    });

    // Fungsi untuk animasi counter
function animateCounter(element, start, end, duration) {
    let startTimestamp = null;

    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const value = Math.floor(progress * (end - start) + start);
        element.textContent = value;
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };

    window.requestAnimationFrame(step);
}

    // Menjalankan animasi untuk setiap elemen statistik
    document.addEventListener("DOMContentLoaded", () => {
        const totalLaporanElement = document.querySelector(".stat:nth-child(1) h2");
        const menungguElement = document.querySelector(".stat:nth-child(2) h2");
        const selesaiElement = document.querySelector(".stat:nth-child(3) h2");

        // Memulai animasi
        animateCounter(totalLaporanElement, 0, parseInt(totalLaporanElement.textContent), 1000);
        animateCounter(menungguElement, 0, parseInt(menungguElement.textContent), 1000);
        animateCounter(selesaiElement, 0, parseInt(selesaiElement.textContent), 1000);
    });
    // Fungsi untuk mengecek apakah elemen terlihat di viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Ambil semua elemen dengan class 'section-title'
    const sectionTitles = document.querySelectorAll(".section-title");

    // Tambahkan event listener untuk scroll
    window.addEventListener("scroll", () => {
        sectionTitles.forEach((title) => {
            const border = title.querySelector(".animate-border");

            // Jika elemen ada di viewport dan belum dianimasikan
            if (isInViewport(title) && title.dataset.animate === "false") {
                border.classList.add("active"); // Aktifkan animasi
                title.dataset.animate = "true"; // Tandai sudah dianimasikan
            }
        });
    });
</script>


<script>
   document.querySelectorAll('.like-btn, .unlike-btn').forEach(button => {
    button.addEventListener('click', () => {
        const laporanId = button.getAttribute('data-id'); // Ambil ID laporan
        const action = button.getAttribute('data-action'); // Ambil aksi (like/unlike)

        // Kirim permintaan ke backend
        fetch('like_unlike.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `laporan_id=${laporanId}&action=${action}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Perbarui angka like/unlike
                document.getElementById(`like-count-${laporanId}`).textContent = data.likes;
                document.getElementById(`unlike-count-${laporanId}`).textContent = data.unlikes;
            } else {
                alert(data.message); // Tampilkan pesan error
            }
        })
        .catch(error => console.error('Terjadi kesalahan:', error));
    });
});

</script>


</body>
</html>