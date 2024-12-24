<?php
// Menyertakan file koneksi
include '../koneksi.php';

// Periksa apakah parameter ID ada di URL
if (isset($_GET['id'])) {
    $id_menu = $_GET['id'];

    // Validasi apakah ID adalah angka
    if (!is_numeric($id_menu)) {
        die("ID menu tidak valid.");
    }

    // Query untuk menghapus data menu berdasarkan ID
    $query = "DELETE FROM menu WHERE id_menu = ?";
    $stmt = $koneksi->prepare($query);

    try {
        // Bind parameter dan eksekusi query
        $stmt->bind_param("i", $id_menu);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirect kembali ke halaman daftar menu dengan pesan sukses
            header("Location: index_menu.php?status=success&message=Menu berhasil dihapus.");
        } else {
            // Jika tidak ada baris yang dihapus
            header("Location: index_menu.php?status=error&message=Menu tidak ditemukan.");
        }
        exit;
    } catch (mysqli_sql_exception $e) {
        // Tampilkan pesan error jika query gagal
        die("Gagal menghapus menu: " . $e->getMessage());
    } finally {
        $stmt->close();
        $koneksi->close();
    }
} else {
    // Jika parameter ID tidak ada, redirect ke halaman daftar menu
    header("Location: index_menu.php?status=error&message=ID menu tidak ditemukan.");
    exit;
}
