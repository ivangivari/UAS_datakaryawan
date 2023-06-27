<?php
session_start(); // Memulai session

// Menghapus semua data session
session_destroy();

// Redirect ke halaman login
header("Location: dashboard.php");
exit();
?>
