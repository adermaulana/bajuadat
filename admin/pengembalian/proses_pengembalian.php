<?php
include '../../config/koneksi.php';

session_start();

if (!isset($_SESSION['status'])) {
    header("location:../");
}

// Proses Tambah Pengembalian oleh Admin
if (isset($_POST['tambah'])) {
    $pesanan_id = $_POST['pesanan_id'];
    $alasan = $_POST['alasan'];
    $keterangan = $_POST['keterangan'];
    $tanggal = date('Y-m-d');
    $admin_id = $_SESSION['id_admin'];
    
    // Upload foto
    $foto_name = '';
    if ($_FILES['foto_kondisi']['name']) {
        $foto_name = 'bukti_'.time().'_'.$_FILES['foto_kondisi']['name'];
        $target = 'bukti_pengembalian/'.$foto_name;
        move_uploaded_file($_FILES['foto_kondisi']['tmp_name'], $target);
    }
    
    // Insert data pengembalian
    $query = "INSERT INTO pengembalian_222145 
              (pesanan_id_222145, tanggal_pengembalian_222145, alasan_pengembalian_222145, 
               keterangan_222145, foto_kondisi_222145, status_222145, admin_id_222145)
              VALUES ('$pesanan_id', '$tanggal', '$alasan', '$keterangan', '$foto_name', 'Disetujui', '$admin_id')";
    mysqli_query($koneksi, $query);
    
    // Update status pesanan
    $update = "UPDATE pesanan_222145 SET status_222145 = 'selesai' WHERE pesanan_id_222145 = '$pesanan_id'";
    mysqli_query($koneksi, $update);
    
    // Kembalikan stok produk
    $detail_query = "SELECT * FROM detail_pesanan_222145 
                    WHERE pesanan_id_222145 = '$pesanan_id'";
    $detail_result = mysqli_query($koneksi, $detail_query);
    
    while ($detail = mysqli_fetch_assoc($detail_result)) {
        $update_stok = "UPDATE ukuran_produk_222145 
                        SET stok_222145 = stok_222145 + ".$detail['jumlah_222145']."
                        WHERE produk_id_222145 = '".$detail['produk_id_222145']."' 
                        AND ukuran_222145 = '".$detail['ukuran_222145']."'";
        mysqli_query($koneksi, $update_stok);
    }
    
    $_SESSION['success'] = "Pengembalian berhasil dicatat";
    header("location:index.php");
    exit();
}

// Proses Approve/Reject (jika masih diperlukan)
$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if ($id && $action) {
    // ... (kode untuk approve/reject tetap sama seperti sebelumnya)
}

header("location:index.php");
?>