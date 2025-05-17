<?php
include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){
    session_unset();
    session_destroy();
    header("location:../");
}

// Default filter: bulan ini
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'bulan';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Build the WHERE clause based on filter
$where = "";
switch($filter) {
    case 'hari':
        $where = "WHERE DATE(p.tanggal_pesanan_222145) = CURDATE()";
        break;
    case 'minggu':
        $where = "WHERE YEARWEEK(p.tanggal_pesanan_222145, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'bulan':
        $where = "WHERE MONTH(p.tanggal_pesanan_222145) = MONTH(CURDATE()) AND YEAR(p.tanggal_pesanan_222145) = YEAR(CURDATE())";
        break;
    case 'range':
        if(!empty($start_date) && !empty($end_date)) {
            $where = "WHERE DATE(p.tanggal_pesanan_222145) BETWEEN '$start_date' AND '$end_date'";
        }
        break;
    default:
        $where = "";
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

// Calculate total pendapatan
$total_query = "SELECT SUM(total_harga_222145) as total FROM pesanan_222145 p $where";
$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_pendapatan = $total_row['total'] ? "Rp. " . number_format($total_row['total'], 0, ',', '.') : "Rp. 0";
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
              <a class="nav-link active" href="index.php">
                <i class="fas fa-file align-text-bottom me-2"></i>
                Laporan
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Penyewaan Baju Adat</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <a href="export_word.php?filter=<?= $filter ?>&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn btn-sm btn-outline-primary">
              <i class="fas fa-file-word"></i> Export to Word
            </a>
            <a href="export_excel.php?filter=<?= $filter ?>&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn btn-sm btn-outline-success">
              <i class="fas fa-file-excel"></i> Export to Excel
            </a>
          </div>
        </div>
      </div>

    <!-- Filter Section -->
    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-filter me-1"></i>
        Filter Laporan
      </div>
      <div class="card-body">
        <form method="get" action="">
          <div class="row mb-3">
            <div class="col-md-3">
              <select class="form-select" name="filter" id="filter" onchange="toggleDateRange()">
                <option value="hari" <?= $filter == 'hari' ? 'selected' : '' ?>>Hari Ini</option>
                <option value="minggu" <?= $filter == 'minggu' ? 'selected' : '' ?>>Minggu Ini</option>
                <option value="bulan" <?= $filter == 'bulan' ? 'selected' : '' ?>>Bulan Ini</option>
                <option value="range" <?= $filter == 'range' ? 'selected' : '' ?>>Range Tanggal</option>
              </select>
            </div>
            <div class="col-md-4" id="dateRangeContainer" style="display: <?= $filter == 'range' ? 'block' : 'none' ?>;">
              <div class="input-group">
                <input type="date" class="form-control" name="start_date" value="<?= $start_date ?>">
                <span class="input-group-text">s/d</span>
                <input type="date" class="form-control" name="end_date" value="<?= $end_date ?>">
              </div>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary">Filter</button>
              <a href="index.php" class="btn btn-secondary">Reset</a>
            </div>
          </div>
        </form>
        
        <!-- Summary Card -->
        <div class="alert alert-info">
          <strong>Total Pendapatan:</strong> <?= $total_pendapatan ?>
          <span class="float-end">
            <?php
            switch($filter) {
              case 'hari': echo "Laporan Harian (Hari Ini)"; break;
              case 'minggu': echo "Laporan Mingguan (Minggu Ini)"; break;
              case 'bulan': echo "Laporan Bulanan (Bulan Ini)"; break;
              case 'range': 
                echo "Laporan Dari " . date('d/m/Y', strtotime($start_date)) . 
                     " Sampai " . date('d/m/Y', strtotime($end_date));
                break;
              default: echo "Laporan Semua Data";
            }
            ?>
          </span>
        </div>
      </div>
    </div>

          <div class="table-responsive col-lg-12">
            <table id="myTable" class="table table-striped table-sm mt-3">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama Penyewa</th>
                  <th scope="col">Email</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">Telepon</th>
                  <th scope="col">Total Biaya</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($result)): 
                  $formatted_price = "Rp. " . number_format($row['total_harga_222145'], 0, ',', '.');
                ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_lengkap_222145']); ?></td>
                    <td><?= htmlspecialchars($row['email_222145']); ?></td>
                    <td><?= htmlspecialchars($row['alamat_222145']); ?></td>
                    <td><?= htmlspecialchars($row['no_telp_222145']); ?></td>
                    <td><?= $formatted_price; ?></td>
                    <td>
                      <?php
                      switch($row['status_222145']) {
                        case 'menunggu':
                          echo '<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal'.$row['pesanan_id_222145'].'">
                                  Menunggu
                                </button>';
                          break;
                        case 'diproses':
                          echo '<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal'.$row['pesanan_id_222145'].'">
                                  Diproses
                                </button>';
                          break;
                        case 'disewa':
                          echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal'.$row['pesanan_id_222145'].'">
                                  Disewa
                                </button>';
                          break;
                        case 'selesai':
                          echo '<button type="button" class="btn btn-success">
                                  Selesai
                                </button>';
                          break;
                        case 'dibatalkan':
                          echo '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal'.$row['pesanan_id_222145'].'">
                                  Dibatalkan
                                </button>';
                          break;
                        default:
                          echo '<button type="button" class="btn btn-secondary">
                                  '.$row['status_222145'].'
                                </button>';
                      }
                      ?>
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


<!-- Include jQuery -->
<script src="../DataTables/jQuery-3.7.0/jquery-3.7.0.min.js"></script>


  <script>
    function toggleDateRange() {
      const filter = document.getElementById('filter').value;
      const container = document.getElementById('dateRangeContainer');
      
      if (filter === 'range') {
        container.style.display = 'block';
      } else {
        container.style.display = 'none';
      }
    }
  </script>

<script>

$(document).ready( function () {
    $('#myTable').DataTable();
} );
  
</script>



<script src="../DataTables/datatables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="../../assets/dashboard.js"></script>
</body>
</html>