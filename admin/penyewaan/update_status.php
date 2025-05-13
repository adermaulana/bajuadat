<?php
// update_status.php
require_once '../../config/koneksi.php'; // or your connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pesanan_id = $_POST['pesanan_id'];
    $status = $_POST['status_222145'];
    
    $query = "UPDATE pesanan_222145 SET status_222145 = ? WHERE pesanan_id_222145 = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "si", $status, $pesanan_id);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: ".$_SERVER['HTTP_REFERER']."?success=1");
    } else {
        header("Location: ".$_SERVER['HTTP_REFERER']."?error=1");
    }
    exit;
}
?>