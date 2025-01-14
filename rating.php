<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db.php';

// Ambil ID resep
$resep_id = $_GET['resep_id'] ?? null;
if ($resep_id === null) {
    echo "ID Resep tidak ditemukan.";
    exit;
}

// Ambil data resep
$result_resep = $conn->query("SELECT * FROM data_resep WHERE id = $resep_id");
$resep = $result_resep->fetch_assoc();

// Tambah rating
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];
    $pelanggan_id = $_POST['pelanggan_id'];

    $stmt = $conn->prepare("INSERT INTO rating_resep (rating, komentar, resep_id, pelanggan_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isii", $rating, $komentar, $resep_id, $pelanggan_id);
    $stmt->execute();
    header("Location: rating.php?resep_id=$resep_id");
    exit;
}

// Ambil semua pelanggan untuk dropdown
$result_pelanggan = $conn->query("SELECT * FROM pelanggan");

// Ambil semua rating untuk resep ini
$result_rating = $conn->query("SELECT rating_resep.rating, rating_resep.komentar, pelanggan.nama_pelanggan 
                               FROM rating_resep 
                               JOIN pelanggan ON rating_resep.pelanggan_id = pelanggan.id 
                               WHERE rating_resep.resep_id = $resep_id");

$result_daftar_resep = $conn->query("SELECT id, nama_resep FROM data_resep");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rating untuk Resep: <?= $resep['nama_resep'] ?></title>
</head>
<head>
    <meta charset="UTF-8">
    <title>Menu Resep Masakan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Pilih Resep Lain:</h3>
    <form action="rating.php" method="GET">
        <select name="resep_id" onchange="this.form.submit()">
            <option value="">-- Pilih Resep --</option>
            <?php
            // Menampilkan daftar resep dalam dropdown
            while ($row = $result_daftar_resep->fetch_assoc()) {
                $selected = ($row['id'] == $resep_id) ? 'selected' : '';
                echo "<option value='" . $row['id'] . "' $selected>" . htmlspecialchars($row['nama_resep']) . "</option>";
            }
            ?>
        </select>
    </form>
    <h2>Rating untuk Resep: <?= $resep['nama_resep'] ?></h1>
    <form method="POST">
        <label>Rating (1-5):</label>
        <input type="number" name="rating" min="1" max="5" required><br>
        <label>Komentar:</label>
        <textarea name="komentar" required></textarea><br>
        <label>Pelanggan:</label>
        <select name="pelanggan_id" required>
            <?php while ($row = $result_pelanggan->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['nama_pelanggan'] ?></option>
            <?php endwhile; ?>
        </select><br>
        <button type="submit">Tambah Rating</button>
    </form>
    <h3>Daftar Rating</h2>
    <ul>
        <?php while ($row = $result_rating->fetch_assoc()): ?>
        <li>
            Rating: <?= $row['rating'] ?>/5<br>
            Komentar: <?= $row['komentar'] ?><br>
            Oleh: <?= $row['nama_pelanggan'] ?>
        </li>
        <?php endwhile; ?>
    </ul>
    <a href="resep.php">Kembali ke Resep</a>
</body>
</html>
