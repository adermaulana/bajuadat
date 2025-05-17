<?php

include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){
    session_unset();
    session_destroy();
    header("location:../");
}

// Get order ID from URL parameter
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Query to fetch order details with customer information
$query = "SELECT 
            p.*,
            pl.nama_lengkap_222145,
            pl.alamat_222145,
            pl.email_222145,
            pl.no_telp_222145,
            pl.foto_ktp_222145,
            pb.metode_pembayaran_222145,
            pb.jumlah_pembayaran_222145,
            pb.status_222145 as status_pembayaran,
            pb.bukti_pembayaran_222145,
            pb.tanggal_pembayaran_222145,
            pb.catatan_222145 as catatan_pembayaran
          FROM 
            pesanan_222145 p
          JOIN 
            pelanggan_222145 pl ON p.pelanggan_id_222145 = pl.pelanggan_id_222145
          LEFT JOIN
            pembayaran_222145 pb ON p.pesanan_id_222145 = pb.pesanan_id_222145
          WHERE 
            p.pesanan_id_222145 = $order_id";
$result = mysqli_query($koneksi, $query);

if(mysqli_num_rows($result) == 0) {
    header("location:index.php");
    exit();
}

$order = mysqli_fetch_assoc($result);

// Query to fetch order items
$items_query = "SELECT 
                  dp.*,
                  p.nama_produk_222145
                FROM 
                  detail_pesanan_222145 dp
                JOIN 
                  produk_222145 p ON dp.produk_id_222145 = p.produk_id_222145
                WHERE 
                  dp.pesanan_id_222145 = $order_id";
$items_result = mysqli_query($koneksi, $items_query);

// Format date
$tanggal_pesanan = date('d F Y', strtotime($order['tanggal_pesanan_222145']));
$tanggal_sewa = date('d F Y', strtotime($order['tanggal_sewa_222145']));
$tanggal_kembali = date('d F Y', strtotime($order['tanggal_kembali_222145']));
$tanggal_pembayaran = !empty($order['tanggal_pembayaran_222145']) ? date('d F Y', strtotime($order['tanggal_pembayaran_222145'])) : '-';

// Format currency
function format_rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/dashboard.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
      
      .payment-proof, .ktp-proof {
        max-width: 100%;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
      }
    </style>

