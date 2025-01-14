<?php
session_start();
include "../koneksi.php";
require '../koneksi.php'; // File koneksi database
$id = $_GET['id'] ?? 0;

// Query untuk mendapatkan detail laporan
$query = $conn->prepare("SELECT laporan.*, divisi.nama_divisi FROM laporan JOIN divisi ON laporan.tujuan = divisi.id_divisi WHERE laporan.id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

// Jika laporan tidak ditemukan
if ($result->num_rows === 0) {
    die("Laporan tidak ditemukan.");
}

$laporan = $result->fetch_assoc();
$query->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instansi</title>
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
        include "../koneksi.php";
        $statement = $conn->query("SELECT * FROM laporan ORDER BY laporan.id DESC LIMIT 1");
        
        if (!$statement) {
            die("Query gagal: " . $conn->error);
        }
        
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
        <?php 
    $result->free(); 
    } ?>

    </li>

    <!-- Logout Button -->
    <!-- <li>
        <a
            href="#"
            class="text-white flex items-center"
            data-toggle="modal"
            data-target="#exampleModal"
        >
            <i class="fa fa-fw fa-sign-out"></i>
            <span class="ml-2">Logout</span>
        </a>
    </li> -->
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
    <div class="flex h-screen">
    <div class="w-64 h-auto bg-gray-800 text-white" id="navbarResponsive">
    <ul class="flex flex-col space-y-2 justify-between p-4">
        <!-- Profile Section -->
        <li class="sidebar-profile">
            <div class="flex flex-col items-center text-center">
                <div class="relative">
                    <img alt="profile" src="images/avatar1.png" class="w-20 h-20 rounded-full">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border border-gray-800"></span>
                </div>
                <div class="mt-2">
                    <span class="font-semibold">Instansi</span><br>
        
                </div>
            </div>
        </li>

        <!-- Dashboard Link -->
       <li>
            <a href="list_sambat" class="flex items-center p-2 space-x-2 rounded hover:bg-gray-700">
                <i class="fa fa-fw fa-dashboard"></i>
                <span>Kembali</span>
            </a>
        </li>

    <!-- Sidebar Toggler -->
    <div class="mt-auto">
        <a href="#" class="flex justify-center p-2 text-gray-400 hover:text-white" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
        </a>
    </div>
</div>
<!-- end navbar -->
<!-- answer report page -->
<div  style="background-image: url('../images/backsginin.png');" class="h-[40vh] w-full bg-cover bg-center bg-no-repeat p-10 mb-[350px]">
    <!-- Bagian Pertanyaan -->
    <div class="bg-white shadow-lg rounded-lg p-6 m-auto w-5/6 z-50 pt-10">
        <div class="flex items-center gap-4 mb-4 ml-10">
            <img src="https://via.placeholder.com/50" alt="Profile" class="w-20 h-20 rounded-full">
            <div>
            <?php
                    ?>
                    <div class="flex items-center justify-between ml-10">
                        <div>
                            <h3 class="font-bold text-green-700 text-xl"><?php echo htmlspecialchars($laporan['nama']); ?></h3>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($tanggal); ?></p>
                            <p class="text-gray-700 text-lg ml-auto"><?php echo htmlspecialchars($laporan['isi']); ?></p>
                        </div>
                    </div>
                    <?php
                //DEBUG 
                $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;

                // Query untuk mendapatkan detail laporan
                $query = $conn->prepare("SELECT laporan.*, divisi.nama_divisi FROM laporan JOIN divisi ON laporan.tujuan = divisi.id_divisi WHERE laporan.id = ?");
                if (!$query) {
                    die("Query gagal dipersiapkan: " . $conn->error); // Debug jika prepare gagal
                }

                $query->bind_param('i', $id); // Bind parameter ID
                if (!$query->execute()) {
                    die("Query gagal dieksekusi: " . $query->error); // Debug jika eksekusi gagal
                }

                $result = $query->get_result();
                $laporan = $result->fetch_assoc();

                // Jika laporan tidak ditemukan
                if (!$laporan) {
                    echo "<p class='text-red-500 text-center'>Laporan tidak ditemukan.</p>";
                    exit(); // Hentikan eksekusi jika laporan tidak ditemukan
                }

                ?>
                
            </div>
        </div>
    </div>

    <!-- Bagian Tanggapan -->
<div class="bg-white shadow-lg rounded-lg p-6 m-auto w-5/6 mt-2">
    <h4 class="font-bold text-gray-700 text-lg mb-3">Tanggapan Anda</h4>
    <form method="POST" action="ditanggapi.php">
        <input type="hidden" name="laporan_id" value="<?php echo $laporan['id']; ?>">
        <?php 
        $id_instansi = $_SESSION['id'];
        $query = $conn->prepare("SELECT username FROM users WHERE id = ? AND role='instansi'");
        $query->bind_param("i", $id_instansi);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_assoc();
        ?>
        <input type="hidden" name="nama" value="<?php echo $user['username']; ?>"> <!-- Nama penanggap -->
        <textarea 
            class="w-full p-4 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500" 
            rows="5" 
            name="isi"
            placeholder="Tulis tanggapan Anda di sini..."
        ></textarea>
        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition duration-300">
                Kirim
            </button>
        </div>
    </form>
</div>

<!-- Bagian List Tanggapan -->
<div class="bg-white shadow-lg rounded-lg p-6 m-auto w-5/6 mt-2 h-auto" >
    <h4 class="font-bold text-gray-700 text-lg mb-3">Tanggapan</h4>
    <?php
$tanggapan_query = $conn->prepare("
    SELECT komen.*, users.username 
    FROM komen 
    JOIN users ON komen.nama = users.username 
    WHERE komen.laporan_id = ? AND role='instansi'
");
$tanggapan_query->bind_param("i", $laporan['id']);
$tanggapan_query->execute();
$result = $tanggapan_query->get_result();
$tanggapan = $result->fetch_all(MYSQLI_ASSOC);
?>


<?php if (count($tanggapan) > 0): ?>
    <?php foreach ($tanggapan as $komen): ?>
        <div class="mb-4">
            <h5 class="font-bold text-gray-900"><?php echo htmlspecialchars($komen['username']); ?></h5>
            <p class="text-sm text-gray-500"><?php echo date('d F Y, H:i', strtotime($komen['tanggal'])); ?></p>
            <p class="text-gray-700"><?php echo htmlspecialchars($komen['isi']); ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-gray-500">Belum ada tanggapan.</p>
<?php endif; ?>
<!-- 
<div id="exampleModal" class="fixed inset-0 items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50 ">
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
</script> -->

</div>
