<?php
// Koneksi ke Database
$host = "localhost";
$username = "root";
$password = "";
$database = "datakaryawan";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Operasi Create (Membuat Data Baru)
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];

    $sql = "INSERT INTO karyawan (nama, alamat, telepon, email) VALUES ('$nama', '$alamat', '$telepon', '$email')";

    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil ditambahkan";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Operasi Update (Memperbarui Data)
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];

    $sql = "UPDATE karyawan SET nama='$nama', alamat='$alamat', telepon='$telepon', email='$email' WHERE id='$id'";

    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil diperbarui";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Operasi Delete (Menghapus Data)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM karyawan WHERE id='$id'";

    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Operasi Read (Membaca Data)
$sql = "SELECT * FROM karyawan";
$result = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Karyawan</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #333;
        }

        form {
            width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-top: 10px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Form Karyawan</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo isset($_POST['edit']) ? $_POST['id'] : ''; ?>">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo isset($_POST['edit']) ? $_POST['nama'] : ''; ?>" required>

        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" required><?php echo isset($_POST['edit']) ? $_POST['alamat'] : ''; ?></textarea>

        <label for="telepon">Telepon:</label>
        <input type="text" id="telepon" name="telepon" value="<?php echo isset($_POST['edit']) ? $_POST['telepon'] : ''; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($_POST['edit']) ? $_POST['email'] : ''; ?>" required>

        <?php if (isset($_POST['edit'])): ?>
            <button type="submit" name="update">Update</button>
        <?php else: ?>
            <button type="submit" name="simpan">Simpan</button>
        <?php endif; ?>
    </form>

    <h2>Data Karyawan</h2>
    <?php if (count($data) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['telepon']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="nama" value="<?php echo $row['nama']; ?>">
                                <input type="hidden" name="alamat" value="<?php echo $row['alamat']; ?>">
                                <input type="hidden" name="telepon" value="<?php echo $row['telepon']; ?>">
                                <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                                <button type="submit" name="edit">Edit</button>
                            </form>
                            <form method="get" action="">
                                <input type="hidden" name="delete" value="<?php echo $row['id']; ?>">
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data karyawan.</p>
    <?php endif; ?>
</body>
</html>
