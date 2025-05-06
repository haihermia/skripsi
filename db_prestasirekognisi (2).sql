-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 01:31 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_prestasirekognisi`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `program_studi` varchar(100) NOT NULL,
  `fakultas` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nama_mahasiswa`, `email`, `program_studi`, `fakultas`, `id_user`) VALUES
(3, '213100200', 'Hermia Mujiyasari', '213100200@almaata.ac.id', 'sistem informasi', 'fakultas komputer dan teknik', 9),
(5, '213100254', 'fani dwi ', '213100254@almaata.ac.id', 'sistem informasi', 'fakultas komputer dan teknik', 16);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_verifikasi`
--

CREATE TABLE `pengajuan_verifikasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `jenis_pengajuan` varchar(50) NOT NULL,
  `dokumen` varchar(255) NOT NULL,
  `tanggal_pengajuan` date DEFAULT current_timestamp(),
  `status` enum('pending','diterima','ditolak') DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `tanggal_verifikasi` date DEFAULT NULL,
  `id_mahasiswa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengajuan_verifikasi`
--

INSERT INTO `pengajuan_verifikasi` (`id`, `nama`, `email`, `jenis_pengajuan`, `dokumen`, `tanggal_pengajuan`, `status`, `catatan`, `tanggal_verifikasi`, `id_mahasiswa`) VALUES
(1, 'hermia mujiyasari', '213100200@almaata.ac.id', '', '1741315819.jpg', '2025-02-28', 'diterima', 'sudah acc', '2025-03-07', 9),
(2, 'hermia mujiyasari', '213100200@almaata.ac.id', 'data rekognisi', '1741787688.png', '2025-02-28', 'pending', NULL, NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `nama_prestasi` varchar(255) DEFAULT NULL,
  `bidang_prestasi` varchar(255) DEFAULT NULL,
  `nama_kegiatan` varchar(255) DEFAULT NULL,
  `tanggal_kegiatan` date DEFAULT NULL,
  `komponen_prestasi` varchar(255) DEFAULT NULL,
  `penyelenggara` varchar(255) DEFAULT NULL,
  `bukti` text DEFAULT NULL,
  `status` enum('diajukan','diterima','ditolak') NOT NULL,
  `id_mahasiswa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`id`, `nim`, `nama_prestasi`, `bidang_prestasi`, `nama_kegiatan`, `tanggal_kegiatan`, `komponen_prestasi`, `penyelenggara`, `bukti`, `status`, `id_mahasiswa`) VALUES
(1, '213100200', 'juara 1 lomba menggambar ', 'seni', 'lomba menggambar tingkat nasional', '2025-02-28', 'Juara 1 (Nasional)', 'dinas kesenian bantul', '1741315678.jpg', 'diajukan', 9),
(2, '213100200', 'juara 1 lomba menyanyi', 'seni', 'lomba menyanyi tingkat nasional', '2025-02-28', 'Juara 1 (Nasional)', 'dinas kesenian bantul', '1741331364.png', 'diajukan', 9);

-- --------------------------------------------------------

--
-- Table structure for table `rekognisi`
--

CREATE TABLE `rekognisi` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama_rekognisi` varchar(255) NOT NULL,
  `bidang_rekognisi` varchar(255) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `tanggal_kegiatan` date NOT NULL,
  `komponen_rekognisi` varchar(255) NOT NULL,
  `penyelenggara` varchar(255) NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rekognisi`
--

INSERT INTO `rekognisi` (`id`, `nim`, `nama_rekognisi`, `bidang_rekognisi`, `nama_kegiatan`, `tanggal_kegiatan`, `komponen_rekognisi`, `penyelenggara`, `bukti`, `id_mahasiswa`) VALUES
(1, '213100200', 'studi independet web development-1', 'pendidikan', 'studi independet web development infinite learning', '2025-02-14', 'msib (studi independent)', 'kemendikbud', '1741315759.png', 9);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(2, 'super admin', 'superadmin@gmail.com', 'default.jpg', '81dc9bdb52d04dc20036dbd8313ed055', 5, 1, 1),
(5, 'admin', 'admin@gmail.com', '1745164542_uml-class_diagram_drawio_(1).png', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, 0),
(6, 'Fakultas Komputer dan Teknik', 'fkt@almaata.ac.id', 'default.jpg', '81dc9bdb52d04dc20036dbd8313ed055', 3, 1, 0),
(7, 'Sistem Informasi', 'si@almaata.ac.id', 'default.jpg', '81dc9bdb52d04dc20036dbd8313ed055', 4, 1, 0),
(9, 'Hermia Mujiyasari', '213100200@almaata.ac.id', '1745254576_uml-use_case_diagram2_drawio.png', '81dc9bdb52d04dc20036dbd8313ed055', 2, 1, 1741284540),
(10, 'Fakultas Komputer dan Teknik3', 'adminfkt@gmail.com', 'default.jpg', '202cb962ac59075b964b07152d234b70', 3, 1, 0),
(11, 'Informatika', 'inf@almaata.ac.id', 'default.jpg', '202cb962ac59075b964b07152d234b70', 4, 1, 0),
(16, 'fani dwi ', '213100254@almaata.ac.id', 'default.jpg', '81dc9bdb52d04dc20036dbd8313ed055', 2, 1, 1745162248);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 1, 3),
(5, 1, 4),
(10, 3, 2),
(11, 3, 6),
(12, 4, 2),
(13, 5, 1),
(14, 5, 2),
(15, 5, 3),
(16, 5, 4),
(17, 5, 5),
(18, 5, 6),
(19, 5, 7),
(20, 5, 8),
(22, 4, 8),
(23, 4, 6),
(24, 5, 9),
(25, 1, 9),
(27, 3, 5),
(28, 2, 10),
(29, 2, 11),
(30, 5, 12),
(31, 2, 19),
(32, 2, 13),
(33, 3, 1),
(34, 4, 1),
(35, 1, 12),
(36, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Dashboard'),
(2, 'User'),
(3, 'Data Prestasi'),
(4, 'Data Rekognisi'),
(5, 'Fakultas'),
(6, 'Prodi'),
(7, 'Pengajuan Verifikasi'),
(8, 'Verifikasi'),
(9, 'Mahasiswa'),
(10, 'Prestasi Saya'),
(11, 'Rekognisi Saya'),
(12, 'Admin'),
(13, 'Pengajuan Saya');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(10) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Mahasiswa'),
(3, 'Fakultas'),
(4, 'Prodi'),
(5, 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'dashboard\r\n', 'bi bi-grid-fill', 1),
(2, 2, 'My Profile', 'user', 'bi bi-person-circle', 1),
(3, 2, 'Edit Profile', 'user/edit', 'bi bi-pencil-square', 1),
(4, 3, 'Data Prestasi', 'prestasi', 'bi bi-award-fill', 1),
(5, 4, 'Data Rekognisi', 'rekognisi\r\n', 'bi bi-bar-chart-fill', 1),
(6, 7, 'Pengajuan Verifikasi ', 'pengajuanverifikasi', 'bi bi-check-circle-fill', 1),
(8, 2, 'Change Password', 'user/changepassword', 'bi bi-person-lock', 1),
(9, 5, 'Data Fakultas', 'fakultas', 'bi bi-buildings-fill', 1),
(11, 6, 'Data Prodi', 'prodi', 'bi bi-laptop-fill', 1),
(12, 8, 'Verifikasi', 'pengajuanverifikasi', 'bi bi-person-check-fill', 1),
(13, 9, 'Data Mahasiswa', 'mahasiswa/user_mahasiswa', 'bi bi-mortarboard-fill', 1),
(14, 10, 'Prestasi Saya', 'prestasi/getprestasibyidmahasiswa', 'bi bi-award-fill', 1),
(15, 11, 'Rekognisi Saya', 'rekognisi/getrekognisibyidmahasiswa', 'bi bi-bar-chart-fill', 1),
(18, 12, 'Data Admin', 'admin', 'bi bi-people-fill', 1),
(19, 13, 'Pengajuan Saya', 'PengajuanVerifikasi/pengajuanku', 'bi bi-check-circle-fill', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pengajuan_verifikasi`
--
ALTER TABLE `pengajuan_verifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rekognisi`
--
ALTER TABLE `rekognisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengajuan_verifikasi`
--
ALTER TABLE `pengajuan_verifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rekognisi`
--
ALTER TABLE `rekognisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
