# Multilanguage Feature Documentation

## Overview
Sistem Perpustakaan Digital sekarang mendukung dua bahasa:
- **Bahasa Indonesia (ID)** - Default
- **English (EN)**

## Struktur File

### 1. Konfigurasi Bahasa
- **config/language.php** - File konfigurasi utama untuk sistem multilanguage
- **lang/id.php** - File terjemahan Bahasa Indonesia
- **lang/en.php** - File terjemahan Bahasa Inggris

### 2. Fungsi Helper

#### `__($key)`
Fungsi untuk mengambil terjemahan berdasarkan key.

**Contoh Penggunaan:**
```php
echo __('site_name'); // Output: Sistem Perpustakaan Digital / Digital Library System
echo __('auth.login'); // Output: Masuk / Login
echo __('books.title'); // Output: Manajemen Buku / Book Management
```

#### `current_lang()`
Fungsi untuk mendapatkan bahasa yang sedang aktif.

**Contoh Penggunaan:**
```php
$lang = current_lang(); // Output: 'id' atau 'en'
```

## Cara Penggunaan

### 1. Menambahkan Translation Key Baru

Edit file `lang/id.php` dan `lang/en.php`, tambahkan key baru:

**lang/id.php:**
```php
'new_section' => [
    'title' => 'Judul Baru',
    'description' => 'Deskripsi Baru',
],
```

**lang/en.php:**
```php
'new_section' => [
    'title' => 'New Title',
    'description' => 'New Description',
],
```

### 2. Menggunakan Translation di Halaman

Pastikan file `config/language.php` sudah di-include:

```php
<?php
require_once '../config/language.php'; // atau ../../config/language.php
?>

<h1><?php echo __('new_section.title'); ?></h1>
<p><?php echo __('new_section.description'); ?></p>
```

### 3. Mengubah Bahasa

Pengguna dapat mengubah bahasa melalui dropdown di pojok kanan atas setiap halaman. Language switcher tersedia di:
- Halaman Login
- Halaman Register
- Semua halaman dengan layout (header, sidebar, footer)

## Kategori Translation Keys

### 1. Authentication (`auth.*`)
- Login/Register forms
- User credentials
- Success/error messages

### 2. Navigation (`nav.*`)
- Menu items
- Sidebar links

### 3. Dashboard (`dashboard.*`)
- Statistics cards
- Welcome messages
- Quick actions

### 4. Books (`books.*`)
- Book management
- Book information
- CRUD operations

### 5. Visitors (`visitors.*`)
- Visitor management
- Visit logging
- Visitor information

### 6. Reports (`reports.*`)
- Report types
- Statistics

### 7. Forms (`form.*`)
- Common form buttons
- Form actions
- Form labels

### 8. Messages (`messages.*`)
- Success messages
- Error messages
- Validation messages

### 9. General (`general.*`)
- Common UI elements
- General terms

### 10. Roles (`roles.*`)
- User roles
- Permission levels

## Fitur Language Switcher

### Desktop View
- Posisi: Pojok kanan atas (fixed position)
- Icon: Globe/Translate icon
- Dropdown dengan checkmark untuk bahasa aktif

### Mobile View
- Posisi: Adjusted untuk tidak bentrok dengan hamburger menu
- Tetap accessible dan visible

### Styling
- Background: Semi-transparent white dengan gradient border
- Hover effect: Slightly darker background
- Active language: Highlighted dengan checkmark icon

## Session Management

Bahasa yang dipilih disimpan dalam session:
```php
$_SESSION['lang'] = 'id'; // atau 'en'
```

Session bahasa akan:
- Persist selama session aktif
- Reset ke default (ID) saat logout
- Dapat diubah kapan saja melalui URL parameter `?lang=id` atau `?lang=en`

## DataTables Localization

DataTables secara otomatis menggunakan bahasa yang sesuai:
- Bahasa Indonesia: `id.json`
- English: `en-GB.json`

Konfigurasi ada di `public/layouts/footer.php`

## Best Practices

### 1. Konsistensi
- Gunakan translation keys untuk semua teks yang terlihat user
- Jangan hardcode text dalam bahasa tertentu

### 2. Nested Keys
- Gunakan struktur nested untuk organisasi yang lebih baik
- Contoh: `books.add`, `books.edit`, `books.delete`

### 3. Fallback
- Jika translation key tidak ditemukan, sistem akan return key itu sendiri
- Berguna untuk debugging

### 4. Testing
- Test semua halaman dengan kedua bahasa
- Pastikan tidak ada broken translations
- Verify formatting dan layout tetap baik di kedua bahasa

## Troubleshooting

### Translation Tidak Muncul
1. Check apakah `config/language.php` sudah di-include
2. Verify translation key exists di kedua file language
3. Check sintaks array PHP untuk typo

### Language Tidak Berubah
1. Check session sudah dimulai (`session_start()`)
2. Verify URL parameter `?lang=` correct
3. Clear browser cache dan session

### Layout Broken
1. Check apakah text terlalu panjang untuk container
2. Adjust CSS untuk accommodate text length differences
3. Test responsive di berbagai ukuran screen

## File yang Sudah Diupdate

✅ config/language.php - Language configuration
✅ lang/id.php - Indonesian translations
✅ lang/en.php - English translations
✅ public/layouts/header.php - Language switcher + translations
✅ public/layouts/sidebar.php - Navigation translations
✅ public/layouts/footer.php - DataTables localization
✅ public/login.php - Full translation support
✅ public/register.php - Full translation support
✅ public/dashboard.php - Dashboard translations
✅ public/books/index.php - Books list translations
✅ public/visitors/log.php - Visitor log translations

## File yang Perlu Update Tambahan (Opsional)

Untuk implementasi lengkap 100%, file-file berikut bisa ditambahkan terjemahan:
- public/books/add.php
- public/books/edit.php
- public/books/view.php
- public/books/delete.php
- public/visitors/index.php
- public/reports/index.php

## Credits

Multilanguage system implemented using:
- PHP Session management
- Bootstrap 5 for UI
- DataTables i18n plugins
- Custom translation helper functions
