-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Des 2024 pada 10.33
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `divisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
 
--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `divisi`) VALUES
(0, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 0),
(1, 'admin1', '25f43b1486ad95a1398e3eeb3d83bc4010015fcc9bedb35b432e00298d5021f7', 1),
(2, 'admin2', '1c142b2d01aa34e9a36bde480645a57fd69e14155dacfab5a3f9257b77fdc8d8', 2),
(3, 'admin3', '4fc2b5673a201ad9b1fc03dcb346e1baad44351daa0503d5534b4dfdcc4332e0', 3),
(4, 'admin4', '110198831a426807bccd9dbdf54b6dcb5298bc5d31ac49069e0ba3d210d970ae', 4),
(5, 'admin5', 'admin12345', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`) VALUES
(0, 'Super Admin'),
(1, 'Pelayanan Pendaftaran Penduduk'),
(2, 'Pelayanan Pencatatan Sipil'),
(3, 'Pengelolaan Informasi Administrasi Kependudukan'),
(4, 'Pemanfaatan Data Dan Inovasi Pelayanan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `nama` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `telpon` varchar(12) NOT NULL,
  `alamat` varchar(256) NOT NULL,
  `tujuan` int(11) NOT NULL,
  `isi` varchar(2048) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `nama`, `email`, `telpon`, `alamat`, `tujuan`, `isi`, `tanggal`, `status`) VALUES
(100, 'Wahid Ari', 'wahiid.ari@gmail.com', '087850866665', 'Mlajah', 1, 'Apakah Aplikasi Pengaduan Masyarakat Dispendukcapil Bangkalan ini?', '2018-05-23 06:17:29', 'Ditanggapi'),
(101, 'Surya Ray', 'ray@gmail.com', '087123123444', 'Bangkalan', 2, 'Apakah nomor pengaduan itu dan apa yang harus saya lakukan terhadap nomor pengaduan ini? ', '2018-05-23 07:25:00', 'Ditanggapi'),
(102, 'Faris Ikhsan', 'faris@gmail.com', '087865786345', 'Bangkalan', 4, 'Apakah kerahasiaan identitas saya sebagai pengadu/pelapor terjaga? ', '2018-05-23 07:37:55', 'Menunggu'),
(103, 'Robbi Pradiantoro', 'robi@gmail.com', '081233824715', 'Bangkalan', 3, 'Berapa lama respon atas pengaduan yang disampaikan diberikan kepada pelapor? ', '2018-06-09 06:40:44', 'Ditanggapi'),
(104, 'Nadzare Kafah Alfatiha', 'zartampan@gmail.com', '093043045060', 'Kost Griya Satria 05', 4, 'Lembaga inovasi sungguh slow respon terhadap client sehingga membuat antrian panjang dan tidak efisien', '2024-12-19 12:37:45', 'Ditanggapi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tanggapan`
--

CREATE TABLE `tanggapan` (
  `id_tanggapan` int(11) NOT NULL,
  `id_laporan` int(11) NOT NULL,
  `admin` varchar(64) NOT NULL,
  `isi_tanggapan` varchar(2048) NOT NULL,
  `tanggal_tanggapan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tanggapan`
--

INSERT INTO `tanggapan` (`id_tanggapan`, `id_laporan`, `admin`, `isi_tanggapan`, `tanggal_tanggapan`) VALUES
(1, 100, 'admin', 'Aplikasi Pengaduan Masyarakat Dispendukcapil Bangkalan adalah aplikasi pengelolaan dan tindak lanjut pengaduan serta pelaporan hasil pengelolaan pengaduan yang disediakan oleh Dispendukcapil Bangkalan sebagai salah satu sarana bagi setiap pejabat/pegawai Dispendukcapil Bangkalan sebagai pihak internal maupun masyarakat luas pengguna layanan Dispendukcapil Bangkalan sebagai pihak eksternal untuk melaporkan dugaan adanya pelanggaran dan/atau ketidakpuasan terhadap pelayanan yang dilakukan/diberikan oleh pejabat/pegawai Dispendukcapil Bangkalan.', '2018-03-25 14:44:57'),
(2, 101, 'Admin', 'Nomor pengaduan adalah nomor yang digunakan sebagai identitas dari sebuah laporan atau pengaduan yang didapatkan ketika pelapor menyampaikan laporan melalui aplikasi ini. Simpan dengan baik nomor pengaduan yang Anda peroleh, jangan sampai tercecer dan diketahui oleh pihak yang tidak berhak karena pelayanan untuk mengetahui status tindak lanjut pengaduan yang disampaikan hanya dapat diberikan melalui nomor pengaduan tersebut.', '2018-05-23 07:26:11'),
(3, 103, 'Admin', 'Sesuai dengan KMK 149 tahun 2011 jawaban/respon atas pengaduan yang disampaikan wajib diberikan dalam kurun waktu paling lambat 30 (tiga puluh) hari terhitung sejak pengaduan diterima.', '2018-06-09 06:40:44'),
(4, 103, 'Admin', 'Untuk respon yang disampaikan tertulis melalui surat dapat diberikan apabila pelapor mencantumkan identitas secara jelas (nama dan alamat koresponden). Untuk respon dari media pengaduan lainnya akan disampaikan dan diberikan sesuai identitas pelapor yang dicantumkan dalam media pengaduan tersebut.', '2018-06-09 06:40:59'),
(5, 104, 'Admin', 'hallo terimakasih nadare tampan sudah mengisi aduan yang kau punyaa jadii semoga kamu berjodoh denganya', '2024-12-19 12:37:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(14, 'admin', 'admin@gmail.com', '$2y$10$QgY7JvLWxDP5eU5SYVGYIezRr.th8/pfnjPRKoV5nN2F2Yu.SaZLm', 'admin'),
(15, 'Nadzare', 'nadzare@gmail.com', '$2y$10$/OMCAo5/AeP1ynI5tPk6K.oA0NIm/6nIAKf9nq8SnT680yAfZOukW', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `divisi` (`divisi`);

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tujuan` (`tujuan`);

--
-- Indeks untuk tabel `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD PRIMARY KEY (`id_tanggapan`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `id_tanggapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`divisi`) REFERENCES `divisi` (`id_divisi`);

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`tujuan`) REFERENCES `divisi` (`id_divisi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
