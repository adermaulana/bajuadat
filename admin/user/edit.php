<?php

include '../../config/koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){
    session_unset();
    session_destroy();
    header("location:../");
}

if(isset($_GET['hal'])){
    if($_GET['hal'] == "edit"){
        $tampil = mysqli_query($koneksi, "SELECT * FROM admin_222145 WHERE admin_id_222145 = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if($data){
            $admin_id = $data['admin_id_222145'];
            $username = $data['username_222145'];
            $nama_lengkap = $data['nama_lengkap_222145'];
            $email = $data['email_222145'];
        }
    }
}

// Update Data
if(isset($_POST['simpan'])){
    // Get form data with security measures
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid";
    } else {
        // Check if password field is not empty (optional update)
        $password_update = "";
        if(!empty($_POST['password'])){
            $password = $_POST['password'];
            
            // Validate password
            if(strlen($password) < 8) {
                $error = "Password minimal 8 karakter!";
            } else if(!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
                $error = "Password harus mengandung minimal 8 karakter dengan kombinasi huruf dan angka!";
            } else {
                $hashed_password = md5($password);
                $password_update = ", password_222145 = '$hashed_password'";
            }
        }
        
        // Continue if no password error
        if(!isset($error)){
            // Check for duplicate username (excluding current admin)
            $check = mysqli_query($koneksi, "SELECT * FROM admin_222145 WHERE username_222145 = '$username' AND admin_id_222145 != '$_GET[id]'");
            
            if(mysqli_num_rows($check) > 0){
                $error = "Username sudah digunakan! Silakan gunakan username lain.";
            } else {
                $simpan = mysqli_query($koneksi, "UPDATE admin_222145 SET
                                        username_222145 = '$username',
                                        nama_lengkap_222145 = '$nama_lengkap',
                                        email_222145 = '$email'
                                        $password_update
                                        WHERE admin_id_222145 = '$_GET[id]'");
                
                if($simpan){
                   echo "<script>
                        alert('Data admin berhasil diupdate!');
                        document.location='index.php';
                    </script>";
                } else {
                    $error = "Update data gagal: " . mysqli_error($koneksi);
                }
            }
        }
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
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
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
              <a class="nav-link active" href="index.php">
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
            <h1 class="h2">Data Admin</h1>
        </div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Admin</h1>
        </div>

        <!-- Alert untuk menampilkan pesan error atau sukses -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="col-lg-8">
            <form method="post" class="mb-5" id="editAdminForm">
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                        value="<?= isset($nama_lengkap) ? htmlspecialchars($nama_lengkap) : '' ?>" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" 
                        value="<?= isset($username) ? htmlspecialchars($username) : '' ?>" required>
                    <small class="text-muted">Username harus unik dan tidak boleh sama dengan yang sudah ada</small>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" 
                        minlength="8" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                    <small id="passwordHelp" class="form-text text-muted">Kosongkan jika tidak ingin mengubah password. Jika diisi, password minimal 8 karakter dengan kombinasi huruf dan angka</small>
                    <small id="passwordError" class="form-text text-danger" style="display: none;">Password harus minimal 8 karakter dengan kombinasi huruf dan angka!</small>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                    <label class="form-check-label" for="showPassword">Tampilkan Password</label>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                        value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
                </div>
                <button style="background-color:#3a5a40; color:white;" type="submit" name="simpan" class="btn">Update Admin</button>
                <a href="index.php" class="btn btn-secondary ms-2">Kembali</a>
            </form>
        </div>  
    </main>
  </div>
</div>

<script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }

    // Real-time password validation
    document.getElementById('password').addEventListener('input', function() {
        var password = this.value;
        var helpText = document.getElementById('passwordHelp');
        var errorText = document.getElementById('passwordError');
        
        // Jika password kosong, tidak perlu validasi (opsional)
        if (password.length === 0) {
            helpText.style.display = 'block';
            errorText.style.display = 'none';
            this.classList.remove('is-invalid', 'is-valid');
            return;
        }
        
        // Regex untuk mengecek minimal 8 karakter dengan huruf dan angka
        var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        
        if (password.length > 0 && !regex.test(password)) {
            helpText.style.display = 'none';
            errorText.style.display = 'block';
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        } else if (regex.test(password)) {
            helpText.style.display = 'block';
            errorText.style.display = 'none';
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
        }
    });

    // Form submission validation
    document.getElementById('editAdminForm').addEventListener('submit', function(e) {
        var password = document.getElementById('password').value;
        
        // Jika password tidak kosong, validasi
        if (password.length > 0) {
            var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
            
            if (!regex.test(password)) {
                e.preventDefault();
                alert('Password harus minimal 8 karakter dengan kombinasi huruf dan angka!');
                return false;
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="../../assets/dashboard.js"></script>
</body>
</html>