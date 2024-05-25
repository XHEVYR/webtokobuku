<?php
session_start();
include('config.php'); // file untuk konfigurasi database

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// Tambah buku baru
if (isset($_POST['add_book'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);

    $query = "INSERT INTO books (title, author, genre, stock, price, description, image) 
              VALUES ('$title', '$author', '$genre', '$stock', '$price', '$description', '$image')";
    mysqli_query($conn, $query);
    header('Location: admin_books.php');
    exit;
}

// Hapus buku
if (isset($_GET['delete_book'])) {
    $book_id = mysqli_real_escape_string($conn, $_GET['delete_book']);
    $query = "DELETE FROM books WHERE id = $book_id";
    mysqli_query($conn, $query);
    header('Location: admin_books.php');
    exit;
}

// Ambil data buku
$query = "SELECT * FROM books";
$result = mysqli_query($conn, $query);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Buku - Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Data Buku</h1>
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
        <h2>Tambah Buku Baru</h2>
        <form method="POST">
            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" required>
            <label for="author">Penerbit:</label>
            <input type="text" id="author" name="author" required>
            <label for="genre">Mata Pelajaran:</label>
            <input type="text" id="genre" name="genre" required>
            <label for="stock">Stok:</label>
            <input type="number" id="stock" name="stock" required>
            <label for="price">Harga:</label>
            <input type="number" id="price" name="price" required>
            <label for="description">Deskripsi:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="image">URL Gambar:</label>
            <input type="text" id="image" name="image" required>
            <button type="submit" name="add_book">Tambah Buku</button>
        </form>

        <h2>Daftar Buku</h2>
        <?php if (!empty($books)): ?>
            <ul>
                <?php foreach ($books as $book): ?>
                    <li>
                        <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" width="200">
                        <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                        <p>Penerbit: <?php echo htmlspecialchars($book['author']); ?></p>
                        <p>Mata Pelajaran: <?php echo htmlspecialchars($book['genre']); ?></p>
                        <p>Stok: <?php echo htmlspecialchars($book['stock']); ?></p>
                        <p>Harga: Rp <?php echo htmlspecialchars($book['price']); ?></p>
                        <p><?php echo htmlspecialchars($book['description']); ?></p>
                        <a href="admin_edit_book.php?id=<?php echo $book['id']; ?>" class="action-button">Edit</a>
                        <a href="admin_books.php?delete_book=<?php echo $book['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" class="action-button">Hapus</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Tidak ada buku yang tersedia.</p>
        <?php endif; ?>
    </main>
    <script src="script.js"></script>
</body>
</html>

