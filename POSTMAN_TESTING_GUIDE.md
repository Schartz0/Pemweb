# Panduan Testing API di Postman (Dengan Bearer Token)

## Konfigurasi Dasar

- Base URL: `http://localhost:8000`
- Semua endpoint API berada di prefix `/api/*`
- Header umum: `Accept: application/json`

## Otentikasi (Login & Logout)

### 1) Login untuk mendapatkan token

- Method: `POST`
- URL: `http://localhost:8000/api/login`
- Headers:
  - `Accept: application/json`
- Body (raw JSON):
```json
{
  "email": "admin@example.com",
  "password": "password"
}
```
- Response sukses:
```json
{
  "access_token": "<TOKEN>",
  "token_type": "Bearer"
}
```
- Simpan nilai `access_token` sebagai environment variable Postman bernama `token`.

### 2) Menggunakan token pada request berikutnya

- Tambahkan header: `Authorization: Bearer {{token}}`
- Semua endpoint mahasiswa di bawah memerlukan header ini.

### 3) Logout (menghapus token)

- Method: `POST`
- URL: `http://localhost:8000/api/logout`
- Headers:
  - `Accept: application/json`
  - `Authorization: Bearer {{token}}`
- Response sukses:
```json
{ "message": "Logged out" }
```

---

## 1. GET `/api/mahasiswa` - Mendapatkan Semua Data Mahasiswa

### Fungsi:
Menampilkan daftar semua mahasiswa yang ada di database dalam format JSON.

### Cara Testing di Postman:

1. **Method:** `GET`
2. **URL:** `http://localhost:8000/api/mahasiswa`
3. **Headers:**
   - `Accept: application/json`
   - `Authorization: Bearer {{token}}`
4. **Body:** Tidak perlu (GET request tidak perlu body)

### Contoh Response:
```json
[
    {
        "nim": "1234567890",
        "nama": "Budi Santoso",
        "semester": 3,
        "jenis_kelamin": "Laki-laki",
        "no_hp": "081234567890",
        "jurusan": "Teknik Informatika"
    },
    {
        "nim": "0987654321",
        "nama": "Siti Nurhaliza",
        "semester": 5,
        "jenis_kelamin": "Perempuan",
        "no_hp": "081987654321",
        "jurusan": "Sistem Informasi"
    }
]
```

### Status Code:
- `200 OK` - Berhasil mendapatkan data
- `500` - Error server

---

## 2. POST `/api/mahasiswa` - Menambahkan Data Mahasiswa Baru

### Fungsi:
Membuat/menambahkan data mahasiswa baru ke dalam database.

### Cara Testing di Postman:

1. **Method:** `POST`
2. **URL:** `http://localhost:8000/api/mahasiswa`
3. **Headers:**
   - `Accept: application/json`
   - `Content-Type: application/json`
   - `Authorization: Bearer {{token}}`
4. **Body** (pilih `raw` dan `JSON`):
```json
{
    "nim": "1234567890",
    "nama": "Budi Santoso",
    "semester": 3,
    "jenis_kelamin": "Laki-laki",
    "no_hp": "081234567890",
    "jurusan": "Teknik Informatika"
}
```

### Validasi:
- `nim`: Required, String, Max 15 karakter, Harus unique
- `nama`: Required, String, Max 100 karakter
- `semester`: Required, Integer
- `jenis_kelamin`: Required, Harus "Laki-laki" atau "Perempuan"
- `no_hp`: Required, String, Max 20 karakter
- `jurusan`: Required, String, Max 50 karakter

### Contoh Response Sukses:
```json
{
    "nim": "1234567890",
    "nama": "Budi Santoso",
    "semester": 3,
    "jenis_kelamin": "Laki-laki",
    "no_hp": "081234567890",
    "jurusan": "Teknik Informatika",
    "created_at": "2025-01-15T10:30:00.000000Z",
    "updated_at": "2025-01-15T10:30:00.000000Z"
}
```

### Status Code:
- `201 Created` - Data berhasil dibuat
- `422 Unprocessable Entity` - Validasi gagal (contoh: NIM sudah ada, field kosong)
- `500` - Error server

### Contoh Error Response:
```json
{
    "message": "The nim has already been taken.",
    "errors": {
        "nim": ["The nim has already been taken."]
    }
}
```

---

