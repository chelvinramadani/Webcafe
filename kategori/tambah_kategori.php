<?php
// Menyertakan file koneksi dan navbar
include '../koneksi.php';
include '../navbar.php';
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Tambah Kategori</h2>
    <form action="/WEBCAFE/kategori/proses_tambah_kategori.php" method="post">
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Masukkan nama kategori" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah</button>
        <a href="/WEBCAFE/kategori/index_kategori.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php
// Menyertakan footer
include '../footer.php';
?>