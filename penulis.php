<?php
include 'db.php';

// Tambah penulis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_penulis = $_POST['nama_penulis'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO penulis_resep (nama_penulis, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama_penulis, $email);
    $stmt->execute();
    header("Location: penulis.php");
    exit;
}

// Ambil semua penulis
$result = $conn->query("SELECT * FROM penulis_resep");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Penulis Resep</title>
</head>
<head>
    <meta charset="UTF-8">
    <title>Menu Resep Masakan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Kelola Penulis Resep</h1>
    <form method="POST">
        <label>Nama Penulis:</label>
        <input type="text" name="nama_penulis" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <button type="submit">Tambah</button>
    </form>
    <h2>Daftar Penulis</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
        <li><?= $row['nama_penulis'] ?> (<?= $row['email'] ?>)</li>
        <?php endwhile; ?>
    </ul>
    <a href="index.php">Kembali ke Menu</a>
</body>
</html>
