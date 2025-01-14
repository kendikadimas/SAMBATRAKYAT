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

<?php
include("koneksi.php");


$username = $_SESSION['username'];

// Gunakan prepared statement dengan placeholder `?`
$query = $conn->prepare("SELECT photo FROM users WHERE username = ?");
if ($query === false) {
    die("Kesalahan dalam query: " . $conn->error);
}

// Ikat parameter dan eksekusi query
$query->bind_param("s", $username); // "s" untuk string
$query->execute();

// Ambil hasil query
$result = $query->get_result();
if ($result->num_rows > 0) {
    $account = $result->fetch_assoc();

    // Periksa apakah kolom `photo` berisi data
    if (!empty($account['photo'])) {
        $photoBase64 = base64_encode($account['photo']); // Encode gambar ke base64

        // Simpan foto ke dalam session
        $_SESSION['photo'] = $photoBase64;
    } else {
        $_SESSION['photo'] = null; // Atur ke null jika foto kosong
    }
} else {
    echo "Data pengguna tidak ditemukan.";
}
$defaultPhoto = "https://cdn.tailgrids.com/2.2/assets/core-components/images/account-dropdowns/image-1.jpg";
// Tutup statement dan koneksi
$query->close();
$conn->close();
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


<!-- end navbar -->

<!-- hero -->
<section 
    style="background-image: url('images/backbms.png');" 
    class="relative h-[60vh] bg-cover w-full bg-center bg-no-repeat flex items-center justify-center">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <!-- Content -->
    <div class="relative text-center text-white px-6 md:px-0">
        <h1 class="text-[40px] md:text-[60px] font-bold leading-tight">
            Komunitas Sambat Rakyat
        </h1>
        <p class="text-[18px] md:text-[24px] font-medium mt-4">
            Temukan diskusi, aksi, dan pendapat masyarakat di sini.
        </p>
    </div>
</section>



<!-- end hero section -->

