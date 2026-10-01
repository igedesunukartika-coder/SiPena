<!--MAIN CONTENT AREA-->
<main class="app-main">
    <!--HEADER SECTION DENGAN JUDUL DAN BREADCRUMB-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Data Izin Siswa</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Izin Siswa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <!--MAIN CONTENT DENGAN TABEL DAN TOMBOL-->
    <div class="app-content">
        <div class="container-fluid">
            <!--TOMBOL UNTUK MENAMBAH IZIN BARU-->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambah">
                + Tambah Izin
            </button>
            <div class="row">
                <div class="col-lg-12">
                    <!--TABEL DATA IZIN DENGAN JOIN SISWA DAN JENIS IJIN-->
                    <table id="tabel-izin" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID IZIN</th>
                                <th scope="col">NAMA SISWA</th>
                                <th scope="col">JENIS IZIN</th>
                                <th scope="col">TANGGAL</th>
                                <th scope="col">FILE</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">TGL DIBUAT</th>
                                <th scope="col">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // INCLUDE KONEKSI DATABASE
                            include("koneksi.php");
                            // QUERY AMBIL DATA IZIN JOIN DENGAN DATA SISWA DAN JENIS IJIN
                            $query_izin = "SELECT i.*, s.nama_siswa, ji.nama_jenis FROM izin i 
                            LEFT JOIN siswa s ON i.id_siswa = s.id_siswa 
                            LEFT JOIN jenis_izin ji ON i.id_jenis = ji.id_jenis";
                            $result = mysqli_query($koneksi, $query_izin);
                            // LOOP MENAMPILKAN SETIAP DATA IZIN
                            while ($row = mysqli_fetch_array($result)) :
                            ?>
                                <tr>
                                    <th scope="row"><?= $row['id_izin'] ?></th>
                                    <td><?= $row['nama_siswa'] ?></td>
                                    <td><?= $row['nama_jenis'] ?></td>
                                    <td><?= $row['tanggal'] ?></td>
                                    <td>
                                        <!--TOMBOL LIHAT FILE JIKA ADA-->
                                        <a href="uploads/<?=$row['file_surat']?>"
                                        class="btn btn-info btn-sm" target="_blank">
                                            <i class="bi bi-file-earmark-text"></i> Lihat
                                        </a>
                                    </td>
                                    <td><?= $row['status'] ?></td>
                                    <td><?= $row['tgl_dibuat'] ?></td>
                                    <td>
                                        <!--TOMBOL EDIT-->
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_izin'] ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!--TOMBOL DELETE DENGAN CONFIRMATION SWEETALERT-->
                                        <button type="button" class="btn btn-danger btn-sm" id="hapus<?= $row['id_izin'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <script>
                                            document.getElementById("hapus<?= $row['id_izin'] ?>").addEventListener("click", function(event) {
                                                event.preventDefault();
                                                Swal.fire({
                                                    title: "Yakin ingin menghapus?",
                                                    text: "Data yang dihapus tidak dapat dikembalikan!",
                                                    icon: "warning",
                                                    showCancelButton: true,
                                                    confirmButtonColor: "#3085d6",
                                                    cancelButtonColor: "#d33",
                                                    confirmButtonText: "Ya, hapus!"
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = 'aksi/aksi_izin.php?aksi=hapus&id_izin=<?= $row['id_izin'] ?>';
                                                    }
                                                });
                                            });
                                        </script>
                                    </td>
                                </tr>

                                <!--MODAL EDIT IZIN-->
                                <div class="modal fade" id="edit<?= $row['id_izin'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Edit Data</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="aksi/aksi_izin.php" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="aksi" value="edit">
                                                    <input type="hidden" name="id_izin" value="<?= $row['id_izin'] ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Siswa</label>
                                                        <select name="id_siswa" class="form-select">
                                                            <?php
                                                            // QUERY AMBIL DATA SISWA
                                                            $query_s = "SELECT id_siswa, nama_siswa FROM siswa";
                                                            $result_s = mysqli_query($koneksi, $query_s);
                                                            while ($row_s = mysqli_fetch_array($result_s)) :
                                                            ?>
                                                                <option value="<?= $row_s['id_siswa'] ?>" <?= ($row['id_siswa'] == $row_s['id_siswa']) ? 'selected' : '' ?>><?= $row_s['nama_siswa'] ?></option>
                                                            <?php endwhile ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Jenis Izin</label>
                                                        <select name="id_jenis" class="form-select">
                                                            <?php
                                                            // QUERY AMBIL DATA JENIS IJIN
                                                            $query_j = "SELECT id_jenis, nama_jenis FROM jenis_izin";
                                                            $result_j = mysqli_query($koneksi, $query_j);
                                                            while ($row_j = mysqli_fetch_array($result_j)) :
                                                            ?>
                                                                <option value="<?= $row_j['id_jenis'] ?>" <?= ($row['id_jenis'] == $row_j['id_jenis']) ? 'selected' : '' ?>><?= $row_j['nama_jenis'] ?></option>
                                                            <?php endwhile ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal</label>
                                                        <input type="date" class="form-control" name="tanggal" required value="<?= $row['tanggal'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Waktu Mulai</label>
                                                        <input type="time" class="form-control" name="waktu_mulai" required value="<?= $row['waktu_mulai'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Waktu Selesai</label>
                                                        <input type="time" class="form-control" name="waktu_selesai" required value="<?= $row['waktu_selesai'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alasan</label>
                                                        <textarea class="form-control" rows="3" name="alasan"><?= $row['alasan'] ?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">File Surat</label>
                                                        <input type="file" class="form-control" name="file_surat">
                                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah file</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select">
                                                            <option value="menunggu" <?= ($row['status'] == 'menunggu') ? 'selected' : '' ?>>Menunggu</option>
                                                            <option value="disetujui" <?= ($row['status'] == 'disetujui') ? 'selected' : '' ?>>Disetujui</option>
                                                            <option value="ditolak" <?= ($row['status'] == 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            endwhile;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!--MODAL TAMBAH DATA IZIN-->
<div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Tambah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="aksi/aksi_izin.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="aksi" value="tambah">
                    <!--INPUT NAMA SISWA-->
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <select name="id_siswa" class="form-select">
                            <?php
                            include("koneksi.php");
                            $query = "SELECT id_siswa, nama_siswa FROM siswa";
                            $result = mysqli_query($koneksi, $query);
                            while ($row = mysqli_fetch_array($result)) :
                            ?>
                                <option value="<?= $row['id_siswa'] ?>"><?= $row['nama_siswa'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <!--INPUT JENIS IJIN-->
                    <div class="mb-3">
                        <label class="form-label">Jenis Izin</label>
                        <select name="id_jenis" class="form-select">
                            <?php
                            $query = "SELECT id_jenis, nama_jenis FROM jenis_izin";
                            $result = mysqli_query($koneksi, $query);
                            while ($r = mysqli_fetch_array($result)) :
                            ?>
                                <option value="<?= $r['id_jenis'] ?>"><?= $r['nama_jenis'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <!--INPUT TANGGAL-->
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" required>
                    </div>
                    <!--INPUT WAKTU MULAI-->
                    <div class="mb-3">
                        <label class="form-label">Waktu Mulai</label>
                        <input type="time" class="form-control" name="waktu_mulai" required>
                    </div>
                    <!--INPUT WAKTU SELESAI-->
                    <div class="mb-3">
                        <label class="form-label">Waktu Selesai</label>
                        <input type="time" class="form-control" name="waktu_selesai" required>
                    </div>
                    <!--INPUT ALASAN-->
                    <div class="mb-3">
                        <label class="form-label">Alasan</label>
                        <textarea class="form-control" rows="3" name="alasan"></textarea>
                    </div>
                    <!--INPUT FILE SURAT-->
                    <div class="mb-3">
                        <label class="form-label">File Surat</label>
                        <input type="file" class="form-control" name="foto" required>
                    </div>
                    <!--INPUT STATUS-->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="menunggu" selected>Menunggu</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
