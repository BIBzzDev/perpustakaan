<?php
if (!defined('INDEX')) die("Forbidden");

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namakategori = mysqli_real_escape_string($conn, $_POST['namakategori']);

    // Jika nama kategori tidak kosong, simpan data ke database
    if (!empty($namakategori)) {
        $query = "INSERT INTO labib_kategoribuku (namakategori) VALUES ('$namakategori')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Kategori buku berhasil ditambahkan!'); window.location='?hal=kategoribuku';</script>";
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    } else {
        $error = "Nama kategori tidak boleh kosong.";
    }
}
?>

<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">Tambah Kategori Buku</h1>
        <p class="text-lg text-gray-300">Isi form berikut untuk menambahkan kategori buku baru.</p>
    </div>

    <!-- Form Tambah Kategori Buku -->
    <div class="card p-4" style="background-color: #1e2a3a; border: 1px solid #444; border-radius: 10px;">
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="namakategori" class="form-label text-cyan-400">Nama Kategori</label>
                <input type="text" class="form-control" id="namakategori" name="namakategori" required>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 py-2">Simpan</button>
                <a href="?hal=kategoribuku" class="btn btn-danger px-4 py-2">Batal</a>
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