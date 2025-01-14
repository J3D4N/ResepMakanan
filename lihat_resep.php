<?php
include 'db.php';

// Ambil ID resep dari URL
$resep_id = $_GET['resep_id'] ?? null;
if ($resep_id === null) {
    echo "ID Resep tidak ditemukan.";
    exit;
}

// Ambil data resep berdasarkan ID
$result_resep = $conn->query("SELECT data_resep.*, kategori_resep.nama_kategori 
                              FROM data_resep 
                              JOIN kategori_resep ON data_resep.kategori_id = kategori_resep.id 
                              WHERE data_resep.id = $resep_id");
$resep = $result_resep->fetch_assoc();

if (!$resep) {
    echo "Resep tidak ditemukan.";
    exit;
}

// Ambil daftar resep untuk pilihan lainnya
$result_daftar_resep = $conn->query("SELECT id, nama_resep FROM data_resep");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Resep: <?= htmlspecialchars($resep['nama_resep']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Pilih Resep Lain:</h3>
    <form action="lihat_resep.php" method="GET">
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
    <h2>Detail Resep</h1>
    <h3><?= htmlspecialchars($resep['nama_resep']) ?></h2>
    <p><strong>Kategori:</strong> <?= htmlspecialchars($resep['nama_kategori']) ?></p>
    <h4>Bahan:</h3>
    <p><?= nl2br(htmlspecialchars($resep['bahan'])) ?></p>
    <h4>Langkah:</h3>
    <p><?= nl2br(htmlspecialchars($resep['langkah'])) ?></p>

    <!-- Dropdown untuk memilih resep lain -->
    

    <!-- Link Kembali -->
    <a href="resep.php">Kembali ke Daftar Resep</a>
</body>
</html>
