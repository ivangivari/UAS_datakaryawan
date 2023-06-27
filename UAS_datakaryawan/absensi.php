<!DOCTYPE html>
<html>
<head>
    <title>Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: inline-block;
            width: 80px;
        }

        input[type="text"],
        input[type="date"],
        select {
            padding: 5px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .success-message {
            color: #4CAF50;
            margin-top: 10px;
        }

        .error-message {
            color: #f44336;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<?php
$host = "localhost";  // Ganti dengan host yang sesuai
$user = "root";  // Ganti dengan username yang sesuai
$password = "";  // Ganti dengan password yang sesuai
$database = "datakaryawan";  // Ganti dengan nama database yang sesuai

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi untuk membuat record baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];

    $sql = "INSERT INTO absensi (nama, tanggal, status) VALUES ('$nama', '$tanggal', '$status')";
    if (mysqli_query($conn, $sql)) {
        echo "<p class='success-message'>Data berhasil ditambahkan.</p>";
    } else {
        echo "<p class='error-message'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
    }
}

// Fungsi untuk menghapus record
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM absensi WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        echo "<p class='success-message'>Data berhasil dihapus.</p>";
    } else {
        echo "<p class='error-message'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
    }
}

// Fungsi untuk mengupdate record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];

    $sql = "UPDATE absensi SET nama='$nama', tanggal='$tanggal', status='$status' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        echo "<p class='success-message'>Data berhasil diperbarui.</p>";
    } else {
        echo "<p class='error-message'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
    }
}
?>

<h2>Form Absensi</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="nama">Nama:</label>
    <input type="text" name="nama" id="nama" required><br><br>

    <label for="tanggal">Tanggal:</label>
    <input type="date" name="tanggal" id="tanggal" required><br><br>

    <label for="status">Status:</label>
    <select name="status" id="status" required>
        <option value="Hadir">Hadir</option>
        <option value="Sakit">Sakit</option>
        <option value="Izin">Izin</option>
        <option value="Alpa">Alpa</option>
    </select><br><br>

    <input type="submit" value="Tambah Data">
</form>

<h2>Data Absensi</h2>
<?php
// Mengambil data absensi dari tabel
$query = "SELECT * FROM absensi";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nama</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>" . $row['tanggal'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>";
        echo "<a href=\"absensi.php?delete=" . $row['id'] . "\">Hapus</a>";
        echo " | ";
        echo "<a href=\"absensi.php?edit=" . $row['id'] . "\">Edit</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Tidak ada data absensi.</p>";
}

// Fungsi untuk mendapatkan data untuk form edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $sql = "SELECT * FROM absensi WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>

    <h2>Edit Data Absensi</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="<?php echo $row['nama']; ?>" required><br><br>

        <label for="tanggal">Tanggal:</label>
        <input type="date" name="tanggal" id="tanggal" value="<?php echo $row['tanggal']; ?>" required><br><br>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="Hadir" <?php if ($row['status'] === 'Hadir') echo 'selected'; ?>>Hadir</option>
            <option value="Sakit" <?php if ($row['status'] === 'Sakit') echo 'selected'; ?>>Sakit</option>
            <option value="Izin" <?php if ($row['status'] === 'Izin') echo 'selected'; ?>>Izin</option>
            <option value="Alpa" <?php if ($row['status'] === 'Alpa') echo 'selected'; ?>>Alpa</option>
        </select><br><br>

        <input type="submit" name="update" value="Perbarui Data">
    </form>

<?php
}

// Menutup koneksi
mysqli_close($conn);
?>
</body>
</html>
