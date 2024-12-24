<?php
// Menyertakan file koneksi
include 'koneksi.php';

// Mengambil data dari form
$metode_pembayaran = $_POST['metode_pembayaran'];
$tanggal_pembayaran = $_POST['tanggal_pembayaran'];
$jumlah_bayar = $_POST['jumlah_bayar'];
$status_pembayaran = $_POST['status_pembayaran'];
$id_pesanan = $_POST['id_pesanan'];

// Validasi data
if (empty($metode_pembayaran) || empty($tanggal_pembayaran) || empty($jumlah_bayar) || empty($status_pembayaran) || empty($id_pesanan)) {
    echo "<script>alert('Semua data wajib diisi!'); window.history.back();</script>";
    exit;
}

// Menyimpan data ke database
$sql = "INSERT INTO pembayaran (metode_pembayaran, tanggal_pembayaran, jumlah_bayar, status_pembayaran, id_pesanan) VALUES ('$metode_pembayaran', '$tanggal_pembayaran', '$jumlah_bayar', '$status_pembayaran', '$id_pesanan')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Pembayaran berhasil disimpan!'); window.location.href = 'index.php';</script>";
} else {
    echo "<script>alert('Gagal menyimpan pembayaran!'); window.history.back();</script>";
}

// Menutup koneksi
$conn->close();
?>
