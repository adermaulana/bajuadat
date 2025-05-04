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

// Get orders that need payment confirmation
$query = "SELECT p.*, 
                 GROUP_CONCAT(pr.nama_produk_222145 SEPARATOR ', ') AS produk,
                 SUM(dp.sub_total_222145) AS total
          FROM pesanan_222145 p
          JOIN detail_pesanan_222145 dp ON p.pesanan_id_222145 = dp.pesanan_id_222145
          JOIN produk_222145 pr ON dp.produk_id_222145 = pr.produk_id_222145
          WHERE p.pelanggan_id_222145 = $id_pelanggan
          AND p.status_222145 IN ('menunggu', 'diproses', 'disewa', 'selesai','dibatalkan')
          GROUP BY p.pesanan_id_222145
          ORDER BY p.tanggal_pesanan_222145 DESC";
$result = mysqli_query($koneksi, $query);
?>

<div class="col">
    <div>
        <h4 class="mb-3">Pembayaran Penyewaanku</h4>
        <div id="container-booking-list">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($order = mysqli_fetch_assoc($result)): 
                    $order_id = str_pad($order['pesanan_id_222145'], 3, '0', STR_PAD_LEFT);
                    $status_class = '';
                    switch($order['status_222145']) {
                        case 'menunggu': $status_class = 'bg-warning'; break;
                        case 'diproses': $status_class = 'bg-info'; break;
                        case 'disewa': $status_class = 'bg-secondary'; break;
                        case 'selesai': $status_class = 'bg-danger'; break;
                        case 'dibatalkan': $status_class = 'bg-success'; break;
                        default: $status_class = 'bg-primary';
                    }
                    
                    // Calculate rental duration
                    $sewa = new DateTime($order['tanggal_sewa_222145']);
                    $kembali = new DateTime($order['tanggal_kembali_222145']);
                    $durasi = $sewa->diff($kembali)->format('%a hari');
                ?>
                    <div class="card mb-3">                         
                        <div class="no-gutters">                                    
                            <div class="">                                  
                                <div class="card-header ">                                    
                                    <div class="row">                                        
                                        <div class="col text-left text-muted">ID Order : <strong>ORD-<?= $order_id ?></strong></div>                                        
                                        <div style="text-align:right;" class="col text">
                                            <strong class="bayar">Rp <?= number_format($order['total'], 0, ',', '.') ?></strong>
                                        </div>                                    
                                    </div>                                  
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Penyewaan <?= htmlspecialchars($order['produk']) ?> (<?= $durasi ?>)</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col text-end action-right">
                                        <?php if($order['status_222145'] == 'menunggu'): ?>
                                            <a href="konfirmasi_pembayaran.php?order_id=<?= $order['pesanan_id_222145'] ?>">
                                                <span class="btn btn-sm btn-success">Konfirmasi Pembayaran</span>
                                            </a>
                                        <?php else: ?>
                                            <span class="badge <?= $status_class ?>"><?= ucfirst($order['status_222145']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    Tidak ada pesanan yang membutuhkan pembayaran.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>