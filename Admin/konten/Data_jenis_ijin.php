<!--MAIN CONTENT AREA-->
<main class="app-main">
    <!--HEADER SECTION DENGAN JUDUL DAN BREADCRUMB-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Data Jenis Ijin</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Jenis Ijin</li>
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
                    <!--TABEL DATA JENIS IJIN DARI DATABASE-->
                    <table id="tabel-jenis" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID Jenis</th>
                                <th scope="col">Nama Jenis</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // INCLUDE KONEKSI DATABASE
                            include("koneksi.php");
                            // QUERY AMBIL SEMUA DATA JENIS IJIN
                            $query_jenis_izin = "SELECT * FROM jenis_izin";
                            $result = mysqli_query($koneksi, $query_jenis_izin);
                            // LOOP MENAMPILKAN SETIAP DATA JENIS IJIN
                            while ($row = mysqli_fetch_array($result)) :
                            ?>
                            <tr>
                                <th scope="row"><?= $row['id_jenis']; ?></th>
                                <td><?= $row['nama_jenis']; ?></td>
                                <td><?= $row['deskripsi']; ?></td>
                                <td>
                                    <!--TOMBOL EDIT DAN DELETE-->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_jenis']; ?>">
                                        Edit
                                    </button>
                                    <a href="aksi/aksi_jenis_ijin.php?aksi=delete&id_jenis=<?= $row['id_jenis']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
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
// QUERY AMBIL DATA JENIS IJIN UNTUK MODAL
$query_jenis_izin = "SELECT * FROM jenis_izin";
$result = mysqli_query($koneksi, $query_jenis_izin);

// LOOP BUAT MODAL EDIT UNTUK SETIAP JENIS IJIN
while ($row = mysqli_fetch_array($result)) :
?>
<!--MODAL EDIT JENIS IJIN-->
<div class="modal fade" id="editModal<?= $row['id_jenis']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id_jenis']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel<?= $row['id_jenis']; ?>">Edit Jenis Ijin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--FORM EDIT JENIS IJIN-->
                <form action="aksi/aksi_jenis_ijin.php" method="POST">
                    <input type="hidden" name="aksi" value="edit">
                    <input type="hidden" name="id_jenis" value="<?= $row['id_jenis']; ?>">
                    
                    <!--INPUT NAMA JENIS-->
                    <div class="mb-3">
                        <label for="nama_jenis<?= $row['id_jenis']; ?>" class="form-label">Nama Jenis</label>
                        <input type="text" class="form-control" id="nama_jenis<?= $row['id_jenis']; ?>" name="nama_jenis" value="<?= $row['nama_jenis']; ?>" required>
                    </div>
                    <!--INPUT DESKRIPSI-->
                    <div class="mb-3">
                        <label for="deskripsi<?= $row['id_jenis']; ?>" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi<?= $row['id_jenis']; ?>" name="deskripsi" rows="3"><?= $row['deskripsi']; ?></textarea>
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

<!--MODAL TAMBAH DATA JENIS IJIN-->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tambahModalLabel">Tambah Jenis Ijin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--FORM TAMBAH JENIS IJIN BARU-->
                <form action="aksi/aksi_jenis_ijin.php" method="POST">
                    <input type="hidden" name="aksi" value="tambah">
                    
                    <!--INPUT NAMA JENIS-->
                    <div class="mb-3">
                        <label for="nama_jenis" class="form-label">Nama Jenis</label>
                        <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" required>
                    </div>
                    <!--INPUT DESKRIPSI-->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
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
