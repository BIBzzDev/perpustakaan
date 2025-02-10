<?php
if (!defined('INDEX')) die("Forbidden");

$query = "SELECT * FROM labib_user";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<div class="container py-5">
   
    <div class="text-center mb-5">
        <h1 class="text-4xl font-bold text-cyan-400">User Management</h1>
        <p class="text-lg text-gray-300">Daftar pengguna sistem perpustakaan.</p>
    </div>

    <div class="mb-4 text-end">
        <button onclick="exportPDF()" class="btn btn-danger px-4 py-2">Download PDF</button>
    
    </div>

    
    <div class="table-responsive">
        <table class="table table-dark table-hover" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto Profil</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1; 
                while ($row = mysqli_fetch_assoc($result)) {
                    $ppPath = !empty($row['pp']) ? '../asset/pp/' . htmlspecialchars($row['pp']) : '../asset/pp/default.jpg';
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td><img src='$ppPath' alt='Foto Profil' style='width:50px; height:50px; border-radius:50%;'></td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['namalengkap']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                    echo "</tr>";
                }

                if (mysqli_num_rows($result) === 0) {
                    echo "<tr><td colspan='8' class='text-center'>Tidak ada data pengguna</td></tr>";
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
        doc.text("Laporan Pengguna Perpustakaan", 105, 15, { align: "center" });

        doc.setFontSize(12);
        doc.setTextColor(100);
        doc.text("Perpustakaan Digital 2025", 105, 22, { align: "center" });

       
        let tableData = [];
        let rows = document.querySelectorAll("#myTable tbody tr");
        rows.forEach((row, index) => {
            let cells = row.querySelectorAll("td");
            let nomor = cells[0].textContent;
            let fotoProfil = cells[1].querySelector("img") ? cells[1].querySelector("img").src : "";
            let username = cells[2].textContent;
            let email = cells[3].textContent;
            let namaLengkap = cells[4].textContent;
            let alamat = cells[5].textContent;
            let level = cells[6].textContent;
            tableData.push([nomor, username, email, namaLengkap, alamat, level]); 
        });

        
        doc.autoTable({
            head: [["No", "Username", "Email", "Nama Lengkap", "Alamat", "Level"]], 
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
                4: { cellWidth: 40 },
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

        
        doc.save("Laporan_Pengguna.pdf");
    }
</script>

</body>
</html>