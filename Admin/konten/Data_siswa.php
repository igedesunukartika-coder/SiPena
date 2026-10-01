<!--MAIN CONTENT AREA-->
<main class="app-main">
    <!--HEADER SECTION DENGAN JUDUL DAN BREADCRUMB-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Data Siswa</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Siswa</li>
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
                    <!--TABEL DATA SISWA DARI DATABASE DENGAN JOIN KELAS-->
                    <table id="tabel-siswa" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID Siswa</th>
                                <th scope="col">ID User</th>
                                <th scope="col">NIS</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Nama Kelas</th>
                                <th scope="col">Tgl Lahir</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // QUERY AMBIL DATA SISWA JOIN DENGAN DATA KELAS
                            $select_siswa = "SELECT s.*, k.nama_kelas FROM siswa s LEFT JOIN kelas k ON s.id_kelas = k.id_kelas";
                            include("koneksi.php");
                            $query_siswa = $select_siswa;
                            $result = mysqli_query($koneksi, $query_siswa);
                            // LOOP MENAMPILKAN SETIAP DATA SISWA
                            while ($row = mysqli_fetch_array($result)) :
                            ?>
                            <tr>
                                <th scope="row"><?= $row['id_siswa']; ?></th>
                                <td><?= $row['id_user']; ?></td>
                                <td><?= $row['nis']; ?></td>
                                <td><?= $row['nama_siswa']; ?></td>
                                <td><?= $row['nama_kelas']; ?></td>
                                <td><?= $row['tgl_lahir']; ?></td>
                                <td><?= $row['jenis_kelamin']; ?></td>
                                <td><?= $row['alamat']; ?></td>
                                <td><?= $row['no_hp']; ?></td>
                                <td>
                                    <!--TOMBOL EDIT DAN DELETE-->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_siswa']; ?>">
                                        Edit
                                    </button>
                                    <a href="aksi/aksi_siswa.php?aksi=delete&id_siswa=<?= $row['id_siswa']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
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
// QUERY AMBIL DATA SISWA DAN KELAS UNTUK MODAL
$query_siswa = "SELECT s.*, k.nama_kelas FROM siswa s LEFT JOIN kelas k ON s.id_kelas = k.id_kelas";
$result = mysqli_query($koneksi, $query_siswa);

// QUERY AMBIL SEMUA DATA KELAS UNTUK DROPDOWN
$query_kelas = "SELECT * FROM kelas";
$result_kelas = mysqli_query($koneksi, $query_kelas);

