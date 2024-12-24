<?php
// Menyertakan Navbar
include '../navbar.php';
?>

<div class="container mt-3">
    <h2 class="mb-4 text-center">Daftar Transaksi</h2>

    <!-- Form Pencarian dan Tambah -->
    <div class="d-flex mb-3 justify-content-between">
        <form class="d-flex gap-2" method="get">
            <input type="text" class="form-control w-auto" placeholder="Cari Transaksi" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn btn-outline-secondary">Cari</button>
        </form>
        <a href="tambah_transaksi.php" class="btn btn-success">Tambah</a>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Pembayaran</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Menghubungkan ke database
                    include '../koneksi.php';

                    // Mengambil parameter pencarian jika ada
                    $search = isset($_GET['search']) ? $_GET['search'] : '';

                    // Query dengan kondisi pencarian 
                    $query = "SELECT id_transaksi, nama_pembeli, total_harga, tanggal_pembayaran FROM pembayaran";
                    if (!empty($search)) {
                        $search = $koneksi->real_escape_string($search);
                        $query .= " WHERE nama_pembeli LIKE '%$search%' OR id_transaksi LIKE '%$search%' OR total_harga LIKE '%$search%' OR tanggal_pembayaran LIKE '%$search%'";
                    }
                    $query .= " ORDER BY tanggal_pembayaran DESC";

                    $result = $koneksi->query($query);

                    if ($result && $result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            // Format tanggal ke format d-m-Y
                            $tanggal_pembayaran = date('d-m-Y', strtotime($row['tanggal_pembayaran']));
                            
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row['nama_pembeli'] . "</td>";
                            $total_harga = isset($row['total_harga']) ? (int)$row['total_harga'] * 1000 : 0;
                            echo "<td>Rp " . number_format($total_harga, 0, ',', '.') . "</td>";
                            echo "<td>" . $tanggal_pembayaran . "</td>";
                            echo "<td class='text-center'>
                                    <a href='detail_transaksi.php?id=" . $row['id_transaksi'] . "' class='btn btn-sm btn-primary'>Lihat</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Data tidak ditemukan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
// Menyertakan Footer
include '../footer.php';
?>
