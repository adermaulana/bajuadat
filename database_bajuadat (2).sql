-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 02:03 AM
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
(5, 'admin', 'de88e3e4ab202d87754078cbb2df6063', 'admin', 'admin@gmail.com');

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
(1, 'andi_pratama', 'de88e3e4ab202d87754078cbb2df6063', 'Andi Pratama Wijaya', 'Jl. Merdeka No. 15, Jakarta Pusat', '081234567890', 'andi.pratama@email.com', 'ktp_001.jpg', 'aktif'),
(2, 'sari_melati', 'de88e3e4ab202d87754078cbb2df6063', 'Sari Melati Sari', 'Jl. Sudirman No. 45, Surabaya', '081298765432', 'sari.melati@email.com', 'ktp_002.jpg', 'aktif'),
(3, 'budi_santoso', 'de88e3e4ab202d87754078cbb2df6063', 'Budi Santoso', 'Jl. Gatot Subroto No. 78, Bandung', '081356789012', 'budi.santoso@email.com', 'ktp_003.jpg', 'nonaktif'),
(4, 'maya_indira', 'de88e3e4ab202d87754078cbb2df6063', 'Maya Indira Putri', 'Jl. Diponegoro No. 23, Yogyakarta', '081445667788', 'maya.indira@email.com', 'ktp_004.jpg', 'aktif'),
(5, 'rizki_ahmad', 'de88e3e4ab202d87754078cbb2df6063', 'Rizki Ahmad Fauzi', 'Jl. Ahmad Yani No. 67, Medan', '081567890123', 'rizki.ahmad@email.com', 'ktp_005.jpg', 'aktif'),
(6, 'dewi_lestari', 'de88e3e4ab202d87754078cbb2df6063', 'Dewi Lestari', 'Jl. Pahlawan No. 34, Makassar', '081612345678', 'dewi.lestari@email.com', 'ktp_006.jpg', 'aktif'),
(7, 'hadi_kurniawan', 'de88e3e4ab202d87754078cbb2df6063', 'Hadi Kurniawan', 'Jl. Veteran No. 89, Semarang', '081723456789', 'hadi.kurniawan@email.com', 'uploads/68588fea33d68.png', 'aktif'),
(8, 'fitri_rahayu', 'de88e3e4ab202d87754078cbb2df6063', 'Fitri Rahayu', 'Jl. Pemuda No. 12, Palembang', '081834567890', 'fitri.rahayu@email.com', 'ktp_008.jpg', 'aktif'),
(9, 'doni_setiawan', 'de88e3e4ab202d87754078cbb2df6063', 'Doni Setiawan', 'Jl. Proklamasi No. 56, Denpasar', '081945678901', 'doni.setiawan@email.com', 'ktp_009.jpg', 'nonaktif'),
(11, 'agus_hermawan', 'de88e3e4ab202d87754078cbb2df6063', 'Agus Hermawan', 'Jl. Cut Nyak Dien No. 25, Banda Aceh', '081187654321', 'agus.hermawan@email.com', 'ktp_011.jpg', 'aktif'),
(12, 'rina_salsabila', 'de88e3e4ab202d87754078cbb2df6063', 'Rina Salsabila', 'Jl. R.A. Kartini No. 43, Padang', '081276543210', 'rina.salsabila@email.com', 'ktp_012.jpg', 'aktif'),
(13, 'tommy_wijaya', 'de88e3e4ab202d87754078cbb2df6063', 'Tommy Wijaya', 'Jl. Sisingamangaraja No. 18, Batam', '081365432109', 'tommy.wijaya@email.com', 'ktp_013.jpg', 'aktif'),
(14, 'sinta_permata', 'de88e3e4ab202d87754078cbb2df6063', 'Sinta Permata Sari', 'Jl. Jendral Sudirman No. 71, Pontianak', '081454321098', 'sinta.permata@email.com', 'ktp_014.jpg', 'nonaktif'),
(15, 'fajar_nugroho', 'de88e3e4ab202d87754078cbb2df6063', 'Fajar Nugroho', 'Jl. Panglima Polim No. 29, Manado', '081543210987', 'fajar.nugroho@email.com', 'ktp_015.jpg', 'aktif');

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
(13, 'Baju Adat Aceh', 'Aceh', 'Aceh', 120000.00, 'uploads/f698fce9-8cc5-4785-8c79-1acceb9d9f96_43.jpg', 'Baju, Celana', 'tersedia'),
(14, 'Baju Adat Batak', 'Sumatera Utara', 'Sumatera Utara', 130000.00, 'uploads/pakaian-adat-batak-toba_43.jpeg', 'Baju, Celana', 'tersedia'),
(15, 'Baju Adat Betawi', 'DKI Jakarta', 'DKI Jakarta', 140000.00, 'uploads/images.jpeg', 'Baju, Celana', 'tersedia'),
(16, 'Baju Adat Sunda', 'Jawa Barat', 'Jawa Barat', 130000.00, 'uploads/baju-adat-menak-pakaian-khas-jawa-barat-untuk-kaum-bangsawan_43.jpeg', 'Baju, Celana', 'tersedia'),
(17, 'Baju Adat Dayak', 'Kalimantan', 'Kalimantan', 130000.00, 'uploads/Sapei-e1718087894749.jpeg', 'Baju, Celana', 'tersedia'),
(18, 'Baju Adat Papua ', 'Papua', 'Papua', 135000.00, 'uploads/ppaua.jpeg', 'Baju, Celana', 'tersedia'),
(19, 'Baju Adat Maluku ', 'Maluku ', 'Maluku ', 125000.00, 'uploads/54512339-118465939328619-6367029561872461298-n-2-9fe02ed21ff502ccbf88757db46243d8.jpg', 'Baju, Celana', 'tersedia'),
(20, 'Baju Adat Nusa Tenggara Barat', 'Lombok', 'Lombok', 120000.00, 'uploads/Pakaian-Adat-Suku-Bima-NTB-sejarah-negara.com_.jpg', 'Baju, Celana', 'tersedia'),
(21, 'Baju Adat Nusa Tenggara Timur', 'Flores', 'Flores', 135000.00, 'uploads/be4c8fb9cbc2f047f813d2ba61f6b6ac.jpg', 'Baju, Celana', 'tersedia'),
(22, 'Baju Adat Sumatera Selatan', 'Sumatera Selatan', 'Sumatera Selatan', 125000.00, 'uploads/1711903333_bc7b11974433f487badd.png', 'Celana, Baju', 'tersedia'),
(23, 'Baju Adat Yogyakarta', 'DI Yogyakarta', 'DI Yogyakarta', 145000.00, 'uploads/busana-kesatriyan-.jpg', 'Celana, Baju', 'tersedia');

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
(14, 8, 'XL', 6),
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
(31, 13, 'S', 4),
(32, 13, 'M', 4),
(33, 13, 'L', 4),
(34, 13, 'XL', 4),
(35, 14, 'S', 4),
(36, 14, 'M', 4),
(37, 14, 'L', 4),
(38, 14, 'XL', 4),
(39, 15, 'S', 5),
(40, 15, 'M', 4),
(41, 15, 'L', 4),
(42, 15, 'XL', 4),
(43, 16, 'S', 4),
(44, 16, 'M', 4),
(45, 16, 'L', 4),
(46, 16, 'XL', 4),
(47, 17, 'S', 5),
(48, 17, 'M', 4),
(49, 17, 'L', 4),
(50, 17, 'XL', 4),
(51, 18, 'S', 3),
(52, 18, 'M', 3),
(53, 18, 'L', 3),
(54, 18, 'XL', 4),
(55, 19, 'S', 4),
(56, 19, 'M', 4),
(57, 19, 'L', 5),
(58, 19, 'XL', 4),
(59, 20, 'S', 5),
(60, 20, 'M', 4),
(61, 20, 'L', 5),
(62, 20, 'XL', 5),
(63, 21, 'S', 4),
(64, 21, 'M', 3),
(65, 21, 'L', 4),
(66, 21, 'XL', 4),
(67, 22, 'S', 5),
(68, 22, 'M', 4),
(69, 22, 'L', 5),
(70, 22, 'XL', 5),
(71, 23, 'S', 4),
(72, 23, 'M', 4),
(73, 23, 'L', 4),
(74, 23, 'XL', 5);

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
  MODIFY `detail_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `keranjang_222145`
--
ALTER TABLE `keranjang_222145`
  MODIFY `keranjang_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `pelanggan_222145`
--
ALTER TABLE `pelanggan_222145`
  MODIFY `pelanggan_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pembayaran_222145`
--
ALTER TABLE `pembayaran_222145`
  MODIFY `pembayaran_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pengembalian_222145`
--
ALTER TABLE `pengembalian_222145`
  MODIFY `pengembalian_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pesanan_222145`
--
ALTER TABLE `pesanan_222145`
  MODIFY `pesanan_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `produk_222145`
--
ALTER TABLE `produk_222145`
  MODIFY `produk_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ukuran_produk_222145`
--
ALTER TABLE `ukuran_produk_222145`
  MODIFY `ukuran_id_222145` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

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
