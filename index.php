<?php
// MULAI SESSION DAN CEK LOGIN
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// CACHE CONTROL UNTUK PREVENT CACHING
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// INCLUDE KONEKSI DATABASE
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <!--META TAG DAN VIEWPORT-->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Siswa - Sistem Perizinan</title>

  <!--LINK CSS BOOTSTRAP DAN BOOTSTRAP ICONS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

  <!--STYLING DASHBOARD-->
  <style>
    :root {
        --primary-color: #2563eb;
        --secondary-color: #1e40af;
    }
    body {
        background-color: #f8fafc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .navbar {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .navbar-brand {
        font-weight: 700;
        font-size: 1.3rem;
    }
    .nav-link {
        color: rgba(255,255,255,0.9) !important;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .nav-link:hover {
        color: #fff !important;
    }
    .btn-logout {
        background-color: #ef4444;
        color: white;
        font-weight: 600;
    }
    .btn-logout:hover {
        background-color: #dc2626;
        color: white;
    }
  </style>
</head>
<body>
  <!--NAVBAR HEADER-->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
          <i class="bi bi-building"></i> SiPena
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="index.php">
              <i class="bi bi-house-door"></i> Beranda
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#izin">
              <i class="bi bi-file-earmark"></i> Pengajuan Izin
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#riwayat">
              <i class="bi bi-clock-history"></i> Riwayat
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-logout ms-2" href="logout.php">
              <i class="bi bi-box-arrow-right"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!--SECTION HEADER DENGAN WELCOME MESSAGE-->
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white;">
          <div class="card-body p-5">
            <h6 class="mb-2" style="opacity: 0.9;"><i class="bi bi-hand-thumbs-up"></i> Selamat Datang</h6>
            <h1 class="fw-bold mb-3"><?=$_SESSION['nama_lengkap'] ?></h1>
            <?php
            // QUERY AMBIL DATA KELAS DARI DATABASE
            $id = $_SESSION['id_kelas'] ?? null;
            if ($id) {
                $query_kelas = "SELECT * FROM kelas WHERE id_kelas = ?";
                $stmt = mysqli_prepare($koneksi, $query_kelas);
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $hasil = mysqli_stmt_get_result($stmt);
                $r = mysqli_fetch_array($hasil);
                $nama_kelas = $r['nama_kelas'] ?? 'Kelas Tidak Ditemukan';
            } else {
                $nama_kelas = 'Siswa';
            }
            ?>
            <p class="mb-0"><i class="bi bi-building"></i> SMK Pariwisata Triatma Jaya Badung</p>
            <p style="opacity: 0.9;"><i class="bi bi-book"></i> <?=$nama_kelas ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm text-center">
          <div class="card-body p-4">
            <div class="mb-3">
              <i class="bi bi-person-circle" style="font-size: 4rem; color: var(--primary-color);"></i>
            </div>
            <h5><?=$_SESSION['username'] ?></h5>
            <p class="text-muted mb-0"><i class="bi bi-shield-check"></i> <?=$_SESSION['role'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--SECTION INFO STATUS PENGAJUAN-->
  <?php
  $id_siswa_sess = $_SESSION['id_siswa'] ?? 0;
  $cnt_total = $cnt_menunggu = $cnt_disetujui = $cnt_ditolak = 0;
  if ($id_siswa_sess) {
      $qc = mysqli_query($koneksi, "SELECT status, COUNT(*) c FROM izin WHERE id_siswa='$id_siswa_sess' GROUP BY status");
      $total = 0;
      while ($rc = mysqli_fetch_assoc($qc)) { $total += $rc['c']; if ($rc['status']=='menunggu') $cnt_menunggu=$rc['c']; elseif ($rc['status']=='disetujui') $cnt_disetujui=$rc['c']; elseif ($rc['status']=='ditolak') $cnt_ditolak=$rc['c']; }
      $cnt_total = $total;
  }
  ?>
  <div class="container mt-5">
    <div class="row g-3">
      <!--CARD PENGAJUAN-->
      <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div style="width: 60px; height: 60px; background: #dbeafe; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-file-earmark-plus" style="font-size: 1.5rem; color: var(--primary-color);"></i>
              </div>
              <div class="ms-3">
                <h6 class="mb-1">Pengajuan</h6>
                <h4 class="mb-0 fw-bold"><?= $cnt_total ?></h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--CARD MENUNGGU-->
      <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div style="width: 60px; height: 60px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-clock" style="font-size: 1.5rem; color: #f59e0b;"></i>
              </div>
              <div class="ms-3">
                <h6 class="mb-1">Menunggu</h6>
                <h4 class="mb-0 fw-bold"><?= $cnt_menunggu ?></h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--CARD DITERIMA-->
      <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div style="width: 60px; height: 60px; background: #dcfce7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-check-circle" style="font-size: 1.5rem; color: #22c55e;"></i>
              </div>
              <div class="ms-3">
                <h6 class="mb-1">Diterima</h6>
                <h4 class="mb-0 fw-bold"><?= $cnt_disetujui ?></h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--CARD DITOLAK-->
      <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div style="width: 60px; height: 60px; background: #fee2e2; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-x-circle" style="font-size: 1.5rem; color: #ef4444;"></i>
              </div>
              <div class="ms-3">
                <h6 class="mb-1">Ditolak</h6>
                <h4 class="mb-0 fw-bold"><?= $cnt_ditolak ?></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--SECTION PENGAJUAN IZIN DAN RIWAYAT-->
  <div class="container mt-5 mb-5" id="izin">
    <div class="row g-4">
      <!--FORM PENGAJUAN IZIN BARU-->
      <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom p-4">
            <h5 class="mb-0 fw-bold">
              <i class="bi bi-plus-circle" style="color: var(--primary-color);"></i> Pengajuan Izin Baru
            </h5>
          </div>
          <div class="card-body p-4">
            <form action="aksi/aksi_izin.php" method="POST" enctype="multipart/form-data">
              <!--INPUT JENIS IZIN-->
              <div class="mb-3">
                <label for="id_jenis" class="form-label fw-500">Jenis Izin</label>
                <select class="form-select" id="id_jenis" name="id_jenis" required>
                  <option value="">-- Pilih Jenis Izin --</option>
                  <?php
                  $qj = mysqli_query($koneksi, "SELECT id_jenis, nama_jenis FROM jenis_izin");
                  while ($rj = mysqli_fetch_array($qj)) :
                  ?>
                  <option value="<?= $rj['id_jenis'] ?>"><?= $rj['nama_jenis'] ?></option>
                  <?php endwhile; ?>
                </select>
              </div>

              <!--INPUT TANGGAL-->
              <div class="mb-3">
                <label for="tanggal" class="form-label fw-500">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
              </div>

              <!--INPUT WAKTU MULAI-->
              <div class="mb-3">
                <label for="waktu_mulai" class="form-label fw-500">Waktu Mulai</label>
                <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai">
              </div>

              <!--INPUT WAKTU SELESAI-->
              <div class="mb-3">
                <label for="waktu_selesai" class="form-label fw-500">Waktu Selesai</label>
                <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai">
              </div>

              <!--INPUT KETERANGAN-->
              <div class="mb-3">
                <label for="alasan" class="form-label fw-500">Keterangan</label>
                <textarea class="form-control" id="alasan" name="alasan" rows="3" placeholder="Jelaskan alasan Anda..." required></textarea>
              </div>

              <!--INPUT FILE BUKTI (OPSIONAL)-->
              <div class="mb-3">
                <label for="foto" class="form-label fw-500">Bukti (Opsional)</label>
                <input type="file" class="form-control" id="foto" name="foto" accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">Format: PDF, JPG, PNG (Max 2MB)</small>
              </div>

              <!--TOMBOL SUBMIT-->
              <button type="submit" class="btn btn-primary w-100 fw-600">
                <i class="bi bi-send"></i> Kirim Pengajuan
              </button>
            </form>
          </div>
        </div>
      </div>

      <!--TABEL RIWAYAT PENGAJUAN-->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom p-4">
            <h5 class="mb-0 fw-bold">
              <i class="bi bi-list-check" style="color: var(--primary-color);"></i> Riwayat Pengajuan
            </h5>
          </div>
          <div class="card-body p-4" id="riwayat">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr class="border-bottom">
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $id_siswa_h = $_SESSION['id_siswa'] ?? 0;
                  $qh = mysqli_query($koneksi, "SELECT i.*, ji.nama_jenis FROM izin i LEFT JOIN jenis_izin ji ON i.id_jenis=ji.id_jenis WHERE i.id_siswa='$id_siswa_h' ORDER BY i.tgl_dibuat DESC, i.id_izin DESC");
                  if ($qh && mysqli_num_rows($qh) > 0) :
                      while ($rh = mysqli_fetch_assoc($qh)) :
                          $badge = $rh['status']=='disetujui' ? 'success' : ($rh['status']=='ditolak' ? 'danger' : 'warning');
                  ?>
                  <tr>
                    <td><?= htmlspecialchars($rh['tanggal']) ?></td>
                    <td><?= htmlspecialchars($rh['nama_jenis'] ?? '-') ?></td>
                    <td><span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($rh['status']) ?></span></td>
                    <td>
                      <?php if (!empty($rh['file_surat'])) : ?>
                      <a href="Admin/uploads/<?= htmlspecialchars($rh['file_surat']) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-text"></i> Lihat</a>
                      <?php else : ?>-<?php endif; ?>
                    </td>
                  </tr>
                  <?php endwhile; else : ?>
                  <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                      <i class="bi bi-inbox"></i> Belum ada pengajuan
                    </td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--LINK SCRIPT SWEETALERT2-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php if (isset($_GET['pesan']) && $_GET['pesan']=='berhasil') : ?>
  <script>Swal.fire({icon:'success',title:'Berhasil',text:'Pengajuan berhasil dikirim!'});</script>
  <?php elseif (isset($_GET['pesan']) && $_GET['pesan']=='gagal') : ?>
  <script>Swal.fire({icon:'error',title:'Gagal',text:'Pengajuan gagal. Cek data & coba lagi.'});</script>
  <?php endif; ?>

  <!--LINK SCRIPT BOOTSTRAP-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <!--STYLING HOVER CARD DAN FONT WEIGHT-->
  <style>
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important;
    }
    .fw-500 {
        font-weight: 500;
    }
    .fw-600 {
        font-weight: 600;
    }
  </style>
</body>
</html>