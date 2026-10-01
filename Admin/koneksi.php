<?php
// KONFIGURASI DATABASE
$host = "localhost";
$username = "root";
$password = "";
$database = "perizinan_siswa";

// MEMBUAT KONEKSI KE DATABASE
$koneksi = new mysqli($host, $username, $password, $database);

// CEK STATUS KONEKSI
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>