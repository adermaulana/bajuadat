<?php

include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");
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
            <a class="nav-link" aria-current="page" href="../index.php">
              <span data-feather="home" class="align-text-bottom"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../obat/index.php">
              <span data-feather="users" class="align-text-bottom"></span>
              Obat
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  <?php if ($_SERVER['REQUEST_URI'] === '/apotek-php/admin/penjualan/tambah.php') echo 'active'; ?>" href="../penjualan/index.php">
              <span data-feather="shopping-cart" class="align-text-bottom"></span>
              Penjualan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../pembelian/index.php">
              <span data-feather="shopping-bag" class="align-text-bottom"></span>
              Pembelian
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../pemasok/index.php">
              <span data-feather="users" class="align-text-bottom"></span>
              Pemasok
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../distributor/index.php">
              <span data-feather="users" class="align-text-bottom"></span>
              Distributor
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../return/index.php">
              <span data-feather="users" class="align-text-bottom"></span>
              Barang Return
            </a>
          </li>
        </ul>
      </div>
    </nav>

   <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="col-lg-12">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Penjualan</h1>
      </div>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Penjualan</h1>
      </div>

<div class="col-lg-8">
    <form method="post" class="mb-5" enctype="multipart/form-data" onsubmit="return validateForm();">
    <div class="mb-3">
         <label for="obat_id" class="form-label">Obat</label>
            <select class="form-select js-example-basic-single" id="obat_id" name="obat_id">
            <option value="0" >Pilih</option>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * FROM data_obat");
                while($data = mysqli_fetch_array($tampil)):
                ?>
                  <option value="<?= $data[0]?>" data-harga="<?= $data[3] ?>" data-stok="<?= $data[4] ?>" ><?= $data[1]?></option>
                  <?php 
                 endwhile; 
                ?>
            </select>
        </div>
    <div class="mb-3">
         <label for="id_pelanggan" class="form-label">Nama Pelanggan</label>
            <select class="form-select js-example-basic-single" id="id_pelanggan" name="id_pelanggan" required>
            <option value="0" >Pilih</option>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * FROM data_pelanggan");
                while($data = mysqli_fetch_array($tampil)):
                ?>
                  <option value="<?= $data[0]?>" ><?= $data[1]?></option>
                  <?php 
                 endwhile; 
                ?>
            </select>
        </div>
         <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input style="background-color:#edede9;" type="number" class="form-control" id="harga" name="harga" readonly>
        </div>
        <div class="mb-3">
           <label for="jumlah" class="form-label">Stok</label>
           <input style="background-color:#edede9;" type="number" class="form-control" id="stok" name="stok" readonly>
       </div>
         <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah">
        </div>
         <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo date('Y-m-d', strtotime('+8 hours')); ?>" readonly>
        </div>
         <div class="mb-4 col-2">
            <label for="harga_total" class="form-label">Harga Total</label>
            <input style="background-color:#edede9;" type="text" class="form-control" id="total" name="harga_total" readonly>
        </div>
            <button style="background-color:#3a5a40; color:white;" type="submit" name="simpan" class="btn btn">Tambah Data</button>
    </form>  
</div>  
    </main>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script type="text/javascript">

function validateForm() {
        var idPelanggan = document.getElementById("id_pelanggan").value;

        // Check if the selected value is not the default "Pilih" option
        if (idPelanggan === "0") {
            alert("Silakan pilih nama pelanggan!");
            return false; // Prevent form submission
        }

        // Continue with form submission if validation passes
        return true;
    }

$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

        $('#obat_id').on('change', function(){
  // ambil data dari elemen option yang dipilih
  const price = $('#obat_id option:selected').data('harga');
  const unit = $('#obat_id option:selected').data('unit');
  const stok = $('#obat_id option:selected').data('stok');
  const beli = $('#obat_id option:selected').data('beli');
  const banyak = $('#jumlah').val();
  
  // kalkulasi total harga
  const total = price;
  const total1 = beli;
  const total2 = unit;
  const total3 = stok;
  
  // tampilkan data ke element
  $('[name=stok]').val(`${total3}`);
  $('[name=unit_id]').val(`${total2}`);
  $('[name=harga_beli]').val(`${total1}`);

  $('#harga').val(`${total}`);
});

  $('#jumlah').on('change',function(){
    const price = $('#obat_id option:selected').data('harga');
    const beli = $('#obat_id option:selected').data('beli');
    const banyak = $('#jumlah').val();

    const total4 = banyak * price;
    const total5 = banyak * beli;

    $('#total').val(`${total4}`);
    $('#total_beli').val(`${total5}`);
  })
</script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="../../assets/dashboard.js"></script>
</body>
</html>