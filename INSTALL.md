# Digital Library System - Installation Guide

## Setup Database

1. Buka phpMyAdmin di browser Anda
2. Buat database baru dengan nama `digital_library`
3. Import file `database/schema.sql`
4. Update konfigurasi database di `config/database.php` jika perlu

## Default Admin Account

Setelah import database, Anda dapat login dengan akun admin default:
- **Username**: admin
- **Password**: admin123
- **Role**: Administrator

## User Roles

System ini memiliki 2 role pengguna:

### 1. Admin
- Kelola buku (tambah, edit, hapus)
- Lihat data pengunjung
- Akses laporan lengkap
- Dashboard statistik lengkap

### 2. Pengunjung
- Lihat katalog buku
- Catat kunjungan
- Dashboard informasi perpustakaan

## Features

### Login & Register
- Login dengan tampilan modern dan premium
- Registrasi pengguna baru (otomatis role: pengunjung)
- Validasi form lengkap
- Session management yang aman

### Dashboard
- Statistik real-time
- Tampilan berbeda untuk admin dan pengunjung
- Responsive design
- Modern UI dengan gradient colors

### Template Bootstrap Premium
- Bootstrap 5.3.2
- Bootstrap Icons
- DataTables untuk tabel data
- Gradient backgrounds
- Modern card designs
- Animated hover effects
- Responsive sidebar navigation

## Browser Support

- Chrome (recommended)
- Firefox
- Edge
- Safari

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP or similar web server
- Modern web browser

## How to Run

1. Pastikan XAMPP sudah running (Apache & MySQL)
2. Akses http://localhost/digital-library-system/
3. Sistem akan otomatis redirect ke halaman login
4. Login dengan akun admin atau register akun baru

## Security Notes

- Password di-hash dengan bcrypt
- Session management dengan helper class
- SQL injection protection dengan prepared statements
- Input validation pada setiap form

## Directory Structure

```
digital-library-system/
├── config/           # Konfigurasi aplikasi
├── database/         # Schema database
├── public/           # File yang dapat diakses publik
│   ├── assets/      # CSS, JS, images
│   ├── books/       # Halaman buku
│   ├── reports/     # Halaman laporan
│   ├── visitors/    # Halaman pengunjung
│   └── layouts/     # Template header, sidebar, footer
└── src/             # Source code aplikasi
    ├── Controllers/ # Business logic
    ├── Models/      # Database models
    ├── Helpers/     # Helper classes
    └── Middleware/  # Middleware classes
```

## Support

Untuk pertanyaan atau masalah, silakan hubungi administrator sistem.
