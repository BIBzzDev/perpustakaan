<?php
if (!defined('INDEX')) die("Forbidden");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID buku tidak valid.");
}

$bukuid = intval($_GET['id']);


$query = "SELECT cover, bukupdf FROM labib_buku WHERE bukuid = $bukuid";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 0) {
    die("Buku tidak ditemukan.");
}

$buku = mysqli_fetch_assoc($result);


if (!empty($buku['cover']) && file_exists("../asset/cover/" . $buku['cover'])) {
    unlink("../asset/cover/" . $buku['cover']);
}


if (!empty($buku['bukupdf']) && file_exists("../asset/buku/" . $buku['bukupdf'])) {
    unlink("../asset/buku/" . $buku['bukupdf']);
}


$queryDelete = "DELETE FROM labib_buku WHERE bukuid = $bukuid";
if (mysqli_query($conn, $queryDelete)) {
    echo "<script>alert('Buku berhasil dihapus!'); window.location='?hal=labib_buku';</script>";
} else {
    echo "<script>alert('Gagal menghapus buku: " . mysqli_error($conn) . "'); window.location='?hal=buku';</script>";
}
?>