<!-- sambatan -->
<main class="flex w-full">
<section class="h-auto w-3/4 bg-cover bg-center bg-no-repeat bg-gray-100">
    <h1 class="text-3xl font-bold px-16 pt-8 pb-4 text-left text-gray-800">Sambatan</h1>

    <!-- Dropdown Kategori -->
    <form method="GET" class="px-16 py-4">
        <label for="kategori" class="block text-gray-700 font-semibold mb-2">Pilih Kategori:</label>
        <select name="kategori" id="kategori" class="border border-gray-300 rounded-md p-2 w-1/3">
            <option value="">Semua Kategori</option>
            <option value="1">Sosial dan Kemasyarakatan</option>
            <option value="2">Keamanan dan Pertahanan</option>
            <option value="3">Politik dan Pemerintahan</option>
            <option value="4">Lingkungan dan Alam</option>
            <option value="5">Infrastruktur dan Transportasi</option>
        </select>
        <button type="submit" class="ml-2 bg-green-700 text-white py-2 px-4 rounded hover:bg-green-600">
            Tampilkan
        </button>
    </form>

    <div class="flex flex-wrap gap-6 px-14 py-3 justify-center w-full border-r-2 border-[#3E7D60]">
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
            <div class="ml-4 flex-1 relative">
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
                <i class="fa fa-comments text-green-600"></i> <?php echo $reply_count; ?> Tanggapan
            </p>
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
<section class="h-100 w-1/4 bg-gray-100 py-10">
    <h1 class="text-3xl font-bold px-16 text-left text-gray-800 mb-6">Event</h1>
    <!-- Scrollable Container -->
    <div class="flex flex-col overflow-y-auto max-h-[800px] px-6 lg:px-16 gap-6">
        <!-- Card Event -->
        <div class="w-full bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
            <img src="images/pos1.png" alt="Seminar" class="rounded-t-lg mb-4 w-full h-40 object-cover">
            <h3 class="text-lg font-bold mb-2">Seminar Pelayanan Masyarakat</h3>
            <p class="text-sm text-gray-600 mb-4">Seminar tentang pelayanan masyarakat dan pengaduan.</p>
            <button 
                class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300 open-modal-btn"
                data-title="Seminar Pelayanan Masyarakat"
                data-description="Seminar ini membahas pelayanan masyarakat, pengaduan, dan langkah-langkah untuk meningkatkan kualitas layanan publik. Jangan lewatkan kesempatan untuk mendapatkan wawasan baru."
                data-image="images/pos1.png"
            >
                Detail
            </button>
        </div>
        <div class="w-full bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
            <img src="images/pos2.png" alt="Seminar" class="rounded-t-lg mb-4 w-full h-40 object-cover">
            <h3 class="text-lg font-bold mb-2">Seminar Pelayanan Masyarakat</h3>
            <p class="text-sm text-gray-600 mb-4">Seminar tentang pelayanan masyarakat dan pengaduan.</p>
            <button 
                class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300 open-modal-btn"
                data-title="Seminar Pelayanan Masyarakat"
                data-description="Seminar ini membahas pelayanan masyarakat, pengaduan, dan langkah-langkah untuk meningkatkan kualitas layanan publik. Jangan lewatkan kesempatan untuk mendapatkan wawasan baru."
                data-image="images/pos2.png"
            >
                Detail
            </button>
        </div>
        <div class="w-full bg-white shadow-lg rounded-lg border p-6 transition-all duration-300 hover:shadow-2xl">
            <img src="images/pos3.png" alt="Seminar" class="rounded-t-lg mb-4 w-full h-40 object-cover">
            <h3 class="text-lg font-bold mb-2">Seminar Pelayanan Masyarakat</h3>
            <p class="text-sm text-gray-600 mb-4">Seminar tentang pelayanan masyarakat dan pengaduan.</p>
            <button 
                class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300 open-modal-btn"
                data-title="Seminar Pelayanan Masyarakat"
                data-description="Seminar ini membahas pelayanan masyarakat, pengaduan, dan langkah-langkah untuk meningkatkan kualitas layanan publik. Jangan lewatkan kesempatan untuk mendapatkan wawasan baru."
                data-image="images/pos3.png"
            >
                Detail
            </button>
        </div>
        <!-- Add more cards here as needed -->
    </div>
</section>

<style>
  /* Ensure smooth vertical scrolling */
  .overflow-y-auto {
      scrollbar-width: thin; /* For Firefox */
  }
  .overflow-y-auto::-webkit-scrollbar {
      width: 8px;
  }
  .overflow-y-auto::-webkit-scrollbar-thumb {
      background-color: rgba(0, 0, 0, 0.2);
      border-radius: 4px;
  }
</style>


<!-- Popup Modal -->
<div id="event-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg w-3/4 lg:w-1/3 shadow-xl p-6">
        <img id="modal-image" src="" alt="Event Image" class="rounded-t-lg w-full h-40 object-cover mb-4">
        <h2 id="modal-title" class="text-xl font-bold text-gray-800 mb-4"></h2>
        <p id="modal-description" class="text-sm text-gray-600 mb-6"></p>
        <div class="flex justify-end gap-4">
            <button 
                id="follow-event-btn"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-300"
            >
                Ikuti Event
            </button>
            <button 
                id="close-modal-btn"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-all duration-300"
            >
                Tutup
            </button>
        </div>
    </div>
</div>


</main>

