<?php
session_start();
include "../koneksi.php";
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

        $statement = $conn->query("SELECT * FROM laporan ORDER BY laporan.id DESC LIMIT 1");
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
                    <span class="font-semibold">Admin</span><br>
                    <!-- <span class="text-sm font-mono"><?php 
                    // echo $divisi; ?></span> -->
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

    <!-- 
        <li>
            <a href="tables" class="flex items-center p-2 space-x-2 rounded hover:bg-gray-700">
                <i class="fa fa-fw fa-table"></i>
                <span>Kelola</span>
            </a>
        </li>

     
        <li>
            <a href="export" class="flex items-center p-2 space-x-2 rounded hover:bg-gray-700">
                <i class="fa fa-fw fa-print"></i>
                <span>Ekspor</span>
            </a>
        </li>

    <li>
            <a href="addinstansi" class="flex items-center p-2 space-x-2 rounded hover:bg-gray-700">
                <i class="fa fa-fw fa-code"></i>
                <span>Instansi</span>
            </a>
        </li>
    </ul> -->

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
                <div class="flex items-center justify-between ml-10">
                    <div>
                        <h3 class="font-bold text-green-700 text-xl">Dimas Kendika Fazrulfalah</h3>
                        <p class="text-sm text-gray-500">02 January 2025, 09:43:09</p>
                        <p class="text-gray-700 text-lg ml-auto">Ini gmn ya daftarnya</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Tanggapan -->
    <div class="bg-white shadow-lg rounded-lg p-6 m-auto w-5/6 mt-2">
        <h4 class="font-bold text-gray-700 text-lg mb-3">Tanggapan Anda</h4>
        <textarea 
            class="w-full p-4 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500" 
            rows="5" 
            placeholder="Tulis tanggapan Anda di sini..."
        ></textarea>
        <div class="flex justify-end mt-4">
            <button class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition duration-300">
                Kirim
            </button>
        </div>
    </div>
</div>
        </div>
   <!-- Footer -->
   <!-- <footer class="text-center flex justify-around w-full bg-[#343a40] text-white py-5">
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
                        Jl. Kabupaten No. 1 Purwokerto
                        <br>Banyumas, Jawa Tengah
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
                            <a class="text-white border border-white mx-0 my-[5px] transition-all duration-300 ease-in-out hover:bg-[#3E7D60] hover:border-[#3E7D60] text-center rounded-circle p-1" href="https://www.facebook.com/betterbanyumas/?ref=embed_page">
                                <i class="fa fa-fw fa-facebook"></i>
                            </a>
                        </li>
                        <li class="pl-0 list-none">
                            <a class="text-white border border-white mx-0 my-[5px] transition-all duration-300 ease-in-out hover:bg-[#3E7D60] hover:border-[#3E7D60] text-center rounded-circle p-1 ml-5" href="https://twitter.com/bmshumas?lang=en">
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
                        https://www.banyumaskab.go.id/ <br>
                        banyumaspemkab@gmail.com
                    </p>
                </div>
        </footer>
        
    
    <div class="copyright bg-black">
        <p style="text-align: center; color: white">Copyright &copy; Pemerintahan Kabupaten Banyumas</p>
    </div> -->
<!-- /copyright -->