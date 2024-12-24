<?php
// Menyertakan file koneksi
include '../koneksi.php';

// Mendapatkan ID kategori dari parameter URL
$id_kategori = $_GET['id'];

// Validasi jika ID kategori tidak ada
if (empty($id_kategori)) {
    echo "<script>alert('ID kategori tidak ditemukan!'); window.location.href = 'index_kategori.php';</script>";
    exit;
}

// Menghapus data dari database
$sql = "DELETE FROM kategori WHERE id_kategori = '$id_kategori'";
if ($koneksi->query($sql) === TRUE) {
    echo "<script>alert('Kategori berhasil dihapus!'); window.location.href = 'index_kategori.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus kategori!'); window.history.back();</script>";
}

// Menutup koneksi
$koneksi->close();
?>
