<?php
    require '../koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = "instansi"; // Ambil nilai role dari form
    
        // Hash password untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Masukkan data ke database
        $query_sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query_sql);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashed_password, $role);
    
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Penambahan akun berhasil!";
            exit();
        } else {
            echo "Penambahan akun Gagal : " . mysqli_error($conn);
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
    <div class="mt-auto">
        <a href="#" class="flex justify-center p-2 text-gray-400 hover:text-white" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
        </a>
    </div>
</div>

<div class="container mx-auto p-4">
    <!-- Breadcrumbs -->
    <!-- <ol class="flex space-x-2 text-gray-700">
        <li><a href="#" class="hover:underline">Da</a></li>
        <li>/</li>
        <li class="font-semibold"><?php 
        // echo $divisi; ?></li>
    </ol>

     -->


            <!-- ./Icon Cards-->

            <!-- Example DataTables Card-->
            <div class="bg-white shadow rounded-lg p-4 mb-4">
    <!-- Header -->
    <div class="flex items-center justify-between border-b pb-2 mb-4">
        <h2 class="text-lg font-semibold text-gray-800">
            <i class="fa fa-table mr-2"></i> Tambah Akun Instansi
        </h2>
        <br>
        <!-- Search Bar -->
        <!-- <div>
            <input type="text" id="searchInput" placeholder="Cari laporan..." class="border border-gray-300 rounded px-2 py-1 text-sm focus:ring focus:ring-blue-300">
        </div> -->
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
            <!-- Input Hidden untuk Role -->
            <input type="hidden" name="role" value="user">
            <div class="mt-4">
                <button type="submit" name="register"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded w-full">
                    Register
                </button>
            </div>
            <div class="mt-4 text-sm text-center text-gray-500">
                <p>Apakah sudah punya akun? <a href="login.php" class="text-blue-500 hover:underline">Login disini</a></p>
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
