<?php
include 'db.php';

// Ambil kategori untuk dropdown
$result = $conn->query("SELECT * FROM kategori_resep");

// Tambah resep
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_resep = $_POST['nama_resep'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];
    $kategori_id = $_POST['kategori_id'];

    $stmt = $conn->prepare("INSERT INTO data_resep (nama_resep, bahan, langkah, kategori_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nama_resep, $bahan, $langkah, $kategori_id);
    $stmt->execute();
    header("Location: resep.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Resep</title>
</head>
<head>
    <meta charset="UTF-8">
    <title>Menu Resep Masakan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Tambah Resep</h1>
    <form method="POST">
        <label>Nama Resep:</label>
        <input type="text" name="nama_resep" required><br>
        <label>Bahan:</label>
        <textarea name="bahan" required></textarea><br>
        <label>Langkah:</label>
        <textarea name="langkah" required></textarea><br>
        <label>Kategori:</label>
        <select name="kategori_id" required>
            <?php while ($row = $result->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['nama_kategori'] ?></option>
            <?php endwhile; ?>
        </select><br>
        <button type="submit">Simpan</button>
    </form>
    <a href="resep.php">Kembali</a>
</body>
</html>
