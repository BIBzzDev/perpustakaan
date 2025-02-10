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

    // Cek apakah buku sudah ada di koleksi pribadi
    $checkQuery = "SELECT * FROM labib_koleksipribadi WHERE userid = $userid AND bukuid = $bukuid";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Buku sudah ada di koleksi pribadi!'); window.location.href='index.php';</script>";
    } else {
        // Tambahkan ke koleksi pribadi
        $insertQuery = "INSERT INTO labib_koleksipribadi (userid, bukuid) VALUES ($userid, $bukuid)";
        
        if (mysqli_query($conn, $insertQuery)) {
            echo "<script>alert('Buku berhasil ditambahkan ke koleksi!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan: " . mysqli_error($conn) . "'); window.location.href='index.php';</script>";
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>