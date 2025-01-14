<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM data_resep WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: resep.php");
    exit;
}
?>
