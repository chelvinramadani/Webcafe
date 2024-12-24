<?php
// Menyertakan Navbar
include '../navbar.php';
?>

<div class="container mt-3">
    <h2 class="mb-4 text-center">Transaksi Baru</h2>
    
    <form id="formTransaksi" action="proses_transaksi.php" method="POST">
        <!-- Input Nama Pembeli -->
        <div class="mb-4">
            <label for="namaPembeli" class="form-label">Nama Pembeli</label>
            <input type="text" class="form-control" id="namaPembeli" name="nama_pembeli" placeholder="Masukkan nama pembeli" required>
        </div>

        <!-- Daftar Menu -->
        <div class="mb-4">
            <h4>Daftar Menu</h4>
            <?php
            // Menghubungkan ke database
            include '../koneksi.php';

            // Mengambil data menu dari database
            $sql = "SELECT * FROM menu";
            $result = $koneksi->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="table table-bordered">';
                echo '<thead><tr><th>Menu</th><th>Harga</th><th>Jumlah</th></tr></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['nama_menu'] . '</td>';
                    echo '<td>Rp ' . number_format($row['harga'], 0, ',', '.') . '</td>';
                    echo '<td>
                            <input type="number" class="form-control jumlah" name="jumlah[' . $row['id_menu'] . ']" 
                            data-harga="' . $row['harga'] . '" min="0" value="0">
                          </td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p class="text-center">Menu tidak tersedia.</p>';
            }
            ?>
        </div>

        <!-- Total Harga -->
        <div class="mb-4">
            <label for="totalHarga" class="form-label">Total Harga</label>
            <input type="number" class="form-control" id="totalHarga" name="total_harga" readonly value="0">
        </div>

        <!-- Input Pembayaran -->
        <div class="mb-4">
            <label for="pembayaran" class="form-label">Pembayaran</label>
            <input type="number" class="form-control" id="pembayaran" name="pembayaran" min="0">
        </div>

        <!-- Input Tanggal Transaksi -->
        <div class="mb-4">
            <label for="tanggalTransaksi" class="form-label">Tanggal Transaksi</label>
            <input type="date" class="form-control" id="tanggalTransaksi" name="tanggal_transaksi" 
            value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <!-- Kembalian -->
        <div class="mb-4">
            <label for="kembalian" class="form-label">Kembalian</label>
            <input type="text" class="form-control" id="kembalian" name="kembalian" readonly value="0">
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary mb-10">Bayar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Menghitung Total Harga Otomatis
document.querySelectorAll('.jumlah').forEach(input => {
    input.addEventListener('input', () => {
        let total = 0;
        document.querySelectorAll('.jumlah').forEach(item => {
            const jumlah = parseInt(item.value) || 0;
            const harga = parseInt(item.getAttribute('data-harga'));
            total += jumlah * harga;
        });
        document.getElementById('totalHarga').value = total.toLocaleString('id-ID');
    });
});

// Menghitung Kembalian
document.getElementById('pembayaran').addEventListener('input', () => {
    const total = parseInt(document.getElementById('totalHarga').value.replace(/\D/g, '')) || 0;
    const pembayaran = parseInt(document.getElementById('pembayaran').value) || 0;
    const kembalian = pembayaran - total;
    document.getElementById('kembalian').value = (kembalian > 0 ? kembalian : 0).toLocaleString('id-ID');
});
</script>

<?php
// Menyertakan Footer
include '../footer.php';
?>