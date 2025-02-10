<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xiirpl4_labib_perpustakaan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>