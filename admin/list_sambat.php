<!-- # @Author: kelompok 4
# @Date:   20 Desember 2024
# @Copyright: (c) Sambat Rakyat Banyumas 2024 -->
<?php
    session_start();

    // database
    require_once("database.php");
    logged_admin ();
    // global var
    global $nomor, $foundreply;
    // hapus Balasan laporan berdasarkan id Balasan laporan
    if (isset($_POST['HapusTanggapan'])) {
        $id_hapus_tanggapan = $_POST['id_tanggapan'];
        $id_hapus_tanggapan_laporan = $_POST['id_hapus_tanggapan_laporan'];
        // hapus tanggapan dari tabel tanggapan
        $statement = $db->query("DELETE FROM `tanggapan` WHERE `tanggapan`.`id_tanggapan` = $id_hapus_tanggapan");
        $statt = $db->query("SELECT * FROM `tanggapan` WHERE id_laporan = $id_hapus_tanggapan_laporan");
        $cek = $statt->fetch(PDO::FETCH_ASSOC);
        // jika user terdaftar
        if(!$cek){
            $update = $db->query("UPDATE `laporan` SET `status` = 'Menunggu' WHERE `laporan`.`id` = $id_hapus_tanggapan_laporan");
        }
    }

    // hapus laporan berdasarkan id laporan
    if (isset($_POST['Hapus'])) {
        $id_hapus = $_POST['id_laporan'];
        // hapus semua tanggapan dari laporan yang akan dihapus
        $statement = $db->query("DELETE FROM `tanggapan` WHERE `tanggapan`.`id_laporan` = $id_hapus");
        // hapus laporan
        $statement = $db->query("DELETE FROM `laporan` WHERE `laporan`.`id` = $id_hapus");
    }

    // tanggapi laporan
    if (isset($_POST['Balas'])) {
        // insert tabel tanggapan
        $id_laporan = $_POST['id_laporan'];
        $isi_tanggapan = $_POST['isi_tanggapan'];
        $admin = "Admin";
        $sql = "INSERT INTO `tanggapan` (`id_tanggapan`, `id_laporan`, `admin`, `isi_tanggapan`, `tanggal_tanggapan`) VALUES (NULL, :id_laporan, :admin, :isi_tanggapan, CURRENT_TIMESTAMP)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id_laporan', $id_laporan);
        $stmt->bindValue(':admin', $admin);
        $stmt->bindValue(':isi_tanggapan', htmlspecialchars($isi_tanggapan));
        $stmt->execute();
        // jika ada tanggapan, update status laporan menjadi ditanggapi
        $statement = $db->query("UPDATE `laporan` SET `status` = 'Ditanggapi' WHERE `laporan`.`id` = $id_laporan");
        // kembali ke page tables
        // header("Location: tables");
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/samblog.svg">
    <title>Daftar Sambatan - Sambat Rakyat Banyumas</title>
    <!-- Bootstrap core CSS-->
    <!-- <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet"> -->
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <!-- <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet"> -->
    <!-- Custom styles for this template-->
    <!-- <link href="css/admin.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="" id="page-top">
    <!-- Navigation-->
    <!-- <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav" style="background-color: #3E7D60;">
        <a class="navbar-brand" href="index">Sambat Rakyat Banyumas</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <nav class="flex fixed w-full z-10 justify-between bg-[#3E7D60] px-4 py-2">
    <div>
        <a href="index" class="text-white font-bold">Sambat Rakyat</a>
    </div>
    <div>
    <ul class="flex items-center space-x-4">
    <!-- Laporan Dropdown -->
    <li class="relative">
        <button
            class="flex items-center text-white focus:outline-none"
            id="messagesDropdownToggle"
            onclick="toggleDropdown('messagesDropdownContent')"
        >
            <i class="fa fa-fw fa-envelope"></i>
            <span class="lg:hidden ml-2">
                Laporan <span class="bg-blue-500 text-white rounded-full px-2 text-xs">1 Baru</span>
            </span>
            <span class="hidden lg:block ml-2">
                <i class="fa fa-fw fa-circle text-blue-500"></i>
            </span>
        </button>

        <?php

        $statement = $db->query("SELECT * FROM laporan ORDER BY laporan.id DESC LIMIT 1");
        foreach ($statement as $key) {
            $mysqldate = $key['tanggal'];
            $phpdate = strtotime($mysqldate);
            $tanggal = date('d/m/Y', $phpdate);
        ?>
        <!-- Dropdown Content -->
        <div
            id="messagesDropdownContent"
            class="hidden absolute bg-white shadow-lg rounded mt-2 w-64 right-0 z-50"
        >
            <h6 class="px-4 py-2 font-semibold text-gray-700">Laporan Baru:</h6>
            <div class="border-t border-gray-200"></div>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                <strong class="text-gray-800"><?php echo $key['nama']; ?></strong>
                <span class="text-sm text-gray-500 float-right"><?php echo $tanggal; ?></span>
                <p class="text-sm text-gray-600 mt-1"><?php echo $key['isi']; ?></p>
            </a>
        </div>
        <?php } ?>
    </li>

    <!-- Logout Button -->
    <li>
        <a
            href="#"
            class="text-white flex items-center"
            data-toggle="modal"
            data-target="#exampleModal"
        >
            <i class="fa fa-fw fa-sign-out"></i>
            <span class="ml-2">Logout</span>
        </a>
    </li>
</ul>

<script>
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');
    }

    // Optional: Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        const dropdownToggle = document.getElementById('messagesDropdownToggle');
        const dropdownContent = document.getElementById('messagesDropdownContent');

        if (
            !dropdownToggle.contains(event.target) &&
            !dropdownContent.contains(event.target)
        ) {
            dropdownContent.classList.add('hidden');
        }
    });
