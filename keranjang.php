<?php 
include 'partials/header.php';

if(!isset($_SESSION['id_pelanggan'])) {
    header("Location: login_pelanggan.php");
    exit();
}

$id_pelanggan = $_SESSION['id_pelanggan'];

// Handle item removal
if(isset($_GET['hapus'])) {
    $keranjang_id = (int)$_GET['hapus'];
    
    // Get item information before deleting to restore stock
    $item_query = "SELECT produk_id_222145, ukuran_222145, jumlah_222145 
                  FROM keranjang_222145 
                  WHERE keranjang_id_222145 = $keranjang_id 
                  AND pelanggan_id_222145 = $id_pelanggan";
    $item_result = mysqli_query($koneksi, $item_query);
    
    if($item = mysqli_fetch_assoc($item_result)) {
        mysqli_begin_transaction($koneksi);
        
        try {
            // Delete item from cart
            $delete_query = "DELETE FROM keranjang_222145 
                            WHERE keranjang_id_222145 = $keranjang_id 
                            AND pelanggan_id_222145 = $id_pelanggan";
            
            if(!mysqli_query($koneksi, $delete_query)) {
                throw new Exception("Gagal menghapus item: " . mysqli_error($koneksi));
            }
            
            // Restore stock
            $restore_stock_query = "UPDATE ukuran_produk_222145 
                                  SET stok_222145 = stok_222145 + {$item['jumlah_222145']} 
                                  WHERE produk_id_222145 = {$item['produk_id_222145']} 
                                  AND ukuran_222145 = '{$item['ukuran_222145']}'";
            
            if(!mysqli_query($koneksi, $restore_stock_query)) {
                throw new Exception("Gagal memulihkan stok: " . mysqli_error($koneksi));
            }
            
            mysqli_commit($koneksi);
            $success_message = "Item berhasil dihapus dari keranjang";
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            $error_message = $e->getMessage();
        }
    }
}

// Handle update quantity
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $keranjang_id = (int)$_POST['keranjang_id'];
    $jumlah_baru = (int)$_POST['jumlah'];
    
    // Validasi jumlah maksimal
    $jumlah_baru = min($jumlah_baru, 10); // Maksimal 10 item
    
    // Get current item information
    $get_item_query = "SELECT produk_id_222145, ukuran_222145, jumlah_222145 
                      FROM keranjang_222145 
                      WHERE keranjang_id_222145 = $keranjang_id 
                      AND pelanggan_id_222145 = $id_pelanggan";
    $item_result = mysqli_query($koneksi, $get_item_query);
    
    if($item = mysqli_fetch_assoc($item_result)) {
        $selisih_jumlah = $jumlah_baru - $item['jumlah_222145'];
        
        if($selisih_jumlah != 0) {
            mysqli_begin_transaction($koneksi);
            
            try {
                // Jika menambah jumlah, cek stok tersedia
                if($selisih_jumlah > 0) {
                    $check_stock_query = "SELECT stok_222145 
                                         FROM ukuran_produk_222145 
                                         WHERE produk_id_222145 = {$item['produk_id_222145']} 
                                         AND ukuran_222145 = '{$item['ukuran_222145']}'";
                    $stock_result = mysqli_query($koneksi, $check_stock_query);
                    $stock_data = mysqli_fetch_assoc($stock_result);
                    
                    if(!$stock_data || $stock_data['stok_222145'] < $selisih_jumlah) {
                        throw new Exception("Stok tidak mencukupi untuk penambahan jumlah");
                    }
                }
                
                // Update quantity in cart
                $update_query = "UPDATE keranjang_222145 
                                SET jumlah_222145 = $jumlah_baru
                                WHERE keranjang_id_222145 = $keranjang_id
                                AND pelanggan_id_222145 = $id_pelanggan";
                
                if(!mysqli_query($koneksi, $update_query)) {
                    throw new Exception("Gagal mengupdate jumlah: " . mysqli_error($koneksi));
                }
                
                // Update stock
                $update_stock_query = "UPDATE ukuran_produk_222145 
                                      SET stok_222145 = stok_222145 - $selisih_jumlah
                                      WHERE produk_id_222145 = {$item['produk_id_222145']} 
                                      AND ukuran_222145 = '{$item['ukuran_222145']}'";
                
                if(!mysqli_query($koneksi, $update_stock_query)) {
                    throw new Exception("Gagal mengupdate stok: " . mysqli_error($koneksi));
                }
                
                mysqli_commit($koneksi);
                $success_message = "Jumlah produk berhasil diperbarui";
            } catch (Exception $e) {
                mysqli_rollback($koneksi);
                $error_message = $e->getMessage();
            }
        }
    }
}

