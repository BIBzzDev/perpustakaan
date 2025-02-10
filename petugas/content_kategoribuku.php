<?php
if (!defined('INDEX')) die("Forbidden");

$query = "SELECT * FROM labib_kategoribuku";
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
    <title>Kategori Buku</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
</head>
<body>

<div class="container py-5">
    
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">Kategori Buku</h1>
        <p class="text-lg text-gray-300">Daftar kategori buku dalam sistem perpustakaan.</p>
    </div>

    <div class="mb-4 text-end">
        <a href="?hal=kategoribuku_tambah" class="btn btn-primary px-4 py-2">Tambah Kategori</a>
        <button onclick="exportPDF()" class="btn btn-danger px-4 py-2">Download PDF</button>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover" id="kategoriTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['namakategori']) . "</td>";
                    echo "<td>
                            <a href='?hal=kategoribuku_edit&id=" . $row['kategoriid'] . "' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='?hal=kategoribuku_hapus&id=" . $row['kategoriid'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus kategori ini?\")'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }
                if (mysqli_num_rows($result) === 0) {
                    echo "<tr><td colspan='3' class='text-center'>Tidak ada data kategori</td></tr>";
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
        doc.text("Laporan Kategori Buku", 105, 15, { align: "center" });

      
        doc.setFontSize(12);
        doc.setTextColor(100);
        doc.text("Perpustakaan XYZ - 2025", 105, 22, { align: "center" });

        
        let tableData = [];
        let rows = document.querySelectorAll("#kategoriTable tbody tr");
        rows.forEach((row, index) => {
            let cells = row.querySelectorAll("td");
            let nomor = cells[0].textContent;
            let namaKategori = cells[1].textContent;
            tableData.push([nomor, namaKategori]); 
        });

       
        doc.autoTable({
            head: [["No", "Nama Kategori"]], 
            body: tableData,
            startY: 30,
            theme: "grid",
            headStyles: { fillColor: [0, 102, 204], textColor: 255 },
            alternateRowStyles: { fillColor: [240, 240, 240] }, 
            styles: { font: "helvetica", fontSize: 10, textColor: [50, 50, 50] },
            columnStyles: {
                0: { cellWidth: 20, halign: "center" },
                1: { cellWidth: 140 }
            }
        });

       
        let totalPages = doc.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
            doc.setPage(i);
            doc.setFontSize(10);
            doc.setTextColor(100);
            doc.text(`Halaman ${i} dari ${totalPages}`, 105, 285, { align: "center" });
        }

        
        doc.save("Laporan_Kategori_Buku.pdf");
    }
</script>

</body>
</html>