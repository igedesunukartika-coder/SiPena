<?php
// INCLUDE KONEKSI DATABASE
include("../koneksi.php");

// AMBIL PARAMETER AKSI DARI POST ATAU GET
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

// PROSES TAMBAH DATA IZIN
if ($aksi == 'tambah') {
    // AMBIL DATA INPUT DARI FORM
    $id_siswa = $_POST['id_siswa'];
    $id_jenis = $_POST['id_jenis'];
    $tanggal = $_POST['tanggal'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $alasan = $_POST['alasan'];
    $status = $_POST['status'];

    // INISIALISASI VARIABLE FILE
    $file_surat = '';
    // CEK DAN HANDLE UPLOAD FILE BUKTI
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg','jpeg','png','pdf'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $new_name = time() . '_' . $filename;
            $upload_path = '../uploads/' . $new_name;
            if (!is_dir('../uploads')) mkdir('../uploads', 0777, true);
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_path)) {
                $file_surat = $new_name;
            }
        }
    }

    // QUERY INSERT DATA KE DATABASE
    $query = "INSERT INTO izin (id_siswa, id_jenis, tanggal, waktu_mulai, waktu_selesai, alasan, file_surat, status)
              VALUES ('$id_siswa','$id_jenis','$tanggal','$waktu_mulai','$waktu_selesai','$alasan','$file_surat','$status')";
    $result = mysqli_query($koneksi, $query);

    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=data_izin_siswa&pesan=berhasil");
        exit();
    } else {
        header("Location: ../index.php?menu=data_izin_siswa&pesan=gagal");
        exit();
    }
}

// PROSES EDIT DATA IZIN
elseif ($aksi == 'edit') {
    // AMBIL DATA INPUT DARI FORM
    $id_izin = $_POST['id_izin'];
    $id_siswa = $_POST['id_siswa'];
    $id_jenis = $_POST['id_jenis'];
    $tanggal = $_POST['tanggal'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $alasan = $_POST['alasan'];
    $status = $_POST['status'];

    // INISIALISASI VARIABLE FILE
    $file_surat = '';
    // CEK DAN HANDLE UPLOAD FILE BARU JIKA ADA
    if (isset($_FILES['file_surat']) && $_FILES['file_surat']['error'] == 0) {
        $allowed = ['jpg','jpeg','png','pdf'];
        $filename = $_FILES['file_surat']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $new_name = time() . '_' . $filename;
            $upload_path = '../uploads/' . $new_name;
            if (!is_dir('../uploads')) mkdir('../uploads', 0777, true);
            if (move_uploaded_file($_FILES['file_surat']['tmp_name'], $upload_path)) {
                $file_surat = $new_name;
            }
        }
    }

    // QUERY UPDATE DENGAN FILE BARU
    if (!empty($file_surat)) {
        $query = "UPDATE izin SET id_siswa='$id_siswa', id_jenis='$id_jenis', tanggal='$tanggal',
                  waktu_mulai='$waktu_mulai', waktu_selesai='$waktu_selesai', alasan='$alasan',
                  file_surat='$file_surat', status='$status' WHERE id_izin='$id_izin'";
    }
    // QUERY UPDATE TANPA GANTI FILE
    else {
        $query = "UPDATE izin SET id_siswa='$id_siswa', id_jenis='$id_jenis', tanggal='$tanggal',
                  waktu_mulai='$waktu_mulai', waktu_selesai='$waktu_selesai', alasan='$alasan',
                  status='$status' WHERE id_izin='$id_izin'";
    }

    $result = mysqli_query($koneksi, $query);

    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=data_izin_siswa&pesan=edit");
        exit();
    } else {
        header("Location: ../index.php?menu=data_izin_siswa&pesan=gagal");
        exit();
    }
}

// PROSES DELETE DATA IZIN
elseif ($aksi == 'delete' || $aksi == 'hapus') {
    // AMBIL ID IZIN DARI URL
    $id_izin = $_GET['id_izin'] ?? $_POST['id_izin'] ?? '';
    // HAPUS FILE SURAT JIKA ADA
    $q = mysqli_query($koneksi, "SELECT file_surat FROM izin WHERE id_izin='$id_izin'");
    if ($q) {
        $d = mysqli_fetch_assoc($q);
        if (!empty($d['file_surat'])) {
            @unlink("../uploads/" . $d['file_surat']);
        }
    }
    // QUERY DELETE DATA DARI DATABASE
    $query = "DELETE FROM izin WHERE id_izin='$id_izin'";
    $result = mysqli_query($koneksi, $query);
    // CEK HASIL QUERY
    if ($result) {
        header("Location: ../index.php?menu=data_izin_siswa&pesan=hapus");
        exit();
    } else {
        header("Location: ../index.php?menu=data_izin_siswa&pesan=gagal");
        exit();
    }
}

// REDIRECT JIKA AKSI TIDAK VALID
else {
    header("Location: ../index.php?menu=data_izin_siswa");
    exit();
}
?>
