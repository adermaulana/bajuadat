-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 12:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_bajuadat`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_222145`
--

CREATE TABLE `admin_222145` (
  `admin_id_222145` int(11) NOT NULL,
  `username_222145` varchar(50) NOT NULL,
  `password_222145` varchar(255) NOT NULL,
  `nama_lengkap_222145` varchar(100) NOT NULL,
  `email_222145` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_222145`
--

INSERT INTO `admin_222145` (`admin_id_222145`, `username_222145`, `password_222145`, `nama_lengkap_222145`, `email_222145`) VALUES
(5, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan_222145`
--

CREATE TABLE `detail_pesanan_222145` (
  `detail_id_222145` int(11) NOT NULL,
  `pesanan_id_222145` int(11) NOT NULL,
  `produk_id_222145` int(11) NOT NULL,
  `jumlah_222145` int(11) NOT NULL,
  `ukuran_222145` varchar(20) NOT NULL,
  `harga_satuan_222145` decimal(10,2) NOT NULL,
  `sub_total_222145` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keranjang_222145`
--

CREATE TABLE `keranjang_222145` (
  `keranjang_id_222145` int(11) NOT NULL,
  `pelanggan_id_222145` int(11) DEFAULT NULL,
  `produk_id_222145` int(11) DEFAULT NULL,
  `ukuran_222145` varchar(10) DEFAULT NULL,
  `jumlah_222145` int(11) NOT NULL DEFAULT 1,
  `harga_satuan_222145` decimal(10,2) DEFAULT NULL,
  `tanggal_tambah_222145` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan_222145`
--

CREATE TABLE `pelanggan_222145` (
  `pelanggan_id_222145` int(11) NOT NULL,
  `username_222145` varchar(50) NOT NULL,
  `password_222145` varchar(255) NOT NULL,
  `nama_lengkap_222145` varchar(100) NOT NULL,
  `alamat_222145` text NOT NULL,
  `no_telp_222145` varchar(20) NOT NULL,
  `email_222145` varchar(100) NOT NULL,
  `foto_ktp_222145` varchar(255) DEFAULT NULL,
  `status_akun_222145` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan_222145`
--

INSERT INTO `pelanggan_222145` (`pelanggan_id_222145`, `username_222145`, `password_222145`, `nama_lengkap_222145`, `alamat_222145`, `no_telp_222145`, `email_222145`, `foto_ktp_222145`, `status_akun_222145`) VALUES
(10, 'tes', '28b662d883b6d76fd96e4ddc5e9ba780', 'tes', 'tes', 'te23', 'test@gmail.com', NULL, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_222145`
--

CREATE TABLE `pembayaran_222145` (
  `pembayaran_id_222145` int(11) NOT NULL,
  `pesanan_id_222145` int(11) NOT NULL,
  `metode_pembayaran_222145` varchar(50) NOT NULL,
  `jumlah_pembayaran_222145` decimal(10,2) NOT NULL,
  `bukti_pembayaran_222145` varchar(255) DEFAULT NULL,
  `status_222145` enum('menunggu','diterima','ditolak') DEFAULT 'menunggu',
  `tanggal_pembayaran_222145` datetime DEFAULT current_timestamp(),
  `admin_id_222145` int(11) DEFAULT NULL,
  `catatan_222145` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian_222145`
--

CREATE TABLE `pengembalian_222145` (
  `pengembalian_id_222145` int(11) NOT NULL,
  `pesanan_id_222145` int(11) DEFAULT NULL,
  `tanggal_pengembalian_222145` date NOT NULL,
  `alasan_pengembalian_222145` varchar(100) NOT NULL,
  `keterangan_222145` text DEFAULT NULL,
  `foto_kondisi_222145` varchar(255) DEFAULT NULL,
  `status_222145` enum('Menunggu Konfirmasi','Disetujui','Ditolak','Didenda') DEFAULT 'Menunggu Konfirmasi',
  `admin_id_222145` int(11) DEFAULT NULL,
  `catatan_admin_222145` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_222145`
--

CREATE TABLE `pesanan_222145` (
  `pesanan_id_222145` int(11) NOT NULL,
  `pelanggan_id_222145` int(11) NOT NULL,
  `tanggal_pesanan_222145` datetime DEFAULT current_timestamp(),
  `tanggal_sewa_222145` date NOT NULL,
  `tanggal_kembali_222145` date NOT NULL,
  `jumlah_hari_222145` int(20) NOT NULL,
  `total_harga_222145` decimal(10,2) NOT NULL,
  `status_222145` enum('menunggu','diproses','disewa','selesai','dibatalkan') DEFAULT 'menunggu',
  `catatan_222145` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk_222145`
--

CREATE TABLE `produk_222145` (
  `produk_id_222145` int(11) NOT NULL,
  `nama_produk_222145` varchar(100) NOT NULL,
  `deskripsi_222145` text DEFAULT NULL,
  `kategori_222145` varchar(50) NOT NULL,
  `harga_sewa_222145` decimal(10,2) NOT NULL,
  `gambar_222145` varchar(255) DEFAULT NULL,
  `kelengkapan_222145` text NOT NULL,
  `status_222145` enum('tersedia','tidak tersedia') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_222145`
--

INSERT INTO `produk_222145` (`produk_id_222145`, `nama_produk_222145`, `deskripsi_222145`, `kategori_222145`, `harga_sewa_222145`, `gambar_222145`, `kelengkapan_222145`, `status_222145`) VALUES
(8, 'Baju Adat Bali', 'Bagus', 'Bali', 100000.00, 'uploads/bali.jpg', 'Baju, Celana', 'tersedia'),
(9, 'Baju Adat Minang', 'Sumatera Barat', 'Sumatera Barat', 110000.00, 'uploads/minang.jpg', 'Sumatera Barat', 'tersedia'),
(10, 'Baju Adat Jawa', 'Jawa Tengah', 'Jawa Tengah', 115000.00, 'uploads/kebaya.png', 'Jawa Tengah', 'tersedia'),
(11, 'Baju Adat Sulawesi Selatan', 'Sulawesi Selatan', 'Sulawesi Selatan', 120000.00, 'uploads/bajubodo.jpeg', 'Sulawesi Selatan', 'tersedia'),
(12, 'Baju Adat Sumatera', 'Sumatera Utara', 'Sumatera Utara', 110000.00, 'uploads/sumatera.jpg', 'Sumatera Utara', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `ukuran_produk_222145`
--

CREATE TABLE `ukuran_produk_222145` (
  `ukuran_id_222145` int(11) NOT NULL,
  `produk_id_222145` int(11) DEFAULT NULL,
  `ukuran_222145` varchar(10) DEFAULT NULL,
  `stok_222145` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ukuran_produk_222145`
--

INSERT INTO `ukuran_produk_222145` (`ukuran_id_222145`, `produk_id_222145`, `ukuran_222145`, `stok_222145`) VALUES
(11, 8, 'S', 2),
(12, 8, 'M', 3),
(13, 8, 'L', 3),
(14, 8, 'XL', 4),
(15, 9, 'S', 5),
(16, 9, 'M', 1),
(17, 9, 'L', 1),
(18, 9, 'XL', 3),
(19, 10, 'S', 8),
(20, 10, 'M', 1),
(21, 10, 'L', 1),
(22, 10, 'XL', 1),
(23, 11, 'S', 2),
(24, 11, 'M', 1),
(25, 11, 'L', 3),
(26, 11, 'XL', 1),
(27, 12, 'S', 2),
(28, 12, 'M', 5),
(29, 12, 'L', 4),
(30, 12, 'XL', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_222145`
--
ALTER TABLE `admin_222145`
  ADD PRIMARY KEY (`admin_id_222145`),
  ADD UNIQUE KEY `username_222145` (`username_222145`),
  ADD UNIQUE KEY `email_222145` (`email_222145`);

--
-- Indexes for table `detail_pesanan_222145`
--
ALTER TABLE `detail_pesanan_222145`
  ADD PRIMARY KEY (`detail_id_222145`),
  ADD KEY `pesanan_id_222145` (`pesanan_id_222145`),
  ADD KEY `produk_id_222145` (`produk_id_222145`);

--
-- Indexes for table `keranjang_222145`
--
ALTER TABLE `keranjang_222145`
  ADD PRIMARY KEY (`keranjang_id_222145`),
  ADD KEY `pelanggan_id_222145` (`pelanggan_id_222145`),
  ADD KEY `produk_id_222145` (`produk_id_222145`);

--
-- Indexes for table `pelanggan_222145`
--
ALTER TABLE `pelanggan_222145`
  ADD PRIMARY KEY (`pelanggan_id_222145`),
  ADD UNIQUE KEY `username_222145` (`username_222145`),
  ADD UNIQUE KEY `email_222145` (`email_222145`);

--
-- Indexes for table `pembayaran_222145`
--
ALTER TABLE `pembayaran_222145`
  ADD PRIMARY KEY (`pembayaran_id_222145`),
  ADD KEY `pesanan_id_222145` (`pesanan_id_222145`),
  ADD KEY `admin_id_222145` (`admin_id_222145`);

--
-- Indexes for table `pengembalian_222145`
--
ALTER TABLE `pengembalian_222145`
  ADD PRIMARY KEY (`pengembalian_id_222145`),
  ADD KEY `pengembalian_222145_ibfk_1` (`pesanan_id_222145`),
  ADD KEY `pengembalian_222145_ibfk_2` (`admin_id_222145`);

--
-- Indexes for table `pesanan_222145`
--
ALTER TABLE `pesanan_222145`
  ADD PRIMARY KEY (`pesanan_id_222145`),
  ADD KEY `pelanggan_id_222145` (`pelanggan_id_222145`);

--
-- Indexes for table `produk_222145`
--
ALTER TABLE `produk_222145`
  ADD PRIMARY KEY (`produk_id_222145`);

--
-- Indexes for table `ukuran_produk_222145`
--
ALTER TABLE `ukuran_produk_222145`
  ADD PRIMARY KEY (`ukuran_id_222145`),
  ADD KEY `ukuran_produk_222145_ibfk_1` (`produk_id_222145`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_222145`
--
ALTER TABLE `admin_222145`
  MODIFY `admin_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `detail_pesanan_222145`
--
ALTER TABLE `detail_pesanan_222145`
  MODIFY `detail_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `keranjang_222145`
--
ALTER TABLE `keranjang_222145`
  MODIFY `keranjang_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pelanggan_222145`
--
ALTER TABLE `pelanggan_222145`
  MODIFY `pelanggan_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran_222145`
--
ALTER TABLE `pembayaran_222145`
  MODIFY `pembayaran_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pengembalian_222145`
--
ALTER TABLE `pengembalian_222145`
  MODIFY `pengembalian_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pesanan_222145`
--
ALTER TABLE `pesanan_222145`
  MODIFY `pesanan_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `produk_222145`
--
ALTER TABLE `produk_222145`
  MODIFY `produk_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ukuran_produk_222145`
--
ALTER TABLE `ukuran_produk_222145`
  MODIFY `ukuran_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan_222145`
--
ALTER TABLE `detail_pesanan_222145`
  ADD CONSTRAINT `detail_pesanan_222145_ibfk_1` FOREIGN KEY (`pesanan_id_222145`) REFERENCES `pesanan_222145` (`pesanan_id_222145`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pesanan_222145_ibfk_2` FOREIGN KEY (`produk_id_222145`) REFERENCES `produk_222145` (`produk_id_222145`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keranjang_222145`
--
ALTER TABLE `keranjang_222145`
  ADD CONSTRAINT `keranjang_222145_ibfk_1` FOREIGN KEY (`pelanggan_id_222145`) REFERENCES `pelanggan_222145` (`pelanggan_id_222145`),
  ADD CONSTRAINT `keranjang_222145_ibfk_2` FOREIGN KEY (`produk_id_222145`) REFERENCES `produk_222145` (`produk_id_222145`);

--
-- Constraints for table `pembayaran_222145`
--
ALTER TABLE `pembayaran_222145`
  ADD CONSTRAINT `pembayaran_222145_ibfk_1` FOREIGN KEY (`pesanan_id_222145`) REFERENCES `pesanan_222145` (`pesanan_id_222145`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_222145_ibfk_2` FOREIGN KEY (`admin_id_222145`) REFERENCES `admin_222145` (`admin_id_222145`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengembalian_222145`
--
ALTER TABLE `pengembalian_222145`
  ADD CONSTRAINT `pengembalian_222145_ibfk_1` FOREIGN KEY (`pesanan_id_222145`) REFERENCES `pesanan_222145` (`pesanan_id_222145`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengembalian_222145_ibfk_2` FOREIGN KEY (`admin_id_222145`) REFERENCES `admin_222145` (`admin_id_222145`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pesanan_222145`
--
ALTER TABLE `pesanan_222145`
  ADD CONSTRAINT `pesanan_222145_ibfk_1` FOREIGN KEY (`pelanggan_id_222145`) REFERENCES `pelanggan_222145` (`pelanggan_id_222145`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ukuran_produk_222145`
--
ALTER TABLE `ukuran_produk_222145`
  ADD CONSTRAINT `ukuran_produk_222145_ibfk_1` FOREIGN KEY (`produk_id_222145`) REFERENCES `produk_222145` (`produk_id_222145`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
