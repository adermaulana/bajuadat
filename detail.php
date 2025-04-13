<?php include 'partials/header.php'; ?>


<section class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="mb-4">
                <img src="img/kebaya.png" class="card-img-top img-fluid rounded" alt="Kebaya Jawa Modern">
            </div>
        </div>
        <div class="col-md-8">
            <div class="mb-4 mt-md-5">
                <div class="card-body ms-md-5">
                    <h1 class="card-title">Kebaya Jawa Modern</h1>
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-primary me-2">Jawa Tengah</span>
                        <small class="text-muted">Tersedia: 5 set</small>
                    </div>
                    
                    <p class="card-text mt-2">
                        Kebaya modern dengan motif batik kontemporer yang elegan. Terbuat dari bahan katun berkualitas tinggi dengan sulaman tangan yang halus. Cocok untuk acara pernikahan, wisuda, atau acara formal lainnya.
                    </p>
                    
                    <div class="mb-4">
                        <h3 class="text-success">Rp 150.000/hari</h3>
                    </div>
                    
                    <hr>
                    
                    <h5 class="mt-4">Detail Produk:</h5>
                    <ul>
                        <li>Bahan: Katun premium</li>
                        <li>Warna: Biru navy dengan motif emas</li>
                        <li>Aksesoris: Termasuk bros dan selendang</li>
                        <li>Ukuran: S, M, L, XL</li>
                        <li>Kondisi: Baru dan bersih</li>
                    </ul>
                    
                    <form class="mt-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="jumlah" class="col-form-label">Jumlah Hari:</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" class="form-control" id="jumlah" min="1" max="7" value="1" style="width: 80px;">
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
                                <select class="form-select" id="ukuran" style="width: 100px;">
                                    <option selected>Pilih</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-4">
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
</style>

<?php include 'partials/footer.php'; ?>
