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
            p.tanggal_kembali_222145
          FROM 
            pesanan_222145 p
          JOIN 
            pelanggan_222145 pl ON p.pelanggan_id_222145 = pl.pelanggan_id_222145
          $where
          ORDER BY 
            p.pesanan_id_222145 DESC";
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
      <td colspan="9" style="text-align: center; font-weight: bold; font-size: 16px;">LAPORAN PENYEWAAN BAJU ADAT</td>
    </tr>
    <tr>
      <td colspan="9" style="text-align: center;"><?= $judul ?></td>
    </tr>
    <tr>
      <td colspan="9" style="text-align: center;">Dicetak pada: <?= date('d/m/Y H:i:s') ?></td>
    </tr>
    <tr>
      <th>No</th>
      <th>Nama Penyewa</th>
      <th>Alamat</th>
      <th>Telepon</th>
      <th>Tanggal Pesan</th>
      <th>Tanggal Sewa</th>
      <th>Tanggal Kembali</th>
      <th>Total Biaya</th>
      <th>Status</th>
    </tr>
    <?php 
    $no = 1;
    while($row = mysqli_fetch_assoc($result)): 
      $formatted_price = number_format($row['total_harga_222145'], 0, ',', '.');
    ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($row['nama_lengkap_222145']); ?></td>
        <td><?= htmlspecialchars($row['alamat_222145']); ?></td>
        <td><?= htmlspecialchars($row['no_telp_222145']); ?></td>
        <td><?= date('d/m/Y', strtotime($row['tanggal_pesanan_222145'])); ?></td>
        <td><?= date('d/m/Y', strtotime($row['tanggal_sewa_222145'])); ?></td>
        <td><?= date('d/m/Y', strtotime($row['tanggal_kembali_222145'])); ?></td>
        <td style="text-align: right;">Rp <?= $formatted_price; ?></td>
        <td><?= ucfirst($row['status_222145']); ?></td>
      </tr>
    <?php endwhile; ?>
    <tr>
      <td colspan="8" style="text-align: right; font-weight: bold;">TOTAL PENDAPATAN</td>
      <td style="text-align: right; font-weight: bold;">Rp <?= $total_pendapatan ?></td>
    </tr>
  </table>
</body>
</html>