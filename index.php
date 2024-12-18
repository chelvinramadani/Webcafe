<?php
// Menghubungkan ke database
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

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
                    <h5 class="card-title">Rp 1.000.000</h5>
                    <p class="card-text">Total penjualan dalam rupiah.</p>
                </div>
            </div>
        </div>

        <!-- Total Transactions Card -->
        <div class="col-md-6">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Total Transaksi</div>
                <div class="card-body">
                    <h5 class="card-title">10 Transaksi</h5>
                    <p class="card-text">Jumlah total transaksi yang terjadi.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Options -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h2>Transaksi Terbaru</h2>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Filter
            </button>
            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item" href="?filter=semua">Semua Transaksi</a></li>
                <li><a class="dropdown-item" href="?filter=transaksi_terbanyak">Transaksi Terbanyak</a></li>
                <li><a class="dropdown-item" href="?filter=produk_terjual_terbanyak">Produk Terjual Terbanyak</a></li>
            </ul>
        </div>
    </div>

    <!-- Sales Table -->
    <table class="table table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Total Pembayaran</th>
                <th>Tanggal</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mendapatkan filter dari URL
            $filter = isset($_GET['filter']) ? $_GET['filter'] : 'semua';

            // Logika untuk mengambil data dari database berdasarkan filter
            if ($filter === 'transaksi_terbanyak') {
                $query = "SELECT nomor_transaksi, nama_pelanggan, total_pembayaran, tanggal FROM transaksi ORDER BY total_pembayaran DESC LIMIT 5";
            } elseif ($filter === 'produk_terjual_terbanyak') {
                $query = "SELECT t.id_pembayaran, t.jumlah_bayar, t.tanggal_pembayaran 
                          FROM pembayaran t
                          JOIN produk p ON t.id_produk = p.id_produk
                          ORDER BY p.jumlah_terjual DESC LIMIT 5";
            } else {
                $query = "SELECT id_pembayaran, jumlah_bayar, tanggal_pembayaran FROM pembayaran ORDER BY tanggal_pembayaran DESC";
            }

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['nomor_transaksi'] . "</td>";
                    echo "<td>" . $row['nama_pelanggan'] . "</td>";
                    echo "<td>Rp " . number_format($row['total_pembayaran'], 0, ',', '.') . "</td>";
                    echo "<td>" . $row['tanggal'] . "</td>";
                    echo "<td class='text-center'>
                            <a href='edit_transaksi.php?id=" . $row['id_transaksi'] . "' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='hapus_transaksi.php?id=" . $row['id_transaksi'] . "' class='btn btn-sm btn-danger'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Data tidak ditemukan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Menutup koneksi database
$conn->close();
?>

<?php include 'footer.php'; ?>
