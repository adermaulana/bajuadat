<?php

    include 'config/koneksi.php';

    session_start();

    if(isset($_SESSION['status']) == 'login'){

        header("location:admin");
    }

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Server-side validation for password length
    if(strlen($password) < 8) {
        echo "<script>
        alert('Password minimal 8 karakter!');
        </script>";
    } else {
        $password = md5($password);

        $login = mysqli_query($koneksi, "SELECT * FROM admin_222145 WHERE username_222145='$username' and password_222145='$password'");
        $cek = mysqli_num_rows($login);

        $login2 = mysqli_query($koneksi, "SELECT * FROM pelanggan_222145 WHERE username_222145='$username' and password_222145='$password'");
        $cek2 = mysqli_num_rows($login2);

        if($cek > 0) {
            $admin_data = mysqli_fetch_assoc($login);
            $_SESSION['id_admin'] = $admin_data['admin_id_222145'];
            $_SESSION['nama_admin'] = $admin_data['nama_lengkap_222145'];
            $_SESSION['username_admin'] = $username;
            $_SESSION['status'] = "login";
            header('location:admin');

        } else if($cek2 > 0) {
            $admin_data = mysqli_fetch_assoc($login2);
            $_SESSION['id_pelanggan'] = $admin_data['pelanggan_id_222145'];
            $_SESSION['nama_pelanggan'] = $admin_data['nama_lengkap_222145'];
            $_SESSION['alamat_pelanggan'] = $admin_data['alamat_222145'];
            $_SESSION['email_pelanggan'] = $admin_data['email_222145'];
            $_SESSION['username_pelanggan'] = $username;
            $_SESSION['status'] = "login";
            header('location:index.php');

        } else {
            echo "<script>
            alert('Login Gagal, Periksa Username dan Password Anda!');
            </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                    <h2 class="text-center">Login</h2>
                    <form method="post" id="loginForm">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                            <small id="passwordHelp" class="form-text text-muted">Password minimal 8 karakter</small>
                            <small id="passwordError" class="form-text text-danger" style="display: none;">Password harus minimal 8 karakter!</small>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                            <label class="form-check-label" for="showPassword">Show Password</label>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                        <span>Belum punya akun?<a href="registrasi.php" class="text-decoration-none"> Registrasi</a></span>
                    </form>
                </div>
            </div>
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
    
    if (password.length > 0 && password.length < 8) {
        helpText.style.display = 'none';
        errorText.style.display = 'block';
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else if (password.length >= 8) {
        helpText.style.display = 'block';
        errorText.style.display = 'none';
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
    } else {
        helpText.style.display = 'block';
        errorText.style.display = 'none';
        this.classList.remove('is-invalid', 'is-valid');
    }
});

// Form submission validation
document.getElementById('loginForm').addEventListener('submit', function(e) {
    var password = document.getElementById('password').value;
    
    if (password.length < 8) {
        e.preventDefault();
        alert('Password minimal 8 karakter!');
        return false;
    }
});

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>