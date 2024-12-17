<?php
// Konfigurasi koneksi database
$host = "localhost";      // Nama host (umumnya localhost)
$username = "root";       // Username MySQL (umumnya root untuk local server)
$password = "";           // Password MySQL (kosong untuk local server)
$database = "db_perkantoran"; // Nama database yang baru dibuat

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Mengecek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>