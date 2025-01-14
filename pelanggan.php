<?php
include 'db.php';

// Tambah pelanggan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $email_pelanggan = $_POST['email_pelanggan'];

    $stmt = $conn->prepare("INSERT INTO pelanggan (nama_pelanggan, email_pelanggan) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama_pelanggan, $email_pelanggan);
    $stmt->execute();
    header("Location: pelanggan.php");
    exit;
}

// Ambil semua pelanggan
$result = $conn->query("SELECT * FROM pelanggan");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pelanggan</title>
</head>
<head>
    <meta charset="UTF-8">
    <title>Menu Resep Masakan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Kelola Pelanggan</h1>
    <form method="POST">
        <label>Nama Pelanggan:</label>
        <input type="text" name="nama_pelanggan" required><br>
        <label>Email Pelanggan:</label>
        <input type="email" name="email_pelanggan" required><br>
        <button type="submit">Tambah</button>
    </form>
    <h2>Daftar Pelanggan</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
        <li><?= $row['nama_pelanggan'] ?> (<?= $row['email_pelanggan'] ?>)</li>
        <?php endwhile; ?>
    </ul>
    <a href="index.php">Kembali ke Menu</a>
</body>
</html>
