<?php
include '../koneksi.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_kategori = $_POST['kategori'];
    $nama_menu = $_POST['nama_menu'];
    $harga = $_POST['harga'];

    // Validasi input
    if (empty($id_kategori) || empty($nama_menu) || empty($harga)) {
        die("Semua data wajib diisi.");
    }

    if (!is_numeric($id_kategori) || $id_kategori <= 0) {
        die("ID Kategori tidak valid.");
    }

    if (!is_numeric($harga) || $harga <= 0) {
        die("Harga harus berupa angka positif.");
    }

    // Query untuk menambahkan data
    $query = "INSERT INTO menu (id_kategori, nama_menu, harga) VALUES (?, ?, ?)";
    $stmt = $koneksi->prepare($query);

    try {
        $stmt->bind_param("isd", $id_kategori, $nama_menu, $harga);
        $stmt->execute();

        header("Location: index_menu.php");
        exit;
    } catch (mysqli_sql_exception $e) {
        die("Gagal menambahkan menu: " . $e->getMessage());
    } finally {
        $stmt->close();
        $koneksi->close();
    }
}
?>
