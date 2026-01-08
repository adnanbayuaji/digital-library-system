# Panduan Import Database

## Cara Import Database Digital Library System

### Metode 1: Menggunakan phpMyAdmin (Paling Mudah)

1. **Buka phpMyAdmin** di browser: `http://localhost/phpmyadmin`

2. **Buat Database Baru:**
   - Klik tab "Databases"
   - Ketik nama: `digital_library`
   - Klik "Create"

3. **Import Schema:**
   - Pilih database `digital_library` di panel kiri
   - Klik tab "Import"
   - Klik "Choose File" dan pilih `schema.sql`
   - Klik "Go"

4. **Import Dummy Data (Opsional):**
   - Masih di tab "Import"
   - Klik "Choose File" dan pilih `dummy_data.sql`
   - Klik "Go"

### Metode 2: Menggunakan MySQL Command Line

```bash
# Masuk ke MySQL
mysql -u root -p

# Buat database
CREATE DATABASE digital_library;
USE digital_library;

# Import schema
SOURCE d:/xampp/htdocs/digital-library-system/database/schema.sql;

# Import dummy data (opsional)
SOURCE d:/xampp/htdocs/digital-library-system/database/dummy_data.sql;

# Keluar
EXIT;
```

### Metode 3: Import Sekaligus (File Lengkap)

Gunakan file `import.sql` yang sudah mencakup semua:

```bash
mysql -u root -p < d:/xampp/htdocs/digital-library-system/database/import.sql
```

## Troubleshooting

### Error: "Table already exists"
**Solusi:** Drop database dulu, lalu buat ulang
```sql
DROP DATABASE digital_library;
CREATE DATABASE digital_library;
```

### Error: "Foreign key constraint fails"
**Solusi:** Import file dengan urutan yang benar:
1. `schema.sql` dulu
2. `dummy_data.sql` kedua

### Error: "Cannot add or update a child row"
**Solusi:** Pastikan tabel users sudah ada admin user (ID 1) sebelum import dummy_data.sql

### Error: "Duplicate entry"
**Solusi:** Database sudah berisi data. Pilih salah satu:
- Drop database dan import ulang
- Gunakan `TRUNCATE TABLE` untuk kosongkan tabel

## Verifikasi Import Berhasil

Jalankan query ini di phpMyAdmin atau MySQL CLI:

```sql
-- Cek jumlah data
SELECT COUNT(*) as total_users FROM users;
SELECT COUNT(*) as total_books FROM books;
SELECT COUNT(*) as total_visitors FROM visitors;
SELECT COUNT(*) as total_borrowings FROM borrowed_books;

-- Cek admin user
SELECT * FROM users WHERE role = 'admin';
```

## Login Credentials Setelah Import

### Admin:
- **Username:** admin
- **Password:** admin123

### User Pengunjung (dari dummy data):
- **Username:** budi_santoso, siti_rahma, ahmad_fauzi, dewi_lestari, rudi_hartono
- **Password:** password123

## Catatan Penting

- File `dummy_data.sql` sudah diperbaiki untuk mengatasi masalah foreign key
- Sekarang menggunakan subquery untuk mencari user_id berdasarkan username
- Lebih aman dan tidak bergantung pada auto-increment ID

## Reset Database (Hapus Semua Data)

Jika ingin mulai dari awal:

```sql
DROP DATABASE digital_library;
CREATE DATABASE digital_library;
USE digital_library;
SOURCE schema.sql;
SOURCE dummy_data.sql;
```
