<?php
include 'partials/header.php';

if(!isset($_SESSION['id_pelanggan'])) {
    header("Location: login_pelanggan.php");
    exit();
}

$id_pelanggan = $_SESSION['id_pelanggan'];

// Get customer data
$customer_query = "SELECT * FROM pelanggan_222145 WHERE pelanggan_id_222145 = $id_pelanggan";
$customer_result = mysqli_query($koneksi, $customer_query);
$customer = mysqli_fetch_assoc($customer_result);

// Get cart items
$cart_query = "SELECT k.*, p.nama_produk_222145, p.gambar_222145, p.harga_sewa_222145
              FROM keranjang_222145 k
              JOIN produk_222145 p ON k.produk_id_222145 = p.produk_id_222145
              WHERE k.pelanggan_id_222145 = $id_pelanggan";
$cart_result = mysqli_query($koneksi, $cart_query);

// Get jumlah hari from session
$jumlah_hari = $_SESSION['jumlah_hari_sewa'] ?? 1;

// Calculate totals
$subtotal = 0;
$total_items = 0;
$cart_items = [];

if(mysqli_num_rows($cart_result) > 0) {
    while($item = mysqli_fetch_assoc($cart_result)) {
        $item_subtotal = $item['harga_sewa_222145'] * $item['jumlah_222145'];
        $subtotal += $item_subtotal;
        $total_items += $item['jumlah_222145'];
        $cart_items[] = $item;
    }
}

