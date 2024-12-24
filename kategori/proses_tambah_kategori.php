<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = $_POST['nama_kategori'];

    // Query untuk menambahkan kategori
    $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: index_kategori.php?status=sukses");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