// LOOP BUAT MODAL EDIT UNTUK SETIAP SISWA
while ($row = mysqli_fetch_array($result)) :
?>
<!--MODAL EDIT SISWA-->
<div class="modal fade" id="editModal<?= $row['id_siswa']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id_siswa']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel<?= $row['id_siswa']; ?>">Edit Siswa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--FORM EDIT SISWA-->
                <form action="aksi/aksi_siswa.php" method="POST">
                    <input type="hidden" name="aksi" value="edit">
                    <input type="hidden" name="id_siswa" value="<?= $row['id_siswa']; ?>">
                    
                    <!--INPUT ID USER-->
                    <div class="mb-3">
                        <label for="id_user<?= $row['id_siswa']; ?>" class="form-label">ID User</label>
                        <input type="number" class="form-control" id="id_user<?= $row['id_siswa']; ?>" name="id_user" value="<?= $row['id_user']; ?>" required>
                    </div>
                    <!--INPUT NIS-->
                    <div class="mb-3">
                        <label for="nis<?= $row['id_siswa']; ?>" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis<?= $row['id_siswa']; ?>" name="nis" value="<?= $row['nis']; ?>" required>
                    </div>
                    <!--INPUT NAMA SISWA-->
                    <div class="mb-3">
                        <label for="nama_siswa<?= $row['id_siswa']; ?>" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama_siswa<?= $row['id_siswa']; ?>" name="nama_siswa" value="<?= $row['nama_siswa']; ?>" required>
                    </div>
                    <!--INPUT KELAS-->
                    <div class="mb-3">
                        <label for="id_kelas<?= $row['id_siswa']; ?>" class="form-label">Nama Kelas</label>
                        <select class="form-select" id="id_kelas<?= $row['id_siswa']; ?>" name="id_kelas" required>
                            <?php
                            // RESET POINTER KELAS DAN LOOP UNTUK DROPDOWN
                            mysqli_data_seek($result_kelas, 0);
                            while ($kelas = mysqli_fetch_array($result_kelas)) :
                            ?>
                            <option value="<?= $kelas['id_kelas']; ?>" <?= ($row['id_kelas'] == $kelas['id_kelas']) ? 'selected' : ''; ?>><?= $kelas['nama_kelas']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <!--INPUT TANGGAL LAHIR-->
                    <div class="mb-3">
                        <label for="tgl_lahir<?= $row['id_siswa']; ?>" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir<?= $row['id_siswa']; ?>" name="tgl_lahir" value="<?= $row['tgl_lahir']; ?>" required>
                    </div>
                    <!--INPUT JENIS KELAMIN-->
                    <div class="mb-3">
                        <label for="jenis_kelamin<?= $row['id_siswa']; ?>" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin<?= $row['id_siswa']; ?>" name="jenis_kelamin" required>
                            <option value="L" <?= ($row['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="P" <?= ($row['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <!--INPUT ALAMAT-->
                    <div class="mb-3">
                        <label for="alamat<?= $row['id_siswa']; ?>" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat<?= $row['id_siswa']; ?>" name="alamat" rows="2"><?= $row['alamat']; ?></textarea>
                    </div>
                    <!--INPUT NO HP-->
                    <div class="mb-3">
                        <label for="no_hp<?= $row['id_siswa']; ?>" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp<?= $row['id_siswa']; ?>" name="no_hp" value="<?= $row['no_hp']; ?>" required>
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

<!--MODAL TAMBAH DATA SISWA-->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tambahModalLabel">Tambah Siswa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--FORM TAMBAH SISWA BARU-->
                <form action="aksi/aksi_siswa.php" method="POST">
                    <input type="hidden" name="aksi" value="tambah">
                    
                    <!--INPUT ID USER (HIDDEN)-->
                    <div class="mb-3">
                        <label for="id_user_tambah" class="form-label"></label>
                        <input type="hidden" class="form-control" id="id_user_tambah" name="id_user">
                    </div>
                    <!--INPUT NIS-->
                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" required>
                    </div>
                    <!--INPUT PILIH SISWA (DARI USER)-->
                    <div class="mb-3">
                        <label for="nama_siswa_tambah" class="form-label">Nama Siswa</label>
                        <select class="form-select" id="nama_siswa_tambah" name="nama_siswa" required>
                            <option value="">Pilih Siswa</option>
                            <?php
                            // QUERY AMBIL USER DENGAN ROLE SISWA
                            $query_siswa_user = "SELECT * FROM users WHERE role = 'siswa'";
                            $result_siswa_user = mysqli_query($koneksi, $query_siswa_user);
                            // LOOP DROPDOWN SISWA
                            while ($siswa_user = mysqli_fetch_array($result_siswa_user)) :
                            ?>
                            <option value="<?= $siswa_user['nama_lengkap']; ?>" data-id="<?= $siswa_user['id_user']; ?>" data-nohp="<?= $siswa_user['no_hp']; ?>"><?= $siswa_user['nama_lengkap']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <!--INPUT KELAS-->
                    <div class="mb-3">
                        <label for="id_kelas" class="form-label">Nama Kelas</label>
                        <select class="form-select" id="id_kelas" name="id_kelas" required>
                            <option value="">Pilih Kelas</option>
                            <?php
                            // QUERY AMBIL SEMUA KELAS
                            $query_kelas_tambah = "SELECT * FROM kelas";
                            $result_kelas_tambah = mysqli_query($koneksi, $query_kelas_tambah);
                            // LOOP DROPDOWN KELAS
                            while ($kelas = mysqli_fetch_array($result_kelas_tambah)) :
                            ?>
                            <option value="<?= $kelas['id_kelas']; ?>"><?= $kelas['nama_kelas']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <!--INPUT TANGGAL LAHIR-->
                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                    </div>
                    <!--INPUT JENIS KELAMIN-->
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <!--INPUT ALAMAT-->
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2"></textarea>
                    </div>
                    <!--INPUT NO HP-->
                    <div class="mb-3">
                        <label for="no_hp_tambah" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp_tambah" name="no_hp" required>
                    </div>
                    
                    <!--TOMBOL CLOSE DAN SIMPAN-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--SCRIPT UNTUK AUTO-FILL ID USER DAN NO HP SAAT PILIH SISWA-->
<script>
document.getElementById('nama_siswa_tambah').addEventListener('change', function() {
    var selected = this.options[this.selectedIndex];
    document.getElementById('id_user_tambah').value = selected.getAttribute('data-id') || '';
    document.getElementById('no_hp_tambah').value = selected.getAttribute('data-nohp') || '';
});
</script>
