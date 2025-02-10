<?php

require 'includes/db.php';

$email = $_POST['email'];
$password_input = $_POST['password']; 

$sql = "SELECT * FROM labib_user WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password_input);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    session_start();
    $user = $result->fetch_assoc();
    $_SESSION['userid'] = $user['userid'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['namalengkap'] = $user['namalengkap'];
    $_SESSION['level'] = $user['level'];

    
    if ($user['level'] == 'admin') {
        header("Location: admin/index.php");
    } elseif ($user['level'] == 'petugas') {
        header("Location: petugas/index.php");
    } elseif ($user['level'] == 'peminjam') {
        header("Location: index.php");
    } else {
        echo "<script>
                alert('Level pengguna tidak valid!');
                window.location.href = 'login.html';
              </script>";
    }
    exit();
} else {
    echo "<script>
            alert('Email atau password salah!');
            window.location.href = 'login.html';
          </script>";
}

$stmt->close();
$conn->close();
?>