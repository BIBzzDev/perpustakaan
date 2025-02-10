<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xiirpl4_labib_perpustakaan"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$namalengkap = $_POST['namalengkap'];
$password = $_POST['password']; 
$password_confirmation = $_POST['password_confirmation']; // Mendapatkan konfirmasi password
$alamat = $_POST['alamat'];

// Cek apakah password dan konfirmasi password cocok
if ($password !== $password_confirmation) {
    echo "<script>
            alert('Password dan konfirmasi password tidak cocok!');
            window.location.href = 'register.html';
          </script>";
    exit;
}

$username = explode('@', $email)[0];
$pp = 'default.jpg'; 

if (isset($_FILES['pp']) && $_FILES['pp']['error'] == 0) {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_extension = pathinfo($_FILES['pp']['name'], PATHINFO_EXTENSION);
    
    if (in_array(strtolower($file_extension), $allowed_extensions)) {
        $pp = uniqid() . '.' . $file_extension; 
        $upload_dir = 'pp/'; 
        $upload_path = $upload_dir . $pp;

        if (move_uploaded_file($_FILES['pp']['tmp_name'], $upload_path)) {
            
        } else {
            echo "<script>
                    alert('Gagal mengupload foto profil!');
                    window.location.href = 'register.html';
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('File yang diupload bukan gambar yang valid!');
                window.location.href = 'register.html';
              </script>";
        exit;
    }
}

$sql = "INSERT INTO labib_user (username, email, namalengkap, password, alamat, pp, level) 
        VALUES ('$username', '$email', '$namalengkap', '$password', '$alamat', '$pp', 'peminjam')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Registration successful! Your username is: $username');
            window.location.href = 'register.html';
          </script>";
} else {
    echo "<script>
            alert('Error: " . $conn->error . "');
            window.location.href = 'register.html';
          </script>";
}

$conn->close();
?>