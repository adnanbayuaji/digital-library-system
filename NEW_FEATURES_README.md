# Fitur Baru - Digital Library System

## Update Terbaru

### 1. ✅ Fitur Peminjaman dan Pengembalian Buku (Admin)

**Lokasi File:**
- `/public/borrowings/index.php` - Daftar peminjaman
- `/public/borrowings/borrow.php` - Form peminjaman buku
- `/public/borrowings/return.php` - Proses pengembalian buku
- `/src/Models/Borrowing.php` - Model untuk manajemen peminjaman

**Fitur:**
- Admin dapat mencatat peminjaman buku untuk pengguna
- Pilih peminjam dari daftar pengguna terdaftar
- Pilih buku yang tersedia (stok > 0)
- Set tanggal jatuh tempo (default 7 hari)
- Otomatis update stok buku saat dipinjam/dikembalikan
- Status peminjaman: Borrowed, Returned, Overdue
- Statistik peminjaman (aktif, terlambat, dikembalikan)
- Filter daftar peminjaman (aktif/semua)
- Auto-update status overdue berdasarkan tanggal jatuh tempo

**Akses:**
- Admin: Full access untuk pinjam dan kembalikan buku
- Sidebar menu: "Peminjaman" / "Borrowings"

---

### 2. ✅ Field Asal Buku (Book Source)

**Lokasi File:**
- `/database/migration_add_features.sql` - Migration untuk field baru
- `/src/Models/Book.php` - Model dengan field source dan description
- `/public/books/add.php` - Form tambah buku dengan field source
- `/public/books/edit.php` - Form edit buku dengan field source

**Field Baru di Tabel Books:**
- `source` (VARCHAR 100) - Asal/sumber buku (Hibah, Pembelian, Donasi, dll)
- `description` (TEXT) - Deskripsi atau ringkasan buku

**Cara Menggunakan:**
1. Import migration file: `database/migration_add_features.sql`
2. Field "Asal Buku" dan "Deskripsi" akan muncul di form tambah/edit buku
3. Data source membantu tracking dari mana buku diperoleh

---

### 3. ✅ Catat Kunjungan Tanpa Login

**Lokasi File:**
- `/public/visitor_log_public.php` - Halaman public untuk catat kunjungan
- `/public/index.php` - Updated redirect ke visitor log

**Fitur:**
- Akses tanpa perlu login
- Form sederhana: Nama dan Tujuan Kunjungan
- Language switcher tersedia
- Responsive design dengan gradient theme
- Link ke halaman login untuk staf perpustakaan

**Akses:**
- URL: `http://localhost/digital-library-system/` atau `http://localhost/digital-library-system/visitor_log_public.php`
- Terbuka untuk umum, tidak perlu autentikasi

---

### 4. ✅ Riwayat Peminjaman untuk Pengguna

**Lokasi File:**
- `/public/borrowings/history.php` - Halaman riwayat peminjaman user

**Fitur:**
- Pengguna (role: pengunjung) dapat melihat history peminjaman mereka sendiri
- Tampilan: Judul buku, penulis, ISBN, tanggal pinjam, jatuh tempo, status
- Status badge: Borrowed (kuning), Returned (hijau), Overdue (merah)
- DataTables untuk pagination dan search

**Akses:**
- Pengguna (pengunjung): Sidebar menu "Riwayat Saya" / "My History"
- Hanya menampilkan data peminjaman user yang login

**Pembatasan Akses Pengguna:**
- ✅ Dapat melihat: Daftar buku (books/index.php)
- ✅ Dapat melihat: Riwayat peminjaman sendiri (borrowings/history.php)
- ❌ Tidak dapat akses: Tambah/edit/hapus buku
- ❌ Tidak dapat akses: Manajemen peminjaman admin
- ❌ Tidak dapat akses: Data pengunjung
- ❌ Tidak dapat akses: Laporan

---

## Database Migration

**Jalankan Migration:**
```sql
-- Di phpMyAdmin atau MySQL client
SOURCE /path/to/database/migration_add_features.sql;
```

**Atau manual:**
1. Buka phpMyAdmin
2. Pilih database `digital_library`
3. Klik tab "SQL"
4. Copy-paste isi file `migration_add_features.sql`
5. Klik "Go"

**Perubahan Database:**
1. Tabel `books`:
   - Tambah kolom `source` (VARCHAR 100)
   - Tambah kolom `description` (TEXT)

2. Tabel `borrowed_books`:
   - Tambah kolom `due_date` (DATE) - tanggal jatuh tempo
   - Tambah kolom `returned_date` (TIMESTAMP) - tanggal dikembalikan
   - Tambah kolom `status` (ENUM) - status peminjaman
   - Hapus kolom `return_date` lama
   - Tambah index untuk performa

---

## Menu Navigasi Update