<!-- Bagian Forum Populer -->
<section class="h-auto w-full bg-gray-100 py-10">
    <h1 class="text-3xl font-bold px-16 text-left text-gray-800 mb-6">Forum Populer</h1>
    <div class="w-full overflow-x-auto snap-x snap-mandatory flex gap-6 px-6 lg:px-16 custom-scrollbar">
        <!-- Card Forum -->
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
            <img src="images/for1.png" alt="Forum Image" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Layanan Publik</h3>
                <p class="text-sm text-gray-600 mb-4">Diskusikan Keluhan terkait layanan transportasi, air bersih, listrik, kesehatan, pendidikan, atau administrasi publik.</p>
                <a href="forum.php" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Bergabung</a>
            </div>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
            <img src="images/for2.png" alt="Forum Image" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Infrastruktur Daerah</h3>
                <p class="text-sm text-gray-600 mb-4">Masalah jalan rusak, saluran air tersumbat, lampu jalan mati, atau fasilitas umum lainnya bersama masyarakat.</p>
                <a href="forum2.php" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Bergabung</a>
            </div>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
            <img src="images/forum3.png" alt="Forum Image" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Keamanan dan Ketertiban</h3>
                <p class="text-sm text-gray-600 mb-4">Pengaduan terkait kejahatan, perilaku yang mengganggu, atau konflik antarwarga bermasyarakat.</p>
                <a href="forum3.php" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Bergabung</a>
            </div>
        </div>
        <!-- Card Forum 2 -->
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
            <img src="images/forum4.png" alt="Forum Image" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Lingkungan Sekitar</h3>
                <p class="text-sm text-gray-600 mb-4">Keluhan tentang polusi, sampah yang tidak dikelola, atau kerusakan lingkungan demi keberlangsungan hidup.</p>
                <a href="forum4.php" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Bergabung</a>
            </div>
        </div>
        <!-- Tambahkan lebih banyak card forum -->
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:border-green-600 transition-all duration-300">
            <img src="images/for5.png" alt="Forum Image" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Sosial dan Ekonomi</h3>
                <p class="text-sm text-gray-600 mb-4">Isu kesenjangan sosial, bantuan yang tidak tepat sasaran, atau peluang kerja yang tidak merata.</p>
                <a href="forum5.php" class="block text-center text-white bg-green-600 px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">Bergabung</a>
            </div>
        </div>
    </div>
</section>

<style>
    .custom-scrollbar {
        /* General scrollbar properties */
        scrollbar-width: thin; /* For Firefox: thin scrollbar */
        scrollbar-color: #ccc #f9f9f9; /* Thumb and track colors */
        overflow-y: auto; /* Ensures vertical scrolling */
        max-height: 100%; /* Prevents scroll container from overflowing */
    }

    /* Scrollbar styling for WebKit browsers (Chrome, Edge, Safari) */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px; /* Width of vertical scrollbar */
        height: 8px; /* Height of horizontal scrollbar */
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #bbb; /* Thumb color */
        border-radius: 4px; /* Rounded corners */
        border: 2px solid transparent; /* Creates space around thumb */
        background-clip: content-box; /* Prevents thumb from overlapping border */
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #888; /* Thumb color on hover */
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background-color: #f9f9f9; /* Track color */
        border-radius: 4px; /* Rounded edges for track */
    }

    .custom-scrollbar::-webkit-scrollbar-track:hover {
        background-color: #f0f0f0; /* Slightly darker track on hover */
    }
</style>



