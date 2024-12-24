<?php
// Menyertakan file koneksi
include 'koneksi.php';

// Mengambil data pembayaran dari database
$sql = "SELECT * FROM pembayaran";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Pembayaran</title>
</head>
<body>
    <h2>Data Pembayaran</h2>
    <table border="1">
        <tr>
            <th>ID Pembayaran</th>
            <th>Metode Pembayaran</th>
            <th>Tanggal Pembayaran</th>
            <th>Jumlah Bayar</th>
            <th>Status Pembayaran</th>
            <th>ID Pesanan</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id_pembayaran']}</td>
                    <td>{$row['metode_pembayaran']}</td>
                    <td>{$row['tanggal_pembayaran']}</td>
                    <td>{$row['jumlah_bayar']}</td>
                    <td>{$row['status_pembayaran']}</td>
                    <td>{$row['id_pesanan']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada pembayaran</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