$grand_total = $subtotal * $jumlah_hari;

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $errors = [];
    
    // Validate form fields
    if(empty($_POST['tanggal_sewa'])) {
        $errors[] = "Tanggal sewa tidak boleh kosong";
    } else {
        $tanggal_sewa = $_POST['tanggal_sewa'];
        // Check if date is not in the past
        if(strtotime($tanggal_sewa) < strtotime(date('Y-m-d'))) {
            $errors[] = "Tanggal sewa tidak boleh di masa lalu";
        }
    }
    
    if(empty($errors)) {
        // Start transaction
        mysqli_begin_transaction($koneksi);
        
        try {
            // Create order
            $tanggal_pesanan = date('Y-m-d H:i:s');
            $tanggal_kembali = date('Y-m-d', strtotime($tanggal_sewa . " + $jumlah_hari days"));
            $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan'] ?? '');
            $status = 'menunggu';
            
            $order_query = "INSERT INTO pesanan_222145 (
                pelanggan_id_222145,
                tanggal_pesanan_222145,
                tanggal_sewa_222145,
                tanggal_kembali_222145,
                jumlah_hari_222145,
                total_harga_222145,
                status_222145,
                catatan_222145
            ) VALUES (
                $id_pelanggan,
                '$tanggal_pesanan',
                '$tanggal_sewa',
                '$tanggal_kembali',
                '$jumlah_hari',
                $grand_total,
                '$status',
                '$catatan'
            )";
            
            if(!mysqli_query($koneksi, $order_query)) {
                throw new Exception("Error membuat pesanan: " . mysqli_error($koneksi));
            }
            
            $order_id = mysqli_insert_id($koneksi);
            
            // Move items from cart to order details
            foreach($cart_items as $item) {
                $item_total = $item['harga_sewa_222145'] * $item['jumlah_222145'] * $jumlah_hari;
                
                $detail_query = "INSERT INTO detail_pesanan_222145 (
                    pesanan_id_222145,
                    produk_id_222145,
                    jumlah_222145,
                    ukuran_222145,
                    harga_satuan_222145,
                    sub_total_222145
                ) VALUES (
                    $order_id,
                    {$item['produk_id_222145']},
                    {$item['jumlah_222145']},
                    '{$item['ukuran_222145']}',
                    {$item['harga_sewa_222145']},
                    $item_total
                )";
                
                if(!mysqli_query($koneksi, $detail_query)) {
                    throw new Exception("Error membuat detail pesanan: " . mysqli_error($koneksi));
                }
            }
            
            // Clear cart
            $clear_cart = "DELETE FROM keranjang_222145 WHERE pelanggan_id_222145 = $id_pelanggan";
            if(!mysqli_query($koneksi, $clear_cart)) {
                throw new Exception("Error menghapus keranjang: " . mysqli_error($koneksi));
            }
            
            // Clear session variable for rental days
            unset($_SESSION['jumlah_hari_sewa']);
            
            mysqli_commit($koneksi);
            header("Location: pembayaran.php?order_id=$order_id");
            exit();
            
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            $error_message = $e->getMessage();
        }
    } else {
        $error_message = implode("<br>", $errors);
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Checkout Penyewaan Baju Adat</h2>
    
    <?php if(empty($cart_items)): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i> Keranjang belanja Anda kosong. Silakan tambahkan produk terlebih dahulu.
        </div>
        <a href="bajuadat.php" class="btn btn-primary">
            <i class="fas fa-shopping-bag me-2"></i> Kembali ke Toko
        </a>
    <?php else: ?>
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i> <?= $error_message ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i> Data Penyewa</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" id="checkout-form">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($customer['nama_lengkap_222145']) ?>" readonly>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control" value="<?= htmlspecialchars($customer['email_222145']) ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Telepon</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($customer['no_telp_222145']) ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Pengiriman</label>
                                <textarea class="form-control" rows="3" readonly><?= htmlspecialchars($customer['alamat_222145']) ?></textarea>
                            </div>
                            
                            <hr>
                            
                            <h5 class="mb-3">Informasi Penyewaan</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_sewa" class="form-label fw-bold">Tanggal Sewa <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required 
                                           min="<?= date('Y-m-d') ?>">
                                    <small class="text-muted">Tanggal pengambilan/pengiriman baju</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_kembali" class="form-label fw-bold">Tanggal Kembali</label>
                                    <input type="date" class="form-control" id="tanggal_kembali" readonly>
                                    <small class="text-muted">Otomatis dihitung <?= $jumlah_hari ?> hari setelah tanggal sewa</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="catatan" class="form-label fw-bold">Catatan (Opsional)</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="2" 
                                          placeholder="Masukkan catatan tambahan untuk pesanan Anda"></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <h5>Daftar Produk yang Disewa</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Produk</th>
                                                <th>Ukuran</th>
                                                <th>Jumlah</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($cart_items as $item): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="admin/bajuadat/<?= htmlspecialchars($item['gambar_222145']) ?>" 
                                                                alt="<?= htmlspecialchars($item['nama_produk_222145']) ?>" 
                                                                class="img-thumbnail me-2" style="max-width: 50px;">
                                                            <?= htmlspecialchars($item['nama_produk_222145']) ?>
                                                        </div>
                                                    </td>
                                                    <td><?= htmlspecialchars($item['ukuran_222145']) ?></td>
                                                    <td><?= $item['jumlah_222145'] ?></td>
                                                    <td>Rp <?= number_format($item['harga_sewa_222145'], 0, ',', '.') ?></td>
                                                    <td>Rp <?= number_format($item['harga_sewa_222145'] * $item['jumlah_222145'], 0, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Jumlah Produk
                                    <span class="badge bg-primary rounded-pill"><?= $total_items ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Subtotal (per hari)
                                    <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Lama Sewa
                                    <span><?= $jumlah_hari ?> hari</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                    TOTAL PEMBAYARAN
                                    <span>Rp <?= number_format($grand_total, 0, ',', '.') ?></span>
                                </li>
                            </ul>
                            
                            <div class="alert alert-info mt-3 mb-3">
                                <i class="fas fa-info-circle me-2"></i> Setelah checkout, Anda akan diarahkan ke halaman pembayaran.
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="checkout" class="btn btn-success btn-lg" form="checkout-form">
                                    <i class="fas fa-check-circle me-2"></i> Checkout Sekarang
                                </button>
                                <a href="keranjang.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i> Kebijakan Penyewaan</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i> Pembayaran dapat dilakukan via transfer bank</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Produk akan dikirim setelah pembayaran dikonfirmasi</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Denda berlaku untuk keterlambatan pengembalian</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Kami tidak bertanggung jawab atas kerusakan produk selama penyewaan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

<style>
    .card {
        border-radius: 8px;
        overflow: hidden;
        border: none;
        transition: all 0.3s ease;
    }
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    }
    .img-thumbnail {
        border-radius: 6px;
    }
    .list-group-item {
        padding: 12px 20px;
        border-left: none;
        border-right: none;
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>

<script>
// Calculate return date based on selected rental date
document.getElementById('tanggal_sewa').addEventListener('change', function() {
    const sewaDate = new Date(this.value);
    const kembaliInput = document.getElementById('tanggal_kembali');
    
    // Calculate return date by adding the rental period
    const jumlahHari = <?= $jumlah_hari ?>;
    sewaDate.setDate(sewaDate.getDate() + jumlahHari);
    
    // Format date as YYYY-MM-DD for the input field
    const year = sewaDate.getFullYear();
    const month = String(sewaDate.getMonth() + 1).padStart(2, '0');
    const day = String(sewaDate.getDate()).padStart(2, '0');
    
    kembaliInput.value = `${year}-${month}-${day}`;
});

// Set today as minimum date for rental date picker
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    
    document.getElementById('tanggal_sewa').min = `${year}-${month}-${day}`;
});
</script>

<?php include 'partials/footer.php'; ?>