# Dokumentasi REST API - Perpustakaan Digital Kampus

Dokumen ini berisi daftar alamat (endpoint) REST API Pertemuan 9 dan 10 yang digunakan untuk mengelola data perpustakaan.

### Catatan Penggunaan API:
- **Alamat Utama (Base URL):** `http://127.0.0.1:8000/api`
- **Format Balasan:** Aplikasi akan selalu membalas dalam format data JSON (masukkan header `Accept: application/json` di Thunder Client/Postman).
- **Format Pengiriman Data:** Saat menambah atau mengubah data (POST/PUT), gunakan format JSON (header `Content-Type: application/json`).
- **Keamanan:** Seluruh endpoint API saat ini bersifat publik (belum memerlukan token/login).
- **Pembagian Halaman (Pagination):** Setiap daftar data (buku, anggota, peminjaman) dibatasi 10 data per halaman. Gunakan parameter `?page=2` untuk berpindah halaman.

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

```

---

## 2. GET /api/books/{id}

Menampilkan detail satu data buku berdasarkan ID.

**Response 200 OK:**

```json
{
  "data": {
    "id": 1,
    "judul": "Laskar Pelangi",
    "penulis": "Andrea Hirata",
    "penerbit": "Bentang Pustaka",
    "tahun_terbit": 2005,
    "isbn": "978-979-3062-79-2",
    "stok": 5,
    "category": {
      "id": 1,
      "nama_kategori": "Novel"
    }
  }
}

```

**Response 404 Not Found:**

```json
{
  "message": "Resource not found."
}

```

---

## 3. POST /api/books

Menambahkan data buku baru.

**Request Body (JSON):**

```json
{
  "judul": "Pemrograman Web Modern",
  "penulis": "Ahmad",
  "penerbit": "PENS Press",
  "tahun_terbit": 2024,
  "isbn": "978-602-1234-56-7",
  "stok": 10,
  "category_id": 4
}

```

**Response 201 Created:**

```json
{
  "message": "Buku berhasil ditambahkan.",
  "data": {
    "id": 21,
    "judul": "Pemrograman Web Modern",
    "penulis": "Ahmad",
    "penerbit": "PENS Press",
    "tahun_terbit": 2024,
    "isbn": "978-602-1234-56-7",
    "stok": 10,
    "category_id": 4
  }
}

```

**Response 422 Unprocessable Entity:**

```json
{
  "message": "The judul field is required.",
  "errors": {
    "judul": [
      "Judul buku wajib diisi."
    ]
  }
}

```

---

## 4. PUT /api/books/{id}

Mengubah data buku yang sudah ada.

**Request Body (JSON):**

```json
{
  "judul": "Pemrograman Web Modern (Edisi Revisi)",
  "penulis": "Ahmad",
  "penerbit": "PENS Press",
  "tahun_terbit": 2025,
  "isbn": "978-602-1234-56-7",
  "stok": 15,
  "category_id": 4
}

```

**Response 200 OK:**

```json
{
  "message": "Buku berhasil diperbarui.",
  "data": {
    "id": 21,
    "judul": "Pemrograman Web Modern (Edisi Revisi)",
    "stok": 15
  }
}

```

---

## 5. DELETE /api/books/{id}

Menghapus data buku berdasarkan ID.

**Response 200 OK:**

```json
{
  "message": "Buku berhasil dihapus."
}

```

**Response 404 Not Found:**

```json
{
  "message": "Resource not found."
}

```

---

## 6. GET /api/members

Menampilkan daftar anggota perpustakaan (10 per halaman).

**Query string (opsional):**

| Parameter | Keterangan |
| --- | --- |
| `page` | Nomor halaman |

**Response 200 OK:**

```json
{
  "data": [
    {
      "id": 1,
      "nama": "Budi Santoso",
      "nim": "3125600001",
      "email": "budi.santoso@pens.ac.id",
      "nomor_telepon": "081234567890",
      "status": "aktif"
    }
  ],
  "links": {
    "first": "[http://127.0.0.1:8000/api/members?page=1](http://127.0.0.1:8000/api/members?page=1)",
    "last": "[http://127.0.0.1:8000/api/members?page=2](http://127.0.0.1:8000/api/members?page=2)",
    "prev": null,
    "next": "[http://127.0.0.1:8000/api/members?page=2](http://127.0.0.1:8000/api/members?page=2)"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 2,
    "per_page": 10,
    "to": 10,
    "total": 15
  }
}

```

---

## 7. GET /api/members/{id}

Menampilkan detail data anggota berdasarkan ID.

**Response 200 OK:**

```json
{
  "data": {
    "id": 1,
    "nama": "Budi Santoso",
    "nim": "3125600001",
    "email": "budi.santoso@pens.ac.id",
    "nomor_telepon": "081234567890",
    "status": "aktif"
  }
}

```

**Response 404 Not Found:**

```json
{
  "message": "Resource not found."
}

```

---

## 8. GET /api/loans

Menampilkan daftar transaksi peminjaman buku beserta relasinya (anggota, petugas, dan buku yang dipinjam).

**Query string (opsional):**

| Parameter | Keterangan |
| --- | --- |
| `page` | Nomor halaman |

**Response 200 OK:**

```json
{
  "data": [
    {
      "id": 1,
      "tanggal_pinjam": "2026-11-01",
      "tanggal_kembali": "2026-11-08",
      "tanggal_dikembalikan": null,
      "status": "dipinjam",
      "member": {
        "id": 1,
        "nama": "Budi Santoso"
      },
      "petugas": {
        "id": 2,
        "name": "Siti Rahmawati"
      },
      "books": [
        {
          "id": 1,
          "judul": "Laskar Pelangi"
        }
      ]
    }
  ],
  "links": {
    "first": "[http://127.0.0.1:8000/api/loans?page=1](http://127.0.0.1:8000/api/loans?page=1)",
    "last": "[http://127.0.0.1:8000/api/loans?page=1](http://127.0.0.1:8000/api/loans?page=1)",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 10,
    "total": 10
  }
}

```

---

## 9. POST /api/loans

Membuat transaksi peminjaman buku baru.

**Request Body (JSON):**

```json
{
  "member_id": 1,
  "user_id": 2,
  "tanggal_pinjam": "2026-11-01",
  "tanggal_kembali": "2026-11-08",
  "book_ids": [1, 3]
}

```

**Response 201 Created:**

```json
{
  "message": "Peminjaman berhasil dibuat.",
  "data": {
    "id": 11,
    "member_id": 1,
    "user_id": 2,
    "tanggal_pinjam": "2026-11-01",
    "tanggal_kembali": "2026-11-08",
    "status": "dipinjam"
  }
}

```

**Response 422 Unprocessable Entity:**

```json
{
  "message": "The member_id field is required.",
  "errors": {
    "member_id": [
      "Pilih anggota peminjam."
    ]
  }
}

```

---

## 10. PUT /api/loans/{id}/kembalikan

Mengubah status peminjaman menjadi `dikembalikan` dan mengisi tanggal dikembalikan.

**Response 200 OK:**

```json
{
  "message": "Buku berhasil dikembalikan.",
  "data": {
    "id": 11,
    "status": "dikembalikan",
    "tanggal_dikembalikan": "2026-11-05"
  }
}

```

**Response 404 Not Found:**

```json
{
  "message": "Resource not found."
}

```

---

## 11. GET /api/stats

Mengambil angka ringkasan statistik perpustakaan untuk dikonsumsi oleh Dashboard.

**Response 200 OK:**

```json
{
  "total_buku": 20,
  "total_anggota": 15,
  "peminjaman_aktif": 4
}
```