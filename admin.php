<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
include('config.php'); // file untuk konfigurasi database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Toko Buku</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Selamat Datang Admin</h1>
        <nav>
            <ul>
                <li><a href="admin_books.php">Data Buku</a></li>
                <li><a href="admin_payments.php">Data Pembayaran</a></li>
                <li><a href="admin_customers.php">Data Pelanggan</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- Konten halaman admin akan ditampilkan di sini -->
    </main>
</body>
</html>
