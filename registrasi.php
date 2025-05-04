<?php
include 'config/koneksi.php';
session_start();

// Redirect if already logged in
if (isset($_SESSION['status']) && $_SESSION['status'] == 'login') {
    header("location:index.php");
    exit();
}

// Handle form submission
if (isset($_POST['registrasi'])) {
    // Get form data
    $username = mysqli_real_escape_string($koneksi, $_POST['username_pelanggan']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password_pelanggan']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat_pelanggan']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email_pelanggan']);
    $telepon = mysqli_real_escape_string($koneksi, $_POST['telepon_pelanggan']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid";
    } else {
        // Check if username or email already exists
        $check_query = "SELECT * FROM pelanggan_222145 WHERE username_222145 = '$username' OR email_222145 = '$email'";
        $check_result = mysqli_query($koneksi, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username atau email sudah terdaftar";
        } else {
            // Hash password
            $hashed_password = md5($password);

            // Insert new customer without KTP photo
            $insert_query = "INSERT INTO pelanggan_222145 (
                username_222145, 
                password_222145, 
                nama_lengkap_222145, 
                alamat_222145, 
                no_telp_222145, 
                email_222145, 
                status_akun_222145
            ) VALUES (
                '$username', 
                '$hashed_password', 
                '$nama_lengkap', 
                '$alamat', 
                '$telepon', 
                '$email', 
                'aktif'
            )";

            if (mysqli_query($koneksi, $insert_query)) {
                $success = "Registrasi berhasil! Silakan login.";
                // Clear form
                $_POST = array();
            } else {
                $error = "Registrasi gagal: " . mysqli_error($koneksi);
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
    <title>Registrasi Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-form {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: white;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-form">
                    <h2 class="text-center">Registrasi</h2>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" 
                                value="<?php echo isset($_POST['nama_pelanggan']) ? htmlspecialchars($_POST['nama_pelanggan']) : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_pelanggan" class="form-label">Alamat Pelanggan</label>
                            <input type="text" class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" 
                                value="<?php echo isset($_POST['alamat_pelanggan']) ? htmlspecialchars($_POST['alamat_pelanggan']) : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_pelanggan" class="form-label">Email Pelanggan</label>
                            <input type="email" class="form-control" id="email_pelanggan" name="email_pelanggan" 
                                value="<?php echo isset($_POST['email_pelanggan']) ? htmlspecialchars($_POST['email_pelanggan']) : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telepon_pelanggan" class="form-label">Telepon Pelanggan</label>
                            <input type="text" class="form-control" id="telepon_pelanggan" name="telepon_pelanggan" 
                                value="<?php echo isset($_POST['telepon_pelanggan']) ? htmlspecialchars($_POST['telepon_pelanggan']) : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="username_pelanggan" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username_pelanggan" name="username_pelanggan" 
                                value="<?php echo isset($_POST['username_pelanggan']) ? htmlspecialchars($_POST['username_pelanggan']) : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_pelanggan" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password_pelanggan" name="password_pelanggan" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                            <label class="form-check-label" for="showPassword">Tampilkan Password</label>
                        </div>
                        <button type="submit" name="registrasi" class="btn btn-primary btn-block">Daftar</button>
                            <span>Sudah punya akun? <a href="login_pelanggan.php" class="text-decoration-none">Login</a></span>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password_pelanggan");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>