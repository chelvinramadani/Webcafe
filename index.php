<?php
include 'koneksi.php';

$limit = 10; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Mendapatkan filter dari URL
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'semua';

// Mendapatkan pencarian tanggal jika ada
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';

// Logika untuk mengambil data dari database berdasarkan filter dan tanggal
if ($filter === 'transaksi_terbanyak') {
    $query = "SELECT id_transaksi, nama_pembeli, total_harga, tanggal_pembayaran 
              FROM pembayaran 
              WHERE total_harga IN (SELECT MAX(total_harga) FROM pembayaran)
              ORDER BY total_harga DESC 
              LIMIT $start, $limit";
} else {
    $query = "SELECT id_transaksi, nama_pembeli, total_harga, tanggal_pembayaran 
              FROM pembayaran 
              WHERE id_transaksi IN (
                  SELECT id_transaksi 
                  FROM pembayaran 
                  WHERE 1=1";

    // Subquery untuk filter berdasarkan tanggal
    if (!empty($tanggal_mulai) && !empty($tanggal_selesai)) {
        $query .= " AND tanggal_pembayaran BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
    }
    $query .= ") ORDER BY tanggal_pembayaran DESC LIMIT $start, $limit";
}

// Subquery untuk total penjualan
$query_total_penjualan = "SELECT (SELECT SUM(total_harga) FROM pembayaran) AS total_penjualan";
$result_total_penjualan = $koneksi->query($query_total_penjualan);
$total_penjualan = ($result_total_penjualan->num_rows > 0) ? $result_total_penjualan->fetch_assoc()['total_penjualan'] * 1000 : 0;

// Subquery untuk menghitung total transaksi
$query_total_transaksi = "SELECT (SELECT COUNT(*) FROM pembayaran) AS total_transaksi";
$result_total_transaksi = $koneksi->query($query_total_transaksi);
$total_transaksi = ($result_total_transaksi->num_rows > 0) ? $result_total_transaksi->fetch_assoc()['total_transaksi'] : 0;


$result = $koneksi->query($query);
?>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<!-- Dashboard Content -->
<div class="container mt-4">
    <h2 class="text-center mb-4">Dashboard Penjualan</h2>

    <!-- Card Row for Sales Data -->
    <div class="row">

        <!-- Total Sales Card -->
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Penjualan</div>
                <div class="card-body">
                    <h5 class="card-title">Rp <?php echo number_format($total_penjualan, 0, ',', '.'); ?></h5>
                    <p class="card-text">Total penjualan dalam rupiah.</p>
                </div>
            </div>
        </div>

        <!-- Total Transactions Card -->
        <div class="col-md-6">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Total Transaksi</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $total_transaksi; ?> Transaksi</h5>
                    <p class="card-text">Jumlah total transaksi yang terjadi.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Options -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h2>Transaksi Terbaru</h2>

        <form class="d-flex gap-2" method="get">
            <input type="date" class="form-control" name="tanggal_mulai" value="<?php echo $tanggal_mulai; ?>" placeholder="Tanggal Mulai">
            <input type="date" class="form-control" name="tanggal_selesai" value="<?php echo $tanggal_selesai; ?>" placeholder="Tanggal Selesai">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Filter
            </button>
            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item" href="?filter=semua">Semua Transaksi</a></li>
                <li><a class="dropdown-item" href="?filter=transaksi_terbanyak">Transaksi Terbanyak</a></li>
            </ul>
        </div>
    </div>

    <!-- Sales Table -->
    <table class="table table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Total Pembayaran</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . (isset($row['nama_pembeli']) ? $row['nama_pembeli'] : 'N/A') . "</td>";
                    $total_harga = isset($row['total_harga']) ? (int)$row['total_harga'] * 1000 : 0;
                    echo "<td>Rp " . number_format($total_harga, 0, ',', '.') . "</td>";
                    echo "<td>" . date('d-m-Y', strtotime($row['tanggal_pembayaran'])) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Data tidak ditemukan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Menutup koneksi database
$koneksi->close();
?>

<?php include 'footer.php'; ?>
