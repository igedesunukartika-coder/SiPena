<!--MAIN CONTENT AREA-->
<main class="app-main">
    <!--HEADER SECTION DENGAN JUDUL DAN BREADCRUMB-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Data Kelas</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Kelas</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <!--MAIN CONTENT DENGAN TABEL DAN TOMBOL-->
    <div class="app-content">
        <div class="container-fluid">
            <!--TOMBOL UNTUK MEMBUKA MODAL TAMBAH DATA-->
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#tambahModal">
                Tambah Data
            </button>
            
            <div class="row">
                <div class="col-12">
                    <!--TABEL DATA KELAS DENGAN JOIN DATA WALI KELAS (GURU)-->
                    <table id="tabel-kelas" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID Kelas</th>
                                <th scope="col">Nama Kelas</th>
                                <th scope="col">Jurusan</th>
                                <th scope="col">Tingkat</th>
                                <th scope="col">Wali Kelas</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // INCLUDE KONEKSI DATABASE
                            include("koneksi.php");
                            // QUERY AMBIL DATA KELAS JOIN DENGAN GURU UNTUK WALI KELAS
                            $query_kelas = "SELECT k.*, u.nama_lengkap AS nama_wali, k.wali_kelas AS id_wali FROM kelas k LEFT JOIN users u ON k.wali_kelas = u.id_user";
                            $result = mysqli_query($koneksi, $query_kelas);
                            // LOOP MENAMPILKAN SETIAP DATA KELAS
                            while ($row = mysqli_fetch_array($result)) :
                            ?>
                            <tr>
                                <th scope="row"><?= $row['id_kelas']; ?></th>
                                <td><?= $row['nama_kelas']; ?></td>
                                <td><?= $row['jurusan']; ?></td>
                                <td><?= $row['tingkat']; ?></td>
                                <td><?= $row['nama_wali']; ?></td>
                                <td>
                                    <!--TOMBOL EDIT DAN DELETE-->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_kelas']; ?>">
                                        Edit
                                    </button>
                                    <a href="aksi/aksi_kelas.php?aksi=delete&id_kelas=<?= $row['id_kelas']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// INCLUDE KONEKSI DATABASE
include("koneksi.php");
// QUERY AMBIL DATA KELAS UNTUK MODAL
$query_kelas = "SELECT k.*, u.nama_lengkap AS nama_wali, k.wali_kelas AS id_wali FROM kelas k LEFT JOIN users u ON k.wali_kelas = u.id_user";
$result = mysqli_query($koneksi, $query_kelas);

// QUERY AMBIL SEMUA GURU UNTUK DROPDOWN WALI KELAS
$query_guru = "SELECT * FROM users WHERE role = 'guru'";
$result_guru = mysqli_query($koneksi, $query_guru);

// LOOP BUAT MODAL EDIT UNTUK SETIAP KELAS
while ($row = mysqli_fetch_array($result)) :
?>
<!--MODAL EDIT KELAS-->
<div class="modal fade" id="editModal<?= $row['id_kelas']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id_kelas']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel<?= $row['id_kelas']; ?>">Edit Kelas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--FORM EDIT KELAS-->
                <form action="aksi/aksi_kelas.php" method="POST">
                    <input type="hidden" name="aksi" value="edit">
                    <input type="hidden" name="id_kelas" value="<?= $row['id_kelas']; ?>">
                    
                    <!--INPUT NAMA KELAS-->
                    <div class="mb-3">
                        <label for="nama_kelas<?= $row['id_kelas']; ?>" class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="nama_kelas<?= $row['id_kelas']; ?>" name="nama_kelas" value="<?= $row['nama_kelas']; ?>" required>
                    </div>
                    <!--INPUT JURUSAN-->
                    <div class="mb-3">
                        <label for="jurusan<?= $row['id_kelas']; ?>" class="form-label">Jurusan</label>
                        <select class="form-select" id="jurusan<?= $row['id_kelas']; ?>" name="jurusan" required>
                            <option value="Kuliner" <?= ($row['jurusan'] == 'Kuliner') ? 'selected' : ''; ?>>Kuliner</option>
                            <option value="Perhotelan" <?= ($row['jurusan'] == 'Perhotelan') ? 'selected' : ''; ?>>Perhotelan</option>
                            <option value="TKC" <?= ($row['jurusan'] == 'TKC') ? 'selected' : ''; ?>>TKC</option>
                            <option value="RPL" <?= ($row['jurusan'] == 'RPL') ? 'selected' : ''; ?>>RPL</option>
                        </select>
                    </div>
                    <!--INPUT TINGKAT-->
                    <div class="mb-3">
                        <label for="tingkat<?= $row['id_kelas']; ?>" class="form-label">Tingkat</label>
                        <select class="form-select" id="tingkat<?= $row['id_kelas']; ?>" name="tingkat" required>
                            <option value="10" <?= ($row['tingkat'] == '10') ? 'selected' : ''; ?>>10</option>
                            <option value="11" <?= ($row['tingkat'] == '11') ? 'selected' : ''; ?>>11</option>
                            <option value="12" <?= ($row['tingkat'] == '12') ? 'selected' : ''; ?>>12</option>
                        </select>
                    </div>
                    <!--INPUT WALI KELAS (DARI GURU)-->
                    <div class="mb-3">
                        <label for="wali_kelas<?= $row['id_kelas']; ?>" class="form-label">Wali Kelas</label>
                        <select class="form-select" id="wali_kelas<?= $row['id_kelas']; ?>" name="wali_kelas" required>
                            <?php
                            // RESET POINTER GURU DAN LOOP UNTUK DROPDOWN
                            mysqli_data_seek($result_guru, 0);
                            while ($guru = mysqli_fetch_array($result_guru)) :
                            ?>
                            <option value="<?= $guru['id_user']; ?>" <?= ($row['id_wali'] == $guru['id_user']) ? 'selected' : ''; ?>><?= $guru['nama_lengkap']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <!--TOMBOL CLOSE DAN UPDATE-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>

<!--MODAL TAMBAH DATA KELAS-->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tambahModalLabel">Tambah Kelas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--FORM TAMBAH KELAS BARU-->
                <form action="aksi/aksi_kelas.php" method="POST">
                    <input type="hidden" name="aksi" value="tambah">
                    
                    <!--INPUT NAMA KELAS-->
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required>
                    </div>
                    <!--INPUT JURUSAN-->
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <select class="form-select" id="jurusan" name="jurusan" required>
                            <option value="">Pilih Jurusan</option>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Perhotelan">Perhotelan</option>
                            <option value="TKC">TKC</option>
                            <option value="RPL">RPL</option>
                        </select>
                    </div>
                    <!--INPUT TINGKAT-->
                    <div class="mb-3">
                        <label for="tingkat" class="form-label">Tingkat</label>
                        <select class="form-select" id="tingkat" name="tingkat" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <!--INPUT WALI KELAS-->
                    <div class="mb-3">
                        <label for="wali_kelas" class="form-label">Wali Kelas</label>
                        <select class="form-select" id="wali_kelas" name="wali_kelas" required>
                            <option value="">Pilih Wali Kelas</option>
                            <?php
                            // QUERY AMBIL SEMUA GURU
                            $query_guru = "SELECT * FROM users WHERE role = 'guru'";
                            $result_guru = mysqli_query($koneksi, $query_guru);
                            // LOOP DROPDOWN GURU
                            while ($guru = mysqli_fetch_array($result_guru)) :
                            ?>
                            <option value="<?= $guru['id_user']; ?>"><?= $guru['nama_lengkap']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <!--TOMBOL CLOSE DAN SIMPAN-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
