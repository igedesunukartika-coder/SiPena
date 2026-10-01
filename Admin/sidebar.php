<!--SIDEBAR NAVIGATION-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--SIDEBAR BRAND/LOGO-->
    <div class="sidebar-brand">
        <a href="index.php?menu=beranda" class="brand-link">
            <img src="./assets/image/MrBeast-Logo.png" alt="SiPena Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">SiPena</span>
        </a>
    </div>

    <!--SIDEBAR WRAPPER DENGAN MENU NAVIGATION-->
    <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="Main navigation">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false" id="navigation">

                <!--MENU BERANDA-->
                <li class="nav-item">
                    <a href="index.php?menu=beranda" class="nav-link">
                        <i class="nav-icon bi bi-house-door"></i>
                        <p>Beranda</p>
                    </a>
                </li>

                <!--HEADER DATA MASTER-->
                <li class="nav-header">Data Master</li>

                <!--MENU DATA USER-->
                <li class="nav-item">
                    <a href="index.php?menu=user" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Data User</p>
                    </a>
                </li>

                <!--MENU DATA SISWA-->
                <li class="nav-item">
                    <a href="index.php?menu=siswa" class="nav-link">
                        <i class="nav-icon bi bi-person-badge"></i>
                        <p>Data Siswa</p>
                    </a>
                </li>

                <!--MENU DATA KELAS-->
                <li class="nav-item">
                    <a href="index.php?menu=kelas" class="nav-link">
                        <i class="nav-icon bi bi-door-open"></i>
                        <p>Data Kelas</p>
                    </a>
                </li>

                <!--MENU DATA JENIS IJIN-->
                <li class="nav-item">
                    <a href="index.php?menu=jenis_ijin" class="nav-link">
                        <i class="nav-icon bi bi-list-check"></i>
                        <p>Data Jenis Ijin</p>
                    </a>
                </li>

                <!--HEADER DATA IZIN-->
                <li class="nav-header">Data Izin</li>

                <!--MENU DATA IZIN SISWA-->
                <li class="nav-item">
                    <a href="index.php?menu=data_izin_siswa" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-text"></i>
                        <p>Data Izin Siswa</p>
                    </a>
                </li>

                <!--MENU VERIFIKASI IZIN-->
                <li class="nav-item">
                    <a href="index.php?menu=verifikasi_izin" class="nav-link">
                        <i class="nav-icon bi bi-clipboard-check"></i>
                        <p>Verifikasi Izin</p>
                    </a>
                </li>

                <!--HEADER AKUN-->
                <li class="nav-header">Akun</li>

                <!--MENU LOGOUT-->
                <li class="nav-item">
                    <a href="login.php?pesan=logout" class="nav-link text-danger">
                        <i class="nav-icon bi bi-box-arrow-left"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
