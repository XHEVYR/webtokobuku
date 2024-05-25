<?php
session_start();
include('config.php'); // file untuk konfigurasi database

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: admin_payments.php');
    exit;
}

$order_id = $_GET['id'];

// Kirim buku
$query = "UPDATE orders SET status = 'Shipped' WHERE id = $order_id";
mysqli_query($conn, $query);

// Update status pesanan menjadi "Terkirim" di halaman riwayat konsumen
$query_update_status = "UPDATE order_history SET status = 'Terkirim' WHERE order_id = $order_id";
mysqli_query($conn, $query_update_status);

header('Location: admin_payments.php');
exit;
?>
