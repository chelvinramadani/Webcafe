<?php
include '../koneksi.php'; // File koneksi ke database
include '../navbar.php';

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Tambah Menu</h2>
    <form action="proses_tambah_menu.php" method="post">
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" id="kategori" name="kategori" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <?php
                $query = "SELECT id_kategori, nama_kategori FROM kategori";
                $result = $koneksi->query($query);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id_kategori']}'>{$row['nama_kategori']}</option>";
                    }
                } else {
                    echo "<option disabled>Data kategori tidak tersedia</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="nama_menu" class="form-label">Nama Menu</label>
            <input type="text" class="form-control" id="nama_menu" name="nama_menu" placeholder="Masukkan nama menu" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga menu" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah</button>
        <a href="index_menu.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php
include '../footer.php';
?>
