<?php
include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){
    session_unset();
    session_destroy();
    header("location:../");
}

$nama_admin = $_SESSION['nama_admin']; 
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

// Query untuk mendapatkan data pesanan
$query_pesanan = "SELECT 
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
$result_pesanan = mysqli_query($koneksi, $query_pesanan);

// Hitung total pendapatan
$total_query = "SELECT SUM(total_harga_222145) as total FROM pesanan_222145 p $where";
$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_pendapatan = $total_row['total'] ? "Rp. " . number_format($total_row['total'], 0, ',', '.') : "Rp. 0";

// Header untuk generate file Word
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=laporan_penyewaan.doc");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Laporan Penyewaan Baju Adat</title>
<style>
  .table-word {
    border: 1px solid #000;
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 20px;
  }
  .table-word th, .table-word td {
    border: 1px solid #000;
    padding: 5px;
  }
  .table-word th {
    background-color: #f2f2f2;
  }
  .detail-table {
    border: 1px solid #000;
    border-collapse: collapse;
    width: 100%;
    margin-top: 10px;
    margin-bottom: 20px;
  }
  .detail-table th, .detail-table td {
    border: 1px solid #000;
    padding: 3px;
    font-size: 10px;
  }
  .detail-table th {
    background-color: #e6e6e6;
  }
  .pesanan-header {
    background-color: #f9f9f9;
    font-weight: bold;
    padding: 10px;
    border: 1px solid #000;
    margin-top: 15px;
  }
</style>
</head>
<body>
  <div style="text-align: center; margin-bottom: 20px;">
    <h2>PENYEWAAN BAJU ADAT TOKO UNDIPA</h2>
    <h3><?= $judul ?></h3>
    <p>Dicetak pada: <?= date('d/m/Y H:i:s') ?></p>
  </div>

  <?php 
  $no = 1;
  while($pesanan = mysqli_fetch_assoc($result_pesanan)): 
    $formatted_total = "Rp. " . number_format($pesanan['total_harga_222145'], 0, ',', '.');
  ?>
    
    <!-- Header Pesanan -->
    <div class="pesanan-header">
      <strong>PESANAN #<?= $pesanan['pesanan_id_222145'] ?></strong>
    </div>
    
    <!-- Info Pelanggan -->
    <table class="table-word">
      <tr>
        <td width="20%"><strong>Nama Penyewa</strong></td>
        <td><?= htmlspecialchars($pesanan['nama_lengkap_222145']) ?></td>
        <td width="20%"><strong>Tanggal Pesan</strong></td>
        <td><?= date('d/m/Y', strtotime($pesanan['tanggal_pesanan_222145'])) ?></td>
      </tr>
      <tr>
        <td><strong>Alamat</strong></td>
        <td><?= htmlspecialchars($pesanan['alamat_222145']) ?></td>
        <td><strong>Tanggal Sewa</strong></td>
        <td><?= date('d/m/Y', strtotime($pesanan['tanggal_sewa_222145'])) ?></td>
      </tr>
      <tr>
        <td><strong>Telepon</strong></td>
        <td><?= htmlspecialchars($pesanan['no_telp_222145']) ?></td>
        <td><strong>Tanggal Kembali</strong></td>
        <td><?= date('d/m/Y', strtotime($pesanan['tanggal_kembali_222145'])) ?></td>
      </tr>
      <tr>
        <td><strong>Status</strong></td>
        <td><?= ucfirst($pesanan['status_222145']) ?></td>
        <td><strong>Total Biaya</strong></td>
        <td><strong><?= $formatted_total ?></strong></td>
      </tr>
    </table>

    <!-- Detail Baju -->
    <?php
    $query_detail = "SELECT 
                       pr.nama_produk_222145,
                       pr.kategori_222145,
                       dp.jumlah_222145,
                       dp.ukuran_222145,
                       dp.harga_satuan_222145,
                       dp.sub_total_222145
                     FROM 
                       detail_pesanan_222145 dp
                     JOIN 
                       produk_222145 pr ON dp.produk_id_222145 = pr.produk_id_222145
                     WHERE 
                       dp.pesanan_id_222145 = " . $pesanan['pesanan_id_222145'];
    $result_detail = mysqli_query($koneksi, $query_detail);
    ?>
    
    <table class="detail-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Baju</th>
          <th>Kategori</th>
          <th>Ukuran</th>
          <th>Jumlah</th>
          <th>Harga Satuan</th>
          <th>Sub Total</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no_detail = 1;
        while($detail = mysqli_fetch_assoc($result_detail)): 
          $formatted_price = "Rp. " . number_format($detail['harga_satuan_222145'], 0, ',', '.');
          $formatted_subtotal = "Rp. " . number_format($detail['sub_total_222145'], 0, ',', '.');
        ?>
          <tr>
            <td><?= $no_detail++ ?></td>
            <td><?= htmlspecialchars($detail['nama_produk_222145']) ?></td>
            <td><?= htmlspecialchars($detail['kategori_222145']) ?></td>
            <td><?= htmlspecialchars($detail['ukuran_222145']) ?></td>
            <td><?= $detail['jumlah_222145'] ?></td>
            <td><?= $formatted_price ?></td>
            <td><?= $formatted_subtotal ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

  <?php 
  $no++;
  endwhile; 
  ?>

  <div style="margin-top: 20px; text-align: right; font-weight: bold; font-size: 14px;">
    <strong>TOTAL PENDAPATAN: <?= $total_pendapatan ?></strong>
  </div>

  <div style="margin-top: 50px; text-align: right;">
    <p>Mengetahui,</p>
    <br><br><br>
    <p>_________________________</p>
    <p>Admin</p>
    <p>Dicetak oleh <?= $nama_admin ?></p>
  </div>
</body>
</html>