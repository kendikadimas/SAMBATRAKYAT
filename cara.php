<!-- # @Author: kelompok 4
# @Date:   20 Desember 2024
# @Copyright: (c) Sambat Rakyat Banyumas 2024 -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Profil Dinas | Sambat Rakyat</title>
    <link rel="shortcut icon" href="images/samblog.svg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/cara.css" rel="stylesheet">

</head>

<body>

        <div class="shadow">
        <?php
// Fungsi untuk menentukan halaman aktif
function isActive($page) {
    return basename($_SERVER['PHP_SELF']) == $page ? 'active-menu' : '';
}
?>
    <div class="navbar">
        <div class="main-logo">
            <a href="/">
                <img src="images/samblog.svg" alt="Logo Sambat" class="main-logo">
            </a>
            <div class="sub-tem">
                <h1>Sambat rakyat</h1>
            </div>
        </div>

        <div class="menu">
            <a href="index" class="<?= isActive('index.php') ?>" target="_top">HOME</a>
            <a href="lapor" class="<?= isActive('lapor.php') ?>" target="_top">SAMBAT</a>
            <a href="lihat" class="<?= isActive('lihat.php') ?>" target="_top">LIHAT PENGADUAN</a>
            <a href="cara" class="<?= isActive('cara.php') ?>" target="_top">PROFIL DINAS</a>
            <a href="faq" class="<?= isActive('faq.php') ?>" target="_top">TENTANG</a>
        </div>

        <?php
        session_start(); // Start session to store user information
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
        ?>

        <?php if ($username) : ?> 
            <div class="logsig">
                <a href="/SAMBATRAKYAT/profile.php">
                    <button class="login-new-btn">
                        <?= htmlspecialchars($username) ?>
                    </button>
                </a>
            </div>
        <?php else: ?>
            <div class="logsig">
                <a href="/SAMBATRAKYAT/login.php">
                    <button class="login-btn">Masuk</button>
                </a>
                <a href="/SAMBATRAKYAT/signin.php">
                    <button class="signup-btn">Daftar</button>
                </a>
            </div>
        <?php endif; ?>
    </div>


            <!-- content -->
            <div class="main-content">

            <div class="container-news">
        <!-- Header Section -->
        <div class="header-news">
            <img src="images/banyu.jpg" alt="News Header" class="image-news">
        </div>

        <!-- Author Section -->
        <div class="author-news">
            <p class="name-author">Alun-alun Banyumas</p>
            <p class="publish-date">Humas, Pemerintahan Banyumas</p>
        </div>

        <!-- Title Section -->
        <div class="title-news">
            <h1>Pemerintah Kabupaten Banyumas</h1>
        </div>

        <!-- Content Section -->
        <div class="content-news">
            <p>
            Kabupaten Banyumas adalah sebuah wilayah di Provinsi Jawa Tengah, Indonesia, yang kaya akan sejarah dan budaya. 
            Banyumas berawal dari pembentukan Kadipaten Banyumas pada tahun 1582 oleh Raden Joko Kahiman. Nama "Banyumas"
            sendiri berasal dari kata "Banyu" yang berarti air dan "Mas" yang berarti emas, menggambarkan sumber daya alam yang berharga,
            khususnya air yang melimpah. Kabupaten ini terletak di bagian barat daya Jawa Tengah dengan ibu kota di Purwokerto, sebuah kota
            yang menjadi pusat kegiatan ekonomi, pendidikan, dan pemerintahan.
            </p>
            <p>
            Secara geografis, Banyumas dikelilingi oleh perbukitan dan pegunungan, termasuk Gunung Slamet, yang merupakan gunung tertinggi di Jawa Tengah. 
            Kabupaten ini memiliki wilayah yang subur dengan aliran sungai besar seperti Sungai Serayu yang melintasi wilayahnya, menjadikannya daerah yang 
            potensial untuk sektor pertanian dan pariwisata.
            </p>

            <p>
            Kabupaten Banyumas dikenal dengan kekayaan budaya dan seni tradisionalnya, seperti Ebeg (kesenian kuda lumping), Calung, dan Lengger. 
            Bahasa Jawa yang digunakan di Banyumas memiliki dialek khas yang dikenal sebagai "Basa Ngapak," yang memiliki ciri pelafalan lugas dan intonasi yang unik.
            </p>

            <p>
                Pariwisata di Banyumas berkembang pesat dengan berbagai destinasi menarik, antara lain:

                Baturaden: Sebuah kawasan wisata pegunungan dengan udara sejuk, air terjun, dan taman rekreasi.
                Curug Cipendok: Air terjun indah yang menjadi daya tarik wisata alam.
                Museum Bank Rakyat Indonesia (BRI): Sebuah museum yang mendokumentasikan sejarah perbankan nasional, karena BRI pertama kali didirikan di Purwokerto.
                Telaga Sunyi: Wisata air yang menawarkan suasana tenang dan pemandangan alami.
            </p>

            <p>
                Kondisi Demografis dan Ekonomi
                Kabupaten Banyumas memiliki populasi lebih dari 1,7 juta jiwa (data 2024), dengan mayoritas penduduknya bermata pencaharian di bidang pertanian, perdagangan,
                dan jasa. Kabupaten ini juga memiliki sektor pendidikan yang maju dengan keberadaan Universitas Jenderal Soedirman (Unsoed) di Purwokerto, yang menjadi salah
                satu pusat pengembangan sumber daya manusia di Jawa Tengah.
            </p>

            <p>
            Pemerintahan Kabupaten Banyumas
            Pemerintahan Kabupaten Banyumas dijalankan oleh Bupati dan Wakil Bupati, yang memimpin di bawah sistem pemerintahan daerah berdasarkan Undang-Undang Otonomi Daerah. 
            Kantor pemerintahan pusat terletak di Purwokerto, yang juga menjadi pusat administrasi kabupaten. Struktur pemerintahan ini terdiri dari beberapa dinas dan badan yang 
            menangani berbagai sektor, seperti pendidikan, kesehatan, infrastruktur, dan pariwisata.
            </p>

            <p>
            Kabupaten Banyumas dibagi menjadi 27 kecamatan, masing-masing dipimpin oleh seorang camat. Kecamatan ini terdiri dari desa dan kelurahan yang jumlahnya mencapai ratusan, 
            dengan fokus utama pada pengelolaan pembangunan yang merata dan peningkatan kesejahteraan masyarakat.
            </p>

            <p>
            Dalam hal pelayanan publik, Kabupaten Banyumas telah mengembangkan beberapa inovasi berbasis teknologi, seperti sistem pelayanan satu pintu (OSS) dan aplikasi layanan digital 
            untuk mempermudah akses masyarakat ke layanan pemerintah. Selain itu, program pembangunan infrastruktur menjadi salah satu prioritas, seperti pengembangan jalan, irigasi, dan fasilitas publik
            </p>

            <p>
            Potensi Pembangunan dan Inovasi
            Kabupaten Banyumas memiliki potensi besar di bidang pertanian, industri kreatif, dan pariwisata. Pemerintah daerah terus mendorong pengembangan UMKM (Usaha Mikro, Kecil, dan Menengah) 
            melalui berbagai pelatihan dan akses pembiayaan. Sementara itu, sektor pariwisata dikembangkan dengan fokus pada kelestarian lingkungan dan pemberdayaan masyarakat lokal.
            </p>
            <p>
            Sebagai daerah yang kaya akan sejarah, budaya, dan sumber daya alam, Banyumas memiliki visi untuk menjadi kabupaten yang maju dan berdaya saing di tingkat nasional. Pemerintah daerah 
            juga aktif dalam program-program keberlanjutan, seperti konservasi sumber daya air, pengelolaan limbah, dan penggunaan energi terbarukan.
            </p>
            <p>
            Dengan perpaduan tradisi dan modernitas, Kabupaten Banyumas tidak hanya menjadi tempat yang nyaman untuk ditinggali tetapi juga menarik untuk dikunjungi. Peran pemerintah dalam mengelola
            potensi ini sangat signifikan, terutama dalam mewujudkan pembangunan yang inklusif dan berkelanjutan.
            </p>
        </div>
    </div>
                  <!-- link to top -->
            <a id="top" href="#" onclick="topFunction()">
                <i class="fa fa-arrow-circle-up"></i>
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


            <!-- end main-content -->
            </div>

            <hr>

            <!-- Footer -->
       <!-- Footer -->
       <footer class="footer text-center">
            <div class="row">
                <div class="col-md-4 mb-5 mb-lg-0">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-map-marker"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Kantor</h4>
                        </li>
                    </ul>
                    <p class="mb-0">
                        Jl. Kabupaten No. 1 Purwokerto
                        <br>Banyumas, Jawa Tengah
                    </p>
                </div>
                <div class="col-md-4 mb-5 mb-lg-0">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-rss"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Sosial Media</h4>
                        </li>
                    </ul>
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://www.facebook.com/betterbanyumas/?ref=embed_page">
                                <i class="fa fa-fw fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://twitter.com/bmshumas?lang=en">
                                <i class="fa fa-fw fa-twitter"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-envelope-o"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Kontak</h4>
                        </li>
                    </ul>
                    <p class="mb-0">
                        +62 858-1417-4267 <br>
                        https://www.banyumaskab.go.id/ <br>
                        banyumaspemkab@gmail.com
                    </p>
                </div>
            </div>
        </footer>
        <!-- /footer -->

    <div class="copyright">
        <p style="text-align: center; color: white">v-1.0 | Copyright &copy; Pemerintahan Kabupaten Banyumas</p>
    </div>
                <!-- shadow -->
        </div>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="js/bootstrap.js"></script>

</body>
</html>
