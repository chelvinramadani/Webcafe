<?php
// Menyertakan file koneksi dan navbar
include '../koneksi.php';
include '../navbar.php';

// Mendapatkan ID menu dari URL
$id_menu = isset($_GET['id']) ? $_GET['id'] : null;

// Jika ID tidak ditemukan, arahkan kembali ke index_menu.php
if (!$id_menu) {
    header("Location: index_menu.php?error=invalid_id");
    exit;
}

// Mendapatkan data menu berdasarkan ID
$query = "SELECT * FROM menu WHERE id_menu = '$id_menu'";
$result = $koneksi->query($query);

// Jika data tidak ditemukan
if ($result->num_rows == 0) {
    header("Location: index_menu.php?error=not_found");
    exit;
}

// Ambil data menu
$menu = $result->fetch_assoc();
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Edit Menu</h2>
    <form action="proses_edit_menu.php" method="post">
        <!-- Hidden input untuk ID Menu -->
        <input type="hidden" name="id_menu" value="<?php echo $menu['id_menu']; ?>">

        <!-- Pilihan Kategori -->
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" id="kategori" name="id_kategori" required>
                <?php
                // Ambil data kategori untuk dropdown
                $query_kategori = "SELECT * FROM kategori";
                $result_kategori = $koneksi->query($query_kategori);

                while ($kategori = $result_kategori->fetch_assoc()) {
                    $selected = $menu['id_kategori'] == $kategori['id_kategori'] ? 'selected' : '';
                    echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nama_kategori']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Nama Menu -->
        <div class="mb-3">
            <label for="nama_menu" class="form-label">Nama Menu</label>
            <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="<?php echo $menu['nama_menu']; ?>" required>
        </div>

        <!-- Harga -->
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $menu['harga']; ?>" required>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index_menu.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php
// Menyertakan footer
include '../footer.php';
?>
