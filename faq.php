<?php
    session_start();
    // require_once("private/database.php");
    // if (!isset($_SESSION['username'])) {
    //     header("Location: login");
    //     exit();
    // }
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
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Tentang | Sambat Rakyat</title>
    <link rel="shortcut icon" href="images/samblog.svg">
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <link rel="stylesheet" href="css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <style>
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.8s ease-out;
    }
</style>
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
    
        <!-- Aside Breadcrumb -->
        <aside class="fixed left-0 top-1/2 transform -translate-y-1/2 flex flex-col gap-4 p-4">
                <a href="#title" class="w-10 h-10 bg-green-700 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-green-500 transition duration-300">
                    <i class="fa fa-home"></i>
                </a>
                <a href="#how-to" class="w-10 h-10 bg-green-700 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-green-500 transition duration-300">
                    <i class="fa fa-info"></i>
                </a>
                <a href="#features" class="w-10 h-10 bg-green-700 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-green-500 transition duration-300">
                    <i class="fa fa-list"></i>
                </a>
                <a href="#why" class="w-10 h-10 bg-green-700 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-green-500 transition duration-300">
                    <i class="fa fa-question-circle"></i>
                </a>
            </aside>
                <!-- Main Content -->
        <div class="main-content mt-10 md:mt-0 max-w-4xl mx-auto p-6 fade-in">
            <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
                <!-- Title -->
                <h3 class="text-3xl font-bold text-green-700 mb-4 text-center" id="title">
                "Aspirasi Didengar, Solusi Dikerjakan!"
                </h3>
                <hr class="my-6 border-t-2 border-green-700">
                
                <div class="flex flex-col md:flex-row items-center gap-6">
            <!-- Image -->
            <div class="w-full md:w-1/2">
                <img src="images/comunication.png" alt="Sambat Rakyat" class="rounded-lg hover:scale-105 transition-transform duration-300">
            </div>
            <!-- Description -->
            <div class="w-full md:w-1/2">
                <p class="text-justify text-gray-700 leading-relaxed">
                    <span class="text-green-700 font-bold" style="font-family: 'Poppins', sans-serif; font-size: 1.5em; line-height: 1.8em;">
                        Sambat Rakyat
                    </span>
                    <span class="text-gray-700 leading-relaxed">
                        adalah aplikasi berbasis web yang memfasilitasi pengelolaan pengaduan masyarakat secara efektif, transparan, dan efisien. Dengan fitur seperti pelacakan status real-time, forum diskusi, dan integrasi dengan instansi terkait, aplikasi ini memungkinkan masyarakat menyampaikan keluhan langsung kepada pemerintah atau lembaga publik yang dapat menindaklanjuti dan memberikan solusi secara cepat.
                    </span>
                </p>
            </div>
        </div>
        <br>
        <!-- How to Use -->
        <h3 class="text-2xl font-bold text-green-700 mb-4 text-center md:text-left pl-3 fade-in" id="how-to">Cara Membuat Sambatan</h3>
        <div class="flex flex-col md:flex-row items-center gap-6 mt-4">
            <!-- Deskripsi (Sebelah Kiri) -->
            <div class="w-full md:w-2/4 pl-5">
                <div class="prose max-w-none text-gray-700 leading-relaxed text-left">
                    <ul class="list-disc pl-5">
                        <li>Pengguna dapat mendaftar melalui halaman signup untuk membuat akun.</li>
                        <li>Setelah mendaftar, pengguna dapat login menggunakan akun yang telah dibuat.</li>
                        <li>Pengguna mengisi formulir pada halaman sambat untuk mengirimkan keluhan.</li>
                        <li>Status sambatan menjadi "pending" dan diverifikasi oleh admin sebelum diposting.</li>
                        <li>Sambatan yang disetujui akan muncul di halaman komunitas, di mana pengguna lain dapat memberikan komentar dan menyukai.</li>
                        <li>Instansi terkait dapat memberikan tanggapan atas keluhan yang disampaikan.</li>
                    </ul>
                </div>
            </div>
            <!-- Gambar (Sebelah Kanan) -->
                <div class="w-full md:w-1/3 pl-5">
                    <img src="images/howto.png" alt="Cara Menggunakan Sambat Rakyat" class="rounded-lg hover:scale-105 transition-transform duration-300 max-w-[355px] mx-auto">
                </div>
        </div>
        <br>
            <!-- Features -->
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12 fade-in">
            <!-- Gambar (Sebelah Kiri) -->
            <div class="w-full md:w-6/12">
                <img src="images/forum.png" alt="Layanan Publik" class="rounded-lg hover:scale-110 transition-transform duration-300 max-w-[355px] mx-auto">
            </div>
            <!-- Deskripsi (Sebelah Kanan) -->
            <div class="w-full md:w-6/12">
            <h2 class="text-2xl font-bold text-green-700 mb-4 text-center md:text-left" id="features">Fitur-fitur Sambat Rakyat</h2>
                <p class="text-justify text-gray-700 leading-relaxed">
                Halaman komunitas pada platform ini memuat semua sambatan pengguna dengan fitur penyaringan kategori yang memudahkan pencarian dan penanganan masalah sesuai bidang. Selain itu, tersedia Forum interaktif sebagai ruang untuk berdiskusi, berbagi pandangan, dan memberikan solusi atas topik-topik yang berkembang di masyarakat. Untuk mendukung partisipasi publik, Halaman Event menyajikan informasi terkait berbagai kegiatan kemasyarakatan, seperti kegiatan sosial, seminar, dan pelatihan. Sementara itu, Halaman Artikel menghadirkan tulisan edukatif tentang isu-isu penting, memberikan wawasan, inspirasi, serta solusi atas beragam permasalahan yang dihadapi masyarakat.
                </p>
            </div>
        </div>  
        <br>
            <!-- Additional Image -->
        <div class="flex flex-col md:flex-row items-center gap-8 justify-center mt-8 mb-5 fade-in">
            <!-- Deskripsi -->
            <div class="md:w-1/2 text-left pl-3">
                <h3 class="text-2xl font-bold text-green-700 mb-4 text-center md:text-left" id="why">Kenapa Sambat Rakyat?</h3>
                <p class="text-gray-700 leading-relaxed text-justify">
                Fitur integrasi dengan instansi terkait mempermudah pengelolaan pengaduan dan mempercepat respons. Melalui fitur Kelola Instansi, pengguna dapat menghubungkan pengaduan dengan instansi pemerintah atau Lembaga relevan berdasarkan kategori. Instansi tersebut dapat memberikan solusi langsung kepada pelapor melalui fitur Tanggapan Instansi, sehingga penyelesaian masalah menjadi lebih efisien.Dengan Kategori Spesifik, pengaduan langsung diarahkan ke instansi terkait, mempercepat proses penanganan dan solusi.
                </p>
            </div> 

            <!-- Gambar -->
            <div class="md:w-1/2 flex justify-center">
                <img src="images/goal.png" alt="Partisipasi Masyarakat" class="rounded-lg hover:scale-105 transition-transform duration-300">
            </div>
        </div>

            </div>
<br>
</div>
        <!-- Back to Top Button -->
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
    // Back to Top Button
    window.onscroll = function() {scrollFunction()};
    function scrollFunction() {
        const button = document.getElementById("top");
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            button.style.display = "block";
        } else {
            button.style.display = "none";
        }
    }

    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
    document.addEventListener("DOMContentLoaded", function () {
        const fadeElements = document.querySelectorAll(".fade-in");

        const observer = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1 }
        );

        fadeElements.forEach(element => {
            observer.observe(element);
        });
    });


</script>
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

</body>

</html>