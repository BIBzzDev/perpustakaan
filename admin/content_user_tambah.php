<?php
if (!defined('INDEX')) die("Forbidden");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $namalengkap = mysqli_real_escape_string($conn, $_POST['namalengkap']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $level = mysqli_real_escape_string($conn, $_POST['level']); 

    
    $pp = ''; 
    if (isset($_FILES['pp']) && $_FILES['pp']['error'] == 0) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($_FILES['pp']['name'], PATHINFO_EXTENSION);
        
        
        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            $pp = uniqid() . '.' . $file_extension; 
            $upload_dir = '../asset/pp/';
            $upload_path = $upload_dir . $pp;

            
            if (move_uploaded_file($_FILES['pp']['tmp_name'], $upload_path)) {
                
            } else {
                echo "<script>alert('Gagal mengupload foto profil!');</script>";
                exit;
            }
        } else {
            echo "<script>alert('File yang diupload bukan gambar yang valid!');</script>";
            exit;
        }
    }

    
    $query = "INSERT INTO labib_user (username, password, email, namalengkap, alamat, level, pp) 
              VALUES ('$username', '$password', '$email', '$namalengkap', '$alamat', '$level', '$pp')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location.href = 'index.php?page=user';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">Tambah User</h1>
        <p class="text-lg text-gray-300">Masukkan data pengguna baru.</p>
    </div>

   
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="namalengkap" class="form-label">Nama Lengkap</label>
            <input type="text" name="namalengkap" id="namalengkap" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select name="level" id="level" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
                <option value="peminjam">Peminjam</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="pp" class="form-label">Foto Profil</label>
            <input type="file" name="pp" id="pp" class="form-control" accept="image/*">
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4 py-2">Simpan</button>
            <a href="index.php?page=user" class="btn btn-secondary px-4 py-2">Batal</a>
        </div>
    </form>
</div>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to bottom right, #0f2027, #203a43, #2c5364);
        color: #ffffff;
    }

    .form-control {
        background-color: #1e2a3a;
        border: 1px solid #444;
        color: #ffffff;
    }

    .form-control:focus {
        background-color: #273c4f;
        border-color: #38bdf8;
        box-shadow: 0 0 5px #38bdf8;
    }

    .btn-primary {
        background-color: #38bdf8;
        color: #ffffff;
        border: none;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #2c97de;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #ffffff;
        border: none;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }
</style>