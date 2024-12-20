<?php
# @Author: Wahid Ari <wahidari>
# @Date:   8 January, 5:05
# @Copyright: (c) wahidari 2017
?>
<?php
    require_once("private/database.php");
?>
<?php
// fungsi untuk merandom avatar profil
function RandomAvatar(){
    $photoAreas = array("avatar1.png", "avatar2.png", "avatar3.png", "avatar4.png", "avatar5.png", "avatar6.png", "avatar7.png", "avatar8.png", "avatar9.png", "avatar10.png", "avatar11.png");
    $randomNumber = array_rand($photoAreas);
    $randomImage = $photoAreas[$randomNumber];
    echo $randomImage;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Sambat Rakyat</title>
    <link rel="shortcut icon" href="images/samblog.svg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/stylehome.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="js/bootstrap.js"></script>
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css">
    
</head>

<body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.11';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <!--Success Modal Saved-->
    <div class="modal fade" id="successmodalclear" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm " role="document">
            <div class="modal-content bg-2">
                <div class="modal-header ">
                    <h4 class="modal-title text-center text-green">Sukses</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">Pengaduan Berhasil Di Kirim</p>
                    <p class="text-center">Untuk Mengetahui Status Pengaduan</p>
                    <p class="text-center">Silahkan Buka Menu <a href="lihat">Lihat Pengaduan</a> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn button-green" onclick="location.href='index';" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($_GET['status'])) {
    ?>
    <script type="text/javascript">
        $("#successmodalclear").modal();
    </script>
    <?php
        }
    ?>
    <!-- body -->
    <div class="shadow">
        <!-- navbar -->
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
                <a href="index" target="_top">HOME</a>
                <a href="lapor" target="_top">SAMBAT</a>
                <a href="lihat" target="_top">LIHAT PENGADUAN</a>
                <a href="cara" target="_top">PROFIL DINAS</a>
                <a href="faq" target="_top">TENTANG</a>
            </div>

        <?php
        session_start(); // Start session to store user information

        // Check if the user is logged in by checking if 'username' is stored in the session
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        } else {
            $username = null;
        }
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
        <?php endif;?>

        </div>
        <!-- end navbar -->

        <section class=header-main">
            <div class="hero">
                <div class="header-text">
                    <h3>Selamat Datang di</h3>
                    <h1>Website</h1>
                    <h1><span style="color:#3E7D60">Sambat Rakyat</span></h1>
                    <p>Sebagai tempat aspirasi dan keluh kesah bagi <br>
                     masyarakat Banyumas, Jawa Tengah</p>
                    <a href="lapor" class="btn button-green">Laporan Kita</a>
                </div>

                <div class="header-image">
                    <img src="images/orang.png" alt="orang">
                </div>
            </div>
        </section>

        <section class="statistik" style="background-image: url('images/cover_hijau.png');">
            <div class="stat">
                <h2>250</h2>
                <p>Total Laporan</p>
            </div>
            <div class="stat">
                <h2>50</h2>
                <p>Menunggu</p>
            </div>
            <div class="stat">
                <h2>70</h2>
                <p>Proses</p>
            </div>
            <div class="stat">
                <h2>130</h2>
                <p>Selesai</p>
            </div>
        </section>


        <section class="about">
            <div class="about-image">
                <img src="images/about.png" alt="about">
            </div>
            <div class="about-text">
                <h2><span style="color:#3E7D60">Tentang</span></h2>
                <h2>Sambat Rakyat</h2>
                <p>
                    Sambat Rakyat adalah sebuah platform pengaduan masyarakat berbasis website yang dirancang
                    untuk mempermudah warga dalam menyampaikan keluhan atau aspirasi mereka kepada pemerintah
                    secara cepat, transparan, dan efisien. Platform ini bertujuan untuk menjembatani komunikasi
                    antara masyarakat dan pemerintah dengan menyediakan proses pelaporan yang mudah diakses
                    serta transparan. Melalui Sambat Rakyat, pengguna dapat membuat laporan secara langsung,
                    memantau status dan perkembangan pengaduannya, serta menerima notifikasi atau umpan balik
                    terkait tindak lanjut yang diambil pemerintah.
                </p>
                <p class="nkri">NKRI tak berarti penyeragaman, melainkan perwujudan kesetaraan dan kesejahteraan.</p>
                <p>Najwa Sihab</p>
            </div>
        </section>
        
        <div class="main-content">
            <!-- section -->
            <div class="section">
                <div class="row">
                    <!-- laporan Terbaru -->
                    <div class="col-md-8">
                        <br>
                        <h3 class="text-center h3-custom"><span style="color:#3E7D60">Pengaduan</span> Terbaru</h3>
                        <hr class="custom-line"/>
                        <hr>
                        <!-- scroll-laporan -->
                        <div class="scroll-laporan">
                            <?php
                            // Ambil semua record dari tabel laporan
                            $statement = $db->query("SELECT * FROM `laporan` ORDER BY id DESC");
                            foreach ($statement as $key ) {
                                $mysqldate = $key['tanggal'];
                                $phpdate = strtotime($mysqldate);
                                $tanggal = date( 'd F Y, H:i:s', $phpdate);
                                ?>
                                <div class="panel-body card-shadow-2">
                                    <a class="media-left" href="#"><img class="img-circle img-sm form-shadow" src="images/avatar/<?php RandomAvatar(); ?>"></a>
                                    <div class="media-body">
                                        <div>
                                            <h4 class="text-green profil-name" style="font-family: monospace;"><?php echo $key['nama']; ?></h4>
                                            <p class="text-muted text-sm"><i class="fa fa-th fa-fw"></i>  -  <?php echo $tanggal; ?></p>
                                        </div>
                                        <hr class="hr-nama">
                                        <p>
                                            <?php echo $key['isi']; ?>
                                        </p>
                                    </div>
                                    <!-- media body -->
                                </div>
                                <!-- panel body -->
    
                                <?php
                            }
                            ?>
    
                        </div>
                        <!-- end scroll-laporan -->
                    </div>
                    <!-- End Laporan Terbaru -->

                <!-- Social Media Feed -->
                <div class="col-md-4">
                    <br>
                    <!-- header text social-feed -->
                    <h3 class="text-center h3-custom"><span style="color:#3E7D60">Social</span> Feed</h3>
                    <hr class="custom-line"/>
                    <!-- end header text social-feed -->
                    <!-- Twitter Feed -->
                    <div class="box">
                        <div class="box-icon shadow">
                            <span class="fa fa-2x fa-twitter"></span>
                        </div>
                        <div class="info">
                            <h3 class="text-center">twitter</h3>
                            <a class="twitter-timeline" href="https://twitter.com/disdukcapilbkl?ref_src=twsrc%5Etfw" data-width="500" data-height="300">Tweets by disdukcapilbkl</a>
                            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </div>
                    </div>
                    <!-- End Twitter Feed -->
                    <hr>
                    <!-- Facebook Feed -->
                    <div class="box">
                        <div class="box-icon shadow">
                            <span class="fa fa-2x fa-facebook"></span>
                        </div>
                        <div class="info">
                            <h3 class="text-center">facebook</h3>
                            <div class="fb-page" data-height="300" data-width="500" data-href="https://www.facebook.com/dispendukcapilbkl" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                <blockquote cite="https://www.facebook.com/dispendukcapilbkl" class="fb-xfbml-parse-ignore">
                                    <a href="https://www.facebook.com/dispendukcapilbkl">Dispenduk dan Capil Kabupaten Bangkalan</a>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <!-- End Facebook Feed -->
                    <hr>
                    <!-- Facebook Feed -->
                    <div class="box">
                        <!-- End Facebook Feed -->
                    </div>
                    <!-- End Social Media Feed -->
                </div>
                <!-- end row -->
            </div>
            <section class="kritik">
                        <div class="kritik-text">
                            <h1><span style="color:#3E7D60">Kritik</span> & Saran</h1>
                            <p>sebagai bahan evaluasi pengembangan</p>
                        </div>
                        <div class="kritik-form" style="background-image: url('images/cover_hijau.png');">
                            <img src="images/orang.png" alt="kritik">
                            <form class="form-horizontal" role="form" method="post">
                                <input type="text" class="form-control" id="kritik" name="kritik" placeholder="Tuliskan kritik dan saran untuk website">
                                <button type="submit" class="btn btn-primary-custom form-shadow">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

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

    </div>
    <!-- end main-content -->

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
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://www.facebook.com/dispendukcapilbkl/">
                                <i class="fa fa-fw fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://twitter.com/disdukcapilbkl">
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

    <div class="copyright" style="background-color: black">
        <p style="text-align: center; color: white">v-1.0 | Copyright &copy; Pemerintahan Kabupaten Banyumas</p>
    </div>
    <!-- shadow -->
</div>

</body>
</html>