</script>

    </div>
</nav>


    <!-- sidebar -->
    <div class="flex h-auto min-h-screen">
    <div class="w-64 h-auto min-h-screen fixed mt-10 bg-gray-800 text-white" id="navbarResponsive">
    <ul class="flex flex-col space-y-2 p-4">
        <!-- Profile Section -->
        <li class="sidebar-profile">
            <div class="flex flex-col items-center text-center">
                <div class="relative">
                    <img alt="profile" src="images/avatar1.png" class="w-20 h-20 rounded-full">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border border-gray-800"></span>
                </div>
                <div class="mt-2">
                    <span class="font-semibold">Instansi</span><br>
                    <!-- <span class="text-sm font-mono"><?php 
                    // echo $divisi; ?></span> -->
                </div>
            </div>
        </li>
    </ul>
</div>

<div class="container mx-auto p-4 ml-64 mt-10">
            <!-- Example DataTables Card-->
            <div class="bg-white shadow rounded-lg p-4 mb-4">
    <!-- Header -->
    <div class="flex items-center justify-between border-b pb-2 mb-4">
        <h2 class="text-lg font-semibold text-gray-800">
            <i class="fa fa-table mr-2"></i> Semua Laporan
        </h2>
        <!-- Search Bar -->
        <div>
            <input type="text" id="searchInput" placeholder="Cari laporan..." class="border border-gray-300 rounded px-2 py-1 text-sm focus:ring focus:ring-blue-300">
        </div>
    </div>

    <?php
    include "../koneksi.php";

    // Pastikan admin sudah login
    if (!isset($_SESSION['id_divisi'])) {
        echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
        exit;
    }

    // Ambil `id_divisi` dari sesi
    $id_divisi = $_SESSION['id_divisi'];

    // Query untuk laporan yang sesuai dengan `id_divisi`
    $query = "SELECT laporan.*, divisi.nama_divisi 
            FROM laporan 
            JOIN divisi ON laporan.tujuan = divisi.id_divisi 
            WHERE laporan.tujuan = ? 
            ORDER BY laporan.id DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_divisi);
    $stmt->execute();
    $result = $stmt->get_result();

?>

    
    


    <!-- Table -->
    <div class="overflow-x-auto">
        <table id="reportTable" class="min-w-full border-collapse border border-gray-300 text-sm text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(0)">Nama</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(1)">Email</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(2)">Telpon</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(3)">Alamat</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(4)">Kategori</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Isi Laporan</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(6)">Tanggal</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(7)">Status</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(8)">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php   
           while ($key = $result->fetch_assoc()) {
                    $mysqldate = $key['tanggal'];
                    $phpdate = strtotime($mysqldate);
                    $tanggal = date('d/m/Y', $phpdate);
                    $status = $key['status'];

                    if ($status == "Ditanggapi") {
                        $style_status = "<span class='bg-green-500 text-white px-2 py-1 rounded text-xs'>Ditanggapi</span>";
                    } elseif ($status == "Terposting") {
                        $style_status = "<span class='bg-blue-500 text-white px-2 py-1 rounded text-xs'>Terposting</span>";
                    } else {
                        $style_status = "<span class='bg-orange-500 text-white px-2 py-1 rounded text-xs'>Menunggu</span>";
                    }
                ?>
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2"><?php echo $key['nama']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $key['email']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $key['telpon']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $key['alamat']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $key['nama_divisi']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $key['isi']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $tanggal; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $style_status; ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex justify-center space-x-2">
                                <!-- Tombol Detail -->
                                <a
                                    class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-500 transition"
                                    href="instansi.php?id=<?php echo $key['id']; ?>"
                                >
                                    Tanggapi
                                </a>
                                
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Search Functionality
document.getElementById('searchInput').addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach(row => {
        const cells = row.getElementsByTagName('td');
        const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(filter));
        row.style.display = match ? '' : 'none';
    });
});

// Sort Functionality
function sortTable(columnIndex) {
    const table = document.getElementById('reportTable');
    const rows = Array.from(table.rows).slice(1); // Skip header row
    const isAsc = table.getAttribute('data-sort-dir') === 'asc';
    const direction = isAsc ? 1 : -1;

    rows.sort((rowA, rowB) => {
        const cellA = rowA.cells[columnIndex].textContent.trim().toLowerCase();
        const cellB = rowB.cells[columnIndex].textContent.trim().toLowerCase();

        if (cellA < cellB) return -1 * direction;
        if (cellA > cellB) return 1 * direction;
        return 0;
    });

    rows.forEach(row => table.tBodies[0].appendChild(row));
    table.setAttribute('data-sort-dir', isAsc ? 'desc' : 'asc');
}

