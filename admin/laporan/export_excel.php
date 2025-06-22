<?php
include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){
    session_unset();
    session_destroy();
    header("location:../");
}

// Ambil parameter filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'bulan';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Build the WHERE clause
$where = "";
switch($filter) {
    case 'hari':
        $where = "WHERE DATE(p.tanggal_pesanan_222145) = CURDATE()";
        $judul = "Laporan Harian (Hari Ini)";
        break;
    case 'minggu':
        $where = "WHERE YEARWEEK(p.tanggal_pesanan_222145, 1) = YEARWEEK(CURDATE(), 1)";
        $judul = "Laporan Mingguan (Minggu Ini)";
        break;
    case 'bulan':
        $where = "WHERE MONTH(p.tanggal_pesanan_222145) = MONTH(CURDATE()) AND YEAR(p.tanggal_pesanan_222145) = YEAR(CURDATE())";
        $judul = "Laporan Bulanan (Bulan Ini)";
        break;
    case 'range':
        if(!empty($start_date) && !empty($end_date)) {
            $where = "WHERE DATE(p.tanggal_pesanan_222145) BETWEEN '$start_date' AND '$end_date'";
            $judul = "Laporan Dari " . date('d/m/Y', strtotime($start_date)) . " Sampai " . date('d/m/Y', strtotime($end_date));
        } else {
            $judul = "Laporan Semua Data";
        }
        break;
    default:
        $judul = "Laporan Semua Data";
}

$query = "SELECT 
            p.pesanan_id_222145,
            pl.nama_lengkap_222145,
            pl.email_222145,
            pl.alamat_222145,
            pl.no_telp_222145,
            p.total_harga_222145,
            p.status_222145,
            p.tanggal_pesanan_222145,
            p.tanggal_sewa_222145,
            p.tanggal_kembali_222145,
            p.jumlah_hari_222145,
            dp.produk_id_222145,
            pr.nama_produk_222145,
            pr.kategori_222145,
            dp.jumlah_222145,
            dp.ukuran_222145,
            dp.harga_satuan_222145,
            dp.sub_total_222145
          FROM 
            pesanan_222145 p
          JOIN 
            pelanggan_222145 pl ON p.pelanggan_id_222145 = pl.pelanggan_id_222145
          JOIN 
            detail_pesanan_222145 dp ON p.pesanan_id_222145 = dp.pesanan_id_222145
          JOIN 
            produk_222145 pr ON dp.produk_id_222145 = pr.produk_id_222145
          $where
          ORDER BY 
            p.pesanan_id_222145 DESC, dp.detail_id_222145 ASC";
$result = mysqli_query($koneksi, $query);

// Hitung total pendapatan
$total_query = "SELECT SUM(total_harga_222145) as total FROM pesanan_222145 p $where";
$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_pendapatan = $total_row['total'] ? number_format($total_row['total'], 0, ',', '.') : "0";

// Header untuk generate file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"laporan_penyewaan_".date('Ymd_His').".xls\"");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>
  <table border="1">
    <tr>
      <td colspan="13" style="text-align: center; font-weight: bold; font-size: 16px;">PENYEWAAN BAJU ADAT TOKO UNDIPA</td>
    </tr>
    <tr>
      <td colspan="13" style="text-align: center;"><?= $judul ?></td>
    </tr>
    <tr>
      <td colspan="13" style="text-align: center;">Dicetak pada: <?= date('d/m/Y H:i:s') ?></td>
    </tr>
    <tr>
      <th>No</th>
      <th>ID Pesanan</th>
      <th>Nama Penyewa</th>
      <th>Alamat</th>
      <th>Telepon</th>
      <th>Nama Produk</th>
      <th>Kategori</th>
      <th>Ukuran</th>
      <th>Jumlah</th>
      <th>Harga Satuan</th>
      <th>Sub Total</th>
      <th>Tanggal Sewa</th>
      <th>Tanggal Kembali</th>
      <th>Jumlah Hari</th>
      <th>Status</th>
    </tr>
    <?php 
    $no = 1;
    $current_pesanan = '';
    $total_keseluruhan = 0;
    while($row = mysqli_fetch_assoc($result)): 
      $formatted_harga_satuan = number_format($row['harga_satuan_222145'], 0, ',', '.');
      $formatted_sub_total = number_format($row['sub_total_222145'], 0, ',', '.');
      $total_keseluruhan += $row['sub_total_222145'];
      
      // Cek apakah ini pesanan yang sama (untuk menggabungkan baris yang sama)
      $show_pesanan_info = ($current_pesanan != $row['pesanan_id_222145']);
      if($show_pesanan_info) {
        $current_pesanan = $row['pesanan_id_222145'];
      }
    ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['pesanan_id_222145']; ?></td>
        <td><?= $show_pesanan_info ? htmlspecialchars($row['nama_lengkap_222145']) : ''; ?></td>
        <td><?= $show_pesanan_info ? htmlspecialchars($row['alamat_222145']) : ''; ?></td>
        <td><?= $show_pesanan_info ? htmlspecialchars($row['no_telp_222145']) : ''; ?></td>
        <td><?= htmlspecialchars($row['nama_produk_222145']); ?></td>
        <td><?= htmlspecialchars($row['kategori_222145']); ?></td>
        <td><?= htmlspecialchars($row['ukuran_222145']); ?></td>
        <td style="text-align: center;"><?= $row['jumlah_222145']; ?></td>
        <td style="text-align: right;">Rp <?= $formatted_harga_satuan; ?></td>
        <td style="text-align: right;">Rp <?= $formatted_sub_total; ?></td>
        <td><?= $show_pesanan_info ? date('d/m/Y', strtotime($row['tanggal_sewa_222145'])) : ''; ?></td>
        <td><?= $show_pesanan_info ? date('d/m/Y', strtotime($row['tanggal_kembali_222145'])) : ''; ?></td>
        <td style="text-align: center;"><?= $show_pesanan_info ? $row['jumlah_hari_222145'] . ' hari' : ''; ?></td>
        <td><?= $show_pesanan_info ? ucfirst($row['status_222145']) : ''; ?></td>
      </tr>
    <?php endwhile; ?>
    <tr>
      <td colspan="14" style="text-align: right; font-weight: bold;">TOTAL PENDAPATAN</td>
      <td style="text-align: right; font-weight: bold;">Rp <?= $total_pendapatan ?></td>
    </tr>
  </table>
</body>
</html>