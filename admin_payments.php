<?php
session_start();
include('config.php'); // file untuk konfigurasi database

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// Ambil data pembayaran
$query = "SELECT orders.*, users.username FROM orders INNER JOIN users ON orders.user_id = users.id";
$result = mysqli_query($conn, $query);
$payments = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Pembayaran - Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <h1>Data Pembayaran</h1>
        <nav>
            <ul>
                <li><a href="admin_books.php">Data Buku</a></li>
                <li><a href="admin_payments.php">Data Pembayaran</a></li>
                <li><a href="admin_customers.php">Data Pelanggan</a></li>
                <li><a href="admin_logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Daftar Pembayaran</h2>
        <?php if (!empty($payments)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Harga</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td><?php echo $payment['id']; ?></td>
                            <td><?php echo $payment['username']; ?></td>
                            <td>Rp <?php echo $payment['total_price']; ?></td>
                            <td><?php echo $payment['address']; ?></td>
                            <td><?php echo $payment['status']; ?></td>
                            <td>
                                <?php if ($payment['status'] == 'Pending'): ?>
                                    <a href="admin_cancel_payment.php?id=<?php echo $payment['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin membatalkan pembayaran ini?')">Batalkan Pembayaran</a>
                                    <a href="admin_ship_books.php?id=<?php echo $payment['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin mengirimkan buku ini?')">Kirim</a>
                                <?php elseif ($payment['status'] == 'Paid'): ?>
                                    <a href="admin_ship_books.php?id=<?php echo $payment['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin mengirimkan buku ini?')">Kirim Buku</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada pembayaran yang tersedia.</p>
        <?php endif; ?>
    </main>
    <script src="script.js"></script>
</body>
</html>
