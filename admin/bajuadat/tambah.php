<?php

include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");
}

if(isset($_POST['simpan'])) {
  // Data produk utama
  $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_baju_adat']);
  $deskripsi = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
  $kategori = mysqli_real_escape_string($koneksi, $_POST['daerah_asal']);
  $harga_sewa = mysqli_real_escape_string($koneksi, $_POST['harga_sewa']);
  $kelengkapan = mysqli_real_escape_string($koneksi, $_POST['kelengkapan']);
  
  // Handle file upload
  $gambar = '';
  if(isset($_FILES['gambar_baju_adat']) && $_FILES['gambar_baju_adat']['error'] == 0) {
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["gambar_baju_adat"]["name"]);
      move_uploaded_file($_FILES["gambar_baju_adat"]["tmp_name"], $target_file);
      $gambar = $target_file;
  }
  
  $status = 'tersedia'; // Default status

  // Insert produk utama
  $query = "INSERT INTO produk_222145 
            (nama_produk_222145, deskripsi_222145, kategori_222145, harga_sewa_222145, 
             gambar_222145, status_222145, kelengkapan_222145) 
            VALUES ('$nama_produk', '$deskripsi', '$kategori', '$harga_sewa', 
                    '$gambar', '$status', '$kelengkapan')";

  $simpan = mysqli_query($koneksi, $query);
  
  if($simpan) {
      $produk_id = mysqli_insert_id($koneksi);
      
      // Insert stok per ukuran
      $ukuran = ['S', 'M', 'L', 'XL'];
      foreach($ukuran as $u) {
          $stok = (int)$_POST['stok_'.strtolower($u)];
          if($stok > 0) {
              $query_ukuran = "INSERT INTO ukuran_produk_222145 
                               (produk_id_222145, ukuran_222145, stok_222145) 
                               VALUES ('$produk_id', '$u', '$stok')";
              mysqli_query($koneksi, $query_ukuran);
          }
      }
      
      echo "<script>
              alert('Produk berhasil ditambahkan!');
              document.location='index.php';
          </script>";
  } else {
      echo "<script>
              alert('Gagal menambahkan produk!');
              document.location='tambah.php';
          </script>";
  }
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
      <a class="nav-link px-3" href="hapusSession.php">Sign out</a>
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
              <a class="nav-link active" href="index.php">
                <i class="fas fa-tshirt align-text-bottom me-2"></i>
                Baju Adat
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../penyewaan/index.php">
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
        <h1 class="h2">Data Baju Adat</h1>
      </div>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Baju Adat Baru</h1>
      </div>

      <div class="col-lg-8">
      <form method="post" class="mb-5" enctype="multipart/form-data">
          <div class="mb-3">
              <label for="nama_baju_adat" class="form-label">Nama Baju Adat</label>
              <input type="text" class="form-control" id="nama_baju_adat" name="nama_baju_adat" required autofocus placeholder="Contoh: Baju Adat Jawa">
          </div>
          <div class="mb-3">
              <label for="daerah_asal" class="form-label">Daerah Asal</label>
              <input type="text" class="form-control" id="daerah_asal" name="daerah_asal" placeholder="Contoh: Jawa Tengah">
          </div>
          <div class="mb-3">
              <label for="keterangan" class="form-label">Keterangan</label>
              <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Deskripsikan pakaian adat ini (sejarah, kegunaan, dll)"></textarea>
          </div>
          <div class="row">
              <div class="col-md-6 mb-3">
                  <label for="harga_sewa" class="form-label">Harga Sewa (per hari)</label>
                  <div class="input-group">
                      <span class="input-group-text">Rp</span>
                      <input type="number" class="form-control" id="harga_sewa" name="harga_sewa" placeholder="Contoh: 350000">
                  </div>
              </div>
          </div>
          <div class="mb-3">
              <label class="form-label">Stok per Ukuran</label>
              <div class="row">
                  <div class="col-md-3">
                      <label for="stok_s" class="form-label">S (Small)</label>
                      <input type="number" class="form-control" id="stok_s" name="stok_s" min="0" value="0">
                  </div>
                  <div class="col-md-3">
                      <label for="stok_m" class="form-label">M (Medium)</label>
                      <input type="number" class="form-control" id="stok_m" name="stok_m" min="0" value="0">
                  </div>
                  <div class="col-md-3">
                      <label for="stok_l" class="form-label">L (Large)</label>
                      <input type="number" class="form-control" id="stok_l" name="stok_l" min="0" value="0">
                  </div>
                  <div class="col-md-3">
                      <label for="stok_xl" class="form-label">XL (Extra Large)</label>
                      <input type="number" class="form-control" id="stok_xl" name="stok_xl" min="0" value="0">
                  </div>
              </div>
          </div>
          <div class="mb-3">
              <label for="kelengkapan" class="form-label">Kelengkapan</label>
              <textarea class="form-control" id="kelengkapan" name="kelengkapan" rows="2" placeholder="Contoh: Atasan, bawahan, selendang, ikat kepala, dll"></textarea>
          </div>
          <div class="mb-3">
              <label for="gambar_baju_adat" class="form-label">Gambar</label>
              <input type="file" class="form-control" id="gambar_baju_adat" name="gambar_baju_adat">
              <div class="form-text">Upload gambar baju adat (format: JPG, PNG. Max: 2MB)</div>
          </div>

          <button type="submit" name="simpan" class="btn btn-success">
              <i class="fas fa-save me-2"></i>Tambah Baju Adat
          </button>
          <a href="index.php" class="btn btn-secondary ms-2">
              <i class="fas fa-times me-2"></i>Batal
          </a>
      </form>
      </div>  
    </div>
  </main>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.js-example-basic-single').select2();
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="../../assets/dashboard.js"></script>
</body>
</html>
