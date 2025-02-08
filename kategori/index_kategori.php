<?php
// Menyertakan file koneksi dan navbar
include '../koneksi.php';
include '../navbar.php';

?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Kategori</h2>

    <!-- Form Pencarian dan Tambah -->
    <div class="d-flex mb-3 justify-content-between">
        <form class="d-flex gap-2" method="get">
            <input type="text" class="form-control w-auto" placeholder="Cari Kategori" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn btn-outline-secondary">Cari</button>
        </form>
        <a href="tambah_kategori.php" class="btn btn-success">Tambah</a>
    </div>


    <!-- Tabel Kategori -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mendapatkan data kategori
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $sql = "SELECT * FROM kategori";
                    if (!empty($search)) {
                        $sql .= " WHERE nama_kategori LIKE '%$search%'";
                    }
                    
                    $result = $koneksi->query($sql);

                    // Debugging: Periksa apakah query berhasil
                    if (!$result) {
                        die("Query error: " . $koneksi->error);
                    }

                    // Jika data ditemukan
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>{$no}</td>
                                <td>{$row['nama_kategori']}</td>
                                <td class='text-center'>
                                    <a href='edit_kategori.php?id={$row['id_kategori']}' class='btn btn-sm btn-primary'>Edit</a>
                                    <a href='hapus_kategori.php?id={$row['id_kategori']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus kategori ini?\")' class='btn btn-sm btn-danger'>Hapus</a>
                                </td>
                            </tr>
                            ";
                            $no++;
                        }
                    } else {
                        echo "
                        <tr>
                            <td colspan='3' class='text-center'>Tidak ada data kategori.</td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Menyertakan footer
include '../footer.php';
?>
