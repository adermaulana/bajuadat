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

// Get order details
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
    if(isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] == 0) {
        $target_dir = "bukti_pembayaran/";
        $file_name = basename($_FILES["bukti_pembayaran"]["name"]);
        $target_file = $target_dir . uniqid() . '_' . $file_name;
        
        // Check file type and size
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        if(in_array($_FILES['bukti_pembayaran']['type'], $allowed_types) && 
           $_FILES['bukti_pembayaran']['size'] <= $max_size) {
            if(move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
                $bukti_pembayaran = $target_file;
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
    
    // Start transaction
    mysqli_begin_transaction($koneksi);
    
    try {
        // Insert payment
        if(!mysqli_query($koneksi, $insert_query)) {
            throw new Exception("Gagal menyimpan pembayaran: " . mysqli_error($koneksi));
        }
        
        // Update order status
        if(!mysqli_query($koneksi, $update_query)) {
            throw new Exception("Gagal mengupdate status pesanan: " . mysqli_error($koneksi));
        }
        
        // Commit transaction
        mysqli_commit($koneksi);
        
        echo "<script>
        alert('Konfirmasi pembayaran berhasil dikirim!');
        document.location='pembayaran.php';
        </script>";
        exit;
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        $error = $e->getMessage();
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Data Penyewa</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> <?= htmlspecialchars($order['nama_lengkap_222145']) ?></p>
                    <p><strong>Alamat:</strong> <?= htmlspecialchars($order['alamat_222145']) ?></p>
                    <p><strong>Telepon:</strong> <?= htmlspecialchars($order['no_telp_222145']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($order['email_222145']) ?></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Konfirmasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <h6>Detail Pesanan</h6>
                    <table class="table table-bordered mb-4">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga/Hari</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Get detailed order items
                            $items_query = "SELECT dp.*, pr.nama_produk_222145, pr.harga_sewa_222145
                                          FROM detail_pesanan_222145 dp
                                          JOIN produk_222145 pr ON dp.produk_id_222145 = pr.produk_id_222145
                                          WHERE dp.pesanan_id_222145 = $order_id";
                            $items_result = mysqli_query($koneksi, $items_query);
                            
                            while($item = mysqli_fetch_assoc($items_result)): 
                                $subtotal = $item['jumlah_222145'] * $item['harga_sewa_222145'] * $durasi;
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['nama_produk_222145']) ?></td>
                                    <td><?= $item['jumlah_222145'] ?></td>
                                    <td>Rp <?= number_format($item['harga_sewa_222145'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                </tr>
                            <?php endwhile; ?>
                            <tr class="table-active">
                                <td colspan="3" class="text-end"><strong>Total</strong></td>
                                <td><strong>Rp <?= number_format($order['total'], 0, ',', '.') ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select class="form-select" name="metode_pembayaran" required>
                                <option value="">Pilih Metode</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="E-Wallet">E-Wallet</option>
                                <option value="Tunai">Tunai</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengambilan</label>
                            <input type="date" class="form-control" name="tanggal_pengambilan" 
                                   min="<?= date('Y-m-d') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Bukti Pembayaran</label>
                            <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*" required>
                            <small class="text-muted">Format: JPG/PNG, maksimal 2MB</small>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                            <label class="form-check-label" for="agreeTerms">
                                Saya menyetujui syarat dan ketentuan penyewaan
                            </label>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" name="simpan" class="btn btn-success btn-lg">
                                <i class="fas fa-paper-plane me-2"></i> Konfirmasi Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>