// Set jumlah hari sewa (akan digunakan di checkout)
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['set_days'])) {
    $jumlah_hari = (int)$_POST['jumlah_hari'];
    
    // Validasi jumlah hari
    $jumlah_hari = max(1, min($jumlah_hari, 7)); // Minimal 1, maksimal 7 hari
    
    // Simpan jumlah hari ke session untuk digunakan saat checkout
    $_SESSION['jumlah_hari_sewa'] = $jumlah_hari;
    $success_message = "Lama penyewaan berhasil disimpan";
}

// Get cart items
$query = "SELECT k.*, p.nama_produk_222145, p.gambar_222145, p.harga_sewa_222145
          FROM keranjang_222145 k
          JOIN produk_222145 p ON k.produk_id_222145 = p.produk_id_222145
          WHERE k.pelanggan_id_222145 = $id_pelanggan";
$result = mysqli_query($koneksi, $query);

// Get jumlah hari from session if exists
$jumlah_hari = $_SESSION['jumlah_hari_sewa'] ?? 1;

// Calculate totals
$total_items = 0;
$subtotal = 0;
?>

<div class="container mt-5">
    <h2 class="mb-4">Keranjang Belanja - Baju Adat Indonesia</h2>
    
    <?php if(isset($success_message)): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php endif; ?>
    
    <?php if(isset($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>
    
    <?php if(mysqli_num_rows($result) > 0): ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Produk dalam Keranjang</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Ukuran</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Harga/hari</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while($item = mysqli_fetch_assoc($result)): 
                                    $item_total = $item['harga_sewa_222145'] * $item['jumlah_222145'];
                                    $subtotal += $item_total;
                                    $total_items += $item['jumlah_222145'];
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="admin/bajuadat/<?= htmlspecialchars($item['gambar_222145']) ?>" 
                                                     alt="<?= htmlspecialchars($item['nama_produk_222145']) ?>" 
                                                     class="img-thumbnail me-2" 
                                                     style="max-width: 60px;">
                                                <span><?= htmlspecialchars($item['nama_produk_222145']) ?></span>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($item['ukuran_222145']) ?></td>
                                        <td>
                                            <form method="post" class="d-flex align-items-center">
                                                <input type="hidden" name="keranjang_id" value="<?= $item['keranjang_id_222145'] ?>">
                                                <input type="number" name="jumlah" value="<?= $item['jumlah_222145'] ?>" 
                                                       min="1" max="10" class="form-control form-control-sm" style="width: 60px;">
                                                <button type="submit" name="update_quantity" class="btn btn-sm btn-outline-secondary ms-2">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>Rp <?= number_format($item['harga_sewa_222145'], 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($item_total, 0, ',', '.') ?></td>
                                        <td>
                                            <a href="?hapus=<?= $item['keranjang_id_222145'] ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Yakin ingin menghapus item ini?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" class="mb-3">
                            <div class="mb-3">
                                <label for="jumlah_hari" class="form-label">Lama Penyewaan (Hari):</label>
                                <div class="d-flex">
                                    <input type="number" id="jumlah_hari" name="jumlah_hari" 
                                          min="1" max="7" class="form-control" value="<?= $jumlah_hari ?>">
                                    <button type="submit" name="set_days" class="btn btn-outline-secondary ms-2">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Maksimal 7 hari</small>
                            </div>
                        </form>
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Item:
                                <span><?= $total_items ?> item</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Subtotal per Hari:
                                <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Lama Sewa:
                                <span><?= $jumlah_hari ?> hari</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                Total:
                                <span>Rp <?= number_format($subtotal * $jumlah_hari, 0, ',', '.') ?></span>
                            </li>
                        </ul>
                        
                        <div class="d-grid gap-2 mt-3">
                            <a href="checkout.php" class="btn btn-success">
                                <i class="fas fa-credit-card me-2"></i> Lanjut ke Checkout
                            </a>
                            <a href="produk.php" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i> Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-shopping-cart me-2"></i> Keranjang belanja Anda kosong. Silakan pilih baju adat yang ingin Anda sewa.
        </div>
        
        <a href="bajuadat.php" class="btn btn-primary mt-2">
            <i class="fas fa-shopping-bag me-2"></i> Mulai Belanja
        </a>
    <?php endif; ?>
</div>

<style>
    .img-thumbnail {
        max-height: 60px;
        object-fit: cover;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 8px;
    }
    .card-header {
        border-radius: 8px 8px 0 0 !important;
    }
</style>

<?php include 'partials/footer.php'; ?>