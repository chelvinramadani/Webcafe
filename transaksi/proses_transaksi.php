<?php
include '../koneksi.php';

$nama_pembeli = $_POST['nama_pembeli'];
$tanggal_transaksi = $_POST['tanggal_transaksi'];
$total_harga = $_POST['total_harga'];
$pembayaran = $_POST['pembayaran'];
$kembalian = $_POST['kembalian'];

// Simpan transaksi ke database
$sql = "INSERT INTO pembayaran (nama_pembeli, tanggal_pembayaran, total_harga, pembayaran, kembalian) 
        VALUES ('$nama_pembeli', '$tanggal_transaksi', '$total_harga', '$pembayaran', '$kembalian')";

if ($koneksi->query($sql) === TRUE) {
    // Redirect ke halaman index transaksi
    header("Location: index_transaksi.php");
    exit(); // Menghentikan eksekusi script setelah redirect
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
