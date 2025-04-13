<?php include 'partials/header.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username_pelanggan'])) {
    // Jika tidak, redirect ke halaman login dengan pesan alert
    echo "<script>
    alert('Anda harus login terlebih dahulu!');
    document.location='login_pelanggan.php';
    </script>";
    exit;
}



?>

<div class="row">
    <div class="col-lg-4 col-md-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <h4>Data Penyewa</h4>
                <span>Nama : <b>Anisa Wijayanti</b></span><br>
                <span>Alamat : <b>Jl. Perintis No. 45, Makassar</b></span><br>
                <span>Telepon : <b>081234567890</b></span><br>
                <span>Email : <b>anisa@gmail.com</b></span><br>
                <hr>
                <span>Terima Kasih Telah Menyewa di Kami</span>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body col-lg-10">
                <h4>Detail Penyewaan Baju Adat</h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Baju Adat Jawa (Pria) - L</span>
                        <span>1 set</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Baju Adat Jawa (Wanita) - M</span>
                        <span>1 set</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Dekorasi Aksesoris</span>
                        <span>1 paket</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Durasi Sewa</span>
                        <span>3 Hari</span>
                    </li>
                </ul>
                
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_order" value="ORD-001">
                    
                    <div class="mb-3">
                        <label class="form-label">Total Pembayaran</label>
                        <input type="text" name="total_bayar" value="Rp 750.000" class="form-control" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-select" name="metode_pembayaran" required>
                            <option value="">Pilih Bank</option>
                            <option value="BCA">BCA - 0583493xxx (Baju Adat Nusantara)</option>
                            <option value="BRI">BRI - 1234567890 (Baju Adat Nusantara)</option>
                            <option value="Mandiri">Mandiri - 9876543210 (Baju Adat Nusantara)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pengambilan</label>
                        <input type="date" class="form-control" name="tanggal_pengambilan" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Bukti Transfer</label>
                        <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*" required>
                        <small class="text-muted">Upload bukti transfer (format: JPG/PNG, max 2MB)</small>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                        <label class="form-check-label" for="agreeTerms">
                            Saya menyetujui syarat dan ketentuan penyewaan
                        </label>
                    </div>
                    
                    <button type="submit" name="simpan" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
