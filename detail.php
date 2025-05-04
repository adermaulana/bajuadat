<?php 
include 'partials/header.php';


// Handle add to cart
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {

    if(!isset($_SESSION['id_pelanggan'])) {
        header("Location: login_pelanggan.php");
        exit();
    }

    $pelanggan_id = $_SESSION['id_pelanggan'];
    $produk_id = $_POST['produk_id'];
    $jumlah_hari = $_POST['jumlah_hari'];
    $ukuran = $_POST['ukuran'];
    
    // Get product price
    $query = "SELECT harga_sewa_222145 FROM produk_222145 WHERE produk_id_222145 = $produk_id";
    $result = mysqli_query($koneksi, $query);
    $produk = mysqli_fetch_assoc($result);
    $harga_satuan = $produk['harga_sewa_222145'];
    $sub_total = $harga_satuan * $jumlah_hari;
    
    // Insert into keranjang_222145 table
    $insert_query = "INSERT INTO keranjang_222145 (
        pelanggan_id_222145,
        produk_id_222145,
        jumlah_hari_222145,
        ukuran_222145,
        harga_satuan_222145,
        sub_total_222145
    ) VALUES (
        $pelanggan_id,
        $produk_id,
        $jumlah_hari,
        '$ukuran',
        $harga_satuan,
        $sub_total
    )";
    
    if(mysqli_query($koneksi, $insert_query)) {
        $success_message = "Produk berhasil ditambahkan ke keranjang!";
    } else {
        $error_message = "Gagal menambahkan produk: " . mysqli_error($koneksi);
    }
}

// Get product details
$produk_id = $_GET['id'] ?? 0;
$query = "SELECT * FROM produk_222145 WHERE produk_id_222145 = $produk_id";
$result = mysqli_query($koneksi, $query);
$produk = mysqli_fetch_assoc($result);

if(!$produk) {
    header("Location: produk.php");
    exit();
}
?>

<section class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="mb-4">
                <img src="admin/bajuadat/<?= htmlspecialchars($produk['gambar_222145'] ?? 'img/kebaya.png') ?>" class="card-img-top img-fluid rounded" alt="<?= htmlspecialchars($produk['nama_produk_222145']) ?>">
            </div>
        </div>
        <div class="col-md-8">
            <div class="mb-4 mt-md-5">
                <div class="card-body ms-md-5">
                    <h1 class="card-title"><?= htmlspecialchars($produk['nama_produk_222145']) ?></h1>
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-primary me-2"><?= htmlspecialchars($produk['kategori_222145']) ?></span>
                        <small class="text-muted">Tersedia: <?= htmlspecialchars($produk['stok_222145']) ?> set</small>
                    </div>
                    
                    <p class="card-text mt-2">
                        <?= htmlspecialchars($produk['deskripsi_222145']) ?>
                    </p>
                    
                    <div class="mb-4">
                        <h3 class="text-success">Rp <?= number_format($produk['harga_sewa_222145'], 0, ',', '.') ?>/hari</h3>
                    </div>
                    
                    <hr>
                    
                    <h5 class="mt-4">Detail Produk:</h5>
                    <ul>
                        <?php 
                        $kelengkapan = explode(",", $produk['kelengkapan_222145']);
                        foreach($kelengkapan as $item):
                            if(trim($item)): ?>
                                <li><?= htmlspecialchars(trim($item)) ?></li>
                            <?php endif;
                        endforeach; ?>
                        <li>Ukuran: <?= htmlspecialchars($produk['ukuran_222145']) ?></li>
                        <li>Kondisi: <?= htmlspecialchars($produk['status_222145']) ?></li>
                    </ul>
                    
                    <form class="mt-4" method="post">
                        <input type="hidden" name="produk_id" value="<?= $produk_id ?>">
                        
                        <?php if(isset($success_message)): ?>
                            <div class="alert alert-success"><?= $success_message ?></div>
                        <?php endif; ?>
                        
                        <?php if(isset($error_message)): ?>
                            <div class="alert alert-danger"><?= $error_message ?></div>
                        <?php endif; ?>
                        
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="jumlah" class="col-form-label">Jumlah Hari:</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" class="form-control" id="jumlah" name="jumlah_hari" min="1" max="7" value="1" style="width: 80px;" required>
                            </div>
                            <div class="col-auto">
                                <span class="text-muted">(max 7 hari)</span>
                            </div>
                        </div>
                        
                        <div class="row g-3 align-items-center mt-2">
                            <div class="col-auto">
                                <label for="ukuran" class="col-form-label">Ukuran:</label>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" id="ukuran" name="ukuran" style="width: 100px;" required>
                                    <option value="">Pilih</option>
                                    <?php 
                                    $ukuran_options = explode(",", $produk['ukuran_222145']);
                                    foreach($ukuran_options as $option): 
                                        $option = trim($option);
                                        if($option): ?>
                                            <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                                        <?php endif;
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" name="add_to_cart" class="btn btn-success btn-lg px-4">
                                <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .card-img-top {
        border-radius: 8px 8px 0 0;
    }
    .card {
        transition: transform 0.3s;
        border-radius: 8px;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .alert {
        margin-top: 15px;
    }
</style>

<?php include 'partials/footer.php'; ?>