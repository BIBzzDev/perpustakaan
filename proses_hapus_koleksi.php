<?php
session_start();
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bukuid'])) {
    $bukuid = intval($_POST['bukuid']);
    $userid = $_SESSION['userid']; 

    
    $queryDelete = "DELETE FROM labib_koleksipribadi WHERE bukuid = ? AND userid = ?";

    $stmt = $conn->prepare($queryDelete);
    $stmt->bind_param("ii", $bukuid, $userid);

    if ($stmt->execute()) {
        echo "<script>alert('Buku berhasil dihapus dari koleksi!'); window.location.href='buku_koleksi.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus buku dari koleksi.'); window.location.href='buku_koleksi.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Akses tidak valid.'); window.location.href='buku_koleksi.php';</script>";
}

$conn->close();
?>