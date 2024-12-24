<?php
// Menyertakan file koneksi
include '../koneksi.php';

// Mengambil data dari form
$id_kategori = $_POST['id_kategori'];
$nama_kategori = $_POST['nama_kategori'];

// Validasi data
if (empty($id_kategori) || empty($nama_kategori)) {
    echo "<script>alert('Semua data wajib diisi!'); window.history.back();</script>";
    exit;
}

// Mengupdate data ke database
$sql = "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id_kategori = '$id_kategori'";
if ($koneksi->query($sql) === TRUE) {
    echo "<script>alert('Kategori berhasil diperbarui!'); window.location.href = 'index_kategori.php';</script>";
} else {
    echo "<script>alert('Gagal memperbarui kategori!'); window.history.back();</script>";
}

// Menutup koneksi
$koneksi->close();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#edit-kategori-form').submit(function(event) {
        event.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: 'path/to/your/php/file.php', // Sesuaikan dengan path file PHP Anda
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    // Update the category name on the page
                    $('#nama-kategori-display').text(response.nama_kategori);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    });
});
</script>
