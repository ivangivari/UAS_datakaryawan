<?php
session_start(); // Memulai session

// Memeriksa apakah pengguna telah login
if (!isset($_SESSION["username"])) {
    // Jika pengguna belum login, redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Menghubungkan ke database
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "root"; // Ganti dengan username database Anda
$password = "password"; // Ganti dengan password database Anda
$dbname = "datakaryawan"; // Ganti dengan nama database Anda

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi untuk menambahkan karyawan
function tambahKaryawan($conn, $nama, $posisi, $gaji)
{
    $sql = "INSERT INTO karyawan (nama, posisi, gaji) VALUES ('$nama', '$posisi', '$gaji')";

    if (mysqli_query($conn, $sql)) {
        echo "Karyawan berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Fungsi untuk menghapus karyawan
function hapusKaryawan($conn, $id)
{
    $sql = "DELETE FROM karyawan WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "Karyawan berhasil dihapus.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Memproses form ketika data karyawan disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $posisi = $_POST["posisi"];
    $gaji = $_POST["gaji"];

    tambahKaryawan($conn, $nama, $posisi, $gaji);
}

// Memproses permintaan hapus karyawan
if (isset($_GET["hapus"])) {
    $id = $_GET["hapus"];
    hapusKaryawan($conn, $id);
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
        <li><a href="tambah_karyawan.php">Tambah Karyawan</a></li>
    </ul>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h3>Form Tambah Karyawan</h3>
        <label for="nama">Nama:</label>
        <input type="text" name="nama" required><br>

        <label for="posisi">Posisi:</label>
        <input type="text" name="posisi" required><br>

        <label for="gaji">Gaji:</label>
        <input type="number" name="gaji" required><br>

        <input type="submit" value="Tambah Karyawan">
    </form>

    <h3>Daftar Karyawan</h3>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Posisi</th>
                <th>Gaji</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mengambil data karyawan dari database
            $sql = "SELECT * FROM karyawan";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["nama"] . "</td>";
                    echo "<td>" . $row["posisi"] . "</td>";
                    echo "<td>" . $row["gaji"] . "</td>";
                    echo "<td><a href='tambah_karyawan.php?hapus=" . $row["id"] . "'>Hapus</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada karyawan</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>

    <a href="logout.php">Logout</a>
</body>
</html>