</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Baju Adat</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="../hapusSession.php">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
  <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3 sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../index.php">
                <i class="fas fa-home align-text-bottom me-2"></i>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="../bajuadat/index.php">
                <i class="fas fa-tshirt align-text-bottom me-2"></i>
                Baju Adat
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="index.php">
                <i class="fas fa-shopping-cart align-text-bottom me-2"></i>
                Penyewaan
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pengembalian/index.php">
                <i class="fas fa-undo align-text-bottom me-2"></i>
                Pengembalian
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pelanggan/index.php">
                <i class="fas fa-users align-text-bottom me-2"></i>
                Pelanggan
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../user/index.php">
                <i class="fas fa-users align-text-bottom me-2"></i>
                Admin
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../laporan/index.php">
                <i class="fas fa-file align-text-bottom me-2"></i>
                Laporan
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="col-lg-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h2>Detail Penyewaan Baju Adat</h2>
          <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-success" href="index.php">
              <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
          </div>
        </div>
        
        <div class="card mb-4">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">ID Penyewaan: RNT-<?= str_pad($order['pesanan_id_222145'], 5, '0', STR_PAD_LEFT) ?></h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <h6>Data Diri Penyewa:</h6>
                <p><strong>Nama:</strong> <?= htmlspecialchars($order['nama_lengkap_222145']) ?></p>
                <p><strong>Alamat:</strong> <?= htmlspecialchars($order['alamat_222145']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($order['email_222145']) ?></p>
                <p><strong>Telepon:</strong> <?= htmlspecialchars($order['no_telp_222145']) ?></p>
                <?php if(!empty($order['foto_ktp_222145'])): ?>
                  <p><strong>Foto KTP:</strong></p>
                  <img src="../../foto_ktp/<?= $order['foto_ktp_222145'] ?>" alt="Foto KTP" class="ktp-proof" style="max-width: 300px;">
                <?php endif; ?>
              </div>
              <div class="col-md-6">
                <h6>Informasi Penyewaan:</h6>
                <p><strong>Tanggal Pesan:</strong> <?= $tanggal_pesanan ?></p>
                <p><strong>Tanggal Sewa:</strong> <?= $tanggal_sewa ?></p>
                <p><strong>Tanggal Kembali:</strong> <?= $tanggal_kembali ?></p>
                <p><strong>Durasi:</strong> 
                  <?php 
                    $datetime1 = new DateTime($order['tanggal_sewa_222145']);
                    $datetime2 = new DateTime($order['tanggal_kembali_222145']);
                    $interval = $datetime1->diff($datetime2);
                    echo $interval->format('%a hari');
                  ?>
                </p>
                <p><strong>Total Harga:</strong> <?= format_rupiah($order['total_harga_222145']) ?></p>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Barang Disewa</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Ukuran</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $no = 1;
                  $total = 0;
                  while($item = mysqli_fetch_assoc($items_result)): 
                    $subtotal = $item['jumlah_222145'] * $item['harga_satuan_222145'];
                    $total += $subtotal;
                  ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= htmlspecialchars($item['nama_produk_222145']) ?></td>
                      <td><?= htmlspecialchars($item['ukuran_222145']) ?></td>
                      <td><?= $item['jumlah_222145'] ?></td>
                      <td><?= format_rupiah($item['harga_satuan_222145']) ?></td>
                      <td><?= format_rupiah($subtotal) ?></td>
                    </tr>
                  <?php endwhile; ?>
                  <tr>
                    <td colspan="5" class="text-end"><strong>Total</strong></td>
                    <td><strong><?= format_rupiah($total) ?></strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Pembayaran</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <p><strong>Status Pembayaran:</strong> 
                  <?php 
                  $status_class = '';
                  switch($order['status_pembayaran']) {
                    case 'Sudah Bayar':
                      $status_class = 'bg-success';
                      break;
                    case 'menunggu':
                      $status_class = 'bg-warning';
                      break;
                    case 'ditolak':
                      $status_class = 'bg-danger';
                      break;
                    default:
                      $status_class = 'bg-secondary';
                  }
                  ?>
                  <span class="badge <?= $status_class ?>"><?= $order['status_pembayaran'] ?? 'Belum Dibayar' ?></span>
                </p>
                <p><strong>Metode Pembayaran:</strong> <?= $order['metode_pembayaran_222145'] ?? '-' ?></p>
                <p><strong>Jumlah Pembayaran:</strong> <?= isset($order['jumlah_pembayaran_222145']) ? format_rupiah($order['jumlah_pembayaran_222145']) : '-' ?></p>
                <p><strong>Tanggal Pembayaran:</strong> <?= $tanggal_pembayaran ?></p>
                <p><strong>Catatan Pembayaran:</strong> <?= !empty($order['catatan_pembayaran']) ? htmlspecialchars($order['catatan_pembayaran']) : '-' ?></p>
              </div>
              <div class="col-md-6">
                <?php if(!empty($order['bukti_pembayaran_222145'])): ?>
                  <p><strong>Bukti Pembayaran:</strong></p>
                  <img src="../../<?= $order['bukti_pembayaran_222145'] ?>" alt="Bukti Pembayaran" class="payment-proof">
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Status Penyewaan</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <p><strong>Status Penyewaan:</strong> 
                  <?php 
                  $status_class = '';
                  switch($order['status_222145']) {
                    case 'Sudah Bayar':
                      $status_class = 'bg-success';
                      break;
                    case 'menunggu':
                      $status_class = 'bg-warning';
                      break;
                    case 'diproses':
                      $status_class = 'bg-info';
                      break;
                    case 'Diantarkan':
                      $status_class = 'bg-primary';
                      break;
                    case 'selesai':
                      $status_class = 'bg-success';
                      break;
                    case 'ditolak':
                      $status_class = 'bg-danger';
                      break;
                    default:
                      $status_class = 'bg-secondary';
                  }
                  ?>
                  <span class="badge <?= $status_class ?>"><?= $order['status_222145'] ?></span>
                </p>
              </div>
              <div class="col-md-6">
                <p><strong>Catatan:</strong> <?= !empty($order['catatan_222145']) ? htmlspecialchars($order['catatan_222145']) : 'Tidak ada catatan' ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
<script src="../../assets/dashboard.js"></script>
</body>
</html>