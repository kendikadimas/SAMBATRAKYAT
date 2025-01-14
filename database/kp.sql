-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jan 2025 pada 17.20
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
(1, 'Sosial dan Kemasyarakatan\r\n'),
(2, 'Keamanan dan Pertahanan'),
(3, 'Politik dan Pemerintahan'),
(4, 'Lingkungan dan Alam'),
(5, 'Infrastruktur dan Transportasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `forum`
--

CREATE TABLE `forum` (
  `id` int(11) NOT NULL,
  `topik` text NOT NULL,
  `chat` text NOT NULL,
  `username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `forum_chat`
--

CREATE TABLE `forum_chat` (
  `id` int(11) NOT NULL,
  `id_topik` int(11) NOT NULL,
  `topik` varchar(255) NOT NULL,
  `chat` text NOT NULL,
  `username` varchar(100) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `forum_chat`
--

INSERT INTO `forum_chat` (`id`, `id_topik`, `topik`, `chat`, `username`, `waktu`) VALUES
(1, 1, 'Layanan Publik', 'Halo teman teman, ayo diskusi mengenai layanan publik yang ada di Indonesia!', 'Dimas Kendika', '2025-01-13 21:59:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `instansi`
--

CREATE TABLE `instansi` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','instansi','') NOT NULL DEFAULT 'user',
  `photo` blob NOT NULL,
  `id_divisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `instansi`
--

INSERT INTO `instansi` (`id`, `username`, `email`, `password`, `role`, `photo`, `id_divisi`) VALUES
(5, 'Kepolisian Republik Indonesia', 'kapolri@gmail.com', '$2y$10$TajnuGKMQMijOatC31s4keJtDVObV9Y9sECYc/PbEVb8D8IhQDlaC', 'instansi', '', 2),
(10, 'Kementerian Sosial Republik Indonesia', 'kemensos@gmail.com', '$2y$10$M12WxbjlVyOVb2hX.LEGUuHmDjkbWiC0yvfKM4tDjgeOvhThtiNGq', 'instansi', '', 1),
(11, 'Kementerian Lingkungan Hidup Dan Kehutanan', 'kemenlhk@gmail.com', '$2y$10$zLCvuHiDKkkmaGokw17jDuxTckMjvAAhIci0GmMdYC7.UZeqxrdSK', 'instansi', '', 4),
(12, 'DPRD Jateng', 'dprdjateng@gmail.com', '$2y$10$aRonh6IWuA7McCVNtG6CEOztme4KahSL/KKZU6T2.1io8KHvCrUoC', 'instansi', '', 3),
(13, 'Kementerian Perhubungan', 'kemenhub@gmail.com', '$2y$10$Sim0GdLnbryQCvoKkv7cielr29SAmJY0BNvapFZf/T3Cl2N/9YVSC', 'instansi', '', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `komen`
--

CREATE TABLE `komen` (
  `id` int(11) NOT NULL,
  `laporan_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `komen`
--

INSERT INTO `komen` (`id`, `laporan_id`, `nama`, `isi`, `tanggal`) VALUES
(39, 106, 'Polisi PWT', 'Baik terimakasih atas laporannya, Saudara Sellyjuan. Selanjutnya akan kami tindaklanjuti dengan pemantauan dan pelaksaan patrol di Desa tersebut. Terimakasih banyak', '2025-01-11 21:48:07'),
(40, 108, 'Pemerintah Purwokerto', 'Terimakasih atas sambatannya, akan kami tinjau kembali kemudian.', '2025-01-11 22:07:37'),
(41, 109, 'Kementerian Lingkungan Hidup Dan Kehutanan', 'Baik terimakasih atas sambatannya saudara Dimas Kendika, jadi untuk daerah disitu memang daerah industri dimana PLTU Cilacap beroperasi jadi memang udaranya kotor jadi memang dibutuhkan penanganan segera. Untuk hal itu akan kami sampaikan dan tinjaukan ke yang terkait di lapangan. Terimakasih', '2025-01-13 01:46:23'),
(42, 109, 'Moreno', 'Wah bener emang daerah itu udaranya item banget', '2025-01-13 07:47:13'),
(43, 106, 'Kafah', 'hallow', '2025-01-14 14:10:47'),
(44, 107, 'Kafah', 'wahh', '2025-01-14 14:32:52'),
(45, 109, '', 'wah benar', '2025-01-14 14:34:40'),
(46, 108, '', 'betul', '2025-01-14 14:41:02'),
(47, 108, 'Kafah', 'benar sekali', '2025-01-14 14:43:30'),
(48, 108, 'Kafah', 'Saya setuju', '2025-01-14 14:44:17'),
(49, 106, 'Kafah', 'Benar', '2025-01-14 14:49:25'),
(50, 106, 'Kafah', 'saya setuju', '2025-01-14 14:51:09'),
(51, 108, 'Kafah', 'Setuju banget', '2025-01-14 14:51:33');

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
  `status` varchar(12) NOT NULL,
  `upvotes` int(11) DEFAULT 0,
  `downvotes` int(11) DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `unlikes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `nama`, `email`, `telpon`, `alamat`, `tujuan`, `isi`, `tanggal`, `status`, `upvotes`, `downvotes`, `likes`, `unlikes`) VALUES
(106, 'Sellyjuan Alya Rosalina', 'selju@gmail.com', '081234567890', 'Karangkemiri, Kec. Maos, Kab, Cilacap, Jawa Tengah', 2, 'Pak, tolong dicek untuk di desa saya terdapat banyak maling dan tawuran pada malam hari, hal ini sudah meresahkan warga. Terimakasih', '2025-01-14 12:23:52', 'Ditanggapi', 0, 0, 10, 0),
(107, 'Moreno Hilbran Glenardi', 'morenking@gmail.com', '081234578910', 'Limas Agung, Purwokerto, Jawa Tengah', 1, 'Ini ppn kenapa naik ke 12%, udah barang pada mahal tambah mahal lagi haduh', '2025-01-14 12:24:02', 'Terposting', 0, 0, 8, 0),
(108, 'Moreno', 'morenking@gmail.com', '081234567890', 'Limas Agung, Purwokerto, Jawa Tengah', 4, 'Keknya pemerintah harus banyak banyakin nanem pohon dikawasan Purwokerto deh, panas banget soalnya udah kek gurun', '2025-01-14 12:23:57', 'Ditanggapi', 0, 0, 9, 0),
(109, 'Dimas Kendika', 'dkendika1@gmail.com', '081227587005', 'Kalijaran, Cilacap, Jawa Tengah', 4, 'Tolong untuk daerah cilacap khususnya dekat PLTU kenapa udaranya sangat kotor ya mungkin bisa ditangani kembali untuk solusinya bagaimana', '2025-01-14 12:24:04', 'Ditanggapi', 0, 0, 4, 0);

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
  `role` enum('admin','user','instansi') NOT NULL DEFAULT 'user',
  `photo` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `photo`) VALUES
(14, 'admin', 'admin@gmail.com', '$2y$10$34BrcDn9L9JCS4NKjtPtluWCcGum5cRBtZ0dzn73AO9mBG.Y/8dMy', 'admin', NULL),
(15, 'Nadzare', 'nadzare@gmail.com', '$2y$10$/OMCAo5/AeP1ynI5tPk6K.oA0NIm/6nIAKf9nq8SnT680yAfZOukW', 'user', NULL),
(16, 'Dimas Kendika', 'dkendika1@gmail.com', '$2y$10$TbE6UcFgSoLxW4I/aXp05eeMxpDHj7iwXBF2R.DQZJMrTMmJuX2k6', 'user', NULL),
(20, 'Sellyjuan Alya', 'selju@gmail.com', '$2y$10$wMnjrh1YOXjuK5hmXY/BWep7e2V1HDioASE/8oS7BXC5B5onvcylK', 'user', NULL),
(21, 'Moreno Hilbran Glenardi', 'morenking@gmail.com', '$2y$10$p45MyPOlrcCxQ4.x/UFjC.k4HqNXVEajZnZ2iLNHpMNmUjPrdpmD6', 'user', NULL),
(25, 'Kementerian Lingkungan Hidup Dan Kehutanan', 'kemenlhk@gmail.com', '$2y$10$wZiHx80Hqdk966r2HVKIFePoGSn9J49sOuIixExefTiUj5E1DKyq.', 'instansi', NULL),
(27, 'Kepolisian Republik Indonesia', 'kapolri@gmail.com', '$2y$10$TajnuGKMQMijOatC31s4keJtDVObV9Y9sECYc/PbEVb8D8IhQDlaC', 'instansi', NULL),
(28, 'jajalan', 'jajal@gmail.com', '$2y$10$HmjOsTuSKKUGDKRx0WvYmuKSX3EHK9q3PqCRlEoQBqTLUHI6wvS5q', 'instansi', NULL),
(31, 'fijfjiijf', 'ijsfiji@ifieji', '$2y$10$uP.g.RSKnxy11h0JyI6vruOYLoqUbUUrTaDE1EAvg6HuF81vOztvO', 'instansi', NULL),
(32, 'Kementerian Sosial Republik Indonesia', 'kemensos@gmail.com', '$2y$10$M12WxbjlVyOVb2hX.LEGUuHmDjkbWiC0yvfKM4tDjgeOvhThtiNGq', 'instansi', NULL),
(33, 'Kementerian Lingkungan Hidup Dan Kehutanan', 'kemenlhk@gmail.com', '$2y$10$zLCvuHiDKkkmaGokw17jDuxTckMjvAAhIci0GmMdYC7.UZeqxrdSK', 'instansi', NULL),
(34, 'DPRD Jateng', 'dprdjateng@gmail.com', '$2y$10$aRonh6IWuA7McCVNtG6CEOztme4KahSL/KKZU6T2.1io8KHvCrUoC', 'instansi', NULL),
(35, 'Kementerian Perhubungan', 'kemenhub@gmail.com', '$2y$10$Sim0GdLnbryQCvoKkv7cielr29SAmJY0BNvapFZf/T3Cl2N/9YVSC', 'instansi', NULL),
(36, 'Kafah', 'zartampan@gmail.com', '$2y$10$qevEd2Xc6fpE0ikm9eUTdObSfkhTwug2HjFKz3Zssp/nuQZpi5EbW', 'user', NULL);

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
-- Indeks untuk tabel `forum_chat`
--
ALTER TABLE `forum_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `instansi`
--
ALTER TABLE `instansi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_divisi` (`id_divisi`);

--
-- Indeks untuk tabel `komen`
--
ALTER TABLE `komen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_id` (`laporan_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `forum_chat`
--
ALTER TABLE `forum_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `komen`
--
ALTER TABLE `komen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `id_tanggapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`divisi`) REFERENCES `divisi` (`id_divisi`);

--
-- Ketidakleluasaan untuk tabel `instansi`
--
ALTER TABLE `instansi`
  ADD CONSTRAINT `fk_divisi` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komen`
--
ALTER TABLE `komen`
  ADD CONSTRAINT `komen_ibfk_1` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`tujuan`) REFERENCES `divisi` (`id_divisi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
