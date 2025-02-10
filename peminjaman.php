<?php

session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
    exit();
}

$userid = $_SESSION['userid'];

if (isset($_GET['bukuid'])) {
    $bukuid = $_GET['bukuid'];

    include('includes/db.php');

    $tanggalpeminjaman = date('Y-m-d');
    $statuspengembalian = 'belum dikembalikan';

    $query = "INSERT INTO labib_peminjaman (userid, bukuid, tanggalpeminjaman, tanggalpengembalian, statuspengembalian)
              VALUES ($userid, $bukuid, '$tanggalpeminjaman', NULL, '$statuspengembalian')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Peminjaman berhasil! Silakan kembalikan buku tepat waktu.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . mysqli_error($conn) . "'); window.location.href='index.php';</script>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>