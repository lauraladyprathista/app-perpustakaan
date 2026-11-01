# Aplikasi Perpustakaan Digital Kampus (`app-perpustakaan`)

Aplikasi manajemen perpustakaan berbasis **Laravel 12** yang dilengkapi dengan REST API Resource, Konsumsi API Internal, dan Autentikasi Berbasis Role.

---

## Syarat Lingkungan (Prerequisites)
* **PHP:** >= 8.2
* **Composer**
* **SQLite / MySQL**

---

## Cara Instalasi & Konfigurasi Awal

1. **Clone Repository & Install Dependencies:**
   `git clone https://github.com/lauraladyprathista/app-perpustakaan.git`
   `cd app-perpustakaan`
   `composer install`

2. **Setup Konfigurasi Environment (`.env`):**
   `cp .env.example .env`
   `php artisan key:generate`
   
   Pastikan variabel berikut sudah disesuaikan di file `.env`:
   * `INTERNAL_API_URL=http://127.0.0.1:8011`
   * `APP_FAKER_LOCALE=id_ID`

3. **Migrasi Database & Seeding Data:**
   `php artisan migrate:fresh --seed`

---

## Cara Menjalankan Aplikasi (Wajib 2 Server)

Aplikasi ini menggunakan Laravel HTTP Client untuk mengonsumsi REST API internalnya sendiri. Karena server `php artisan serve` standar bersifat *single-threaded*, **wajib menjalankan 2 instance server di dua terminal berbeda**:

1. **Terminal 1 (Server Utama Aplikasi Web):**
   `php artisan serve --port=8000`
   *Akses di browser:* `http://127.0.0.1:8000`

2. **Terminal 2 (Server Khusus API Internal):**
   `php artisan serve --port=8011`

---

## Akun Demo Default

* **Admin:** `admin@pens.ac.id` | Password: `password`
* **Petugas 1:** `petugas1@pens.ac.id` | Password: `password`
* **Petugas 2:** `petugas2@pens.ac.id` | Password: `password`