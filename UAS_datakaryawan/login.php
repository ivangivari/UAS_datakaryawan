<?php
session_start(); // Mulai session (harus ada di awal file)

// Memeriksa apakah pengguna sudah submit form login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"]; // Ambil username dari form
    $password = $_POST["password"]; // Ambil password dari form

    // Lakukan validasi username dan password (misalnya dari database)
    if ($username === "admin" && $password === "admin") {
        // Login berhasil, simpan informasi pengguna ke dalam session
        $_SESSION["username"] = $username;
        
        // Redirect ke halaman dashboard atau halaman yang diinginkan
        header("Location: dashboard.php");
        exit();
    } else {
        // Login gagal, tampilkan pesan error
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo $error; ?>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label>Username:</label>
        <input type="text" name="username"><br>
        <label>Password:</label>
        <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
