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

// Batalkan pembayaran
$query = "UPDATE orders SET status = 'Cancelled' WHERE id = $order_id";
mysqli_query($conn, $query);
header('Location: admin_payments.php');
exit;
?>
