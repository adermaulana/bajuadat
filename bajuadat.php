<?php 
include 'partials/header.php';


// Pagination setup
$per_page = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

// Get total products
$total_query = "SELECT COUNT(*) FROM produk_222145 WHERE status_222145 = 'tersedia'";
$total_result = mysqli_query($koneksi, $total_query);
$total_rows = mysqli_fetch_row($total_result)[0];
$total_pages = ceil($total_rows / $per_page);

// Get products for current page
$query = "SELECT * FROM produk_222145 
          WHERE status_222145 = 'tersedia' 
          LIMIT $offset, $per_page";
$result = mysqli_query($koneksi, $query);
?>

<section class="container mt-5">
    <h2 class="mb-4">Daftar Baju Adat</h2>
    <div class="row">
        <?php while($produk = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-12 col-lg-3">
                <div class="card mb-4">
                    <img style="height: 200px; object-fit: cover;" 
                         src="admin/bajuadat/<?= htmlspecialchars($produk['gambar_222145'] ?? 'img/default.jpg') ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($produk['nama_produk_222145']) ?>">
                    <div class="card-body">
                        <h3 class="card-title"><?= htmlspecialchars($produk['nama_produk_222145']) ?></h3>
                        <h5>Rp <?= number_format($produk['harga_sewa_222145'], 0, ',', '.') ?>/hari</h5>
                        <a class="btn btn-outline-primary rounded-pill" 
                           href="detail.php?id=<?= $produk['produk_id_222145'] ?>">
                           Detail
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Pagination (Dynamic) -->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
            </li>
            
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            
            <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
            </li>
        </ul>
    </nav>
</section>

<?php include 'partials/footer.php'; ?>