<?php include 'partials/header.php'; ?>

<section class="container mt-5">
    <h2 class="mb-4">Daftar Baju Adat</h2>
    <div class="row">
        <!-- Item 1 -->
        <div class="col-md-12 col-lg-3">
            <div class="card mb-4">
                <img style="height: 200px; object-fit: cover;" src="img/kebaya.png" class="card-img-top" alt="Baju Adat Jawa">
                <div class="card-body">
                    <h3 class="card-title">Kebaya Jawa Modern</h3>
                    <h5>Rp 150.000/hari</h5>
                    <a class="btn btn-outline-primary rounded-pill" href="detail.php">Detail</a>
                </div>
            </div>
        </div>
        
        <!-- Item 2 -->
        <div class="col-md-12 col-lg-3">
            <div class="card mb-4">
                <img style="height: 200px; object-fit: cover;" src="img/bali.jpg" class="card-img-top" alt="Baju Adat Bali">
                <div class="card-body">
                    <h3 class="card-title">Baju Adat Bali</h3>
                    <h5>Rp 200.000/hari</h5>
                    <a class="btn btn-outline-primary rounded-pill" href="detail.php">Detail</a>
                </div>
            </div>
        </div>
        
        <!-- Item 3 -->
        <div class="col-md-12 col-lg-3">
            <div class="card mb-4">
                <img style="height: 200px; object-fit: cover;" src="img/minang.jpg" class="card-img-top" alt="Baju Adat Minang">
                <div class="card-body">
                    <h3 class="card-title">Baju Adat Minang</h3>
                    <h5>Rp 180.000/hari</h5>
                    <a class="btn btn-outline-primary rounded-pill" href="detail.php">Detail</a>
                </div>
            </div>
        </div>
        
        <!-- Item 4 -->
        <div class="col-md-12 col-lg-3">
            <div class="card mb-4">
                <img style="height: 200px; object-fit: cover;" src="img/bali.jpg" class="card-img-top" alt="Baju Adat Betawi">
                <div class="card-body">
                    <h3 class="card-title">Baju Adat Bugis</h3>
                    <h5>Rp 170.000/hari</h5>
                    <a class="btn btn-outline-primary rounded-pill" href="detail.php">Detail</a>
                </div>
            </div>
        </div>
        
        <!-- Item 5 -->
        <div class="col-md-12 col-lg-3">
            <div class="card mb-4">
                <img style="height: 200px; object-fit: cover;" src="img/minang.jpg" class="card-img-top" alt="Baju Adat Sunda">
                <div class="card-body">
                    <h3 class="card-title">Baju Adat Sunda</h3>
                    <h5>Rp 160.000/hari</h5>
                    <a class="btn btn-outline-primary rounded-pill" href="detail.php">Detail</a>
                </div>
            </div>
        </div>
        
        <!-- Item 6 -->
        <div class="col-md-12 col-lg-3">
            <div class="card mb-4">
                <img style="height: 200px; object-fit: cover;" src="img/kebaya.png" class="card-img-top" alt="Baju Adat Dayak">
                <div class="card-body">
                    <h3 class="card-title">Baju Adat Dayak</h3>
                    <h5>Rp 220.000/hari</h5>
                    <a class="btn btn-outline-primary rounded-pill" href="detail.php">Detail</a>
                </div>
            </div>
        </div>
        
        <!-- Item 7 -->
        <div class="col-md-12 col-lg-3">
            <div class="card mb-4">
                <img style="height: 200px; object-fit: cover;" src="img/minang.jpg" class="card-img-top" alt="Baju Adat Aceh">
                <div class="card-body">
                    <h3 class="card-title">Baju Adat Aceh</h3>
                    <h5>Rp 190.000/hari</h5>
                    <a class="btn btn-outline-primary rounded-pill" href="detail.php">Detail</a>
                </div>
            </div>
        </div>
        
        <!-- Item 8 -->
        <div class="col-md-12 col-lg-3">
            <div class="card mb-4">
                <img style="height: 200px; object-fit: cover;" src="img/bali.jpg" class="card-img-top" alt="Baju Adat Papua">
                <div class="card-body">
                    <h3 class="card-title">Baju Adat Papua</h3>
                    <h5>Rp 210.000/hari</h5>
                    <a class="btn btn-outline-primary rounded-pill" href="detail.php">Detail</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination (Static) -->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item active"><a class="page-link" href="?page=1">1</a></li>
            <li class="page-item"><a class="page-link" href="?page=2">2</a></li>
            <li class="page-item"><a class="page-link" href="?page=3">3</a></li>
            <li class="page-item"><a class="page-link" href="?page=2">Next</a></li>
        </ul>
    </nav>
</section>

<?php include 'partials/footer.php'; ?>



