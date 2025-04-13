<?php
include 'partials/header.php';

// Ensure user is logged in
if (!isset($_SESSION['username_pelanggan'])) {
    echo "<script>
    alert('Anda harus login terlebih dahulu!');
    document.location='login_pelanggan.php';
    </script>";
    exit;
}

// Get order details
$id_order = $_GET['id'];
$pelanggan = $_SESSION['id_pelanggan'];

// Fetch order details
$query_order = mysqli_query($koneksi, "SELECT * FROM data_order WHERE id_order = '$id_order' AND id_pelanggan = '$pelanggan'");
$order = mysqli_fetch_assoc($query_order);

// Fetch order items
$query_items = mysqli_query($koneksi, "SELECT doi.*, dmat.nama_material, dmat.harga_material
                                      FROM data_order_item doi
                                      JOIN data_material dmat ON doi.id_material = dmat.id_material
                                      WHERE doi.id_order = '$id_order'");
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h3 class="mb-4">Form Return Produk</h3>
            <form action="proses_return.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_order" value="<?= $id_order ?>">
                
                <div class="card mb-4">
                    <div class="card-header">
                        Detail Pesanan
                    </div>
                    <div class="card-body">
                        <p>ID Order: <?= $order['id_order'] ?></p>
                        <p>Total Order: Rp <?= number_format($order['total_order'], 0, ',', '.') ?></p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        Pilih Produk yang Akan Dikembalikan
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Pilih Return</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($item = mysqli_fetch_assoc($query_items)): ?>
                                <tr>
                                    <td><?= $item['nama_material'] ?></td>
                                    <td><?= $item['jumlah_order_item'] ?></td>
                                    <td>Rp <?= number_format($item['harga_material'], 0, ',', '.') ?></td>
                                    <td>
                                        <input type="checkbox" name="produk_return[]" value="<?= $item['id_order_item'] ?>" 
                                               data-harga="<?= $item['harga_material'] ?>" 
                                               data-jumlah="<?= $item['jumlah_order_item'] ?>">
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        Alasan Return
                    </div>
                    <div class="card-body">
                        <select name="alasan_return" class="form-control" required>
                            <option value="">Pilih Alasan Return</option>
                            <option value="Rusak">Produk Rusak</option>
                            <option value="Tidak Sesuai">Tidak Sesuai Pesanan</option>
                            <option value="Salah Kirim">Salah Kirim</option>
                            <option value="Lainnya">Alasan Lainnya</option>
                        </select>
                        <textarea name="keterangan_return" class="form-control mt-3" placeholder="Keterangan tambahan (opsional)"></textarea>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        Unggah Bukti Kerusakan
                    </div>
                    <div class="card-body">
                        <input type="file" name="bukti_return" class="form-control" accept="image/*" required>
                        <small class="text-muted">Maksimal ukuran file 5MB, format jpg/png</small>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        Detail Return
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Total Produk Dikembalikan:</strong>
                                <span id="total_produk">0</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Estimasi Pengembalian Dana:</strong>
                                <span id="estimasi_dana">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Ajukan Return</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[name="produk_return[]"]');
    const totalProdukSpan = document.getElementById('total_produk');
    const estimasiDanaSpan = document.getElementById('estimasi_dana');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateReturnDetails);
    });

    function updateReturnDetails() {
        let totalProduk = 0;
        let totalDana = 0;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                totalProduk += parseInt(checkbox.dataset.jumlah);
                totalDana += parseInt(checkbox.dataset.harga) * parseInt(checkbox.dataset.jumlah);
            }
        });

        totalProdukSpan.textContent = totalProduk;
        estimasiDanaSpan.textContent = 'Rp ' + totalDana.toLocaleString('id-ID');
    }
});
</script>

<?php include 'partials/footer.php'; ?>
