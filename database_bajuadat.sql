-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 11:44 PM
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
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan_222145`
--

CREATE TABLE `detail_pesanan_222145` (
  `detail_id_222145` int(11) NOT NULL,
  `pesanan_id_222145` int(11) NOT NULL,
  `produk_id_222145` int(11) NOT NULL,
  `jumlah_222145` int(11) NOT NULL,
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
  `jumlah_hari_222145` int(11) DEFAULT NULL,
  `ukuran_222145` varchar(10) DEFAULT NULL,
  `harga_satuan_222145` decimal(10,2) DEFAULT NULL,
  `sub_total_222145` decimal(10,2) DEFAULT NULL,
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
(4, 'pelanggan', '7f78f06d2d1262a0a222ca9834b15d9d', 'pelanggan', 'pelanggan', '038348', 'pelanggan@gmail.com', 'uploads/Screenshot (2).png', 'aktif'),
(7, 'kun', '51711d3cb95945007b827cb703fcf398', 'kun', 'kun', 'kun', 'kun@gmail.com', NULL, 'aktif'),
(8, 'rot', '0d3d238b089a67e34e39b5abf80db19b', 'rot', 'rot', 'rot', 'rot@gmail.com', NULL, 'aktif');

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
-- Table structure for table `pesanan_222145`
--

CREATE TABLE `pesanan_222145` (
  `pesanan_id_222145` int(11) NOT NULL,
  `pelanggan_id_222145` int(11) NOT NULL,
  `tanggal_pesanan_222145` datetime DEFAULT current_timestamp(),
  `tanggal_sewa_222145` date NOT NULL,
  `tanggal_kembali_222145` date NOT NULL,
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
  `stok_222145` int(11) NOT NULL,
  `ukuran_222145` varchar(20) DEFAULT NULL,
  `gambar_222145` varchar(255) DEFAULT NULL,
  `kelengkapan_222145` text NOT NULL,
  `status_222145` enum('tersedia','tidak tersedia') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_222145`
--
ALTER TABLE `admin_222145`
  MODIFY `admin_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detail_pesanan_222145`
--
ALTER TABLE `detail_pesanan_222145`
  MODIFY `detail_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `keranjang_222145`
--
ALTER TABLE `keranjang_222145`
  MODIFY `keranjang_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pelanggan_222145`
--
ALTER TABLE `pelanggan_222145`
  MODIFY `pelanggan_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pembayaran_222145`
--
ALTER TABLE `pembayaran_222145`
  MODIFY `pembayaran_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pesanan_222145`
--
ALTER TABLE `pesanan_222145`
  MODIFY `pesanan_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk_222145`
--
ALTER TABLE `produk_222145`
  MODIFY `produk_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan_222145`
--
ALTER TABLE `detail_pesanan_222145`
  ADD CONSTRAINT `detail_pesanan_222145_ibfk_1` FOREIGN KEY (`pesanan_id_222145`) REFERENCES `pesanan_222145` (`pesanan_id_222145`),
  ADD CONSTRAINT `detail_pesanan_222145_ibfk_2` FOREIGN KEY (`produk_id_222145`) REFERENCES `produk_222145` (`produk_id_222145`);

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
  ADD CONSTRAINT `pembayaran_222145_ibfk_1` FOREIGN KEY (`pesanan_id_222145`) REFERENCES `pesanan_222145` (`pesanan_id_222145`),
  ADD CONSTRAINT `pembayaran_222145_ibfk_2` FOREIGN KEY (`admin_id_222145`) REFERENCES `admin_222145` (`admin_id_222145`);

--
-- Constraints for table `pesanan_222145`
--
ALTER TABLE `pesanan_222145`
  ADD CONSTRAINT `pesanan_222145_ibfk_1` FOREIGN KEY (`pelanggan_id_222145`) REFERENCES `pelanggan_222145` (`pelanggan_id_222145`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
