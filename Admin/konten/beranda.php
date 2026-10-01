<!--MAIN CONTENT AREA-->
<main class="app-main">
  <!--HEADER SECTION DENGAN TITLE DAN BREADCRUMB-->
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1 class="mb-0 fs-3">Beranda</h1>
        </div>
        <div class="col-sm-6">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <!--MAIN CONTENT-->
  <div class="app-content">
    <div class="container-fluid">
      <!--ROW PERTAMA: STATISTIK IZIN-->
      <div class="row">
        <?php
        // INCLUDE KONEKSI DATABASE
        include("koneksi.php");
        
        // QUERY TOTAL PENGAJUAN IZIN
        $query_total = "SELECT COUNT(*) as total FROM izin";
        $result_total = mysqli_query($koneksi, $query_total);
        $row_total = mysqli_fetch_assoc($result_total);
        $total_izin = $row_total['total'];
        
        // QUERY IZIN STATUS MENUNGGU
        $query_menunggu = "SELECT COUNT(*) as menunggu FROM izin WHERE status='menunggu'";
        $result_menunggu = mysqli_query($koneksi, $query_menunggu);
        $row_menunggu = mysqli_fetch_assoc($result_menunggu);
        $menunggu = $row_menunggu['menunggu'];
        
        // QUERY IZIN STATUS DISETUJUI
        $query_disetujui = "SELECT COUNT(*) as disetujui FROM izin WHERE status='disetujui'";
        $result_disetujui = mysqli_query($koneksi, $query_disetujui);
        $row_disetujui = mysqli_fetch_assoc($result_disetujui);
        $disetujui = $row_disetujui['disetujui'];
        
        // QUERY IZIN STATUS DITOLAK
        $query_ditolak = "SELECT COUNT(*) as ditolak FROM izin WHERE status='ditolak'";
        $result_ditolak = mysqli_query($koneksi, $query_ditolak);
        $row_ditolak = mysqli_fetch_assoc($result_ditolak);
        $ditolak = $row_ditolak['ditolak'];
        ?>
        
        <!--CARD TOTAL IZIN-->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-primary">
            <div class="inner">
              <h3><?= $total_izin ?></h3>
              <p>Total Pengajuan</p>
            </div>
            <svg
              class="small-box-icon"
              fill="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
              ></path>
            </svg>
          </div>
        </div>

        <!--CARD IZIN MENUNGGU-->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-warning">
            <div class="inner">
              <h3><?= $menunggu ?></h3>
              <p>Menunggu Verifikasi</p>
            </div>
            <svg
              class="small-box-icon"
              fill="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"
              ></path>
            </svg>
          </div>
        </div>

        <!--CARD IZIN DISETUJUI-->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-success">
            <div class="inner">
              <h3><?= $disetujui ?></h3>
              <p>Disetujui</p>
            </div>
            <svg
              class="small-box-icon"
              fill="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"
              ></path>
            </svg>
          </div>
        </div>

        <!--CARD IZIN DITOLAK-->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-danger">
            <div class="inner">
              <h3><?= $ditolak ?></h3>
              <p>Ditolak</p>
            </div>
            <svg
              class="small-box-icon"
              fill="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"
              ></path>
            </svg>
          </div>
        </div>
      </div>

      <!--ROW KEDUA: STATISTIK MASTER DATA-->
      <div class="row mt-4">
        <?php
        // QUERY TOTAL SISWA
        $query_siswa = "SELECT COUNT(*) as total FROM siswa";
        $result_siswa = mysqli_query($koneksi, $query_siswa);
        $row_siswa = mysqli_fetch_assoc($result_siswa);
        $total_siswa = $row_siswa['total'];
        
        // QUERY TOTAL KELAS
        $query_kelas = "SELECT COUNT(*) as total FROM kelas";
        $result_kelas = mysqli_query($koneksi, $query_kelas);
        $row_kelas = mysqli_fetch_assoc($result_kelas);
        $total_kelas = $row_kelas['total'];
        
        // QUERY TOTAL GURU
        $query_guru = "SELECT COUNT(*) as total FROM users WHERE role='guru'";
        $result_guru = mysqli_query($koneksi, $query_guru);
        $row_guru = mysqli_fetch_assoc($result_guru);
        $total_guru = $row_guru['total'];
        
        // QUERY TOTAL ADMIN
        $query_admin = "SELECT COUNT(*) as total FROM users WHERE role='admin'";
        $result_admin = mysqli_query($koneksi, $query_admin);
        $row_admin = mysqli_fetch_assoc($result_admin);
        $total_admin = $row_admin['total'];
        ?>
        
        <!--CARD TOTAL SISWA-->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-info">
            <div class="inner">
              <h3><?= $total_siswa ?></h3>
              <p>Total Siswa</p>
            </div>
            <svg
              class="small-box-icon"
              fill="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
              ></path>
            </svg>
          </div>
        </div>

        <!--CARD TOTAL KELAS-->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-secondary">
            <div class="inner">
              <h3><?= $total_kelas ?></h3>
              <p>Total Kelas</p>
            </div>
            <svg
              class="small-box-icon"
              fill="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82M12 3L1 9l11 6.18L23 9 12 3M5 8.18v4l7 3.82 7-3.82v-4L12 10l-7-1.82z"
              ></path>
            </svg>
          </div>
        </div>

        <!--CARD TOTAL GURU-->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-light">
            <div class="inner">
              <h3><?= $total_guru ?></h3>
              <p>Total Guru</p>
            </div>
            <svg
              class="small-box-icon"
              fill="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"
              ></path>
            </svg>
          </div>
        </div>

        <!--CARD TOTAL ADMIN-->
        <div class="col-lg-3 col-6">
          <div class="small-box text-bg-dark">
            <div class="inner">
              <h3><?= $total_admin ?></h3>
              <p>Total Admin</p>
            </div>
            <svg
              class="small-box-icon"
              fill="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"
              ></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>