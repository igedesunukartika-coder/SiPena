<?php
// INCLUDE KONEKSI DATABASE
include("../koneksi.php");
?>
<!--MAIN CONTENT AREA-->-->
<main class="app-main">
    <!--HEADER SECTION DENGAN JUDUL DAN BREADCRUMB-->-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Verifikasi Izin</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Verifikasi Izin</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <!--MAIN CONTENT DENGAN TABEL IZIN YANG SUDAH DIVERIFIKASI-->-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!--TABEL DATA IZIN DENGAN JOIN SISWA DAN JENIS IJIN-->-->
                    <table id="tabel-verifikasi" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID IZIN</th>
                                <th scope="col">NAMA SISWA</th>
                                <th scope="col">JENIS IZIN</th>
                                <th scope="col">TANGGAL</th>
                                <th scope="col">WAKTU</th>
                                <th scope="col">ALASAN</th>
                                <th scope="col">FILE</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">TGL DIBUAT</th>
                                <th scope="col">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // QUERY AMBIL DATA IZIN YANG SUDAH DISETUJUI ATAU DITOLAK
                            $query_verifikasi = "SELECT i.*, s.nama_siswa, ji.nama_jenis FROM izin i 
                            LEFT JOIN siswa s ON i.id_siswa = s.id_siswa 
                            LEFT JOIN jenis_izin ji ON i.id_jenis = ji.id_jenis
                            WHERE i.status IN ('disetujui', 'ditolak')
                            ORDER BY i.tgl_dibuat DESC";
                            $result = mysqli_query($koneksi, $query_verifikasi);
                            $count = mysqli_num_rows($result);
                            
                            if ($count > 0) {
                                // LOOP MENAMPILKAN SETIAP DATA IZIN YANG DIVERIFIKASI
                                while ($row = mysqli_fetch_array($result)) :
                            ?>
                                <tr>
                                    <th scope="row"><?= $row['id_izin'] ?></th>
                                    <td><?= $row['nama_siswa'] ?></td>
                                    <td><?= $row['nama_jenis'] ?></td>
                                    <td><?= $row['tanggal'] ?></td>
                                    <td><?= $row['waktu_mulai'] ?> - <?= $row['waktu_selesai'] ?></td>
                                    <td>
                                        <small class="text-muted"><?= substr($row['alasan'], 0, 50) ?>...</small>
                                    </td>
                                    <td>
                                        <!--TOMBOL LIHAT FILE JIKA ADA-->
                                        <?php if ($row['file_surat']) : ?>
                                            <a href="uploads/<?=$row['file_surat']?>"
                                            class="btn btn-info btn-sm" target="_blank">
                                                <i class="bi bi-file-earmark-text"></i> Lihat
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <!--BAGE STATUS DENGAN WARNA BERBEDA-->
                                        <?php if ($row['status'] == 'disetujui') : ?>
                                            <span class="badge bg-success">Disetujui</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger">Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $row['tgl_dibuat'] ?></td>
                                    <td>
                                        <!--TOMBOL INFO UNTUK MENANDAI IZIN SUDAH DIVERIFIKASI-->
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Izin ini sudah diverifikasi oleh admin">
                                            <i class="bi bi-info-circle"></i> Info
                                        </button>
                                    </td>
                                </tr>

                            <?php
                                endwhile;
                            } else {
                                // TAMPILKAN PESAN JIKA BELUM ADA IZIN YANG DIVERIFIKASI
                            ?>
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox" style="font-size: 2rem;"></i><br>
                                        Belum ada izin yang diverifikasi
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!--SCRIPT UNTUK INITIALIZATION POPOVER DAN DATATABLE-->-->
<script>
    <!--INISIALISASI POPOVER UNTUK TOOLTIP INFO-->-->
    document.addEventListener('DOMContentLoaded', function() {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    });
    
    <!--INISIALISASI DATATABLE DENGAN BUTTON EXPORT -->-->
    $(document).ready(function() {
        $('#tabel-verifikasi').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            },
            "layout": {
                "topStart": {
                    "buttons": ['copyHtml5', 'excelHtml5', 'pdfHtml5']
                }
            }
        });
    });
</script>
