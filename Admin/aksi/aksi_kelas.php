<?php
// INCLUDE KONEKSI DATABASE
include("../koneksi.php");

// AMBIL PARAMETER AKSI DARI POST ATAU GET
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

// PROSES TAMBAH DATA KELAS
if ($aksi == 'tambah') {
    // AMBIL DATA INPUT DARI FORM
    $nama_kelas = $_POST['nama_kelas'];
    $jurusan = $_POST['jurusan'];
    $tingkat = $_POST['tingkat'];
    $wali_kelas = $_POST['wali_kelas'];

    // QUERY INSERT DATA KE DATABASE
    $query = "INSERT INTO kelas (nama_kelas, jurusan, tingkat, wali_kelas) 
              VALUES ('$nama_kelas', '$jurusan', '$tingkat', '$wali_kelas')";
    
    $result = mysqli_query($koneksi, $query);
    
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=kelas&pesan=berhasil");
        exit();
    } else {
        header("Location: ../index.php?menu=kelas&pesan=gagal");
        exit();
    }
}

// PROSES EDIT DATA KELAS
elseif ($aksi == 'edit') {
    // AMBIL DATA INPUT DARI FORM
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $jurusan = $_POST['jurusan'];
    $tingkat = $_POST['tingkat'];
    $wali_kelas = $_POST['wali_kelas'];

    // QUERY UPDATE DATA KE DATABASE
    $query = "UPDATE kelas SET 
              nama_kelas='$nama_kelas', 
              jurusan='$jurusan', 
              tingkat='$tingkat', 
              wali_kelas='$wali_kelas' 
              WHERE id_kelas='$id_kelas'";
    
    $result = mysqli_query($koneksi, $query);
    
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=kelas&pesan=edit");
        exit();
    } else {
        header("Location: ../index.php?menu=kelas&pesan=gagal");
        exit();
    }
}

// PROSES DELETE DATA KELAS
elseif ($aksi == 'delete') {
    // AMBIL ID KELAS DARI URL
    $id_kelas = $_GET['id_kelas'];
    
    // QUERY DELETE DATA DARI DATABASE
    $query = "DELETE FROM kelas WHERE id_kelas='$id_kelas'";
    $result = mysqli_query($koneksi, $query);
    
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=kelas&pesan=hapus");
        exit();
    } else {
        header("Location: ../index.php?menu=kelas&pesan=gagal");
        exit();
    }
}

// REDIRECT JIKA AKSI TIDAK VALID
else {
    header("Location: ../index.php?menu=kelas");
    exit();
}
?>
