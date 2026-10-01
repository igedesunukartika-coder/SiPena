<?php
// CEK PARAMETER MENU DARI URL
if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];
    // SWITCH CASE UNTUK MENAMPILKAN HALAMAN SESUAI MENU
    switch ($menu) {
        case 'beranda':
            include "konten/beranda.php";
            break;

        case 'user':
            include "konten/Data_user.php";
            break;

        case 'siswa':
            include "konten/Data_siswa.php";
            break;

        case 'kelas':
            include "konten/Data_kelas.php";
            break;

        case 'jenis_ijin':
            include "konten/Data_jenis_ijin.php";
            break;

        case 'data_izin_siswa':
            include "konten/data_izin_siswa.php";
            break;

        case 'verifikasi_izin':
            include "konten/Verifikasi_izin.php";
            break;
    }
} else {
    // DEFAULT HALAMAN BERANDA
    include "konten/beranda.php";
}
?>
