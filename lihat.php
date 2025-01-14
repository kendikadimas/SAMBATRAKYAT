<?php
session_start();
include "koneksi.php";
require_once("private/database.php");

$nomorError = "";
global $found, $foundreply;
$notFound = "";

// Cek apakah pengguna sudah login, jika tidak beri status bahwa belum login
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    $isLoggedIn = false;
} else {
    $isLoggedIn = true;
    $username = $_SESSION['username'];
}

// Jalankan jika tombol cari ditekan
if (isset($_POST['submit'])) {
    $nomor = $_POST['nomor'];
    $is_valid = true;

    // Validasi nomor laporan yang diinputkan user
    if (!preg_match("/^[0-9]*$/", $nomor)) { // cek nomor hanya boleh angka
        $nomorError = "Input Hanya Boleh Angka";
        $is_valid = false;
    } else {
        $nomorError = "";
    }

    // Jika input valid jalankan
    if ($is_valid) {
        // Gunakan prepared statement dengan parameter
        $statement = $db->prepare("SELECT * FROM laporan LEFT JOIN divisi ON laporan.tujuan = divisi.id_divisi WHERE laporan.id = ?");
        $statement->execute([$nomor]);

        // Jika laporan tidak ditemukan tampilkan pesan
        if ($statement->rowCount() < 1) {
            $notFound = "Nomor Sambatan Tidak Ditemukan!";
        } else {
            // Ada laporan, cek apakah ada tanggapan
            $stat = $db->prepare("SELECT * FROM tanggapan WHERE id_laporan = ?");
            $stat->execute([$nomor]);

            if ($stat->rowCount() > 0) {
                $foundreply = true;
            }

            // Pengaduan ditemukan
            $nomorError = "";
            $found = true;
        }
    }
}

// Jika pengguna sudah login, query foto profil pengguna
if ($isLoggedIn) {
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
        // Jika data pengguna tidak ditemukan, atur foto ke null
        $_SESSION['photo'] = null;
    }

    $defaultPhoto = "https://cdn.tailgrids.com/2.2/assets/core-components/images/account-dropdowns/image-1.jpg";
    $query->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Lihat Sambatan | Sambat Rakyat</title>
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
        #main-content {
            flex: 1; /* Ambil sisa ruang di antara header dan footer */
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!--Success Modal Saved-->
    <div class="fixed top-0 right-0 bottom-0 left-0 z-[100] overflow-hidden outline-none hidden " id="failedmodal" tabindex="-1" role="dialog">
        <div class="relative w-auto m-[10px] " role="document">
            <div class="realtive mt-[30%] bg-white bg-clip-padding border border-solid border-[#999] rounded-md outline-none shadow-sm  bg-2">
                <div class="p-[15px] border-b-[1px] border-solid border-[#e5e5e5] ">
                    <h4 class="m-0 leading-[1.42857143] text-center text-danger">Gagal</h4>
                </div>
                <div class="relative p-[15px] ">
                    <p class="text-center">Nomor Sambatan Tidak Ditemukan</p>
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

    <div class="w-full bg-white shadow-lg p-5 flex justify-between items-center z-[100]" >
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

        <!-- content -->
        <div class="p-6 rounded-lg shadow-lg border border-gray-200 mx-auto my-8 w-3/5 h-auto bg-white to-gray-100 flex flex-col" id="main-content">
            <h3 class="text-primary font-bold text-center text-3xl mb-4">Lihat Sambatan</h3>
            <hr class="border-t border-gray-300 mb-6" />
            <div class="flex flex-col items-center flex-grow mb-5">

                <form class=" space-y-6 w-full" role="form" method="post">

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <label for="nomor" class="font-semibold text-gray-700 col-span-1 ml-7">Nomor Sambatan</label>
                        <div class="col-span-2">
                            <input 
                                type="text" 
                                id="nomor" 
                                name="nomor" 
                                placeholder="Masukkan Nomor Sambatan" 
                                class="bg-gray-100 text-gray-500 w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-300"
                                required>
                            <p class="text-sm text-red-600 mt-2"><?= @$nomorError ?></p>
                        </div>
                    </div>
                    <div class="text-center">
                        <button 
                            type="submit" 
                            name="submit" 
                            id="submit"
                            class="bg-[#3E7D60] hover:bg-[#3E7D60]/80 text-white font-bold py-2 px-4 rounded">
                            Lihat Sambatan
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
                                    <div class="flex justify-between">
                                        <h4 class="text-lg font-semibold text-gray-800">Tindak Lanjut Laporan</h4>
                                        <?php 
                                        $status = $key['status'];
                                         if ($status == "Ditanggapi") {
                                            $style_status = "<span class='bg-green-500 text-white px-2 py-1 rounded text-xs'>Ditanggapi</span>";
                                        } elseif ($status == "Terposting") {
                                            $style_status = "<span class='bg-blue-500 text-white px-2 py-1 rounded text-xs'>Terposting</span>";
                                        } else {
                                            $style_status = "<span class='bg-orange-500 text-white px-2 py-1 rounded text-xs'>Menunggu</span>";
                                        }
                                        
                                        ?>
                                        <p class="text-sm text-gray-600"><?= $style_status ?></p>
                                    </div>

                                    <hr class="border-t-2 border-gray-300 my-3">
                                    <?php
// Pastikan koneksi database dibuat sebelumnya
                                    $conn = mysqli_connect("localhost", "root", "", "kp");

                                    // Periksa apakah koneksi berhasil
                                    if (!$conn) {
                                        die("Koneksi gagal: " . mysqli_connect_error());
                                    }

                                    // Query untuk mengambil tanggapan berdasarkan laporan_id
                                    $laporan_id = $key['id'];
                                    $query = "SELECT komen.*, users.username 
                                            FROM komen 
                                            JOIN users ON komen.nama = users.username 
                                            WHERE komen.laporan_id = '$laporan_id' AND role = 'instansi'";
                                    $result = mysqli_query($conn, $query);

                                    // Periksa apakah query berhasil dijalankan
                                    if (!$result) {
                                        die("Query error: " . mysqli_error($conn));
                                    }
                                    ?>

                                    <?php if (mysqli_num_rows($result) > 0): ?>
                                        <?php while ($reply = mysqli_fetch_assoc($result)): ?>
                                            <div class="flex items-start mt-6">
                                                <img class="w-12 h-12 rounded-full border-2 border-blue-600" src="images/avatar/avatar2.png" alt="Avatar Admin">
                                                <div class="ml-6">
                                                    <h5 class="text-blue-700 font-bold"><?= htmlspecialchars($reply['username']); ?></h5>
                                                    <p class="text-gray-800 mt-3"><?= htmlspecialchars($reply['isi']); ?></p>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <p class="text-gray-600 text-sm"><i class="fa fa-exclamation-circle"></i> Belum Ada Tanggapan</p>
                                    <?php endif; ?>

                                    <?php
                                    // Tutup koneksi setelah semua selesai
                                    mysqli_close($conn);
                                    ?>

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

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

</body>

</html>