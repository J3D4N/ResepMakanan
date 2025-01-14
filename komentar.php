<?php
include 'db.php';

// Ambil resep ID
$resep_id = $_GET['resep_id'];

// Ambil data resep
$result_resep = $conn->query("SELECT * FROM data_resep WHERE id = $resep_id");
$resep = $result_resep->fetch_assoc();

// Tambah komentar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isi_komentar = $_POST['isi_komentar'];
    $penulis_id = $_POST['penulis_id'];

    $stmt = $conn->prepare("INSERT INTO komentar_resep (isi_komentar, resep_id, penulis_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $isi_komentar, $resep_id, $penulis_id);
    $stmt->execute();
    header("Location: komentar.php?resep_id=$resep_id");
    exit;
}

// Ambil komentar untuk resep ini
$result_komentar = $conn->query("SELECT komentar_resep.isi_komentar, penulis_resep.nama_penulis 
                                 FROM komentar_resep 
                                 JOIN penulis_resep ON komentar_resep.penulis_id = penulis_resep.id 
                                 WHERE komentar_resep.resep_id = $resep_id");

// Ambil semua penulis untuk dropdown
$result_penulis = $conn->query("SELECT * FROM penulis_resep");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Komentar untuk <?= $resep['nama_resep'] ?></title>
</head>
<head>
    <meta charset="UTF-8">
    <title>Menu Resep Masakan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Komentar untuk Resep: <?= $resep['nama_resep'] ?></h1>
    <form method="POST">
        <label>Komentar:</label>
        <textarea name="isi_komentar" required></textarea><br>
        <label>Penulis:</label>
        <select name="penulis_id" required>
            <?php while ($row = $result_penulis->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['nama_penulis'] ?></option>
            <?php endwhile; ?>
        </select><br>
        <button type="submit">Tambah Komentar</button>
    </form>
    <h2>Daftar Komentar</h2>
    <ul>
        <?php while ($row = $result_komentar->fetch_assoc()): ?>
        <li><?= $row['isi_komentar'] ?> - <strong><?= $row['nama_penulis'] ?></strong></li>
        <?php endwhile; ?>
    </ul>
    <a href="resep.php">Kembali ke Resep</a>
</body>
</html>
