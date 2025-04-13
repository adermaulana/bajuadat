<?php

  include './config/koneksi.php';

  session_start();

  // Cek apakah pengguna sudah login
  if(isset($_SESSION['username_admin'])) {
      $isLoggedIn = true;
      $userName = $_SESSION['username_admin']; // Ambil nama user dari session
  } else if(isset($_SESSION['username_pelanggan'])) {
    $isLoggedIn = true;
    $userName = $_SESSION['username_pelanggan']; // Ambil nama user dari session
  } 
  
  else {
      $isLoggedIn = false;
  }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Penyewaan Baju Adat</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/14cd2e1081.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">
            <img src="img/logobaju.png" width="70" alt="">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/scm-najwa/index.php') echo 'active'; ?>" aria-current="page" href="index.php">Halaman Utama</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/scm-najwa/material.php') echo 'active'; ?>" href="bajuadat.php">Produk</a>
              </li>
            </ul>

            <?php if($isLoggedIn): ?>
                <!-- Tampilkan elemen navigasi setelah login -->
                <ul class="navbar-nav ms-auto me-5">
                <li class="nav-item">
                  <?php if(isset($_SESSION['username_admin'])): ?>
                    <a class="btn btn-light" href="admin/index.php">Dashboard</a>
                    <?php else: ?>
                      <div class="dropdown me-5">
                        <a href="keranjang.php" class="btn btn-light"><i class="fa-solid fa-cart-shopping"></i></a>
                        <a class="btn btn-light dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Welcome, <?= $_SESSION['username_pelanggan'] ?>
                        </a>

                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="pembayaran.php">Pembayaran</a></li>
                          <li><a class="dropdown-item" href="admin/hapusSession.php">Logout</a></li>
                        </ul>
                      </div>
                  <?php endif; ?>
                </li>
                </ul>
            <?php else: ?>
            <!-- Start Tombol Button -->
            <ul class="navbar-nav ms-auto me-5">
                <li class="nav-item">
                  <a href="keranjang.php" class="btn btn-light"><i class="fa-solid fa-cart-shopping"></i></a>
                    <a class="btn btn-light" href="login_pelanggan.php">Login</a>
                </li>
            </ul>
            <!-- End Tombol Button -->
            <?php endif; ?>

          </div>
        </div>
      </nav>
    </header>
    <main class="container mt-4 mb-3">
