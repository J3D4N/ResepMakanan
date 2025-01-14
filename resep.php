<?php
include 'db.php';

// Ambil semua resep
$result = $conn->query("SELECT data_resep.id, data_resep.nama_resep, kategori_resep.nama_kategori 
                        FROM data_resep 
                        JOIN kategori_resep ON data_resep.kategori_id = kategori_resep.id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Resep</title>
</head>
<head>
    <meta charset="UTF-8">
    <title>Menu Resep Masakan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Kelola Resep</h1>
    <a href="tambah_resep.php">Tambah Resep</a>
    <h2>Daftar Resep</h2>
    <table border="1">
        <tr>
            <th>Nama Resep</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['nama_resep'] ?></td>
            <td><?= $row['nama_kategori'] ?></td>
            <td>
                <a href="edit_resep.php?id=<?= $row['id'] ?>">Edit</a>
                <a href="delete_resep.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus resep ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="index.php">Kembali ke Menu</a>
</body>
</html>
