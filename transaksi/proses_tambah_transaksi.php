<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_pembeli = $_POST['nama_pembeli'];
    $total_harga = $_POST['total_harga'];
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $status_pembayaran = $_POST['status_pembayaran'];
    $id_pesanan = $_POST['id_pesanan'];

    if (empty($nama_pelanggan) || empty($total_pembayaran) || empty($tanggal_pembayaran) || empty($metode_pembayaran) || empty($id_pesanan)) {
        die("Semua kolom wajib diisi!");
    }

    $sql = "INSERT INTO pembayaran (metode_pembayaran, tanggal_pembayaran, total_harga, status_pembayaran, id_pesanan, nama_pelanggan) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    // Bind parameter ke query
    $stmt->bind_param("ssdsss", $metode_pembayaran, $tanggal_pembayaran, $total_pembayaran, $status_pembayaran, $id_pesanan, $nama_pelanggan);

    // Eksekusi query
    try {
        if ($stmt->execute()) {
            header("Location: index_transaksi.php?success=true");
            exit;
        } else {
            die("Execution failed: " . $stmt->error);
        }
    } catch (Exception $e) {
        die("Error occurred: " . $e->getMessage());
    } finally {
        $stmt->close();
        $conn->close();
    }
} else {
    die("Invalid request method.");
}
?>
