<?php
if (!defined('INDEX')) die("Forbidden");

$query = "SELECT lb.bukuid, lb.judul, lb.penulis, lb.penerbit, lb.tahunterbit, 
                 GROUP_CONCAT(lk.namakategori SEPARATOR ', ') AS kategori
          FROM labib_buku lb
          LEFT JOIN labib_kategoribuku_relasi lkr ON lb.bukuid = lkr.bukuid
          LEFT JOIN labib_kategoribuku lk ON lkr.kategoriid = lk.kategoriid
          GROUP BY lb.bukuid";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
</head>
<body>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">Manajemen Buku</h1>
        <p class="text-lg text-gray-300">Daftar koleksi buku di perpustakaan.</p>
    </div>

    <div class="mb-4 text-end">
        <a href="?hal=buku_tambah" class="btn btn-primary px-4 py-2">Tambah Buku</a>
        <button onclick="exportPDF()" class="btn btn-danger px-4 py-2">Download PDF</button>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Kategori</th>
                    <th>Aksi</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1; 
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['penulis']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['penerbit']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tahunterbit']) . "</td>";
                    echo "<td>" . (!empty($row['kategori']) ? htmlspecialchars($row['kategori']) : "Tanpa Kategori") . "</td>";
                    echo "<td>
                            <a href='?hal=buku_edit&id=" . $row['bukuid'] . "' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='?hal=buku_hapus&id=" . $row['bukuid'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus buku ini?\")'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }

                if (mysqli_num_rows($result) === 0) {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data buku</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function exportPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: "portrait",
            unit: "mm",
            format: "a4"
        });

       
        doc.setFont("helvetica", "bold");
        doc.setFontSize(20);
        doc.setTextColor(0, 102, 204); 
        doc.text("Laporan Koleksi Buku", 105, 15, { align: "center" });

        doc.setFontSize(12);
        doc.setTextColor(100);
        doc.text("Perpustakaan Digital 2025", 105, 22, { align: "center" });

       
        let tableData = [];
        let rows = document.querySelectorAll("#myTable tbody tr");
        rows.forEach((row, index) => {
            let cells = row.querySelectorAll("td");
            let nomor = cells[0].textContent;
            let judul = cells[1].textContent;
            let penulis = cells[2].textContent;
            let penerbit = cells[3].textContent;
            let tahunTerbit = cells[4].textContent;
            let kategori = cells[5].textContent;
            tableData.push([nomor, judul, penulis, penerbit, tahunTerbit, kategori]); 
        });

        
        doc.autoTable({
            head: [["No", "Judul Buku", "Penulis", "Penerbit", "Tahun Terbit", "Kategori"]], 
            body: tableData,
            startY: 30,
            theme: "grid",
            headStyles: { fillColor: [0, 102, 204], textColor: 255 }, 
            alternateRowStyles: { fillColor: [240, 240, 240] }, 
            styles: { font: "helvetica", fontSize: 10, textColor: [50, 50, 50] },
            columnStyles: {
                0: { cellWidth: 10, halign: "center" },
                1: { cellWidth: 50 },
                2: { cellWidth: 35 },
                3: { cellWidth: 35 },
                4: { cellWidth: 20, halign: "center" },
                5: { cellWidth: 40 }
            }
        });

        
        let totalPages = doc.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
            doc.setPage(i);
            doc.setFontSize(10);
            doc.setTextColor(100);
            doc.text(`Halaman ${i} dari ${totalPages}`, 105, 285, { align: "center" });
        }

       
        doc.save("Laporan_Buku.pdf");
    }
</script>

</body>
</html>