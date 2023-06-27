<?php
$servername = "localhost";  // Ganti dengan nama server database Anda jika perlu
$username = "root";     // Ganti dengan username database Anda
$password = "";     // Ganti dengan password database Anda
$dbname = "datakaryawan";  // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

echo "Koneksi berhasil";

// Menutup koneksi
$conn->close();
?>
