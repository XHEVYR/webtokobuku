<?php
session_start();
include('config.php'); // file untuk konfigurasi database

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Tambahkan item ke keranjang
if (isset($_GET['add_to_cart']) && isset($_GET['quantity'])) {
    $book_id = $_GET['add_to_cart'];
    $quantity = intval($_GET['quantity']);
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    if (isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id] += $quantity;
    } else {
        $_SESSION['cart'][$book_id] = $quantity;
    }
    $message = "Buku telah dimasukkan di keranjang";
}

// Hapus item dari keranjang
if (isset($_GET['remove_from_cart'])) {
    $book_id = $_GET['remove_from_cart'];
    if (isset($_SESSION['cart'][$book_id])) {
        unset($_SESSION['cart'][$book_id]);
    }
}

// Ambil detail buku dari keranjang
$cart_books = array();
if (!empty($_SESSION['cart'])) {
    $cart_ids = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM books WHERE id IN ($cart_ids)";
    $result = mysqli_query($conn, $query);
    while ($book = mysqli_fetch_assoc($result)) {
        $book['quantity'] = $_SESSION['cart'][$book['id']];
        $cart_books[] = $book;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Keranjang</h1>
        <nav>
            <ul>
                <li><a href="index.php">Rekomendasi Buku</a></li>
                <li><a href="cart.php">Keranjang</a></li>
                <li><a href="payment.php">Pembayaran</a></li>
                <li><a href="history.php">Riwayat</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Keranjang Belanja</h2>
        <?php if (!empty($cart_books)): ?>
            <ul>
                <?php foreach ($cart_books as $book): ?>
                    <li>
                        <img src="<?php echo $book['image']; ?>" alt="<?php echo $book['title']; ?>">
                        <h3><?php echo $book['title']; ?></h3>
                        <p>Harga: Rp <?php echo $book['price']; ?></p>
                        <p>Jumlah: <?php echo $book['quantity']; ?></p>
                        <a href="cart.php?remove_from_cart=<?php echo $book['id']; ?>">Hapus</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="payment.php">Lanjutkan ke Pembayaran</a>
        <?php else: ?>
            <p>Keranjang anda kosong.</p>
        <?php endif; ?>
    </main>
    <script src="script.js"></script>
</body>
</html>
