<?php
// Menyertakan file koneksi dan navbar
include '../koneksi.php';
include '../navbar.php';
?>

<div class="container mt-3 mb-5">
    <h2 class="text-center mb-3">Daftar Menu</h2>

    <!-- Form Pencarian dan Tambah -->
    <div class="d-flex mb-3 justify-content-between">
        <form class="d-flex gap-2" method="get">
            <input type="text" class="form-control w-auto" placeholder="Cari Menu" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn btn-outline-secondary">Cari</button>
        </form>
        <a href="tambah_menu.php" class="btn btn-success">Tambah</a>
    </div>

    <!-- Tabel Menu -->

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mengambil parameter pencarian jika ada
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    
                    // Query untuk mendapatkan data menu
                    $sql = "SELECT m.id_menu, k.nama_kategori, m.nama_menu, m.harga 
                            FROM menu m 
                            JOIN kategori k ON m.id_kategori = k.id_kategori";
                    if (!empty($search)) {
                        $sql .= " WHERE m.nama_menu LIKE '%$search%' OR k.nama_kategori LIKE '%$search%'";
                    }
                    $result = $koneksi->query($sql);

                    // Debugging: Periksa apakah query berhasil
                    if (!$result) {
                        die("Query error: " . $koneksi->error);
                    }

                    // Menampilkan data
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>{$no}</td>
                                <td>{$row['nama_kategori']}</td>
                                <td>{$row['nama_menu']}</td>
                                <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                                <td class='text-center'>
                                    <a href='edit_menu.php?id={$row['id_menu']}' class='btn btn-sm btn-primary'>Edit</a>
                                    <a href='hapus_menu.php?id={$row['id_menu']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus menu ini?\")' class='btn btn-sm btn-danger'>Hapus</a>
                                </td>
                            </tr>
                            ";
                            $no++;
                        }
                    } else {
                        echo "
                        <tr>
                            <td colspan='5' class='text-center'>Tidak ada data menu.</td>
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
