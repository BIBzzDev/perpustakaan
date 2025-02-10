📚 Perpustakaan Digital

🚀 Project UKK RPL 2024 - Sistem Manajemen Perpustakaan Berbasis Web



📖 Tentang Proyek

Perpustakaan Digital adalah sebuah sistem berbasis web yang dirancang untuk mempermudah pengelolaan perpustakaan, termasuk administrasi buku, anggota, peminjaman, dan pengembalian buku. Proyek ini dibuat sebagai bagian dari Ujian Kompetensi Keahlian (UKK) RPL 2024, dengan fokus pada efisiensi dan kemudahan penggunaan.

🔹 Dibangun dengan: PHP, MySQL, Bootstrap
🔹 Tujuan: Digitalisasi perpustakaan sekolah untuk meningkatkan aksesibilitas dan manajemen data
🔹 Status: ✅ Selesai dan siap digunakan


---

🎯 Fitur Utama

✅ Manajemen Buku → Tambah, Edit, Hapus, dan Cari Buku
✅ Manajemen Anggota → Kelola data anggota perpustakaan
✅ Peminjaman & Pengembalian → Catat transaksi peminjaman dan pengembalian buku
✅ Laporan & Riwayat → Melihat histori peminjaman dan pengembalian buku
✅ Dashboard Interaktif → Statistik dan data penting dalam satu tempat


---

🛠️ Instalasi & Setup

1️⃣ Clone Repository

Pastikan kamu sudah menginstal Git di perangkat. Kemudian jalankan perintah berikut di Command Prompt (CMD) / Termux:

git clone https://github.com/BIBzzDev/xiirpl4_labib_perpustakaan.git

Setelah proses selesai, pindahkan folder hasil clone ke dalam direktori server lokal:

C:/xampp/htdocs/xiirpl4_labib_perpustakaan


---

2️⃣ Konfigurasi Database

1. Jalankan XAMPP dan aktifkan Apache serta MySQL.


2. Buka phpMyAdmin dengan mengakses:

http://localhost/phpmyadmin


3. Buat database baru dengan nama:

perpustakaan


4. Import database dari file database.sql yang ada di dalam folder proyek.

Klik Import

Pilih file database.sql

Klik Go untuk menyelesaikan proses impor





---

3️⃣ Menjalankan Proyek

Setelah database dikonfigurasi, buka browser dan akses:

http://localhost/xiirpl4_labib_perpustakaan

🔑 Akun Default untuk Login:

Admin:

Username: admin

Password: admin


Anggota Perpustakaan:

Username: anggota01

Password: 123456




---

📂 Struktur Folder

/xiirpl4_labib_perpustakaan
│── /assets       → File CSS, JavaScript, dan gambar  
│── /config       → File konfigurasi database dan koneksi  
│── /controllers  → Logic aplikasi  
│── /views        → Tampilan halaman web  
│── /models       → Query database  
│── database.sql  → Struktur dan data awal database  
│── index.php     → File utama aplikasi  
└── README.md     → Dokumentasi proyek


---

💡 Cara Penggunaan

1. Login sebagai admin untuk mengelola data buku dan anggota.


2. Tambah data buku sebelum bisa dipinjam oleh anggota.


3. Registrasi anggota dilakukan oleh admin sebelum mereka bisa login.


4. Peminjaman Buku:

Pilih buku yang tersedia

Masukkan data anggota

Tentukan tanggal peminjaman

Simpan transaksi



5. Pengembalian Buku:

Cek daftar peminjaman

Konfirmasi pengembalian

Denda akan dihitung otomatis jika terlambat





---

🌐 Teknologi yang Digunakan

🔹 PHP (Native) - Backend
🔹 MySQL - Database
🔹 Bootstrap 5 - Frontend
🔹 JavaScript (jQuery) - Interaksi UI
🔹 XAMPP - Server lokal


---

🛠️ Troubleshooting

Q: Website tidak bisa diakses?
A: Pastikan XAMPP sudah berjalan dan Apache serta MySQL dalam keadaan aktif.

Q: Database tidak ditemukan?
A: Pastikan database sudah dibuat dan file database.sql telah di-import dengan benar.

Q: Tidak bisa login?
A: Gunakan akun default di atas. Jika masih gagal, cek tabel users di database dan reset passwordnya.


---

📌 Kontributor

💻 Muhammad Labib (Developer)

Ingin berkontribusi? Silakan fork repository ini dan buat pull request! 🚀


---

📜 Lisensi

Proyek ini dibuat untuk keperluan UKK RPL 2024 dan dapat digunakan serta dikembangkan oleh siapa saja.

📌 GitHub Repository: BIBzzDev/xiirpl4_labib_perpustakaan

🚀 Selamat menggunakan Perpustakaan Digital! Jika ada pertanyaan, silakan hubungi saya!
