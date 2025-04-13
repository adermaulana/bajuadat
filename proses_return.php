<?php
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate input
    $id_order = mysqli_real_escape_string($koneksi, $_POST['id_order']);
    $alasan_return = mysqli_real_escape_string($koneksi, $_POST['alasan_return']);
    $keterangan_return = mysqli_real_escape_string($koneksi, $_POST['keterangan_return']);

    // Handle file upload
    $bukti_return = '';
    if (!empty($_FILES['bukti_return']['name'])) {
        $target_dir = "uploads/return/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . uniqid() . '_' . basename($_FILES['bukti_return']['name']);
        
        if (move_uploaded_file($_FILES['bukti_return']['tmp_name'], $target_file)) {
            $bukti_return = $target_file;
        } else {
            die("Gagal mengunggah bukti return");
        }
    }

    // Begin transaction
    mysqli_begin_transaction($koneksi);

    try {
        // Insert return request
        $return_query = "INSERT INTO return_produk (
            id_order, 
            alasan_return, 
            keterangan_return, 
            bukti_return, 
            status_return
        ) VALUES (
            '$id_order', 
            '$alasan_return', 
            '$keterangan_return', 
            '$bukti_return',
            'Menunggu Konfirmasi'
        )";
        
        if (!mysqli_query($koneksi, $return_query)) {
            throw new Exception("Gagal membuat permintaan return");
        }

        $return_id = mysqli_insert_id($koneksi);

        // Insert returned items
        if (isset($_POST['produk_return'])) {
            foreach ($_POST['produk_return'] as $id_detail_order) {
                $detail_query = "INSERT INTO detail_return (
                    id_return, 
                    id_detail_order
                ) VALUES (
                    '$return_id', 
                    '$id_detail_order'
                )";
                
                if (!mysqli_query($koneksi, $detail_query)) {
                    throw new Exception("Gagal menambahkan detail return");
                }
            }
        }

        // Update order status
        $update_order_query = "UPDATE data_order SET status_order = 'Return Proses' WHERE id_order = '$id_order'";
        if (!mysqli_query($koneksi, $update_order_query)) {
            throw new Exception("Gagal memperbarui status order");
        }

        // Commit transaction
        mysqli_commit($koneksi);

        // Redirect with success message
        echo "<script>
            alert('Permintaan return berhasil diajukan');
            document.location='pembayaran.php';
        </script>";
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($koneksi);

        // Remove uploaded file if transaction fails
        if (!empty($bukti_return) && file_exists($bukti_return)) {
            unlink($bukti_return);
        }

        echo "<script>
            alert('Gagal mengajukan return: " . $e->getMessage() . "');
            document.location='pembayaran.php';
        </script>";
    }
} else {
    // Redirect if accessed directly
    header("Location: pembayaran.php");
    exit;
}
?>