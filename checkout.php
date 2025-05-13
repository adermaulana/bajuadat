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

// Get cart items with size information
$cart_query = "SELECT k.*, p.nama_produk_222145, p.gambar_222145, p.harga_sewa_222145, k.ukuran_222145
               FROM keranjang_222145 k
               JOIN produk_222145 p ON k.produk_id_222145 = p.produk_id_222145
               WHERE k.pelanggan_id_222145 = $id_pelanggan";
$cart_result = mysqli_query($koneksi, $cart_query);

// Calculate totals and get the number of days
$subtotal = 0;
$cart_items = [];
$jumlah_hari = 0;

if(mysqli_num_rows($cart_result) > 0) {
    while($item = mysqli_fetch_assoc($cart_result)) {
        $item_total = $item['harga_sewa_222145'] * $item['jumlah_hari_222145'];
        $subtotal += $item_total;
        $cart_items[] = $item;
        $jumlah_hari = $item['jumlah_hari_222145'];
    }
}

$grand_total = $subtotal;

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    // Start transaction
    mysqli_begin_transaction($koneksi);
    
    try {
        // Create order
        $tanggal_pesanan = date('Y-m-d H:i:s');
        $tanggal_sewa = $_POST['tanggal_sewa'];
        $tanggal_kembali = date('Y-m-d', strtotime($tanggal_sewa . " + $jumlah_hari days"));
        $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan']);
        
        $order_query = "INSERT INTO pesanan_222145 (
            pelanggan_id_222145,
            tanggal_pesanan_222145,
            tanggal_sewa_222145,
            tanggal_kembali_222145,
            total_harga_222145,
            status_222145,
            catatan_222145
        ) VALUES (
            $id_pelanggan,
            '$tanggal_pesanan',
            '$tanggal_sewa',
            '$tanggal_kembali',
            $grand_total,
            'menunggu',
            '$catatan'
        )";
        
        if(!mysqli_query($koneksi, $order_query)) {
            throw new Exception("Error creating order: " . mysqli_error($koneksi));
        }
        
        $order_id = mysqli_insert_id($koneksi);
        
        // Move items from cart to order details
        foreach($cart_items as $item) {
            // Validate that ukuran exists in the item array
            if(!isset($item['ukuran_222145'])) {
                throw new Exception("Ukuran tidak ditemukan untuk produk ini");
            }
            
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
                {$item['jumlah_hari_222145']},
                '{$item['ukuran_222145']}',
                {$item['harga_sewa_222145']},
                " . ($item['harga_sewa_222145'] * $item['jumlah_hari_222145']) . "
            )";
            
            if(!mysqli_query($koneksi, $detail_query)) {
                throw new Exception("Error creating order details: " . mysqli_error($koneksi));
            }
        }
        
        // Clear cart
        $clear_cart = "DELETE FROM keranjang_222145 WHERE pelanggan_id_222145 = $id_pelanggan";
        if(!mysqli_query($koneksi, $clear_cart)) {
            throw new Exception("Error clearing cart: " . mysqli_error($koneksi));
        }
        
        mysqli_commit($koneksi);
        header("Location: pembayaran.php?order_id=$order_id");
        exit();
        
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        $error = $e->getMessage();
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Checkout Penyewaan Baju Adat</h2>
    
    <?php if(empty($cart_items)): ?>
        <div class="alert alert-warning">
            Keranjang belanja Anda kosong. Silakan tambahkan produk terlebih dahulu.
        </div>
        <a href="bajuadat.php" class="btn btn-primary">Kembali ke Toko</a>
    <?php else: ?>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Data Penyewa</h5>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($customer['nama_lengkap_222145']) ?>" readonly>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="<?= htmlspecialchars($customer['email_222145']) ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Telepon</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($customer['no_telp_222145']) ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" rows="3" readonly><?= htmlspecialchars($customer['alamat_222145']) ?></textarea>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                                    <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required min="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" readonly>
                                    <small class="text-muted">Otomatis dihitung <?= $jumlah_hari ?> hari setelah tanggal sewa</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan (Opsional)</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="2"></textarea>
                            </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3">Produk Disewa:</h6>
                        <ul class="list-group mb-3">
                            <?php foreach($cart_items as $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($item['nama_produk_222145']) ?>
                                    <span>Rp <?= number_format($item['harga_sewa_222145'] * $item['jumlah_hari_222145'], 0, ',', '.') ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold fs-5">
                                Total Pembayaran:
                                <span>Rp <?= number_format($grand_total, 0, ',', '.') ?></span>
                            </li>
                        </ul>
                        
                        <button type="submit" name="checkout" class="btn btn-success w-100 mt-3 py-2">
                            <i class="fas fa-credit-card me-2"></i> Lanjut ke Pembayaran
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// Set return date based on rental date and number of days
document.getElementById('tanggal_sewa').addEventListener('change', function() {
    const sewaDate = new Date(this.value);
    const kembaliInput = document.getElementById('tanggal_kembali');
    
    // Calculate return date by adding the number of days
    sewaDate.setDate(sewaDate.getDate() + <?= $jumlah_hari ?>);
    const returnDate = sewaDate.toISOString().split('T')[0];
    kembaliInput.value = returnDate;
});
</script>

<?php include 'partials/footer.php'; ?>