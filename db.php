<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "resep_masakan";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
