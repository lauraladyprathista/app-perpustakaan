# Skenario Demo Aplikasi Perpustakaan Digital Kampus

Dokumen ini berisi urutan langkah demo fungsionalitas sistem perpustakaan untuk persiapan evaluasi / UAS.

---

## Urutan Skenario Demo

### 1. Persiapan Server & Database
* Pastikan database sudah terisi data dummy terbaru:
  `php artisan migrate:fresh --seed`
* Nyalakan dua instance server di dua terminal berbeda:
  * **Terminal 1 (Server Utama Web):** `php artisan serve --port=8000`
  * **Terminal 2 (Server API Internal):** `php artisan serve --port=8011`

---

### 2. Autentikasi (Login & Access Control)
1. Buka browser di `http://127.0.0.1:8000/login`.
2. Login sebagai **Admin**:
   * **Email:** `admin@pens.ac.id`
   * **Password:** `password`
3. Verifikasi bahwa sistem melakukan redirect otomatis ke **Dashboard** (`/`) dan menampilkan nama **Bambang Sutrisno (Admin)** di navbar.

---

### 3. Tampilan Dashboard (`/`)
1. Amati 3 kartu statistik: **Total Buku**, **Total Anggota**, dan **Peminjaman Aktif**.
2. Verifikasi bahwa angka statistik berhasil diambil dari API internal (`GET /api/stats`).

---

### 4. Kelola Kategori (Khusus Admin)
1. Klik menu **Kategori** (`/categories`).
2. Tambahkan kategori baru (misal: `Sastra`).
3. Verifikasi pesan sukses dan pastikan data baru muncul di tabel.

---

### 5. Kelola Buku (`/books`)
1. Klik menu **Buku** (`/books`).
2. Klik tombol **+ Tambah Buku**, isi form buku baru dengan memilih kategori yang sesuai.
3. Simpan data dan verifikasi bahwa buku baru muncul di daftar.
4. Tes pagination di bagian bawah tabel (`« Sebelumnya 1 2 Berikutnya »`).

---

### 6. Kelola Anggota (`/members`)
1. Klik menu **Anggota** (`/members`).
2. Klik **+ Tambah Anggota**, isi data mahasiswa dengan nama dan email domain kampus (`@pens.ac.id`).
3. Simpan dan cek data anggota baru di tabel.

---

### 7. Transaksi Peminjaman (`/loans`)
1. Klik menu **Peminjaman** (`/loans`).
2. Klik **+ Tambah Peminjaman**, pilih Anggota, Petugas, serta satu atau beberapa Buku.
3. Klik simpan. Verifikasi status peminjaman bernilai **Dipinjam**.
4. Cek kembali halaman **Dashboard** (`/`) untuk memastikan indikator *Peminjaman Aktif* bertambah.

---

### 8. Proses Pengembalian Buku
1. Pada daftar peminjaman aktif, klik tombol **Kembalikan**.
2. Verifikasi status transaksi berubah menjadi **Dikembalikan** dan tanggal dikembalikan terisi tanggal hari ini.

---

### 9. Laporan Peminjaman (`/loans/report`)
1. Klik menu **Laporan** (`/loans/report`).
2. Verifikasi bahwa data riwayat transaksi berhasil dikonsumsi dari API internal (`GET /api/loans`) dan ditampilkan rapi lengkap dengan navigasi halaman.

---

### 10. Pengujian API via Extension REST Client / Postman
1. Buka extension **Thunder Client** ⚡ di VS Code atau Postman.
2. Pengujian `GET /api/books` dengan Header `Accept: application/json`.
3. Pengujian `GET /api/stats` untuk melihat response JSON statistik.
4. Pengujian `POST /api/loans` untuk menguji pembuatan transaksi via REST API.