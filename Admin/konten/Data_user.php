<!--MAIN CONTENT AREA-->
<main class="app-main">
    <!--HEADER SECTION DENGAN JUDUL DAN BREADCRUMB-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Data User</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data User</li>
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
                    <!--TABEL DATA USER DARI DATABASE-->
                    <table id="tabel-user" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID User</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Email</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Role</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // INCLUDE KONEKSI DATABASE
                            include("koneksi.php");
                            // QUERY AMBIL SEMUA DATA USER
                            $query_user = "SELECT * FROM users";
                            $result = mysqli_query($koneksi, $query_user);
                            // LOOP MENAMPILKAN SETIAP DATA USER
                            while ($row = mysqli_fetch_array($result)) :
                            ?>
                            <tr>
                                <th scope="row"><?= $row['id_user']; ?></th>
                                <td><?= $row['username']; ?></td>
                                <td><?= $row['password']; ?></td>
                                <td><?= $row['nama_lengkap']; ?></td>
                                <td><?= $row['email']; ?></td>
                                <td><?= $row['no_hp']; ?></td>
                                <td><?= $row['role']; ?></td>
                                <td>
                                    <!--TOMBOL EDIT DAN DELETE-->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_user']; ?>">
                                        Edit
                                    </button>
                                    <a href="aksi/aksi_user.php?aksi=delete&id_user=<?= $row['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
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
// QUERY AMBIL SEMUA DATA USER UNTUK MODAL EDIT
$query_user = "SELECT * FROM users";
$result = mysqli_query($koneksi, $query_user);
// LOOP BUAT MODAL EDIT UNTUK SETIAP USER
while ($row = mysqli_fetch_array($result)) :
?>
<!--MODAL EDIT USER-->
<div class="modal fade" id="editModal<?= $row['id_user']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id_user']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel<?= $row['id_user']; ?>">Edit User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--FORM EDIT USER-->
                <form action="aksi/aksi_user.php" method="POST">
                    <input type="hidden" name="aksi" value="edit">
                    <input type="hidden" name="id" value="<?= $row['id_user']; ?>">
                    
                    <!--INPUT USERNAME-->
                    <div class="mb-3">
                        <label for="username<?= $row['id_user']; ?>" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username<?= $row['id_user']; ?>" name="username" value="<?= $row['username']; ?>" required>
                    </div>
                    <!--INPUT PASSWORD-->
                    <div class="mb-3">
                        <label for="password<?= $row['id_user']; ?>" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password<?= $row['id_user']; ?>" name="password" value="<?= $row['password']; ?>" required>
                    </div>
                    <!--INPUT NAMA LENGKAP-->
                    <div class="mb-3">
                        <label for="nama_lengkap<?= $row['id_user']; ?>" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap<?= $row['id_user']; ?>" name="nama_lengkap" value="<?= $row['nama_lengkap']; ?>" required>
                    </div>
                    <!--INPUT EMAIL-->
                    <div class="mb-3">
                        <label for="email<?= $row['id_user']; ?>" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email<?= $row['id_user']; ?>" name="email" value="<?= $row['email']; ?>" required>
                    </div>
                    <!--INPUT NO HP-->
                    <div class="mb-3">
                        <label for="no_hp<?= $row['id_user']; ?>" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp<?= $row['id_user']; ?>" name="no_hp" value="<?= $row['no_hp']; ?>" required>
                    </div>
                    <!--INPUT ROLE-->
                    <div class="mb-3">
                        <label for="role<?= $row['id_user']; ?>" class="form-label">Role</label>
                        <select class="form-select" id="role<?= $row['id_user']; ?>" name="role" required>
                            <option value="admin" <?= ($row['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="siswa" <?= ($row['role'] == 'siswa') ? 'selected' : ''; ?>>Siswa</option>
                             <option value="guru" <?= ($row['role'] == 'guru') ? 'selected' : ''; ?>>Guru</option>
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

<!--MODAL TAMBAH DATA USER-->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tambahModalLabel">Tambah User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--FORM TAMBAH USER BARU-->
                <form action="aksi/aksi_user.php" method="POST">
                    <input type="hidden" name="aksi" value="tambah">
                    
                    <!--INPUT USERNAME-->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <!--INPUT PASSWORD-->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password" required>
                    </div>
                    <!--INPUT NAMA LENGKAP-->
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                    </div>
                    <!--INPUT EMAIL-->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <!--INPUT NO HP-->
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                    </div>
                    <!--INPUT ROLE-->
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="siswa">Siswa</option>
                            <option value="guru">Guru</option>
                        </select>
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
