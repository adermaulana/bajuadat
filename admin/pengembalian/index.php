<?php
include '../../config/koneksi.php';

session_start();

if ($_SESSION['status'] != 'login') {
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
  <link rel="stylesheet" href="../../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../../assets/dashboard.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link href="../DataTables/datatables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../lightbox/css/lightbox.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
              <a class="nav-link " href="../penyewaan/index.php">
                <i class="fas fa-shopping-cart align-text-bottom me-2"></i>
                Penyewaan
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="index.php">
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

  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
    <div class="col-lg-12">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daftar Pengembalian Baju Adat</h1>
      </div>

      <div class="table-responsive col-lg-12">
        <table id="myTable" class="table table-striped table-sm mt-3">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">ID Penyewaan</th>
              <th scope="col">Alasan Pengembalian</th>
              <th scope="col">Keterangan</th>
              <th scope="col">Status</th>
              <th scope="col">Foto Kondisi</th>
              <th scope="col">Tanggal Pengembalian</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>RNT-2025041301</td>
              <td>Pengembalian Normal</td>
              <td>Baju adat dikembalikan dalam kondisi baik</td>
              <td>
                <span class="badge bg-success">Disetujui</span>
              </td>
              <td>
                <a href="../../img/minang.jpg" data-lightbox="bukti-return-1" data-title="Kondisi Baju Adat">
                  <img src="../../img/minang.jpg" alt="Kondisi Baju" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                </a>
              </td>
              <td>15/04/2025</td>
              <td>
                <a href="detail.php" class="badge bg-info border-0"><i class="fas fa-eye"></i></a>
                <a href="#" class="badge bg-success border-0" onclick="return confirm('Apakah Anda yakin ingin menerima pengembalian ini?')"><i class="fas fa-check-circle"></i></a>
                <a href="#" class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menolak pengembalian ini?')"><i class="fas fa-times-circle"></i></a>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>RNT-2025041202</td>
              <td>Kerusakan Kecil</td>
              <td>Terdapat noda pada bagian kerah kebaya</td>
              <td>
                <span class="badge bg-warning">Menunggu Konfirmasi</span>
              </td>
              <td>
                <a href="../../img/minang.jpg" data-lightbox="bukti-return-1" data-title="Kondisi Baju Adat">
                  <img src="../../img/minang.jpg" alt="Kondisi Baju" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                </a>
              </td>
              <td>12/04/2025</td>
              <td>
                <a href="detail.php" class="badge bg-info border-0"><i class="fas fa-eye"></i></a>
                <a href="#" class="badge bg-success border-0" onclick="return confirm('Apakah Anda yakin ingin menerima pengembalian ini?')"><i class="fas fa-check-circle"></i></a>
                <a href="#" class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menolak pengembalian ini?')"><i class="fas fa-times-circle"></i></a>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>RNT-2025041003</td>
              <td>Kehilangan Aksesoris</td>
              <td>Pendhing (ikat pinggang) tidak dikembalikan</td>
              <td>
                <span class="badge bg-danger">Ditolak</span>
              </td>
              <td>
                <span class="text-muted">Belum ada bukti return</span>
              </td>
              <td>10/04/2025</td>
              <td>
                <a href="detail.php" class="badge bg-info border-0"><i class="fas fa-eye"></i></a>
                <a href="#" class="badge bg-success border-0" onclick="return confirm('Apakah Anda yakin ingin menerima pengembalian ini?')"><i class="fas fa-check-circle"></i></a>
                <a href="#" class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menolak pengembalian ini?')"><i class="fas fa-times-circle"></i></a>
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>RNT-2025040804</td>
              <td>Kerusakan Parah</td>
              <td>Sobek pada bagian jahitan baju beskap</td>
              <td>
                <span class="badge bg-warning">Menunggu Konfirmasi</span>
              </td>
              <td>
                <a href="../../img/minang.jpg" data-lightbox="bukti-return-1" data-title="Kondisi Baju Adat">
                  <img src="../../img/minang.jpg" alt="Kondisi Baju" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                </a>
              </td>
              <td>08/04/2025</td>
              <td>
                <a href="detail.php" class="badge bg-info border-0"><i class="fas fa-eye"></i></a>
                <a href="#" class="badge bg-success border-0" onclick="return confirm('Apakah Anda yakin ingin menerima pengembalian ini?')"><i class="fas fa-check-circle"></i></a>
                <a href="#" class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menolak pengembalian ini?')"><i class="fas fa-times-circle"></i></a>
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>RNT-2025040605</td>
              <td>Pengembalian Terlambat</td>
              <td>Terlambat 2 hari dari batas waktu</td>
              <td>
                <span class="badge bg-success">Disetujui</span>
              </td>
              <td>
                <a href="../../img/minang.jpg" data-lightbox="bukti-return-1" data-title="Kondisi Baju Adat">
                  <img src="../../img/minang.jpg" alt="Kondisi Baju" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                </a>
              </td>
              <td>06/04/2025</td>
              <td>
                <a href="detail.php" class="badge bg-info border-0"><i class="fas fa-eye"></i></a>
                <a href="#" class="badge bg-success border-0" onclick="return confirm('Apakah Anda yakin ingin menerima pengembalian ini?')"><i class="fas fa-check-circle"></i></a>
                <a href="#" class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menolak pengembalian ini?')"><i class="fas fa-times-circle"></i></a>
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>RNT-2025040406</td>
              <td>Pengembalian Normal</td>
              <td>Dikembalikan dalam kondisi bersih</td>
              <td>
                <span class="badge bg-success">Disetujui</span>
              </td>
              <td>
                <a href="../../img/minang.jpg" data-lightbox="bukti-return-1" data-title="Kondisi Baju Adat">
                  <img src="../../img/minang.jpg" alt="Kondisi Baju" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                </a>
              </td>
              <td>04/04/2025</td>
              <td>
                <a href="detail.php" class="badge bg-info border-0"><i class="fas fa-eye"></i></a>
                <a href="#" class="badge bg-success border-0" onclick="return confirm('Apakah Anda yakin ingin menerima pengembalian ini?')"><i class="fas fa-check-circle"></i></a>
                <a href="#" class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menolak pengembalian ini?')"><i class="fas fa-times-circle"></i></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  </div>
</div>
<script src="../../lightbox/js/lightbox-plus-jquery.js"></script>
<script src="../DataTables/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
<script src="../DataTables/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="../../assets/dashboard.js"></script>
<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
</script>

</body>
</html>
