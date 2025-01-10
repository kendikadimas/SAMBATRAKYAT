
<?php
    require_once("database.php"); // koneksi DB
    require_once 'auth.php';
    
    logged_admin ();
    global $total_laporan_masuk, $total_laporan_menunggu, $total_laporan_ditanggapi;
    if ($id_admin > 0) {
        foreach($db->query("SELECT COUNT(*) FROM laporan WHERE laporan.tujuan = $id_admin") as $row) {
            $total_laporan_masuk = $row['COUNT(*)'];
        }

        foreach($db->query("SELECT COUNT(*) FROM laporan WHERE status = \"Ditanggapi\" AND laporan.tujuan = $id_admin") as $row) {
            $total_laporan_ditanggapi = $row['COUNT(*)'];
        }

        foreach($db->query("SELECT COUNT(*) FROM laporan WHERE status = \"Menunggu\" AND laporan.tujuan = $id_admin") as $row) {
            $total_laporan_menunggu = $row['COUNT(*)'];
        }
    } else {
        foreach($db->query("SELECT COUNT(*) FROM laporan") as $row) {
            $total_laporan_masuk = $row['COUNT(*)'];
        }

        foreach($db->query("SELECT COUNT(*) FROM laporan WHERE status = \"Ditanggapi\"") as $row) {
            $total_laporan_ditanggapi = $row['COUNT(*)'];
        }

        foreach($db->query("SELECT COUNT(*) FROM laporan WHERE status = \"Menunggu\"") as $row) {
            $total_laporan_menunggu = $row['COUNT(*)'];
        }
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
    <title>Dashboard - Sambat Rakyat Banyumas</title>
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

        <nav class="flex justify-between bg-[#3E7D60] px-4 py-2">
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
    <div class="flex h-auto">
    <div class="w-64 h-auto bg-gray-800 text-white" id="navbarResponsive">
    <ul class="flex flex-col space-y-2 p-4">
        <!-- Profile Section -->
        <li class="sidebar-profile">
            <div class="flex flex-col items-center text-center">
                <div class="relative">
                    <img alt="profile" src="images/avatar1.png" class="w-20 h-20 rounded-full">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border border-gray-800"></span>
                </div>
                <div class="mt-2">
                    <span class="font-semibold">Admin</span><br>
                    <span class="text-sm font-mono"><?php echo $divisi; ?></span>
                </div>
            </div>
        </li>

        <!-- Dashboard Link -->
        <li>
            <a href="index" class="flex items-center p-2 space-x-2 rounded hover:bg-gray-700">
                <i class="fa fa-fw fa-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Kelola Link -->
        <li>
            <a href="tables" class="flex items-center p-2 space-x-2 rounded hover:bg-gray-700">
                <i class="fa fa-fw fa-table"></i>
                <span>Kelola</span>
            </a>
        </li>

        <!-- Ekspor Link -->
        <li>
            <a href="export" class="flex items-center p-2 space-x-2 rounded hover:bg-gray-700">
                <i class="fa fa-fw fa-print"></i>
                <span>Ekspor</span>
            </a>
        </li>

        <!-- Instansi Link -->
        <li>
            <a href="addinstansi" class="flex items-center p-2 space-x-2 rounded hover:bg-gray-700">
                <i class="fa fa-fw fa-code"></i>
                <span>Instansi</span>
            </a>
        </li>
    </ul>

    <!-- Sidebar Toggler -->
    <div class="mt-auto">
        <a href="#" class="flex justify-center p-2 text-gray-400 hover:text-white" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
        </a>
    </div>
</div>

<div class="container mx-auto p-4">
    <!-- Breadcrumbs -->
    <!-- <ol class="flex space-x-2 text-gray-700">
        <li><a href="#" class="hover:underline">Dashboard</a></li>
        <li>/</li>
        <li class="font-semibold"><?php echo $divisi; ?></li>
    </ol> -->

    <!-- Icon Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 my-4">
        <!-- Card: Laporan Masuk -->
        <div class="bg-blue-500 text-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 flex items-center space-x-4">
                <div>
                    <i class="fa fa-comments-o text-3xl"></i>
                </div>
                <div>
                    <p class="text-lg font-bold"><?php echo $total_laporan_masuk; ?> Laporan Masuk</p>
                </div>
            </div>
            <a href="tables" class="block bg-blue-600 hover:bg-blue-700 text-white text-sm text-center py-2">
                Total Laporan Masuk <i class="fa fa-angle-right ml-2"></i>
            </a>
        </div>

        <!-- Card: Belum Ditanggapi -->
        <div class="bg-red-500 text-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 flex items-center space-x-4">
                <div>
                    <i class="fa fa-minus-circle text-3xl"></i>
                </div>
                <div>
                    <p class="text-lg font-bold"><?php echo $total_laporan_menunggu; ?> Belum Ditanggapi</p>
                </div>
            </div>
            <a href="#" class="block bg-red-600 hover:bg-red-700 text-white text-sm text-center py-2">
                Belum Ditanggapi <i class="fa fa-angle-right ml-2"></i>
            </a>
        </div>

        <!-- Card: Sudah Ditanggapi -->
        <div class="bg-green-500 text-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 flex items-center space-x-4">
                <div>
                    <i class="fa fa-check-square text-3xl"></i>
                </div>
                <div>
                    <p class="text-lg font-bold"><?php echo $total_laporan_ditanggapi; ?> Sudah Ditanggapi</p>
                </div>
            </div>
            <a href="#" class="block bg-green-600 hover:bg-green-700 text-white text-sm text-center py-2">
                Sudah Ditanggapi <i class="fa fa-angle-right ml-2"></i>
            </a>
        </div>
    </div>

    <!-- ./Icon Cards-->

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

    <!-- Table -->
    <div class="overflow-x-auto">
        <table id="reportTable" class="min-w-full border-collapse border border-gray-300 text-sm text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(0)">Nama</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(1)">Email</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(2)">Telpon</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(3)">Alamat</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(4)">Tujuan</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Isi Laporan</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(6)">Tanggal</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(7)">Status</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php
                if ($id_admin > 0) {
                    $statement = $db->query("SELECT * FROM laporan, divisi WHERE laporan.tujuan = divisi.id_divisi AND laporan.tujuan = $id_admin ORDER BY laporan.id DESC");
                } else {
                    $statement = $db->query("SELECT * FROM laporan, divisi WHERE laporan.tujuan = divisi.id_divisi ORDER BY laporan.id DESC");
                }

                foreach ($statement as $key) {
                    $mysqldate = $key['tanggal'];
                    $phpdate = strtotime($mysqldate);
                    $tanggal = date('d/m/Y', $phpdate);
                    $status = $key['status'];

                    if ($status == "Ditanggapi") {
                        $style_status = "<span class='bg-green-500 text-white px-2 py-1 rounded text-xs'>Ditanggapi</span>";
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
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="mt-4 text-gray-500 text-xs">
        Updated yesterday at 11:59 PM
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

<!-- Scroll to Top Button -->
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
       <!-- Logout Modal -->
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

</body>

</html>