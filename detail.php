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
    $ukuran = $_POST['ukuran'];
    $jumlah = $_POST['jumlah'] ?? 1; // Default 1 jika tidak diisi
    
    // Cek stok tersedia
    $stok_query = "SELECT stok_222145 FROM ukuran_produk_222145 
                  WHERE produk_id_222145 = $produk_id AND ukuran_222145 = '$ukuran'";
    $stok_result = mysqli_query($koneksi, $stok_query);
    $stok_data = mysqli_fetch_assoc($stok_result);
    
    if($stok_data && $stok_data['stok_222145'] >= $jumlah) {
        // Get product price
        $query = "SELECT harga_sewa_222145 FROM produk_222145 WHERE produk_id_222145 = $produk_id";
        $result = mysqli_query($koneksi, $query);
        $produk = mysqli_fetch_assoc($result);
        $harga_satuan = $produk['harga_sewa_222145'];
        
        // Mulai transaksi
        mysqli_begin_transaction($koneksi);
        
        try {
            // Cek apakah produk dengan ukuran yang sama sudah ada di keranjang
            $check_cart_query = "SELECT keranjang_id_222145, jumlah_222145 
                                FROM keranjang_222145 
                                WHERE pelanggan_id_222145 = $pelanggan_id 
                                AND produk_id_222145 = $produk_id 
                                AND ukuran_222145 = '$ukuran'";
            $check_cart_result = mysqli_query($koneksi, $check_cart_query);
            
            if(mysqli_num_rows($check_cart_result) > 0) {
                // Jika sudah ada, update jumlah
                $cart_item = mysqli_fetch_assoc($check_cart_result);
                $new_jumlah = $cart_item['jumlah_222145'] + $jumlah;
                
                $update_query = "UPDATE keranjang_222145 
                                SET jumlah_222145 = $new_jumlah
                                WHERE keranjang_id_222145 = ".$cart_item['keranjang_id_222145'];
                
                if(mysqli_query($koneksi, $update_query)) {
                    // Update stok
                    $update_stok_query = "UPDATE ukuran_produk_222145 
                                        SET stok_222145 = stok_222145 - $jumlah 
                                        WHERE produk_id_222145 = $produk_id 
                                        AND ukuran_222145 = '$ukuran'";
                    
                    if(mysqli_query($koneksi, $update_stok_query)) {
                        mysqli_commit($koneksi);
                        $success_message = "Jumlah produk dalam keranjang telah diperbarui!";
                    } else {
                        throw new Exception("Gagal mengupdate stok: " . mysqli_error($koneksi));
                    }
                } else {
                    throw new Exception("Gagal mengupdate keranjang: " . mysqli_error($koneksi));
                }
            } else {
                // Jika belum ada, insert baru
                $insert_query = "INSERT INTO keranjang_222145 (
                    pelanggan_id_222145,
                    produk_id_222145,
                    ukuran_222145,
                    jumlah_222145,
                    harga_satuan_222145,
                    tanggal_tambah_222145
                ) VALUES (
                    $pelanggan_id,
                    $produk_id,
                    '$ukuran',
                    $jumlah,
                    $harga_satuan,
                    NOW()
                )";
                
                if(mysqli_query($koneksi, $insert_query)) {
                    // Update stok
                    $update_stok_query = "UPDATE ukuran_produk_222145 
                                        SET stok_222145 = stok_222145 - $jumlah 
                                        WHERE produk_id_222145 = $produk_id 
                                        AND ukuran_222145 = '$ukuran'";
                    
                    if(mysqli_query($koneksi, $update_stok_query)) {
                        mysqli_commit($koneksi);
                        $success_message = "Produk berhasil ditambahkan ke keranjang!";
                    } else {
                        throw new Exception("Gagal mengupdate stok: " . mysqli_error($koneksi));
                    }
                } else {
                    throw new Exception("Gagal menambahkan produk: " . mysqli_error($koneksi));
                }
            }
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            $error_message = $e->getMessage();
        }
    } else {
        $error_message = "Stok tidak mencukupi untuk jumlah yang diminta";
    }
}

// Get product details
$produk_id = $_GET['id'] ?? 0;
$query = "SELECT p.*, 
                 GROUP_CONCAT(CONCAT(u.ukuran_222145, ':', u.stok_222145)) AS stok_ukuran
          FROM produk_222145 p
          LEFT JOIN ukuran_produk_222145 u ON p.produk_id_222145 = u.produk_id_222145
          WHERE p.produk_id_222145 = $produk_id
          GROUP BY p.produk_id_222145";
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
                        <?php 
                        if(!empty($produk['stok_ukuran'])) {
                            $stok_ukuran = explode(",", $produk['stok_ukuran']);
                            foreach($stok_ukuran as $stok) {
                                list($ukuran, $jumlah) = explode(":", $stok);
                                echo "<span class='badge bg-secondary me-2'>$ukuran: $jumlah</span>";
                            }
                        } else {
                            echo "<small class='text-muted'>Stok kosong</small>";
                        }
                        ?>
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
                                    <label for="jumlah" class="col-form-label">Jumlah:</label>
                                </div>
                                <div class="col-auto">
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" max="10" value="1" style="width: 80px;" required>
                                </div>
                            </div>
                        
                        
                        <div class="row g-3 align-items-center mt-2">
                            <div class="col-auto">
                                <label for="ukuran" class="col-form-label">Ukuran:</label>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" id="ukuran" name="ukuran" style="width: 100px;" required>
                                    <option value="">Pilih Ukuran</option>
                                    <?php 
                                    if(!empty($produk['stok_ukuran'])) {
                                        $stok_ukuran = explode(",", $produk['stok_ukuran']);
                                        foreach($stok_ukuran as $stok) {
                                            list($ukuran, $jumlah) = explode(":", $stok);
                                            if($jumlah > 0) {
                                                echo "<option value='$ukuran'>$ukuran (Tersedia: $jumlah)</option>";
                                            } else {
                                                echo "<option value='$ukuran' disabled>$ukuran (Habis)</option>";
                                            }
                                        }
                                    } else {
                                        echo "<option disabled>Stok kosong</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" name="add_to_cart" class="btn btn-success btn-lg px-4" <?= (empty($produk['stok_ukuran'])) ? 'disabled' : '' ?>>
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

    .badge {
        font-size: 0.85rem;
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    .badge.bg-secondary {
        background-color: #6c757d !important;
    }

</style>

<?php include 'partials/footer.php'; ?>