## 3. GET `/api/mahasiswa/{nim}` - Mendapatkan Detail Satu Mahasiswa

### Fungsi:
Menampilkan detail data mahasiswa berdasarkan NIM (Nomor Induk Mahasiswa).

### Cara Testing di Postman:

1. **Method:** `GET`
2. **URL:** `http://localhost:8000/api/mahasiswa/1234567890`
   - Ganti `1234567890` dengan NIM yang ingin dicari
3. **Headers:**
   - `Accept: application/json`
   - `Authorization: Bearer {{token}}`
4. **Body:** Tidak perlu

### Contoh Response Sukses:
```json
{
    "nim": "1234567890",
    "nama": "Budi Santoso",
    "semester": 3,
    "jenis_kelamin": "Laki-laki",
    "no_hp": "081234567890",
    "jurusan": "Teknik Informatika",
    "created_at": "2025-01-15T10:30:00.000000Z",
    "updated_at": "2025-01-15T10:30:00.000000Z"
}
```

### Status Code:
- `200 OK` - Data ditemukan
- `404 Not Found` - Data tidak ditemukan
- `500` - Error server

### Contoh Error Response:
```json
{
    "message": "Mahasiswa tidak ditemukan."
}
```

---

## 4. PUT `/api/mahasiswa/{nim}` - Mengupdate Semua Data Mahasiswa

### Fungsi:
Mengupdate/mengubah data mahasiswa secara lengkap (semua field harus diisi).

### Cara Testing di Postman:

1. **Method:** `PUT`
2. **URL:** `http://localhost:8000/api/mahasiswa/1234567890`
   - Ganti `1234567890` dengan NIM mahasiswa yang ingin diupdate
3. **Headers:**
   - `Accept: application/json`
   - `Content-Type: application/json`
   - `Authorization: Bearer {{token}}`
4. **Body** (pilih `raw` dan `JSON`):
```json
{
    "nama": "Budi Santoso Updated",
    "semester": 4,
    "jenis_kelamin": "Laki-laki",
    "no_hp": "081234567890",
    "jurusan": "Teknik Informatika"
}
```

**Catatan:** Field `nim` tidak bisa diubah, jadi tidak perlu dikirim di body.

### Validasi:
- `nama`: Required, String, Max 100 karakter
- `semester`: Required, Integer
- `jenis_kelamin`: Required, Harus "Laki-laki" atau "Perempuan"
- `no_hp`: Required, String, Max 20 karakter
- `jurusan`: Required, String, Max 50 karakter

### Contoh Response Sukses:
```json
{
    "nim": "1234567890",
    "nama": "Budi Santoso Updated",
    "semester": 4,
    "jenis_kelamin": "Laki-laki",
    "no_hp": "081234567890",
    "jurusan": "Teknik Informatika",
    "created_at": "2025-01-15T10:30:00.000000Z",
    "updated_at": "2025-01-15T10:35:00.000000Z"
}
```

### Status Code:
- `200 OK` - Data berhasil diupdate
- `404 Not Found` - Data tidak ditemukan
- `422 Unprocessable Entity` - Validasi gagal
- `500` - Error server

---

## 5. PATCH `/api/mahasiswa/{nim}` - Mengupdate Sebagian Data Mahasiswa

### Fungsi:
Mengupdate/mengubah data mahasiswa secara parsial (hanya field yang dikirim yang akan diupdate).

### Cara Testing di Postman:

1. **Method:** `PATCH`
2. **URL:** `http://localhost:8000/api/mahasiswa/1234567890`
   - Ganti `1234567890` dengan NIM mahasiswa yang ingin diupdate
3. **Headers:**
   - `Accept: application/json`
   - `Content-Type: application/json`
   - `Authorization: Bearer {{token}}`
4. **Body** (pilih `raw` dan `JSON`):
```json
{
    "semester": 5
}
```

**Contoh lain - hanya update nama:**
```json
{
    "nama": "Nama Baru"
}
```

**Contoh - update beberapa field:**
```json
{
    "nama": "Nama Baru",
    "no_hp": "081999999999",
    "jurusan": "Sistem Informasi"
}
```

