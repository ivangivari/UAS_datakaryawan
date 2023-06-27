<?php
session_start(); // Memulai session

// Memeriksa apakah pengguna telah login
if (!isset($_SESSION["username"])) {
    // Jika pengguna belum login, redirect ke halaman login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu Data Karyawan</title>
</head>
<body>
    <h1>Selamat datang, <?php echo $_SESSION["username"]; ?></h1>

    <h2>Data Karyawan</h2>
    <ul>
        <li><a href="karyawan.php">Tambah Karyawan</a></li>

    </ul>

    <h2>Absensi Karyawan</h2>
    <ul>
        <li><a href="absensi.php">Tambah Absensi</a></li>
    </ul>

    <a href="logout.php">Logout</a>
</body>
</html>
