<?php
session_start();
include("../koneksi.php");
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php?pesan=belum_login");
    exit();
}
$id_siswa = $_SESSION['id_siswa'] ?? '';
if (empty($id_siswa)) {
    header("Location: ../index.php?pesan=gagal");
    exit();
}
$id_jenis = $_POST['id_jenis'] ?? '';
$tanggal = $_POST['tanggal'] ?? '';
$waktu_mulai = $_POST['waktu_mulai'] ?? '';
$waktu_selesai = $_POST['waktu_selesai'] ?? '';
$alasan = $_POST['alasan'] ?? '';
$status = 'menunggu';
if (empty($id_jenis) || empty($tanggal) || empty($alasan)) {
    header("Location: ../index.php?pesan=gagal");
    exit();
}
$file_surat = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $allowed = ['jpg','jpeg','png','pdf'];
    $filename = $_FILES['foto']['name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if (in_array($ext, $allowed)) {
        $new_name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        $upload_dir = '../Admin/uploads';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $upload_path = $upload_dir . '/' . $new_name;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_path)) {
            $file_surat = $new_name;
        }
    }
}
$query = "INSERT INTO izin (id_siswa, id_jenis, tanggal, waktu_mulai, waktu_selesai, alasan, file_surat, status) VALUES ('$id_siswa','$id_jenis','$tanggal','$waktu_mulai','$waktu_selesai','$alasan','$file_surat','$status')";
try {
    $result = mysqli_query($koneksi, $query);
} catch (mysqli_sql_exception $e) {
    $result = false;
}
if ($result) {
    header("Location: ../index.php?pesan=berhasil#izin");
    exit();
} else {
    header("Location: ../index.php?pesan=gagal#izin");
    exit();
}
