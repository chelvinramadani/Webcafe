<?php
// Menyertakan Navbar
include '../navbar.php';

// Menghubungkan ke database
include '../koneksi.php';

// Mendapatkan ID transaksi dari URL
$id_transaksi = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_transaksi) {
    echo "<div class='container mt-3'><p class='text-danger text-center'>ID Transaksi tidak ditemukan!</p></div>";
    include '../footer.php';
    exit;
}

// Query untuk mendapatkan data transaksi berdasarkan ID
$sql = "SELECT * FROM pembayaran WHERE id_transaksi = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_transaksi);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='container mt-3'><p class='text-danger text-center'>Transaksi tidak ditemukan!</p></div>";
    include '../footer.php';
    exit;
}

$transaksi = $result->fetch_assoc();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Detail Transaksi</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Nama Pembeli:</div>
                        <div class="col-sm-8"><?php echo $transaksi['nama_pembeli']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Tanggal:</div>
                        <div class="col-sm-8"><?php echo date('d-m-Y', strtotime($transaksi['tanggal_pembayaran'])); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Subtotal:</div>
                        <div class="col-sm-8">Rp <?php echo number_format((int)$transaksi['total_harga'] * 1000, 0, ',', '.'); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Pembayaran:</div>
                        <div class="col-sm-8">Rp <?php echo number_format($transaksi['pembayaran'], 0, ',', '.'); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Kembalian:</div>
                        <div class="col-sm-8">Rp <?php echo number_format((int)$transaksi['kembalian'] * 1000, 0, ',', '.'); ?></div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="index_transaksi.php" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
// Menyertakan Footer
include '../footer.php';
?>
