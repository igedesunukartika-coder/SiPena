<?php
// INCLUDE KONEKSI DATABASE
include("../koneksi.php");

// AMBIL PARAMETER AKSI DARI POST ATAU GET
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

// PROSES TAMBAH DATA USER
if ($aksi == 'tambah') {
    // AMBIL DATA INPUT DARI FORM
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $role = $_POST['role'];

    // QUERY INSERT DATA KE DATABASE
    $query = "INSERT INTO users (username, password, nama_lengkap, email, no_hp, role) 
              VALUES ('$username', '$password', '$nama_lengkap', '$email', '$no_hp', '$role')";
    
    $result = mysqli_query($koneksi, $query);

    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=user&pesan=berhasil");
        exit();
    } else {
        header("Location: ../index.php?menu=user&pesan=gagal");
        exit();
    }
}

// PROSES EDIT DATA USER
elseif ($aksi == 'edit') {
    // AMBIL DATA INPUT DARI FORM
    $id_user = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $role = $_POST['role'];

    // CEK APAKAH PASSWORD DIISI
    if (!empty($password)) {
        // UPDATE TERMASUK PASSWORD JIKA DIISI
        $query = "UPDATE users SET 
                  username='$username', 
                  password='$password', 
                  nama_lengkap='$nama_lengkap', 
                  email='$email', 
                  no_hp='$no_hp', 
                  role='$role' 
                  WHERE id_user='$id_user'";
    } else {
        // UPDATE TANPA PASSWORD JIKA TIDAK DIISI
        $query = "UPDATE users SET 
                  username='$username', 
                  nama_lengkap='$nama_lengkap', 
                  email='$email', 
                  no_hp='$no_hp', 
                  role='$role' 
                  WHERE id_user='$id_user'";
    }
    
    $result = mysqli_query($koneksi, $query);
    
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=user&pesan=edit");
        exit();
    } else {
        header("Location: ../index.php?menu=user&pesan=gagal");
        exit();
    }
}

// PROSES DELETE DATA USER
elseif ($aksi == 'delete') {
    // AMBIL ID USER DARI URL
    $id_user = $_GET['id_user'];
    // QUERY DELETE DATA DARI DATABASE
    $query = "DELETE FROM users WHERE id_user='$id_user'";
    $result = mysqli_query($koneksi, $query);
    
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=user&pesan=hapus");
        exit();
    } else {
        header("Location: ../index.php?menu=user&pesan=gagal");
        exit();
    }
}

// REDIRECT JIKA AKSI TIDAK VALID
else {
    header("Location: ../index.php?menu=user");
    exit();
}
?>
