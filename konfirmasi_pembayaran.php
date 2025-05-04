<?php 
include 'partials/header.php';

if(!isset($_SESSION['id_pelanggan'])) {
    echo "<script>
    alert('Anda harus login terlebih dahulu!');
    document.location='login_pelanggan.php';
    </script>";
    exit;
}

$id_pelanggan = $_SESSION['id_pelanggan'];
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

// Get order and customer details
$query = "SELECT p.*, 
                 pl.nama_lengkap_222145, 
                 pl.alamat_222145, 
                 pl.no_telp_222145, 
                 pl.email_222145,
                 GROUP_CONCAT(pr.nama_produk_222145 SEPARATOR ' + ') AS produk,
                 SUM(dp.sub_total_222145) AS total
          FROM pesanan_222145 p
          JOIN pelanggan_222145 pl ON p.pelanggan_id_222145 = pl.pelanggan_id_222145
          JOIN detail_pesanan_222145 dp ON p.pesanan_id_222145 = dp.pesanan_id_222145
          JOIN produk_222145 pr ON dp.produk_id_222145 = pr.produk_id_222145
          WHERE p.pesanan_id_222145 = $order_id
          AND p.pelanggan_id_222145 = $id_pelanggan
          GROUP BY p.pesanan_id_222145";
$result = mysqli_query($koneksi, $query);

if(!$result || mysqli_num_rows($result) == 0) {
    echo "<script>
    alert('Pesanan tidak ditemukan!');
    document.location='pembayaran.php';
    </script>";
    exit;
}

$order = mysqli_fetch_assoc($result);

// Calculate rental duration
$sewa = new DateTime($order['tanggal_sewa_222145']);
$kembali = new DateTime($order['tanggal_kembali_222145']);
$durasi = $sewa->diff($kembali)->format('%a');

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simpan'])) {
    $metode_pembayaran = mysqli_real_escape_string($koneksi, $_POST['metode_pembayaran']);
    $tanggal_pengambilan = mysqli_real_escape_string($koneksi, $_POST['tanggal_pengambilan']);
    
    // Handle file upload
    $bukti_pembayaran = '';
    if(isset($_FILES['bukti_pembayaran'])) {
        $file = $_FILES['bukti_pembayaran'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        
        // Check if file was uploaded without errors
        if($file_error === 0) {
            // Validate file type and size
            $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
            $max_size = 2 * 1024 * 1024; // 2MB
            
            if(in_array($file['type'], $allowed_types) && $file_size <= $max_size) {
                // Generate unique filename
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $file_new_name = 'bukti_'.$order_id.'_'.time().'.'.$file_ext;
                $upload_path = 'bukti_pembayaran/'.$file_new_name;
                
                if(move_uploaded_file($file_tmp, $upload_path)) {
                    $bukti_pembayaran = $file_new_name;
                }
            }
        }
    }
    
    // Insert payment data
    $insert_query = "INSERT INTO pembayaran_222145 (
        pesanan_id_222145,
        metode_pembayaran_222145,
        jumlah_pembayaran_222145,
        bukti_pembayaran_222145,
        status_222145,
        tanggal_pembayaran_222145
    ) VALUES (
        $order_id,
        '$metode_pembayaran',
        {$order['total']},
        '$bukti_pembayaran',
        'menunggu',
        NOW()
    )";
    
    // Update order status
    $update_query = "UPDATE pesanan_222145 
                    SET status_222145 = 'diproses' 
                    WHERE pesanan_id_222145 = $order_id";
    
    if(mysqli_query($koneksi, $insert_query) && mysqli_query($koneksi, $update_query)) {
        echo "<script>
        alert('Konfirmasi pembayaran berhasil!');
        document.location='pembayaran.php';
        </script>";
        exit;
    } else {
        $error = "Gagal menyimpan konfirmasi pembayaran: ".mysqli_error($koneksi);
    }
}
?>

<div class="row">
    <div class="col-lg-4 col-md-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <h4>Data Penyewa</h4>
                <span>Nama : <b><?= htmlspecialchars($order['nama_lengkap_222145']) ?></b></span><br>
                <span>Alamat : <b><?= htmlspecialchars($order['alamat_222145']) ?></b></span><br>
                <span>Telepon : <b><?= htmlspecialchars($order['no_telp_222145']) ?></b></span><br>
                <span>Email : <b><?= htmlspecialchars($order['email_222145']) ?></b></span><br>
                <hr>
                <span>Terima Kasih Telah Menyewa di Kami</span>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body col-lg-10">
                <h4>Detail Penyewaan Baju Adat</h4>
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <ul class="list-group mb-3">
                    <?php 
                    // Get order items
                    $items_query = "SELECT dp.*, p.nama_produk_222145, p.ukuran_222145
                                  FROM detail_pesanan_222145 dp
                                  JOIN produk_222145 p ON dp.produk_id_222145 = p.produk_id_222145
                                  WHERE dp.pesanan_id_222145 = $order_id";
                    $items_result = mysqli_query($koneksi, $items_query);
                    
                    while($item = mysqli_fetch_assoc($items_result)): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><?= htmlspecialchars($item['nama_produk_222145']) ?> - <?= htmlspecialchars($item['ukuran_222145']) ?></span>
                            <span><?= $item['jumlah_222145'] ?> set</span>
                        </li>
                    <?php endwhile; ?>
                    
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Durasi Sewa</span>
                        <span><?= $durasi ?> Hari</span>
                    </li>
                </ul>
                
                <form action="" method="post" enctype="multipart/form-data">                    
                    <div class="mb-3">
                        <label class="form-label">Total Pembayaran</label>
                        <input type="text" name="total_bayar" value="Rp <?= number_format($order['total'], 0, ',', '.') ?>" class="form-control" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-select" name="metode_pembayaran" required>
                            <option value="">Pilih Bank</option>
                            <option value="BCA">BCA - 0583493xxx (Baju Adat Nusantara)</option>
                            <option value="BRI">BRI - 1234567890 (Baju Adat Nusantara)</option>
                            <option value="Mandiri">Mandiri - 9876543210 (Baju Adat Nusantara)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pengambilan</label>
                        <input type="date" class="form-control" name="tanggal_pengambilan" 
                               min="<?= date('Y-m-d') ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Bukti Transfer</label>
                        <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*" required>
                        <small class="text-muted">Upload bukti transfer (format: JPG/PNG, max 2MB)</small>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                        <label class="form-check-label" for="agreeTerms">
                            Saya menyetujui syarat dan ketentuan penyewaan
                        </label>
                    </div>
                    
                    <button type="submit" name="simpan" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>