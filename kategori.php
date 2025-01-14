<?php
include 'db.php';

// Tambah kategori
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = $_POST['nama_kategori'];
    $stmt = $conn->prepare("INSERT INTO kategori_resep (nama_kategori) VALUES (?)");
    $stmt->bind_param("s", $nama_kategori);
    $stmt->execute();
    header("Location: kategori.php");
    exit;
}

// Ambil semua kategori
$result = $conn->query("SELECT * FROM kategori_resep");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Kategori</title>
</head>
<head>
    <meta charset="UTF-8">
    <title>Menu Resep Masakan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Kelola Kategori</h1>
    <form method="POST">
        <label>Nama Kategori:</label>
        <input type="text" name="nama_kategori" required>
        <button type="submit">Tambah</button>
    </form>
    <h2>Daftar Kategori</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
        <li><?= $row['nama_kategori'] ?></li>
        <?php endwhile; ?>
    </ul>
    <a href="index.php">Kembali ke Menu</a>
</body>
</html>
