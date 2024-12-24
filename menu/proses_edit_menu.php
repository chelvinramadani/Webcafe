<?php
// Menyertakan file koneksi
include '../koneksi.php';

// Memastikan request berasal dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_menu = $_POST['id_menu'];
    $id_kategori = $_POST['id_kategori'];
    $nama_menu = $_POST['nama_menu'];
    $harga = $_POST['harga'];

    // Query untuk memperbarui data menu
    $query = "UPDATE menu 
              SET id_kategori = '$id_kategori', nama_menu = '$nama_menu', harga = '$harga' 
              WHERE id_menu = '$id_menu'";

    if ($koneksi->query($query) === TRUE) {
        // Berhasil diperbarui, kembali ke index_menu.php
        header("Location: index_menu.php?status=sukses_edit");
    } else {
        // Gagal diperbarui, tampilkan error
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }
}
?>
