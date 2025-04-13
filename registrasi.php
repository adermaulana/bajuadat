<?php
    include 'config/koneksi.php';
    session_start();

    if (isset($_SESSION['status']) == 'login') {
        header("location:index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-form">
                    <h2 class="text-center">Registrasi</h2>
                    <form method="post">
                        <div class="mb-3">
                            <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_pelanggan" class="form-label">Alamat Pelanggan</label>
                            <input type="text" class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_pelanggan" class="form-label">Email Pelanggan</label>
                            <input type="email" class="form-control" id="email_pelanggan" name="email_pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="telepon_pelanggan" class="form-label">Telepon Pelanggan</label>
                            <input type="text" class="form-control" id="username_pelanggan" name="telepon_pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="username_pelanggan" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username_pelanggan" name="username_pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_pelanggan" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password_pelanggan" name="password_pelanggan" required>
                        </div>
                                                <!-- Add this inside the form -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                            <label class="form-check-label" for="showPassword">Show Password</label>
                        </div>
                        <button type="submit" name="registrasi" class="btn btn-primary btn-block">Daftar</button>
                                                <span>Sudah punya akun?<a href="login_pelanggan.php" class="text-decoration-none" > Login</a></span>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>