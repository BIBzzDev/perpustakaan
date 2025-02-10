<?php
if (!defined('INDEX')) die("Forbidden");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID Kategori tidak ditemukan.");
}

$kategoriid = $_GET['id'];


$query = "DELETE FROM labib_kategoribuku WHERE kategoriid = '$kategoriid'";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "<script>alert('Kategori berhasil dihapus.'); window.location='?hal=kategoribuku';</script>";
} else {
    echo "<script>alert('Gagal menghapus kategori.'); window.location='?hal=kategoribuku';</script>";
}
?>