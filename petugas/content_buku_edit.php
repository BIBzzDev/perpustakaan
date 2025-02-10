<?php
if (!defined('INDEX')) die("Forbidden");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID buku tidak valid.");
}

$bukuid = intval($_GET['id']);

// Ambil data buku berdasarkan ID
$query = "SELECT * FROM labib_buku WHERE bukuid = $bukuid";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 0) {
    die("Buku tidak ditemukan.");
}
$buku = mysqli_fetch_assoc($result);

// Proses update buku
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahunterbit = intval($_POST['tahunterbit']);
    $cover = $buku['cover'];
    $bukupdf = $buku['bukupdf'];

    // Upload Cover jika ada file baru
    if (!empty($_FILES['cover']['name'])) {
        $targetDir = "../asset/cover/";
        $coverName = time() . "_" . basename($_FILES['cover']['name']);
        $targetFilePath = $targetDir . $coverName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['cover']['tmp_name'], $targetFilePath)) {
                if (!empty($buku['cover']) && file_exists($targetDir . $buku['cover'])) {
                    unlink($targetDir . $buku['cover']); // Hapus cover lama
                }
                $cover = $coverName;
            } else {
                $error = "Gagal mengunggah file cover.";
            }
        } else {
            $error = "Format file tidak valid. Harap unggah file JPG, JPEG, PNG, atau GIF.";
        }
    }

    // Upload Buku PDF jika ada file baru
    if (!empty($_FILES['bukupdf']['name'])) {
        $targetDirPdf = "../asset/buku/";
        $bukupdfName = time() . "_" . basename($_FILES['bukupdf']['name']);
        $targetFilePathPdf = $targetDirPdf . $bukupdfName;
        $fileTypePdf = strtolower(pathinfo($targetFilePathPdf, PATHINFO_EXTENSION));
        $allowedTypesPdf = ['pdf'];

        if (in_array($fileTypePdf, $allowedTypesPdf)) {
            if (move_uploaded_file($_FILES['bukupdf']['tmp_name'], $targetFilePathPdf)) {
                if (!empty($buku['bukupdf']) && file_exists($targetDirPdf . $buku['bukupdf'])) {
                    unlink($targetDirPdf . $buku['bukupdf']); // Hapus PDF lama
                }
                $bukupdf = $bukupdfName;
            } else {
                $error = "Gagal mengunggah file PDF.";
            }
        } else {
            $error = "Format file tidak valid. Harap unggah file PDF.";
        }
    }

    // Update data ke database
    if (empty($error)) {
        $queryUpdate = "UPDATE labib_buku SET 
                        judul = '$judul', 
                        penulis = '$penulis', 
                        penerbit = '$penerbit', 
                        tahunterbit = $tahunterbit, 
                        cover = '$cover', 
                        bukupdf = '$bukupdf' 
                        WHERE bukuid = $bukuid";

        if (mysqli_query($conn, $queryUpdate)) {
            echo "<script>alert('Data buku berhasil diperbarui!'); window.location='?hal=labib_buku';</script>";
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($conn);
        }
    }
}
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">Edit Buku</h1>
        <p class="text-lg text-gray-300">Ubah informasi buku yang sudah ada.</p>
    </div>

    <div class="card p-4" style="background-color: #1e2a3a; border: 1px solid #444; border-radius: 10px;">
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul" class="form-label text-cyan-400">Judul Buku</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $buku['judul']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="penulis" class="form-label text-cyan-400">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $buku['penulis']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="penerbit" class="form-label text-cyan-400">Penerbit</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo $buku['penerbit']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tahunterbit" class="form-label text-cyan-400">Tahun Terbit</label>
                <input type="number" class="form-control" id="tahunterbit" name="tahunterbit" value="<?php echo $buku['tahunterbit']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="cover" class="form-label text-cyan-400">Cover Buku (Biarkan kosong jika tidak ingin mengganti)</label>
                <input type="file" class="form-control" id="cover" name="cover">
                <?php if (!empty($buku['cover'])) : ?>
                    <p>Cover saat ini: <img src="../asset/cover/<?php echo $buku['cover']; ?>" width="100"></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="bukupdf" class="form-label text-cyan-400">File PDF Buku (Biarkan kosong jika tidak ingin mengganti)</label>
                <input type="file" class="form-control" id="bukupdf" name="bukupdf">
                <?php if (!empty($buku['bukupdf'])) : ?>
                    <p><a href="../asset/buku/<?php echo $buku['bukupdf']; ?>" target="_blank">Lihat PDF</a></p>
                <?php endif; ?>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 py-2">Simpan</button>
                <a href="?hal=labib_buku" class="btn btn-danger px-4 py-2">Batal</a>
            </div>
        </form>
    </div>
</div>