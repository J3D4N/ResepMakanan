<?php
include 'db.php';

// Ambil data resep berdasarkan ID
$id = $_GET['id'];
$result_resep = $conn->query("SELECT * FROM data_resep WHERE id = $id");
$resep = $result_resep->fetch_assoc();

// Ambil kategori untuk dropdown
$result_kategori = $conn->query("SELECT * FROM kategori_resep");

// Update resep
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_resep = $_POST['nama_resep'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];
    $kategori_id = $_POST['kategori_id'];

    $stmt = $conn->prepare("UPDATE data_resep SET nama_resep = ?, bahan = ?, langkah = ?, kategori_id = ? WHERE id = ?");
    $stmt->bind_param("sssii", $nama_resep, $bahan, $langkah, $kategori_id, $id);
    $stmt->execute();

    header("Location: resep.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Resep</title>
</head>
<head>
    <meta charset="UTF-8">
    <title>Menu Resep Masakan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Resep</h1>
    <form method="POST">
        <label>Nama Resep:</label>
        <input type="text" name="nama_resep" value="<?= $resep['nama_resep'] ?>" required><br>
        <label>Bahan:</label>
        <textarea name="bahan" required><?= $resep['bahan'] ?></textarea><br>
        <label>Langkah:</label>
        <textarea name="langkah" required><?= $resep['langkah'] ?></textarea><br>
        <label>Kategori:</label>
        <select name="kategori_id" required>
            <?php while ($row = $result_kategori->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>" <?= $row['id'] == $resep['kategori_id'] ? 'selected' : '' ?>>
                <?= $row['nama_kategori'] ?>
            </option>
            <?php endwhile; ?>
        </select><br>
        <button type="submit">Simpan</button>
    </form>
    <a href="resep.php">Kembali</a>
</body>
</html>
