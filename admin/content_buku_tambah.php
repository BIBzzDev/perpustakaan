<?php
if (!defined('INDEX')) die("Forbidden");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahunterbit = intval($_POST['tahunterbit']);
    $kategoriid = intval($_POST['kategori']); // Ambil ID kategori dari form
    $cover = '';
    $bukupdf = '';

    // Upload Cover
    if (!empty($_FILES['cover']['name'])) {
        $targetDir = "../asset/cover/";
        $coverName = time() . "_" . basename($_FILES['cover']['name']);
        $targetFilePath = $targetDir . $coverName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['cover']['tmp_name'], $targetFilePath)) {
                $cover = $coverName;
            } else {
                $error = "Gagal mengunggah file cover.";
            }
        } else {
            $error = "Format file tidak valid. Harap unggah file JPG, JPEG, PNG, atau GIF.";
        }
    }

    // Upload Buku PDF
    if (!empty($_FILES['bukupdf']['name'])) {
        $targetDirPdf = "../asset/buku/";
        $bukupdfName = time() . "_" . basename($_FILES['bukupdf']['name']);
        $targetFilePathPdf = $targetDirPdf . $bukupdfName;
        $fileTypePdf = strtolower(pathinfo($targetFilePathPdf, PATHINFO_EXTENSION));
        $allowedTypesPdf = ['pdf'];

        if (in_array($fileTypePdf, $allowedTypesPdf)) {
            if (move_uploaded_file($_FILES['bukupdf']['tmp_name'], $targetFilePathPdf)) {
                $bukupdf = $bukupdfName;
            } else {
                $error = "Gagal mengunggah file PDF.";
            }
        } else {
            $error = "Format file tidak valid. Harap unggah file PDF.";
        }
    }

    // Simpan data ke tabel labib_buku
    if (empty($error)) {
        $query = "INSERT INTO labib_buku (judul, penulis, penerbit, tahunterbit, cover, bukupdf) 
                  VALUES ('$judul', '$penulis', '$penerbit', $tahunterbit, '$cover', '$bukupdf')";

        if (mysqli_query($conn, $query)) {
            $bukuid = mysqli_insert_id($conn); // Ambil ID buku yang baru disimpan

            // Simpan ke tabel labib_kategoribuku_relasi
            if ($kategoriid > 0) {
                $queryKategori = "INSERT INTO labib_kategoribuku_relasi (bukuid, kategoriid) VALUES ($bukuid, $kategoriid)";
                mysqli_query($conn, $queryKategori);
            }

            echo "<script>alert('Data buku berhasil ditambahkan!'); window.location='?hal=labib_buku';</script>";
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">Tambah Buku</h1>
        <p class="text-lg text-gray-300">Isi form berikut untuk menambahkan buku baru.</p>
    </div>

    <div class="card p-4" style="background-color: #1e2a3a; border: 1px solid #444; border-radius: 10px;">
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul" class="form-label text-cyan-400">Judul Buku</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="mb-3">
                <label for="penulis" class="form-label text-cyan-400">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis" required>
            </div>
            <div class="mb-3">
                <label for="penerbit" class="form-label text-cyan-400">Penerbit</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" required>
            </div>
            <div class="mb-3">
                <label for="tahunterbit" class="form-label text-cyan-400">Tahun Terbit</label>
                <input type="number" class="form-control" id="tahunterbit" name="tahunterbit" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label text-cyan-400">Kategori</label>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    $queryKategori = "SELECT * FROM labib_kategoribuku";
                    $resultKategori = mysqli_query($conn, $queryKategori);
                    while ($row = mysqli_fetch_assoc($resultKategori)) {
                        echo "<option value='" . $row['kategoriid'] . "'>" . $row['namakategori'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="cover" class="form-label text-cyan-400">Cover Buku</label>
                <input type="file" class="form-control" id="cover" name="cover">
            </div>
            <div class="mb-3">
                <label for="bukupdf" class="form-label text-cyan-400">File PDF Buku</label>
                <input type="file" class="form-control" id="bukupdf" name="bukupdf" required>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 py-2">Simpan</button>
                <a href="?hal=buku" class="btn btn-danger px-4 py-2">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to bottom right, #0f2027, #203a43, #2c5364);
        color: #ffffff;
    }

    .btn {
        text-decoration: none;
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-primary {
        background-color: #38bdf8;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
    }

    .btn-primary:hover {
        background-color: #2c97de;
    }

    .btn-danger {
        background-color: #ff6f61;
        color: #ffffff;
        padding: 10px 20px;
    }

    .btn-danger:hover {
        background-color: #e63939;
    }

    .form-label {
        font-weight: bold;
    }

    .form-control {
        background-color: #1e2a3a;
        color: #ffffff;
        border: 1px solid #444;
        border-radius: 5px;
    }

    .form-control:focus {
        background-color: #2c5364;
        border-color: #38bdf8;
        color: #ffffff;
    }
</style>