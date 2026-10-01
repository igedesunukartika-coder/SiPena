<?php
// INCLUDE KONEKSI DATABASE
include("../koneksi.php");

// AMBIL PARAMETER AKSI DARI POST ATAU GET
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

// PROSES TAMBAH DATA JENIS IJIN
if ($aksi == 'tambah') {
    // AMBIL DATA INPUT DARI FORM
    $nama_jenis = $_POST['nama_jenis'];
    $deskripsi = $_POST['deskripsi'];

    // QUERY INSERT DATA KE DATABASE
    $query = "INSERT INTO jenis_izin (nama_jenis, deskripsi) 
              VALUES ('$nama_jenis', '$deskripsi')";
    
    $result = mysqli_query($koneksi, $query);
    
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=jenis_ijin&pesan=berhasil");
        exit();
    } else {
        header("Location: ../index.php?menu=jenis_ijin&pesan=gagal");
        exit();
    }
}

// PROSES EDIT DATA JENIS IJIN
elseif ($aksi == 'edit') {
    // AMBIL DATA INPUT DARI FORM
    $id_jenis = $_POST['id_jenis'];
    $nama_jenis = $_POST['nama_jenis'];
    $deskripsi = $_POST['deskripsi'];

    // QUERY UPDATE DATA KE DATABASE
    $query = "UPDATE jenis_izin SET 
              nama_jenis='$nama_jenis', 
              deskripsi='$deskripsi' 
              WHERE id_jenis='$id_jenis'";
    
    $result = mysqli_query($koneksi, $query);
    
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=jenis_ijin&pesan=edit");
        exit();
    } else {
        header("Location: ../index.php?menu=jenis_ijin&pesan=gagal");
        exit();
    }
}

// PROSES DELETE DATA JENIS IJIN
elseif ($aksi == 'delete') {
    // AMBIL ID JENIS DARI URL
    $id_jenis = $_GET['id_jenis'];
    
    // QUERY DELETE DATA DARI DATABASE
    $query = "DELETE FROM jenis_izin WHERE id_jenis='$id_jenis'";
    $result = mysqli_query($koneksi, $query);
    
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=jenis_ijin&pesan=hapus");
        exit();
    } else {
        header("Location: ../index.php?menu=jenis_ijin&pesan=gagal");
        exit();
    }
}

// REDIRECT JIKA AKSI TIDAK VALID
else {
    header("Location: ../index.php?menu=jenis_ijin");
    exit();
}
?>
