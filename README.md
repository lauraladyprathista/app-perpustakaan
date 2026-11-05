# Aplikasi Praktikum Web Laravel

Aplikasi ini merupakan proyek berbasis framework Laravel yang bertujuan untuk mempelajari konsep dasar pengembangan web modern, seperti routing, controller, view, dan struktur MVC. Aplikasi ini digunakan sebagai media latihan praktikum dalam membangun aplikasi web yang modular dan terstruktur.

Studi kasus yang dibangun selama praktikum adalah **Perpustakaan Digital Kampus**: aplikasi manajemen buku, kategori, anggota, dan peminjaman, lengkap dengan autentikasi berbasis peran, REST API, serta dashboard dan laporan yang mengonsumsi API milik aplikasi sendiri.

<!--
Penjelasan Perbedaan Model, View, dan Controller (MVC):
Model bertanggung jawab mengelola logika data dan interaksi dengan database. View bertugas menampilkan antarmuka dan format tampilan informasi kepada pengguna. Controller bertindak sebagai jembatan yang menerima permintaan pengguna, memproses logika aplikasi melalui Model, lalu menentukan View mana yang harus ditampilkan.
-->

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

---

# Perpustakaan Digital Kampus

## Fitur Utama

- Autentikasi petugas (login/logout) dengan dua peran: **admin** dan **petugas**
- CRUD **Buku** (dengan kategori, pencarian, dan pagination)
- CRUD **Kategori** (khusus admin)
- CRUD **Anggota**
- **Peminjaman** multi-buku dan proses pengembalian
- **Dashboard** statistik (diambil dari `GET /api/stats`)
- **Laporan Peminjaman** (diambil dari `GET /api/loans`)
- **REST API** untuk books, members, loans, dan stats (lihat [`API.md`](API.md))
- Seeder dan Factory dengan data dummy bergaya Indonesia

## Teknologi

- PHP 8.2+
- Laravel 12
- SQLite / MySQL
- Composer
- Thunder Client / Postman (untuk pengujian API)

## Prasyarat

Pastikan sudah terpasang:
- PHP 8.2 atau lebih baru
- Composer
- Git

## Cara Instalasi & Konfigurasi awal

### 1. Clone Repository
```bash
git clone [https://github.com/lauraladyprathista/app-perpustakaan.git](https://github.com/lauraladyprathista/app-perpustakaan.git)
cd app-perpustakaan

```

### 2. Install Dependency

```bash
composer install

```

### 3. Salin File Environment

```bash
cp .env.example .env

```

### 4. Generate Application Key

```bash
php artisan key:generate

```

### 5. Konfigurasi `.env`

Pastikan variabel berikut disesuaikan di file `.env`:

```env
# Locale Faker untuk data dummy bergaya Indonesia
APP_FAKER_LOCALE=id_ID

# Base URL instance kedua `php artisan serve` khusus panggilan API internal
# (dipakai Dashboard dan Laporan). Wajib port berbeda dari server utama.
INTERNAL_API_URL=[http://127.0.0.1:8011](http://127.0.0.1:8011)

```

### 6. Migrasi & isi Data Dummy

```bash
php artisan migrate:fresh --seed

```

Perintah ini membuat seluruh tabel lalu mengisi: 3 user, 5 kategori, 20 buku, 15 anggota, dan 10 transaksi peminjaman.

---

## Menjalankan Aplikasi (Wajib 2 Server)

Aplikasi ini membutuhkan **dua server** berjalan bersamaan, jadi buka **dua terminal**:

- **Terminal 1 - Server utama (untuk browser):**
```bash
php artisan serve --port=8000

```


*Akses di browser:* `http://127.0.0.1:8000`
- **Terminal 2 - Server khusus API internal:**
```bash
php artisan serve --port=8011

```



### Kenapa Harus Dua Server?

`php artisan serve` hanya memproses satu request pada satu waktu (*single-threaded*). Dashboard dan Laporan memanggil API milik aplikasi sendiri lewat HTTP Client. Jika memakai satu server, request pertama menunggu balasan dari request kedua yang tidak pernah bisa diproses (*deadlock*). Dengan dua server di port berbeda, keduanya tidak saling mengunci.

Jika server kedua tidak menyala, Dashboard menampilkan angka `0` dan Laporan menampilkan tabel kosong tanpa error 500 karena dilindungi `try/catch ConnectionException`.

---

## Akun Demo Default

| Peran | Email | Password |
| --- | --- | --- |
| Admin | `admin@pens.ac.id` | `password` |
| Petugas 1 | `petugas1@pens.ac.id` | `password` |
| Petugas 2 | `petugas2@pens.ac.id` | `password` |

---

## Ringkasan REST API

Base URL: `http://127.0.0.1:8000/api`

| Method | URL | Keterangan |
| --- | --- | --- |
| GET | `/api/books` | Daftar buku (filter `judul`, `category_id`) |
| GET | `/api/books/{id}` | Detail buku |
| POST | `/api/books` | Tambah buku |
| PUT | `/api/books/{id}` | Ubah buku |
| DELETE | `/api/books/{id}` | Hapus buku |
| GET | `/api/members` | Daftar anggota |
| GET | `/api/members/{id}` | Detail anggota |
| GET | `/api/loans` | Daftar peminjaman |
| POST | `/api/loans` | Buat peminjaman |
| PUT | `/api/loans/{id}/kembalikan` | Proses pengembalian |
| GET | `/api/stats` | Statistik ringkas |

Dokumentasi lengkap beserta contoh request dan response ada di [`API.md`](API.md). Gunakan header `Accept: application/json` pada setiap request.

---

## Skenario Demo UAS

Petunjuk langkah-langkah demo aplikasi untuk evaluasi/UAS ada di [`DEMO.md`](DEMO.md).

---

## Struktur Penting

```text
app/Http/Controllers/          Controller web (Auth, Book, Category, Member, Loan, Dashboard)
app/Http/Controllers/Api/      Controller REST API
app/Http/Resources/            API Resource (BookResource, MemberResource, LoanResource)
database/factories/            Factory (BookFactory, MemberFactory)
database/seeders/              Seeder (User, Category, Book, Member, Loan)
resources/views/                Blade template
resources/views/vendor/pagination/custom.blade.php    View pagination custom
routes/web.php                  Route web
routes/api.php                  Route API
config/services.php            Konfigurasi internal_api

```