<!-- Bagian Edukasi Masyarakat (Carousel) -->
<section class="h-auto w-full bg-gray-100 py-10">
    <h1 class="text-3xl font-bold px-16 text-left text-gray-800 mb-6">Edukasi Masyarakat</h1>
    <div class="w-full overflow-x-auto snap-x snap-mandatory flex gap-6 px-6 lg:px-16 scrollbar-hide">
        <!-- Card Artikel -->
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
            <a href="artikel.php">
            <img src="images/artbro1.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-gray-900/90 via-gray-800/50 to-transparent p-6">
                <h3 class="text-lg font-bold text-white drop-shadow-md">Pengaduan Masyarakat</h3>
                <p class="text-sm text-gray-300 drop-shadow-md">Pentingnya Layanan Pengaduan Masyarakat untuk Kesejahteraan Bersama.</p>
            </div>
            </a>
        </div>
        <!-- Card Artikel 2 -->
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
        <a href="artikel.php">
            <img src="images/artbro2.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-gray-900/90 via-gray-800/50 to-transparent p-6">
                <h3 class="text-lg font-bold text-white drop-shadow-md">Panduan Pengaduan</h3>
                <p class="text-sm text-gray-300 drop-shadow-md">Panduan Praktis Mengakses Layanan Pengaduan Masyarakat.</p>
            </div>
        </a>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
        <a href="artikel.php">
            <img src="images/artbr3.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-gray-900/90 via-gray-800/50 to-transparent p-6">
                <h3 class="text-lg font-bold text-white drop-shadow-md">Peningkatan Efektivitas</h3>
                <p class="text-sm text-gray-300 drop-shadow-md">Meningkatkan Efektivitas Pengaduan dengan Teknologi Digital.</p>
            </div>
        </a>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
        <a href="artikel.php">
            <img src="images/artbro4.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-gray-900/90 via-gray-800/50 to-transparent p-6">
                <h3 class="text-lg font-bold text-white drop-shadow-md">Kewajiban Masyarakat</h3>
                <p class="text-sm text-gray-300 drop-shadow-md">Hak dan Kewajiban Masyarakat dalam Mengajukan Pengaduan.</p>
            </div>
        </a>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
        <a href="artikel.php">
            <img src="images/artbro5.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-gray-900/90 via-gray-800/50 to-transparent p-6">
                <h3 class="text-lg font-bold text-white drop-shadow-md">Transparansi Pengaduan</h3>
                <p class="text-sm text-gray-300 drop-shadow-md">Mengapa Transparansi Penting dalam Layanan Pengaduan Masyarakat?.</p>
            </div>
        </a>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
        <a href="artikel.php">
            <img src="images/artbro6.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-gray-900/90 via-gray-800/50 to-transparent p-6">
                <h3 class="text-lg font-bold text-white drop-shadow-md">Masyarakat dan Pemerintah</h3>
                <p class="text-sm text-gray-300 drop-shadow-md">Kolaborasi Masyarakat dan Pemerintah dalam Menyelesaikan Masalah.</p>
            </div>
        </a>
        </div>
        <div class="bg-white snap-center shrink-0 w-3/4 sm:w-1/2 md:w-1/3 lg:w-1/4 shadow-lg rounded-lg overflow-hidden border hover:shadow-2xl relative">
        <a href="artikel.php">
            <img src="images/artbro7.png" alt="Artikel Image" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-gray-900/90 via-gray-800/50 to-transparent p-6">
                <h3 class="text-lg font-bold text-white drop-shadow-md">Inovasi Pengaduan</h3>
                <p class="text-sm text-gray-300 drop-shadow-md">Inovasi Layanan Pengaduan Masyarkat Berbasis Aplikasi Website dan Mobile.</p>
            </div>
        </a>
        </div>
    </div>
</section>

<style>
    .scrollbar-hide {
        scrollbar-width: thin; /* Firefox */
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





<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('event-modal');
    const modalImage = document.getElementById('modal-image');
    const modalTitle = document.getElementById('modal-title');
    const modalDescription = document.getElementById('modal-description');
    const followEventBtn = document.getElementById('follow-event-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');

    // Handle open modal
    document.querySelectorAll('.open-modal-btn').forEach(button => {
        button.addEventListener('click', () => {
            const title = button.getAttribute('data-title');
            const description = button.getAttribute('data-description');
            const image = button.getAttribute('data-image');

            // Update modal content
            modalTitle.textContent = title;
            modalDescription.textContent = description;
            modalImage.src = image;

            // Show modal
            modal.classList.remove('hidden');
        });
    });

    // Handle close modal
    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Handle follow event button
    followEventBtn.addEventListener('click', () => {
        alert('Anda telah mengikuti event ini!');
        modal.classList.add('hidden');
    });
});


</script>

</body>
</html>