<?php include 'partials/header.php';



$id_pelanggan = 1;



?>

 <div class="container mt-5">
        <h2 class="mb-4">Keranjang Belanja - Baju Adat Indonesia</h2>
        
        <div class="row">
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Baju Adat</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Total</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>
                                <img src="img/kebaya.png" alt="Baju Adat Jawa" class="img-thumbnail" style="max-width: 100px;">
                                Baju Adat Jawa
                            </td>
                            <td>2</td>
                            <td>Rp. 850.000</td>
                            <td>Rp. 1.700.000</td>
                            <td>
                                <button class="btn btn-danger">
                                    <i class="fas fa-times-circle"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>
                                <img src="img/bali.jpg" alt="Baju Adat Bali" class="img-thumbnail" style="max-width: 100px;">
                                Baju Adat Bali
                            </td>
                            <td>1</td>
                            <td>Rp. 950.000</td>
                            <td>Rp. 950.000</td>
                            <td>
                                <button class="btn btn-danger">
                                    <i class="fas fa-times-circle"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>
                                <img src="img/minang.jpg" alt="Baju Adat Minang" class="img-thumbnail" style="max-width: 100px;">
                                Baju Adat Minang
                            </td>
                            <td>1</td>
                            <td>Rp. 1.250.000</td>
                            <td>Rp. 1.250.000</td>
                            <td>
                                <button class="btn btn-danger">
                                    <i class="fas fa-times-circle"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Belanja</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Subtotal:
                                <span>Rp. 3.900.000</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Pengiriman:
                                <span>Rp. 50.000</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                Total:
                                <span>Rp. 3.950.000</span>
                            </li>
                        </ul>
                        <button class="btn btn-primary mt-3 w-100">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
        
        <a href="bajuadat.php" class="btn btn-success mt-3">
            <i class="fas fa-shopping-cart"></i> Lanjut Belanja
        </a>
    </div>

<?php include 'partials/footer.php'; ?>