### Validasi:
- Semua field optional (karena menggunakan `sometimes`)
- Jika field dikirim, harus sesuai validasi:
  - `nama`: String, Max 100 karakter
  - `semester`: Integer
  - `jenis_kelamin`: Harus "Laki-laki" atau "Perempuan"
  - `no_hp`: String, Max 20 karakter
  - `jurusan`: String, Max 50 karakter

### Contoh Response Sukses:
```json
{
    "nim": "1234567890",
    "nama": "Budi Santoso",
    "semester": 5,
    "jenis_kelamin": "Laki-laki",
    "no_hp": "081234567890",
    "jurusan": "Teknik Informatika",
    "created_at": "2025-01-15T10:30:00.000000Z",
    "updated_at": "2025-01-15T10:40:00.000000Z"
}
```

### Status Code:
- `200 OK` - Data berhasil diupdate
- `404 Not Found` - Data tidak ditemukan
- `422 Unprocessable Entity` - Validasi gagal
- `500` - Error server

### Perbedaan PUT vs PATCH:
- **PUT**: Harus mengirim semua field (kecuali nim)
- **PATCH**: Bisa mengirim hanya field yang ingin diubah

---

## 6. DELETE `/api/mahasiswa/{nim}` - Menghapus Data Mahasiswa

### Fungsi:
Menghapus data mahasiswa dari database berdasarkan NIM.

### Cara Testing di Postman:

1. **Method:** `DELETE`
2. **URL:** `http://localhost:8000/api/mahasiswa/1234567890`
   - Ganti `1234567890` dengan NIM mahasiswa yang ingin dihapus
3. **Headers:**
   - `Accept: application/json`
   - `Authorization: Bearer {{token}}`
4. **Body:** Tidak perlu

### Contoh Response Sukses:
```json
{
    "message": "Mahasiswa deleted successfully"
}
```

### Status Code:
- `200 OK` - Data berhasil dihapus
- `404 Not Found` - Data tidak ditemukan
- `500` - Error server

### Contoh Error Response:
```json
{
    "message": "Mahasiswa tidak ditemukan."
}
```

**⚠️ PERINGATAN:** Setelah dihapus, data tidak bisa dikembalikan!

---

## Tips Testing di Postman

### 1. Membuat Collection
- Buat collection baru dengan nama "Mahasiswa API"
- Simpan semua request di collection untuk memudahkan testing

### 2. Menggunakan Environment Variables
Buat environment dengan variabel:
- `base_url`: `http://localhost:8000`
- `token`: diisi dari response login (`access_token`)
- `nim`: `1234567890` (contoh NIM untuk testing)

Kemudian gunakan di URL: `{{base_url}}/api/mahasiswa/{{nim}}`

### 3. Testing Workflow yang Disarankan
1. **POST** - Buat data baru
2. **GET** - Verifikasi data berhasil dibuat
3. **GET (semua)** - Lihat semua data
4. **PATCH** - Update sebagian data
5. **GET** - Verifikasi data terupdate
6. **PUT** - Update semua data
7. **GET** - Verifikasi data terupdate
8. **DELETE** - Hapus data
9. **GET** - Verifikasi data sudah terhapus (harus 404)

### 4. Menambahkan Authorization otomatis
- Cara mudah: di tab Authorization pilih `Bearer Token`, isi dengan `{{token}}`.
- Atau gunakan header manual: `Authorization: Bearer {{token}}`.

### 5. Menggunakan Tests Script
Untuk auto-verifikasi response:
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Response has nim field", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('nim');
});
```

---

## Troubleshooting

### Error: "Route not found"
- Pastikan server Laravel sedang berjalan (`php artisan serve`)
- Pastikan URL sudah benar (termasuk `/api/` prefix)
- Pastikan method HTTP sudah benar (GET, POST, PUT, PATCH, DELETE)

### Error: "401 Unauthorized"
- Pastikan sudah login dan menyimpan `access_token`.
- Pastikan setiap request menyertakan header `Authorization: Bearer {{token}}`.
- Jika token kedaluwarsa atau telah logout, login kembali untuk token baru.

### Error: "404 Not Found" saat GET detail
- Pastikan NIM yang digunakan sudah ada di database
- Cek dulu dengan GET semua data untuk melihat NIM yang tersedia

### Error: "422 Unprocessable Entity"
- Cek validasi field yang dikirim
- Pastikan semua required field sudah diisi
- Pastikan format data sudah benar (integer untuk semester, dll)