### Admin Menu:
1. Dashboard
2. Manajemen Buku (Books) - CRUD
3. **Peminjaman (Borrowings)** - NEW ✨
4. Data Pengunjung (Visitors)
5. Laporan (Reports)
6. Logout

### Pengguna (Pengunjung) Menu:
1. Dashboard
2. Daftar Buku (Books) - Read Only
3. **Riwayat Saya (My History)** - NEW ✨
4. Logout

---

## Testing Guide

### Test Fitur Peminjaman (Admin):
1. Login sebagai admin (admin/admin123)
2. Klik menu "Peminjaman"
3. Klik "Pinjam Buku"
4. Pilih peminjam dari dropdown
5. Pilih buku yang tersedia
6. Set tanggal jatuh tempo
7. Submit form
8. Lihat stok buku berkurang di daftar buku
9. Klik tombol "Kembalikan" untuk mengembalikan buku
10. Verify stok buku bertambah kembali

### Test Field Asal Buku:
1. Login sebagai admin
2. Klik "Buku" → "Tambah Buku"
3. Isi form termasuk field "Asal Buku" (contoh: "Hibah dari Alumni")
4. Isi field "Deskripsi" 
5. Simpan buku
6. Edit buku → verify field source dan description tersimpan

### Test Catat Kunjungan Publik:
1. Buka `http://localhost/digital-library-system/`
2. Akan redirect ke halaman catat kunjungan
3. Isi nama dan tujuan kunjungan
4. Submit tanpa login
5. Verify success message muncul

### Test Riwayat Pengguna:
1. Login sebagai pengguna (budi_santoso/password123 atau user lain)
2. Klik menu "Riwayat Saya"
3. Verify hanya menampilkan peminjaman user yang login
4. Check tidak ada akses ke menu admin

---

## File Structure Update

```
digital-library-system/
├── database/
│   ├── migration_add_features.sql          # NEW - Migration file
│   └── ...
├── public/
│   ├── borrowings/                          # NEW - Borrowing module
│   │   ├── index.php                       # Daftar peminjaman
│   │   ├── borrow.php                      # Form pinjam buku
│   │   ├── return.php                      # Proses kembalikan
│   │   └── history.php                     # Riwayat user
│   ├── books/
│   │   ├── add.php                         # UPDATED - tambah field source
│   │   └── edit.php                        # UPDATED - tambah field source
│   ├── layouts/
│   │   └── sidebar.php                     # UPDATED - menu baru
│   ├── index.php                           # UPDATED - redirect ke visitor log
│   └── visitor_log_public.php              # NEW - Catat kunjungan publik
├── src/
│   └── Models/
│       ├── Book.php                        # UPDATED - source & description
│       └── Borrowing.php                   # NEW - Borrowing model
└── ...
```

---

## Multilanguage Support

Semua fitur baru sudah support 2 bahasa:
- 🇮🇩 Bahasa Indonesia
- 🇬🇧 English

**Translation keys tambahan:**
- Peminjaman / Borrowings
- Riwayat Saya / My History
- Pinjam Buku / Borrow Book
- Kembalikan / Return
- Dipinjam / Borrowed
- Dikembalikan / Returned
- Terlambat / Overdue
- Asal Buku / Book Source
- Deskripsi / Description

---

## Summary Perubahan

### ✅ Completed Features:

1. **Peminjaman & Pengembalian Buku**
   - Model Borrowing dengan full CRUD
   - Halaman admin untuk manage peminjaman
   - Auto update stok buku
   - Status tracking (borrowed/returned/overdue)
   - Statistik peminjaman

2. **Field Asal Buku**
   - Field source di database
   - Field description di database
   - Form input di add/edit buku

3. **Catat Kunjungan Publik**
   - Halaman standalone tanpa login
   - Form visitor log public
   - Redirect dari index.php

4. **Riwayat User**
   - Halaman history untuk pengguna
   - Filter by user_id
   - Read-only access

5. **Permission & Navigation**
   - Updated sidebar menu
   - Role-based access control
   - Pengunjung: read-only untuk books + history

---

## Troubleshooting

### Error: Column 'source' doesn't exist
**Solusi:** Run migration file `migration_add_features.sql`

### Error: Table 'borrowed_books' doesn't exist
**Solusi:** Pastikan schema.sql sudah diimport, lalu run migration

### Stok buku tidak update
**Solusi:** Check transaction di Borrowing model, pastikan tidak ada error

### User tidak bisa lihat history
**Solusi:** Verify user sudah login dan punya peminjaman di database

---

## Credits

**Developer:** GitHub Copilot  
**Date:** January 7, 2026  
**Version:** 2.0.0

Fitur-fitur ini menambahkan fungsionalitas core library management system:
- Borrowing & return management
- Book source tracking
- Public visitor logging
- User borrowing history
