<?php
// Menyertakan file koneksi dan navbar
include '../koneksi.php';
include '../navbar.php';

// Mendapatkan ID kategori dari parameter URL
$id_kategori = $_GET['id'];

// Validasi jika ID kategori tidak ada
if (empty($id_kategori)) {
    echo "<script>alert('ID kategori tidak ditemukan!'); window.location.href = 'index.php';</script>";
    exit;
}

// Mengambil data kategori berdasarkan ID
$sql = "SELECT * FROM kategori WHERE id_kategori = '$id_kategori'";
$result = $koneksi->query($sql);

// Jika data tidak ditemukan
if ($result->num_rows == 0) {
    echo "<script>alert('Kategori tidak ditemukan!'); window.location.href = 'index.php';</script>";
    exit;
}

$data = $result->fetch_assoc();
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Edit Kategori</h2>
    <form action="proses_edit_kategori.php" method="post">
        <input type="hidden" name="id_kategori" value="<?php echo $data['id_kategori']; ?>">
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?php echo $data['nama_kategori']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/WEBCAFE/kategori/index_kategori.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php
// Menyertakan footer
include '../footer.php';
?>
