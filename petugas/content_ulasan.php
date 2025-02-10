<?php
if (!defined('INDEX')) die("Forbidden");

$query = "SELECT labib_ulasanbuku.*, 
                 labib_user.username, 
                 labib_buku.judul 
          FROM labib_ulasanbuku
          LEFT JOIN labib_user ON labib_ulasanbuku.userid = labib_user.userid
          LEFT JOIN labib_buku ON labib_ulasanbuku.bukuid = labib_buku.bukuid
          ORDER BY labib_ulasanbuku.tanggal DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">Manajemen Ulasan</h1>
        <p class="text-lg text-gray-300">Daftar ulasan yang diberikan oleh pengguna.</p>
    </div>
<div class="mb-4 text-end">
        <button onclick="exportPDF()" class="btn btn-danger px-4 py-2">Download PDF</button>
    </div>
    <!-- Tabel Data Ulasan -->
    <div class="table-responsive">
        <table class="table table-dark table-hover" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>Judul Buku</th>
                    <th>Ulasan</th>
                    <th>Rating</th>
                    <th>Tanggal</th>
                    <th>Aksi</th> <!-- Kolom Aksi ditambahkan di HTML -->
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1; 
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['username'] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row['judul'] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row['ulasan'] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row['rating'] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row['tanggal'] ?? '') . "</td>";
                    echo "<td>
                            <a href='?hal=ulasan_hapus&id=" . $row['ulasanid'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus ulasan ini?\")'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }

                if (mysqli_num_rows($result) === 0) {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada ulasan</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

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
        doc.text("Laporan Ulasan Buku", 105, 15, { align: "center" });

        doc.setFontSize(12);
        doc.setTextColor(100);
        doc.text("Perpustakaan Digital 2025", 105, 22, { align: "center" });

        
        let tableData = [];
        let rows = document.querySelectorAll("#myTable tbody tr");
        rows.forEach((row, index) => {
            let cells = row.querySelectorAll("td");
            let nomor = cells[0].textContent;
            let namaPengguna = cells[1].textContent;
            let judulBuku = cells[2].textContent;
            let ulasan = cells[3].textContent;
            let rating = cells[4].textContent;
            let tanggal = cells[5].textContent;
            tableData.push([nomor, namaPengguna, judulBuku, ulasan, rating, tanggal]); 
        });

      
        doc.autoTable({
            head: [["No", "Nama Pengguna", "Judul Buku", "Ulasan", "Rating", "Tanggal"]], 
            body: tableData,
            startY: 30,
            theme: "grid",
            headStyles: { fillColor: [0, 102, 204], textColor: 255 }, 
            alternateRowStyles: { fillColor: [240, 240, 240] }, 
            styles: { font: "helvetica", fontSize: 10, textColor: [50, 50, 50] },
            columnStyles: {
                0: { cellWidth: 10, halign: "center" },
                1: { cellWidth: 50 },
                2: { cellWidth: 50 },
                3: { cellWidth: 60 },
                4: { cellWidth: 20, halign: "center" },
                5: { cellWidth: 30 }
            }
        });

        
        let totalPages = doc.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
            doc.setPage(i);
            doc.setFontSize(10);
            doc.setTextColor(100);
            doc.text(`Halaman ${i} dari ${totalPages}`, 105, 285, { align: "center" });
        }

        
        doc.save("Laporan_Ulasan.pdf");
    }
</script>

</body>
</html>