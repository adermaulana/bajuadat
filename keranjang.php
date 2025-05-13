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
    $delete_query = "DELETE FROM keranjang_222145 
                    WHERE keranjang_id_222145 = $keranjang_id 
                    AND pelanggan_id_222145 = $id_pelanggan";
    mysqli_query($koneksi, $delete_query);
}

// Get cart items
$query = "SELECT k.*, p.nama_produk_222145, p.gambar_222145, p.harga_sewa_222145
          FROM keranjang_222145 k
          JOIN produk_222145 p ON k.produk_id_222145 = p.produk_id_222145
          WHERE k.pelanggan_id_222145 = $id_pelanggan";
$result = mysqli_query($koneksi, $query);

// Calculate totals
$subtotal = 0;
?>

<div class="container mt-5">
    <h2 class="mb-4">Keranjang Belanja - Baju Adat Indonesia</h2>
    
    <?php if(mysqli_num_rows($result) > 0): ?>
        <div class="row">
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Baju Adat</th>
                            <th scope="col">Jumlah Hari</th>
                            <th scope="col">Harga/hari</th>
                            <th scope="col">Total</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($item = mysqli_fetch_assoc($result)): 
                            $item_total = $item['harga_sewa_222145'] * $item['jumlah_hari_222145'];
                            $subtotal += $item_total;
                        ?>
                            <tr>
                                <th scope="row"><?= $no++ ?></th>
                                <td>
                                    <img src="admin/bajuadat/<?= htmlspecialchars($item['gambar_222145']) ?>" 
                                         alt="<?= htmlspecialchars($item['nama_produk_222145']) ?>" 
                                         class="img-thumbnail" 
                                         style="max-width: 100px;">
                                    <?= htmlspecialchars($item['nama_produk_222145']) ?>
                                </td>
                                <td><?= $item['jumlah_hari_222145'] ?></td>
                                <td>Rp <?= number_format($item['harga_sewa_222145'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($item_total, 0, ',', '.') ?></td>
                                <td>
                                    <a href="?hapus=<?= $item['keranjang_id_222145'] ?>" 
                                       class="btn btn-danger"
                                       onclick="return confirm('Yakin ingin menghapus item ini?')">
                                        <i class="fas fa-times-circle"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Belanja</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                Total:
                                <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                            </li>
                        </ul>
                        <a href="checkout.php" class="btn btn-primary mt-3 w-100">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Keranjang belanja Anda kosong. Silakan pilih baju adat yang ingin Anda sewa.
        </div>
    <?php endif; ?>
    
    <a href="bajuadat.php" class="btn btn-success mt-3">
        <i class="fas fa-shopping-cart"></i> Lanjut Belanja
    </a>
</div>

<?php include 'partials/footer.php'; ?>