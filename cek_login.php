<?php
// INCLUDE KONEKSI DATABASE DAN MULAI SESSION
include ("koneksi.php");
session_start();

// AMBIL DATA INPUT USERNAME DAN PASSWORD DARI FORM
$username = $_POST['username'];
$password = $_POST['password'];

// QUERY CEK DATA USER DI DATABASE
$query = "SELECT * FROM users WHERE username=? AND password=?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "ss", $username, $password);
mysqli_stmt_execute($stmt);
$sql = mysqli_stmt_get_result($stmt);

// HITUNG JUMLAH DATA YANG COCOK
$row = mysqli_num_rows($sql);

// VALIDASI HASIL QUERY
if ($row > 0) {
    // AMBIL DATA USER DAN SIMPAN KE SESSION
    $r = mysqli_fetch_assoc($sql);
    $_SESSION['username'] = $r['username'];
    $_SESSION['role'] = $r['role'];
    $_SESSION['nama_lengkap'] = $r['nama_lengkap'];
    $_SESSION['id_user'] = $r['id_user'];
    $q2 = mysqli_prepare($koneksi, "SELECT id_siswa, id_kelas FROM siswa WHERE id_user = ? LIMIT 1");
    if ($q2) {
        mysqli_stmt_bind_param($q2, "i", $r['id_user']);
        mysqli_stmt_execute($q2);
        $res2 = mysqli_stmt_get_result($q2);
        if ($rowS = mysqli_fetch_assoc($res2)) {
            $_SESSION['id_siswa'] = $rowS['id_siswa'];
            $_SESSION['id_kelas'] = $rowS['id_kelas'];
        }
    }

    // REDIRECT BERDASARKAN ROLE USER
    if ($r['role'] == 'admin' || $r['role'] == 'guru') {
        header("Location: Admin/index.php");
    } else {
        header("Location: index.php");
    }
    exit();
} else {
    // LOGIN GAGAL KARENA DATA TIDAK COCOK
    header("Location: login.php?pesan=gagal");
    exit();
}
?>