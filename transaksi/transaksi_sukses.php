<?php
// Menyertakan file koneksi
include '../koneksi.php';
include '../navbar.php';

// Ambil data dari form
$nama_pembeli = $_POST['nama_pembeli'];
$total_harga = str_replace(',', '', $_POST['total_harga']); // Hapus format angka
$pembayaran = $_POST['pembayaran'];
$kembalian = $_POST['kembalian'];
$jumlah_menu = $_POST['jumlah']; // Array jumlah menu

try {
    // Mulai transaksi
    $conn->begin_transaction();

    // Simpan data transaksi ke tabel `pembayaran`
    $sql_transaksi = "INSERT INTO pembayaran (nama_pembeli, total_harga, pembayaran, kembalian) 
                      VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_transaksi);
    $stmt->bind_param("siii", $nama_pembeli, $total_harga, $pembayaran, $kembalian);
    $stmt->execute();

    // Ambil ID transaksi yang baru saja disimpan
    $id_transaksi = $conn->insert_id;

    // Simpan detail menu yang dipesan ke tabel `detail_transaksi`
    $sql_detail = "INSERT INTO detail_transaksi (id_transaksi, id_menu, jumlah, subtotal) 
                   VALUES (?, ?, ?, ?)";
    $stmt_detail = $conn->prepare($sql_detail);

    foreach ($jumlah_menu as $id_menu => $jumlah) {
        if ($jumlah > 0) { // Hanya simpan jika jumlah lebih dari 0
            // Ambil harga menu berdasarkan id_menu
            $sql_menu = "SELECT harga FROM menu WHERE id_menu = ?";
            $stmt_menu = $conn->prepare($sql_menu);
            $stmt_menu->bind_param("i", $id_menu);
            $stmt_menu->execute();
            $result_menu = $stmt_menu->get_result();

            if ($result_menu->num_rows > 0) {
                $harga = $result_menu->fetch_assoc()['harga'];

                // Hitung subtotal
                $subtotal = $jumlah * $harga;

                // Simpan ke tabel `detail_transaksi`
                $stmt_detail->bind_param("iiii", $id_transaksi, $id_menu, $jumlah, $subtotal);
                $stmt_detail->execute();
            }
        }
    }

    // Commit transaksi
    $conn->commit();

    // Redirect ke halaman transaksi sukses
    header('Location: transaksi_sukses.php?status=success&id_transaksi=' . $id_transaksi);
    exit();
} catch (Exception $e) {
    // Rollback jika terjadi kesalahan
    $conn->rollback();

    // Tampilkan pesan error
    echo "Gagal menyimpan transaksi: " . $e->getMessage();
}
?>
<?php 
include '../footer.php';
 ?>