</script>
        <!-- /.container-fluid-->

        <!-- /.content-wrapper-->
        <footer class="bg-gray-800 text-white py-4">
    <div class="container mx-auto text-center">
        <small>Copyright © Pemerintahan Kabupaten Banyumas</small>
    </div>
</footer>


        <!-- Isi masing2 modal, detail, balas dan hapus -->
        <!-- Modal Detail -->
<div id="ModalDetail" 
     class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h5 class="text-lg font-semibold">Detail Laporan</h5>
            <button class="text-gray-400 hover:text-gray-600" onclick="closeModal('ModalDetail<?php echo $key['id']; ?>')">
                &times;
            </button>
        </div>
        <div class="p-4">
            <p class="mb-2"><b>Nama:</b> <?php echo $key['nama']; ?></p>
            <p class="mb-2"><b>Email:</b> <?php echo $key['email']; ?></p>
            <p class="mb-2"><b>Telpon:</b> <?php echo $key['telpon']; ?></p>
            <p class="mb-2"><b>Alamat:</b> <?php echo $key['alamat']; ?></p>
            <p class="mb-2"><b>Tujuan:</b> <?php echo $key['nama_divisi']; ?></p>
            <p class="mb-2"><b>Isi Laporan:</b> <?php echo $key['isi']; ?></p>
            <p class="mb-2"><b>Tanggal:</b> <?php echo $key['tanggal']; ?></p>
            <?php if ($foundreply) : ?>
                <hr class="my-2">
                <p class="mb-2"><b>Tanggapan:</b></p>
                <?php foreach ($stat as $keyy) : ?>
                    <p class="mb-2"><?php echo $keyy['isi_tanggapan']; ?></p>
                    <form method="post">
                        <input type="hidden" name="id_hapus_tanggapan_laporan" value="<?php echo $keyy['id_laporan']; ?>">
                        <input type="hidden" name="id_tanggapan" value="<?php echo $keyy['id_tanggapan']; ?>">
                        <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-500" name="HapusTanggapan">
                            Hapus
                        </button>
                    </form>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="border-t px-4 py-3 text-right">
            <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400" onclick="closeModal('ModalDetail<?php echo $key['id']; ?>')">
                Tutup
            </button>
        </div>
    </div>
</div>

    <!-- Modal Hapus -->
    <div id="ModalHapus" 
        class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm">
            <div class="border-b px-4 py-3">
                <h5 class="text-lg font-semibold">Hapus Laporan</h5>
            </div>
            <div class="p-4 text-center">
                <p class="mb-4">Hapus pengaduan dari <b><?php echo $key['nama']; ?></b>?</p>
            </div>
            <div class="border-t px-4 py-3 text-right space-x-2">
                <form method="post" class="inline-block">
                <input type="hidden" name="id_laporan" value="<?php echo $key['id']; ?>">
                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500" name="Hapus">
                    Hapus
                </button>
                </form>
                <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400" onclick="closeModal('ModalHapus<?php echo $key['id']; ?>')">
                Batal
                </button>
            </div>
        </div>
    </div>

        <!-- Scroll to Top Button-->
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

        <!-- Logout Modal-->
        <div id="exampleModal" class="fixed inset-0 items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-sm w-full">
                <div class="border-b px-4 py-2 flex justify-between items-center">
                    <h5 class="text-lg font-semibold text-gray-800">Yakin Ingin Keluar?</h5>
                    <button class="text-gray-500 hover:text-gray-800" onclick="closeModal('exampleModal')">
                        &times;
                    </button>
                </div>
                <div class="p-4">
                    <p class="text-sm text-gray-600">Pilih "Logout" jika anda ingin mengakhiri sesi.</p>
                </div>
                <div class="border-t px-4 py-2 flex justify-end space-x-2">
                    <button class="bg-gray-300 text-gray-700 px-4 py-1 rounded hover:bg-gray-400" onclick="closeModal('exampleModal')">Batal</button>
                    <a href="logout" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-500">Logout</a>
                </div>
            </div>
        </div>

            <script>
                function openModal(modalId) {
                document.getElementById(modalId).style.display = 'flex';
            }

            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
            }
            </script>

        <!-- Version Info Modal -->
        <!-- Modal -->
        <!-- <div class="modal fade" id="VersionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Admin Versi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 style="text-align : center;">V-1.0</h5>
                        <p style="text-align : center;">Copyright © Pemerintahan Kabupaten Banyumas</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-close card-shadow-2 btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div> -->

    

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Page level plugin JavaScript-->
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/admin.js"></script>
        <!-- Custom scripts for this page-->
        <script src="js/admin-datatables.js"></script>

    </div>
    <!-- /.content-wrapper-->
</body>

</html>