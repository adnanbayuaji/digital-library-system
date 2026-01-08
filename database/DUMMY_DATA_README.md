# Data Dummy - Digital Library System

## Cara Import Data

### 1. Import Schema Database
```sql
-- Jalankan file ini terlebih dahulu
source database/schema.sql
```

### 2. Import Data Dummy
```sql
-- Setelah schema berhasil, jalankan file ini
source database/dummy_data.sql
```

**Atau melalui phpMyAdmin:**
1. Buka phpMyAdmin
2. Pilih database `digital_library`
3. Klik tab "Import"
4. Upload file `schema.sql` terlebih dahulu
5. Kemudian upload file `dummy_data.sql`

---

## Kredensial Login

### Admin Account
- **Username**: `admin`
- **Password**: `admin123`
- **Role**: Administrator
- **Email**: admin@library.com

### Pengunjung Accounts
Semua akun pengunjung menggunakan password yang sama: **`password123`**

| Username | Email | Nama Lengkap | Telepon |
|----------|-------|--------------|---------|
| budi_santoso | budi.santoso@email.com | Budi Santoso | 081234567891 |
| siti_rahma | siti.rahma@email.com | Siti Rahmawati | 081234567892 |
| ahmad_fauzi | ahmad.fauzi@email.com | Ahmad Fauzi | 081234567893 |
| dewi_lestari | dewi.lestari@email.com | Dewi Lestari | 081234567894 |
| rudi_hartono | rudi.hartono@email.com | Rudi Hartono | 081234567895 |

---

## Data yang Diinsert

### 📚 Books (20 Buku)
- **5 Novel Indonesia**: Laskar Pelangi, Bumi Manusia, Ayat-Ayat Cinta, Perahu Kertas, Negeri 5 Menara
- **5 Novel Dunia**: Harry Potter, The Hobbit, 1984, To Kill a Mockingbird, The Great Gatsby
- **5 Non-Fiksi**: Sejarah Indonesia, Ilmu Komputer, Ekonomi Makro, Filsafat Ilmu, Psikologi Pendidikan
- **5 Teknologi**: Clean Code, Python for Data Science, Design Patterns, Pragmatic Programmer, JavaScript

### 👥 Users (6 Users)
- 1 Admin
- 5 Pengunjung

### 📝 Visitor Logs (20 Entries)
Data kunjungan dari Januari 2024 - April 2024

### 📖 Borrowed Books (19 Transaksi)
- **11 Peminjaman sudah dikembalikan** (return_date terisi)
- **8 Peminjaman masih aktif** (return_date NULL)

#### Peminjaman Aktif (Belum Dikembalikan):
| Username | Buku yang Dipinjam | Tanggal Pinjam |
|----------|-------------------|----------------|
| budi_santoso | Bumi Manusia | 15 Des 2025 |
| siti_rahma | The Hobbit | 20 Des 2025 |
| ahmad_fauzi | To Kill a Mockingbird | 22 Des 2025 |
| dewi_lestari | The Great Gatsby | 28 Des 2025 |
| rudi_hartono | Filsafat Ilmu | 2 Jan 2026 |
| budi_santoso | Psikologi Pendidikan | 3 Jan 2026 |
| siti_rahma | Python for Data Science | 5 Jan 2026 |
| ahmad_fauzi | Design Patterns | 6 Jan 2026 |

---

## Testing

### Test Login Admin
1. Akses: http://localhost/digital-library-system/
2. Login dengan username: `admin` password: `admin123`
3. Akan redirect ke dashboard admin
4. Menu yang tersedia:
   - Dashboard
   - Kelola Buku
   - Data Pengunjung
   - Laporan

### Test Login Pengunjung
1. Akses: http://localhost/digital-library-system/
2. Login dengan username: `budi_santoso` password: `password123`
3. Akan redirect ke dashboard pengunjung
4. Menu yang tersedia:
   - Dashboard
   - Katalog Buku
   - Catat Kunjungan

### Test Fitur Buku
- View semua buku di katalog
- Tambah buku baru (admin only)
- Edit buku (admin only)
- Delete buku (admin only)
- View detail buku

### Test Fitur Pengunjung
- Log kunjungan baru
- View data pengunjung (admin only)

### Test Fitur Laporan
- View laporan buku terbaru
- View laporan pengunjung terbaru
- (Admin only)

---

## Status Stok Buku Setelah Import

Buku dengan stok berkurang karena sedang dipinjam:
- Bumi Manusia: 2/4 (1 dipinjam)
- The Hobbit: 2/3 (1 dipinjam)
- To Kill a Mockingbird: 2/3 (1 dipinjam)
- The Great Gatsby: 3/4 (1 dipinjam)
- Filsafat Ilmu: 3/4 (1 dipinjam)
- Psikologi Pendidikan: 4/5 (1 dipinjam)
- Python for Data Science: 2/3 (1 dipinjam)
- Design Patterns: 2/3 (1 dipinjam)

---

## Notes

- Semua password user menggunakan bcrypt hashing
- Data tanggal dibuat realistis dengan range waktu yang berbeda
- Peminjaman yang sudah dikembalikan memiliki return_date
- Peminjaman aktif memiliki return_date NULL
- Available_copies otomatis dikurangi untuk buku yang sedang dipinjam
