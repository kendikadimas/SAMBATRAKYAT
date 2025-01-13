<?php
    
    require '../koneksi.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = "Instansi"; // Ambil nilai role dari form
        $id_divisi = $_POST["id_divisi"];
    
        // Hash password untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Mulai transaksi
        mysqli_begin_transaction($conn);
    
        try {
            // Masukkan data ke tabel users
            $query_users = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt_users = mysqli_prepare($conn, $query_users);
            mysqli_stmt_bind_param($stmt_users, "ssss", $username, $email, $hashed_password, $role);
            mysqli_stmt_execute($stmt_users);
    
            // Masukkan data ke tabel instansi
            $query_instansi = "INSERT INTO instansi (username, email, password, role, id_divisi) VALUES (?, ?, ?, ?, ?)";
            $stmt_instansi = mysqli_prepare($conn, $query_instansi);
            mysqli_stmt_bind_param($stmt_instansi, "ssssi", $username, $email, $hashed_password, $role, $id_divisi);
            mysqli_stmt_execute($stmt_instansi);
    
            // Commit transaksi
            mysqli_commit($conn);
    
            echo "<script>alert('Penambahan akun berhasil!');</script>";
        } catch (Exception $e) {
            // Rollback jika ada error
            mysqli_rollback($conn);
            echo "Penambahan akun Gagal: " . $e->getMessage();
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
    <title>Add Instansi - Sambat Rakyat Banyumas</title>
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
    <link rel="stylesheet" href="../css/addinstansi.css">
</head>

<body class="" id="page-top">
    <!-- Navigation-->
    <!-- <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav" style="background-color: #3E7D60;">
        <a class="navbar-brand" href="index">Sambat Rakyat Banyumas</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <nav class="flex justify-between fixed w-full z-10 bg-[#3E7D60] px-4 py-2">
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
                    <span class="font-semibold">Admin</span><br>
                    <!-- <span class="text-sm font-mono"><?php 
                    // echo $divisi; ?></span> -->
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
    <!-- <div class="mt-auto">
        <a href="#" class="flex justify-center p-2 text-gray-400 hover:text-white" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
        </a>
    </div> -->
</div>

<div class="container mx-auto p-4  ml-64 mt-10">

            <!-- Example DataTables Card-->
            <div class="bg-white min-h-screen rounded-lg p-4 mb-4">
    <!-- Header -->
    <div class="flex items-center justify-between border-b pb-2 mb-4">
        <h2 class="text-lg font-semibold text-gray-800">
            <i class="fa fa-table mr-2"></i> Tambah Akun Instansi
        </h2>
        <br>
    </div>
    <button id="addButton" onclick="openModal();" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-5">
    Tambah Akun
    </button>


    <div id="form-instansi" class=" fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
        <!-- Tombol Tutup -->
        <button onclick="closeModal();" class="absolute top-3 right-3 text-red-500 text-xl font-bold hover:text-red-700">
            &times;
        </button>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-medium mb-1">Username</label>
                <input type="text" id="username" name="username" placeholder="Username"
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" id="email" name="email" placeholder="Email"
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" id="password" name="password" placeholder="Password"
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="id_divisi" class="block text-gray-700 font-medium mb-1">Divisi</label>
                <select name="id_divisi" id="id_divisi" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-500" required>
                    <option value="" disabled selected>Pilih Divisi</option>    
                    <option value="1">Sosial dan Kemasyarakatan</option>
                    <option value="2">Keamanan dan Pertahanan</option>
                    <option value="3">Politik dan Pemerintahan</option>
                    <option value="4">Lingkungan dan Alam</option>
                    <option value="5">Infrastruktur dan Transportasi</option>
                </select> 
            </div>

            <!-- Input Hidden untuk Role -->
            <input type="hidden" name="role" value="user">
            <div class="mt-4">
                <button type="submit" name="register"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded w-full">
                    Buat Akun
                </button>
            </div>
        </form>
    </div>
</div>


<script>
  function openModal() {
    // Menampilkan modal dengan menghapus class hidden
    document.getElementById('form-instansi').style.display = 'flex';
  }

  function closeModal() {
    // Menyembunyikan modal dengan menambahkan class hidden
    document.getElementById('form-instansi').style.display = 'none';
  }
</script>

<div class="overflow-x-auto">
        <table id="reportTable" class="min-w-full border-collapse border border-gray-300 text-sm text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(0)">ID</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(1)">Email</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(2)">Username</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(3)">Role</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(4)">Kategori</th>
                    <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" onclick="sortTable(5)">Aksi</th>
                  
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php
                    $statement = $conn->query("SELECT * FROM instansi JOIN divisi ON instansi.id_divisi = divisi.id_divisi WHERE role = 'instansi'");
                    foreach ($statement as $key) {
                ?>
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2"><?php echo $key['id']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $key['email']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $key['username']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $key['role']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $key['nama_divisi']; ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <form method="POST" action="deleteinstansi.php">
                                <input type="hidden" name="id" value="<?php echo $key['id']; ?>">
                                <button type="submit" name="Hapus" 
                                    class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-500 transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

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
</script>

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
