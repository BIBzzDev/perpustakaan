<?php
if (!defined('INDEX')) die("Forbidden");

$query = "SELECT lp.peminjamanid, lb.judul, lu.namalengkap, lp.tanggalpeminjaman, 
                 lp.tanggalpengembalian, lp.statuspengembalian
          FROM labib_peminjaman lp
          LEFT JOIN labib_buku lb ON lp.bukuid = lb.bukuid
          LEFT JOIN labib_user lu ON lp.userid = lu.userid";

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
    <title>Manajemen Peminjaman Buku</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
</head>
<body>

<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">Manajemen Peminjaman Buku</h1>
        <p class="text-lg text-gray-300">Daftar peminjaman buku di perpustakaan.</p>
    </div>

    <div class="mb-4 text-end">
        <button onclick="exportPDF()" class="btn btn-danger px-4 py-2">Download PDF</button>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover" id="peminjamanTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status Pengembalian</th>
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
                    echo "<td>" . htmlspecialchars($row['namalengkap']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tanggalpeminjaman']) . "</td>";
                    echo "<td>" . (isset($row['tanggalpengembalian']) ? htmlspecialchars($row['tanggalpengembalian']) : "-") . "</td>";
                    echo "<td>" . (isset($row['statuspengembalian']) ? htmlspecialchars($row['statuspengembalian']) : "Belum Kembali") . "</td>";
                    echo "<td>
                            <a href='?hal=peminjaman_hapus&id=" . $row['peminjamanid'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }

                if (mysqli_num_rows($result) === 0) {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data peminjaman</td></tr>";
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
            orientation: "landscape", 
            unit: "mm",
            format: "a4"
        });

       
        doc.setFont("helvetica", "bold");
        doc.setFontSize(20);
        doc.setTextColor(0, 102, 204); 
        doc.text("Laporan Peminjaman Buku", 148, 15, { align: "center" });

      
        doc.setFontSize(12);
        doc.setTextColor(100);
        doc.text("Perpustakaan XYZ - 2025", 148, 22, { align: "center" });

        
        let tableData = [];
        let rows = document.querySelectorAll("#peminjamanTable tbody tr");
        rows.forEach((row, index) => {
            let cells = row.querySelectorAll("td");
            let nomor = cells[0].textContent;
            let judul = cells[1].textContent;
            let peminjam = cells[2].textContent;
            let tanggalPinjam = cells[3].textContent;
            let tanggalKembali = cells[4].textContent;
            let status = cells[5].textContent;
            tableData.push([nomor, judul, peminjam, tanggalPinjam, tanggalKembali, status]); 
        });

        
        doc.autoTable({
            head: [["No", "Judul Buku", "Nama Peminjam", "Tgl Peminjaman", "Tgl Pengembalian", "Status"]], 
            body: tableData,
            startY: 30,
            theme: "grid",
            headStyles: { fillColor: [0, 102, 204], textColor: 255 }, 
            alternateRowStyles: { fillColor: [240, 240, 240] }, 
            styles: { font: "helvetica", fontSize: 10, textColor: [50, 50, 50] },
            columnStyles: {
                0: { cellWidth: 10, halign: "center" },
                1: { cellWidth: 60 },
                2: { cellWidth: 40 },
                3: { cellWidth: 30, halign: "center" },
                4: { cellWidth: 30, halign: "center" },
                5: { cellWidth: 30, halign: "center" }
            }
        });

        
        let totalPages = doc.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
            doc.setPage(i);
            doc.setFontSize(10);
            doc.setTextColor(100);
            doc.text(`Halaman ${i} dari ${totalPages}`, 148, 200, { align: "center" });
        }

        
        doc.save("Laporan_Peminjaman_Buku.pdf");
    }
</script>

</body>
</html>