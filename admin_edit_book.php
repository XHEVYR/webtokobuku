<?php
session_start();
include('config.php'); // file untuk konfigurasi database

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: admin_books.php');
    exit;
}

$book_id = $_GET['id'];

// Ambil data buku berdasarkan ID
$query = "SELECT * FROM books WHERE id = $book_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Buku tidak ditemukan.";
    exit;
}

$book = mysqli_fetch_assoc($result);

// Update buku
if (isset($_POST['update_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $query = "UPDATE books SET title = '$title', author = '$author', genre = '$genre', stock = '$stock', price = '$price', description = '$description', image = '$image' WHERE id = $book_id";
    mysqli_query($conn, $query);
    header('Location: admin_books.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku - Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Edit Buku</h1>
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
        <h2>Edit Buku</h2>
        <form method="POST">
            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" value="<?php echo $book['title']; ?>" required>
            <label for="author">Penulis:</label>
            <input type="text" id="author" name="author" value="<?php echo $book['author']; ?>" required>
            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" value="<?php echo $book['genre']; ?>" required>
            <label for="stock">Stok:</label>
            <input type="number" id="stock" name="stock" value="<?php echo $book['stock']; ?>" required>
            <label for="price">Harga:</label>
            <input type="number" id="price" name="price" value="<?php echo $book['price']; ?>" required>
            <label for="description">Deskripsi:</label>
            <textarea id="description" name="description" required><?php echo $book['description']; ?></textarea>
            <label for="image">URL Gambar:</label>
            <input type="text" id="image" name="image" value="<?php echo $book['image']; ?>" required>
            <button type="submit" name="update_book">Update Buku</button>
        </form>
    </main>
    <script src="script.js"></script>
</body>
</html>
