<?php include 'partials/header.php'; ?>

<div class="container-fluid p-0">
    <!-- Hero Section with Carousel -->
    <div id="welcomeCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="hero-slide bg-dark" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('img/adat.jpg');">
                    <div class="container h-100">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-lg-8 text-center text-white">
                                <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">Sewa Baju Adat Berkualitas</h1>
                                <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">Temukan koleksi baju adat terlengkap dari berbagai daerah</p>
                                <a href="bajuadat.php" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm animate__animated animate__fadeInUp animate__delay-2s">
                                    <i class="bi bi-search me-2"></i>Lihat Koleksi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="carousel-item">
                                <div class="hero-slide bg-dark" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('img/adat2.jpg');">
                    <div class="container h-100">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-lg-8 text-center text-white">
                                <h1 class="display-4 fw-bold mb-3">Harga Terjangkau</h1>
                                <p class="lead mb-4">Sewa baju adat berkualitas dengan harga bersaing</p>
                                <a href="bajuadat.php" class="btn btn-warning btn-lg px-4 rounded-pill shadow-sm">
                                     <i class="bi bi-search me-2"></i>Lihat Koleksi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="carousel-item">
                <div class="hero-slide bg-dark" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('img/adat3.jpg');">
                    <div class="container h-100">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-lg-8 text-center text-white">
                                <h1 class="display-4 fw-bold mb-3">Layanan Lengkap</h1>
                                <p class="lead mb-4">Kami menyediakan paket lengkap dengan aksesoris</p>
                                <a href="bajuadat.php" class="btn btn-success btn-lg px-4 rounded-pill shadow-sm">
                                     <i class="bi bi-search me-2"></i>Lihat Koleksi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <section id="koleksi" class="container my-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Koleksi Terbaru</h2>
                <p class="text-muted">Temukan baju adat terbaru kami</p>
            </div>

            <div class="row g-4">
                <!-- Baju 1 -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <img src="img/kebaya.png" 
                            class="card-img-top" 
                            alt="Baju Adat Jawa">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">Kebaya Jawa Modern</h5>
                            <p class="card-text text-muted">Kebaya dengan motif batik kontemporer, nyaman dipakai untuk berbagai acara.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-light text-dark">Jawa Tengah</span>
                                <small class="text-muted">Rp 150.000/hari</small>
                            </div>
                            <a href="#" class="btn btn-outline-primary w-100 mt-3 rounded-pill">Sewa Sekarang</a>
                        </div>
                    </div>
                </div>
                
                <!-- Baju 2 -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <img src="img/bali.jpg"
                            class="card-img-top" 
                            alt="Baju Adat Bali">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">Baju Adat Bali</h5>
                            <p class="card-text text-muted">Baju adat Bali lengkap dengan kain khas dan aksesoris tradisional.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-light text-dark">Bali</span>
                                <small class="text-muted">Rp 200.000/hari</small>
                            </div>
                            <a href="#" class="btn btn-outline-primary w-100 mt-3 rounded-pill">Sewa Sekarang</a>
                        </div>
                    </div>
                </div>
                
                <!-- Baju 3 -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <img src="img/minang.jpg"
                            class="card-img-top" 
                            alt="Baju Adat Sumatera">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">Baju Adat Minang</h5>
                            <p class="card-text text-muted">Baju adat Minangkabau dengan songket khas dan hiasan kepala.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-light text-dark">Sumatera Barat</span>
                                <small class="text-muted">Rp 180.000/hari</small>
                            </div>
                            <a href="#" class="btn btn-outline-primary w-100 mt-3 rounded-pill">Sewa Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</div>



<?php include 'partials/footer.php'; ?>

<style>
    .hero-slide {
        height: 80vh;
        min-height: 500px;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
    }
    
    .carousel-item {
        transition: transform 1.5s ease-in-out;
    }
    
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
    
    .card-img-top {
        object-position: top;
    }
</style>

