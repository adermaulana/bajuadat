<?php include 'partials/header.php';

if (!isset($_SESSION['username_pelanggan'])) {
    // Jika tidak, redirect ke halaman login dengan pesan alert
    echo "<script>
    alert('Anda harus login terlebih dahulu!');
    document.location='login_pelanggan.php';
    </script>";
    exit;
}

?>

<div class="col">
    <div>
        <h4 class="mb-3">Pembayaran Penyewaanku</h4>
        <div id="container-booking-list">
            <!-- Order 1 -->
            <div class="card mb-3">						 
                <div class="no-gutters">						    					    
                    <div class="">						      
                        <div class="card-header ">							  	
                            <div class="row">								    
                                <div class="col text-left text-muted">ID Order : <strong>ORD-001</strong></div>								    
                                <div style="text-align:right;" class="col text">
                                    <strong class="bayar">Rp 350.000</strong>
                                </div>							    
                            </div>							  
                        </div>
                        <div class="card-body">
                            <p class="card-text">Penyewaan Baju Adat Jawa - Paket Lengkap (3 Hari)</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col text-end action-right">
                                <a href="konfirmasi_pembayaran.php"><span class="btn btn-sm btn-success">Konfirmasi Pembayaran</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order 2 -->
            <div class="card mb-3">						 
                <div class="no-gutters">						    					    
                    <div class="">						      
                        <div class="card-header ">							  	
                            <div class="row">								    
                                <div class="col text-left text-muted">ID Order : <strong>ORD-002</strong></div>								    
                                <div style="text-align:right;" class="col text">
                                    <strong class="bayar">Rp 250.000</strong>
                                </div>							    
                            </div>							  
                        </div>
                        <div class="card-body">
                            <p class="card-text">Penyewaan Baju Adat Bali - Wanita (2 Hari)</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col text-end action-right">
                                <span class="badge bg-info">Proses</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order 3 -->
            <div class="card mb-3">						 
                <div class="no-gutters">						    					    
                    <div class="">						      
                        <div class="card-header ">							  	
                            <div class="row">								    
                                <div class="col text-left text-muted">ID Order : <strong>ORD-003</strong></div>								    
                                <div style="text-align:right;" class="col text">
                                    <strong class="bayar">Rp 500.000</strong>
                                </div>							    
                            </div>							  
                        </div>
                        <div class="card-body">
                            <p class="card-text">Penyewaan Baju Adat Sunda - Paket Keluarga (5 Hari)</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col text-end action-right">
                                <span class="badge bg-secondary">Diantarkan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order 5 -->
            <div class="card mb-3">						 
                <div class="no-gutters">						    					    
                    <div class="">						      
                        <div class="card-header ">							  	
                            <div class="row">								    
                                <div class="col text-left text-muted">ID Order : <strong>ORD-005</strong></div>								    
                                <div style="text-align:right;" class="col text">
                                    <strong class="bayar">Rp 420.000</strong>
                                </div>							    
                            </div>							  
                        </div>
                        <div class="card-body">
                            <p class="card-text">Penyewaan Baju Adat Minang - Pasangan (3 Hari)</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col text-end action-right">
                                <span class="badge bg-danger">Ditolak</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<?php include 'partials/footer.php'; ?>

