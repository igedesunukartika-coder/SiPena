<?php
// INCLUDE KONEKSI DATABASE
include("../koneksi.php");

// AMBIL PARAMETER AKSI DARI POST ATAU GET
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

// PROSES TAMBAH DATA SISWA
if ($aksi == 'tambah') {
    // AMBIL DATA INPUT DARI FORM
    $id_user = $_POST['id_user'];
    $nis = $_POST['nis'];
    $nama_siswa = $_POST['nama_siswa'];
    $id_kelas = $_POST['id_kelas'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    // VALIDASI DAN FORMAT NOMOR HP
    $no_hp = preg_replace('/[^0-9]/', '', $no_hp);
    $no_hp = substr($no_hp, 0, 15);

    if (empty($id_user) || empty($nis) || empty($nama_siswa) || empty($id_kelas)) {
        header("Location: ../index.php?menu=siswa&pesan=gagal");
        exit();
    }

    // VALIDASI JENIS KELAMIN
    if ($jenis_kelamin != 'L' && $jenis_kelamin != 'P') {
        header("Location: ../index.php?menu=siswa&pesan=gagal");
        exit();
    }

    // QUERY INSERT DATA KE DATABASE
    $query = "INSERT INTO siswa (id_user, nis, nama_siswa, id_kelas, tgl_lahir, jenis_kelamin, alamat, no_hp) 
              VALUES ('$id_user', '$nis', '$nama_siswa', '$id_kelas', '$tgl_lahir', '$jenis_kelamin', '$alamat', '$no_hp')";
    
    try {
        $result = mysqli_query($koneksi, $query);
    } catch (mysqli_sql_exception $e) {
        $result = false;
    }
    
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=siswa&pesan=berhasil");
        exit();
    } else {
        header("Location: ../index.php?menu=siswa&pesan=gagal");
        exit();
    }
}

// PROSES EDIT DATA SISWA
elseif ($aksi == 'edit') {
    // AMBIL DATA INPUT DARI FORM
    $id_siswa = $_POST['id_siswa'];
    $id_user = $_POST['id_user'];
    $nis = $_POST['nis'];
    $nama_siswa = $_POST['nama_siswa'];
    $id_kelas = $_POST['id_kelas'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    // VALIDASI DAN FORMAT NOMOR HP
    $no_hp = preg_replace('/[^0-9]/', '', $no_hp);
    $no_hp = substr($no_hp, 0, 15);

    // VALIDASI JENIS KELAMIN
    if ($jenis_kelamin != 'L' && $jenis_kelamin != 'P') {
        header("Location: ../index.php?menu=siswa&pesan=gagal");
        exit();
    }

    // QUERY UPDATE DATA KE DATABASE
    $query = "UPDATE siswa SET 
              id_user='$id_user', 
              nis='$nis', 
              nama_siswa='$nama_siswa', 
              id_kelas='$id_kelas', 
              tgl_lahir='$tgl_lahir', 
              jenis_kelamin='$jenis_kelamin', 
              alamat='$alamat', 
              no_hp='$no_hp' 
              WHERE id_siswa='$id_siswa'";
    
    $result = mysqli_query($koneksi, $query);
    
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=siswa&pesan=edit");
        exit();
    } else {
        header("Location: ../index.php?menu=siswa&pesan=gagal");
        exit();
    }
}

// PROSES DELETE DATA SISWA
elseif ($aksi == 'delete') {
    // AMBIL ID SISWA DARI URL
    $id_siswa = $_GET['id_siswa'];
    
    // QUERY DELETE DATA DARI DATABASE
    $query = "DELETE FROM siswa WHERE id_siswa='$id_siswa'";
    $result = mysqli_query($koneksi, $query);
    
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=siswa&pesan=hapus");
        exit();
    } else {
        header("Location: ../index.php?menu=siswa&pesan=gagal");
        exit();
    }
}

// REDIRECT JIKA AKSI TIDAK VALID
else {
    header("Location: ../index.php?menu=siswa");
    exit();
}
?>
