<?php
if (!defined('INDEX')) die("Forbidden");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID Kategori tidak ditemukan.");
}

$kategoriid = $_GET['id'];
$query = "SELECT * FROM labib_kategoribuku WHERE kategoriid = '$kategoriid'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Kategori tidak ditemukan.");
}

$row = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $namakategori = mysqli_real_escape_string($conn, $_POST['namakategori']);
    
    if (!empty($namakategori)) {
        $updateQuery = "UPDATE labib_kategoribuku SET namakategori = '$namakategori' WHERE kategoriid = '$kategoriid'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            echo "<script>alert('Kategori berhasil diperbarui.'); window.location='?hal=kategoribuku';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui kategori.');</script>";
        }
    } else {
        echo "<script>alert('Nama kategori tidak boleh kosong.');</script>";
    }
}
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">Edit Kategori</h1>
        <p class="text-lg text-gray-300">Perbarui nama kategori buku.</p>
    </div>

    <div class="card p-4 bg-dark text-white">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="namakategori" class="form-control" value="<?= htmlspecialchars($row['namakategori']); ?>" required>
            </div>
            <div class="text-end">
                <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="?hal=kategoribuku" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>