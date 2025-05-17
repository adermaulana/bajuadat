<?php
include '../../config/koneksi.php';

session_start();

if ($_SESSION['status'] != 'login') {
    session_unset();
    session_destroy();
    header("location:../");
}

// Query untuk mendapatkan data pengembalian
$query = "SELECT p.*, pl.nama_lengkap_222145, ps.tanggal_sewa_222145, ps.tanggal_kembali_222145 
          FROM pengembalian_222145 p
          JOIN pesanan_222145 ps ON p.pesanan_id_222145 = ps.pesanan_id_222145
          JOIN pelanggan_222145 pl ON ps.pelanggan_id_222145 = pl.pelanggan_id_222145
          ORDER BY p.tanggal_pengembalian_222145 DESC";
$result = mysqli_query($koneksi, $query);
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
            <li class="nav-item">
              <a class="nav-link" href="../laporan/index.php">
                <i class="fas fa-file align-text-bottom me-2"></i>
                Laporan
              </a>
            </li>
          </ul>
        </div>
      </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
      <div class="col-lg-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Daftar Pengembalian Baju Adat</h1>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPengembalian">
            <i class="fas fa-plus"></i> Tambah Pengembalian
          </button>
        </div>

        <!-- Modal Tambah Pengembalian -->
        <div class="modal fade" id="tambahPengembalian" tabindex="-1" aria-labelledby="tambahPengembalianLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="proses_pengembalian.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="tambahPengembalianLabel">Tambah Data Pengembalian</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="pesanan_id" class="form-label">Pilih Pesanan</label>
                    <select class="form-select" id="pesanan_id" name="pesanan_id" required>
                      <option value="">-- Pilih Pesanan --</option>
                      <?php
                      $query_pesanan = "SELECT p.*, pl.nama_lengkap_222145 
                                      FROM pesanan_222145 p
                                      JOIN pelanggan_222145 pl ON p.pelanggan_id_222145 = pl.pelanggan_id_222145
                                      WHERE p.status_222145 = 'Disewa'";
                      $result_pesanan = mysqli_query($koneksi, $query_pesanan);
                      while ($row = mysqli_fetch_assoc($result_pesanan)): ?>
                        <option value="<?= $row['pesanan_id_222145']; ?>">
                          <?= $row['pesanan_id_222145']; ?> - <?= $row['nama_lengkap_222145']; ?>
                          (<?= date('d/m/Y', strtotime($row['tanggal_sewa_222145'])); ?> s/d <?= date('d/m/Y', strtotime($row['tanggal_kembali_222145'])); ?>)
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  
                  <div class="mb-3">
                    <label for="alasan" class="form-label">Alasan Pengembalian</label>
                    <select class="form-select" id="alasan" name="alasan" required>
                      <option value="">-- Pilih Alasan --</option>
                      <option value="Pengembalian Normal">Pengembalian Normal</option>
                      <option value="Kerusakan Kecil">Kerusakan Kecil</option>
                      <option value="Kerusakan Parah">Kerusakan Parah</option>
                      <option value="Kehilangan Aksesoris">Kehilangan Aksesoris</option>
                      <option value="Pengembalian Terlambat">Pengembalian Terlambat</option>
                    </select>
                  </div>
                  
                  <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                  </div>
                  
                  <div class="mb-3">
                    <label for="foto_kondisi" class="form-label">Foto Kondisi Baju</label>
                    <input class="form-control" type="file" id="foto_kondisi" name="foto_kondisi">
                    <small class="text-muted">Upload foto jika ada kerusakan atau masalah</small>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

            <div class="table-responsive col-lg-12">
              <table id="myTable" class="table table-striped table-sm mt-3">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">ID Penyewaan</th>
                    <th scope="col">Nama Pelanggan</th>
                    <th scope="col">Alasan Pengembalian</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Status</th>
                    <th scope="col">Foto Kondisi</th>
                    <th scope="col">Tanggal Pengembalian</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $no = 1;
                  while ($row = mysqli_fetch_assoc($result)): 
                    $status_class = '';
                    if ($row['status_222145'] == 'Disetujui') {
                      $status_class = 'bg-success';
                    } elseif ($row['status_222145'] == 'Ditolak') {
                      $status_class = 'bg-danger';
                    } else {
                      $status_class = 'bg-warning';
                    }
                  ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['pesanan_id_222145']; ?></td>
                    <td><?= $row['nama_lengkap_222145']; ?></td>
                    <td><?= $row['alasan_pengembalian_222145']; ?></td>
                    <td><?= $row['keterangan_222145']; ?></td>
                    <td>
                      <span class="badge <?= $status_class; ?>"><?= $row['status_222145']; ?></span>
                    </td>
                    <td>
                      <?php if (!empty($row['foto_kondisi_222145'])): ?>
                        <a href="bukti_pengembalian/<?= $row['foto_kondisi_222145']; ?>" data-lightbox="bukti-return-<?= $row['pengembalian_id_222145']; ?>" data-title="Kondisi Baju Adat">
                          <img src="bukti_pengembalian/<?= $row['foto_kondisi_222145']; ?>" alt="Kondisi Baju" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                        </a>
                      <?php else: ?>
                        <span class="text-muted">Tidak ada foto</span>
                      <?php endif; ?>
                    </td>
                    <td><?= date('d/m/Y', strtotime($row['tanggal_pengembalian_222145'])); ?></td>
                    <td>
                      <a href="detail.php?id=<?= $row['pengembalian_id_222145']; ?>" class="badge bg-info border-0"><i class="fas fa-eye"></i></a>
                      <?php if ($row['status_222145'] == 'Menunggu Konfirmasi'): ?>
                        <a href="proses_pengembalian.php?action=approve&id=<?= $row['pengembalian_id_222145']; ?>" class="badge bg-success border-0" onclick="return confirm('Apakah Anda yakin ingin menerima pengembalian ini?')"><i class="fas fa-check-circle"></i></a>
                        <a href="proses_pengembalian.php?action=reject&id=<?= $row['pengembalian_id_222145']; ?>" class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menolak pengembalian ini?')"><i class="fas fa-times-circle"></i></a>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endwhile; ?>
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
