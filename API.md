# Dokumentasi REST API - Perpustakaan Digital Kampus

Dokumen ini berisi daftar alamat (endpoint) REST API Pertemuan 9 yang digunakan untuk mengelola data perpustakaan.

### Catatan Penggunaan API:
* **Alamat Utama (Base URL):** `http://127.0.0.1:8000/api`
* **Format Balasan:** Aplikasi akan selalu membalas dalam format data JSON (masukkan header `Accept: application/json` di Thunder Client/Postman).
* **Format Pengiriman Data:** Saat menambah atau mengubah data (POST/PUT), gunakan format JSON (header `Content-Type: application/json`).
* **Keamanan:** Seluruh endpoint API saat ini bersifat publik (belum memerlukan token/login).
* **Pembagian Halaman (Pagination):** Setiap daftar data (buku, anggota, peminjaman) dibatasi 10 data per halaman. Gunakan parameter `?page=2` untuk berpindah halaman.
---

## Ringkasan Endpoint

| No | Method | URL | Body (jika ada) | Status Sukses | Status Gagal |
|----|--------|-----|-----------------|---------------|--------------|
| 1 | GET | `/api/books` | - (query opsional: `judul`, `category_id`, `page`) | 200 | - |
| 2 | GET | `/api/books/{id}` | - | 200 | 404 |
| 3 | POST | `/api/books` | `judul`, `penulis`, `penerbit`, `tahun_terbit`, `isbn`, `stok`, `category_id` | 201 | 422 |
| 4 | PUT | `/api/books/{id}` | sama seperti POST `/api/books` | 200 | 404, 422 |
| 5 | DELETE | `/api/books/{id}` | - | 200 | 404 |
| 6 | GET | `/api/members` | - (query opsional: `page`) | 200 | - |
| 7 | GET | `/api/members/{id}` | - | 200 | 404 |
| 8 | GET | `/api/loans` | - (query opsional: `page`) | 200 | - |
| 9 | POST | `/api/loans` | `member_id`, `user_id`, `tanggal_pinjam`, `tanggal_kembali`, `book_ids[]` | 201 | 422 |
| 10 | PUT | `/api/loans/{id}/kembalikan` | - | 200 | 404 |
| 11 | GET | `/api/stats` | - | 200 | - |

### Arti Status Code

| Kode | Arti |
|------|------|
| 200 | OK - request berhasil |
| 201 | Created - data baru berhasil dibuat |
| 404 | Not Found - data dengan id tersebut tidak ada |
| 422 | Unprocessable Entity - data yang dikirim gagal validasi |

---

## 1. GET /api/books

Menampilkan daftar buku (10 per halaman) beserta kategorinya.

**Query string (opsional):**

| Parameter | Keterangan |
|-----------|------------|
| `judul` | Pencarian sebagian judul (LIKE), contoh `?judul=laskar` |
| `category_id` | Filter kategori, contoh `?category_id=2` |
| `page` | Nomor halaman |

**Response 200:**

```json
{
    "data": [
        {
            "id": 1,
            "judul": "Laskar Pelangi",
            "penulis": "Andrea Hirata",
            "penerbit": "Bentang Pustaka",
            "tahun_terbit": 2005,
            "isbn": "978-979-3062-79-2",
            "stok": 5,
            "sampul": null,
            "category": {
                "id": 1,
                "nama_kategori": "Novel"
            },
            "created_at": "2026-10-29T00:00:00.000000Z",
            "updated_at": "2026-10-29T00:00:00.000000Z"
        }
    ],
    "links": {
        "first": "[http://127.0.0.1:8000/api/books?page=1](http://127.0.0.1:8000/api/books?page=1)",
        "last": "[http://127.0.0.1:8000/api/books?page=1](http://127.0.0.1:8000/api/books?page=1)",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}