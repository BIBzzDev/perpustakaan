<?php
if (!defined('INDEX')) die("Forbidden");

// Pastikan parameter ID tersedia
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID pengguna tidak ditemukan.");
}

$id = intval($_GET['id']); // Hindari SQL Injection dengan memastikan ID adalah angka

// Ambil data user berdasarkan ID
$query = "SELECT * FROM labib_user WHERE userid = $id";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) {
    die("Pengguna tidak ditemukan.");
}

$user = mysqli_fetch_assoc($result);

// Proses update data jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $namalengkap = mysqli_real_escape_string($conn, $_POST['namalengkap']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);

    // Jika ada upload foto profil baru
    if (!empty($_FILES['pp']['name'])) {
        $ppName = time() . "_" . basename($_FILES['pp']['name']);
        $targetPath = "../asset/pp/" . $ppName;

        if (move_uploaded_file($_FILES['pp']['tmp_name'], $targetPath)) {
            // Hapus foto lama jika bukan default
            if ($user['pp'] !== 'default.jpg') {
                @unlink("../asset/pp/" . $user['pp']);
            }
            $updatePP = ", pp = '$ppName'";
        } else {
            die("Gagal mengupload gambar.");
        }
    } else {
        $updatePP = "";
    }

    // Update data ke database
    $updateQuery = "UPDATE labib_user SET 
                    username = '$username', 
                    email = '$email', 
                    namalengkap = '$namalengkap', 
                    alamat = '$alamat', 
                    level = '$level'
                    $updatePP
                    WHERE userid = $id";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Data pengguna berhasil diperbarui.'); window.location.href='?hal=user';</script>";
    } else {
        die("Gagal memperbarui data: " . mysqli_error($conn));
    }
}
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">Edit Pengguna</h1>
        <p class="text-lg text-gray-300">Perbarui informasi pengguna di sini.</p>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="namalengkap" class="form-control" value="<?= htmlspecialchars($user['namalengkap']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required><?= htmlspecialchars($user['alamat']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Level</label>
            <select name="level" class="form-control" required>
                <option value="admin" <?= $user['level'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="petugas" <?= $user['level'] === 'petugas' ? 'selected' : '' ?>>Petugas</option>
                <option value="peminjam" <?= $user['level'] === 'peminjam' ? 'selected' : '' ?>>Peminjam</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Profil</label><br>
            <img src="../asset/pp/<?= htmlspecialchars($user['pp']) ?>" alt="Foto Profil" style="width:80px; height:80px; border-radius:50%;">
            <input type="file" name="pp" class="form-control mt-2">
        </div>

        <div class="mb-3 text-end">
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="?hal=user" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>