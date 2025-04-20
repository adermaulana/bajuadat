<?php

include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");
}

if(isset($_POST['simpan'])){

  // File upload handling
  $gambar_material = $_FILES['gambar_material']['name'];
  $gambar_temp = $_FILES['gambar_material']['tmp_name'];
  $upload_dir = '../../uploads/'; // Specify your upload directory

  $lokasi_foto="uploads/" . $gambar_material;
  // Move uploaded file to the specified directory
  move_uploaded_file($gambar_temp, $upload_dir . $gambar_material);

  $simpan = mysqli_query($koneksi, "INSERT INTO data_material (nama_material, deskripsi_material, harga_material, gambar_material) VALUES ('$_POST[nama_material]', '$_POST[deskripsi]', '$_POST[harga]', '$lokasi_foto')");

    if($simpan){
        echo "<script>
                alert('Simpan data sukses!');
                document.location='index.php';
            </script>";
    } else {
        echo "<script>
                alert('Simpan data Gagal!');
                document.location='index.php';
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
            <div class="col-md-6 mb-3">
              <label for="stok" class="form-label">Stok</label>
              <input type="number" class="form-control" id="stok" name="stok" placeholder="Jumlah unit tersedia">
            </div>
          </div>
          <div class="mb-3">
            <label for="ukuran" class="form-label">Ukuran Tersedia</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="ukuran_s" name="ukuran[]" value="S">
              <label class="form-check-label" for="ukuran_s">S (Small)</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="ukuran_m" name="ukuran[]" value="M">
              <label class="form-check-label" for="ukuran_m">M (Medium)</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="ukuran_l" name="ukuran[]" value="L">
              <label class="form-check-label" for="ukuran_l">L (Large)</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="ukuran_xl" name="ukuran[]" value="XL">
              <label class="form-check-label" for="ukuran_xl">XL (Extra Large)</label>
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
