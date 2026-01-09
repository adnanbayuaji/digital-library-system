-- ============================================
-- DUMMY DATA FOR DIGITAL LIBRARY SYSTEM
-- ============================================
-- IMPORTANT: Run schema.sql first before importing this file
-- This file assumes admin user exists with ID 1

-- ============================================
-- INSERT USERS (Pengunjung)
-- ============================================
-- Password untuk semua user: password123
-- Hash generated dengan: password_hash('password123', PASSWORD_BCRYPT)
INSERT INTO users (username, password, email, role, full_name, phone, created_at) VALUES
('budi_santoso', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'budi.santoso@email.com', 'pengunjung', 'Budi Santoso', '081234567891', '2024-01-15 08:30:00'),
('siti_rahma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siti.rahma@email.com', 'pengunjung', 'Siti Rahmawati', '081234567892', '2024-01-20 09:15:00'),
('ahmad_fauzi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ahmad.fauzi@email.com', 'pengunjung', 'Ahmad Fauzi', '081234567893', '2024-02-01 10:20:00'),
('dewi_lestari', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'dewi.lestari@email.com', 'pengunjung', 'Dewi Lestari', '081234567894', '2024-02-10 11:45:00'),
('rudi_hartono', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'rudi.hartono@email.com', 'pengunjung', 'Rudi Hartono', '081234567895', '2024-03-05 13:00:00');

-- ============================================
-- INSERT BOOKS
-- ============================================
INSERT INTO books (title, author, published_year, isbn, source, available_copies, total_copies, created_at) VALUES
-- Novel Indonesia
('Laskar Pelangi', 'Andrea Hirata', 2005, '978-602-03-0000-1', 'Donasi PT. Gramedia', 3, 5, '2024-01-10 08:00:00'),
('Bumi Manusia', 'Pramoedya Ananta Toer', 1980, '978-602-03-0000-2', 'Hibah Perpustakaan Nasional', 2, 4, '2024-01-10 08:15:00'),
('Ayat-Ayat Cinta', 'Habiburrahman El Shirazy', 2004, '978-602-03-0000-3', 'Pembelian Perpustakaan', 4, 5, '2024-01-10 08:30:00'),
('Perahu Kertas', 'Dee Lestari', 2009, '978-602-03-0000-4', 'Donasi Alumni', 2, 3, '2024-01-10 08:45:00'),
('Negeri 5 Menara', 'Ahmad Fuadi', 2009, '978-602-03-0000-5', 'Pembelian Perpustakaan', 3, 4, '2024-01-10 09:00:00'),

-- Novel Dunia
('Harry Potter and the Philosopher Stone', 'J.K. Rowling', 1997, '978-602-03-0000-6', 'Donasi Komunitas Baca', 5, 6, '2024-01-11 08:00:00'),
('The Hobbit', 'J.R.R. Tolkien', 1937, '978-602-03-0000-7', 'Hibah British Council', 2, 3, '2024-01-11 08:15:00'),
('1984', 'George Orwell', 1949, '978-602-03-0000-8', 'Pembelian Perpustakaan', 3, 4, '2024-01-11 08:30:00'),
('To Kill a Mockingbird', 'Harper Lee', 1960, '978-602-03-0000-9', 'Donasi Kedutaan Amerika', 2, 3, '2024-01-11 08:45:00'),
('The Great Gatsby', 'F. Scott Fitzgerald', 1925, '978-602-03-0000-10', 'Pembelian Perpustakaan', 3, 4, '2024-01-11 09:00:00'),

-- Non-Fiksi
('Sejarah Indonesia Modern', 'Prof. Dr. Sartono Kartodirdjo', 2015, '978-602-03-0000-11', 'Hibah Kemendikbud', 4, 5, '2024-01-12 08:00:00'),
('Pengantar Ilmu Komputer', 'Dr. Bambang Hariyanto', 2018, '978-602-03-0000-12', 'Pembelian Perpustakaan', 3, 4, '2024-01-12 08:15:00'),
('Ekonomi Makro', 'Prof. Sadono Sukirno', 2016, '978-602-03-0000-13', 'Hibah Perpustakaan Universitas', 5, 6, '2024-01-12 08:30:00'),
('Filsafat Ilmu', 'Dr. Jujun S. Suriasumantri', 2017, '978-602-03-0000-14', 'Pembelian Perpustakaan', 3, 4, '2024-01-12 08:45:00'),
('Psikologi Pendidikan', 'Prof. Muhibbin Syah', 2019, '978-602-03-0000-15', 'Donasi Yayasan Pendidikan', 4, 5, '2024-01-12 09:00:00'),

-- Teknologi & Programming
('Clean Code', 'Robert C. Martin', 2008, '978-602-03-0000-16', 'Donasi Perusahaan IT', 3, 4, '2024-01-13 08:00:00'),
('Python for Data Science', 'Jake VanderPlas', 2016, '978-602-03-0000-17', 'Pembelian Perpustakaan', 2, 3, '2024-01-13 08:15:00'),
('Design Patterns', 'Gang of Four', 1994, '978-602-03-0000-18', 'Hibah Komunitas Developer', 2, 3, '2024-01-13 08:30:00'),
('The Pragmatic Programmer', 'Andrew Hunt', 1999, '978-602-03-0000-19', 'Pembelian Perpustakaan', 3, 4, '2024-01-13 08:45:00'),
('JavaScript: The Good Parts', 'Douglas Crockford', 2008, '978-602-03-0000-20', 'Donasi Tech Community', 4, 5, '2024-01-13 09:00:00');

-- ============================================
-- INSERT VISITORS (Data Kunjungan)
-- ============================================
INSERT INTO visitors (name, visit_purpose, visit_date) VALUES
-- Januari 2024
('Ani Wijaya', 'Membaca buku referensi tugas kuliah', '2024-01-15 09:30:00'),
('Bambang Sutrisno', 'Mencari referensi skripsi', '2024-01-15 10:15:00'),
('Citra Dewi', 'Belajar kelompok', '2024-01-16 13:20:00'),
('Doni Prakoso', 'Meminjam buku novel', '2024-01-17 14:45:00'),
('Eka Putri', 'Membaca majalah', '2024-01-18 08:30:00'),

-- Februari 2024
('Fajar Ramadhan', 'Mencari referensi penelitian', '2024-02-01 09:00:00'),
('Gita Sari', 'Membaca koran dan majalah', '2024-02-02 10:30:00'),
('Hadi Susanto', 'Belajar mandiri', '2024-02-05 11:20:00'),
('Indah Permata', 'Mencari buku tentang sejarah', '2024-02-08 14:00:00'),
('Joko Widodo', 'Meminjam buku ekonomi', '2024-02-10 15:30:00'),

-- Maret 2024
('Kartika Sari', 'Belajar bahasa Inggris', '2024-03-01 09:15:00'),
('Lukman Hakim', 'Mencari referensi makalah', '2024-03-05 10:45:00'),
('Maya Angelina', 'Membaca novel', '2024-03-10 13:00:00'),
('Nanda Pratama', 'Belajar kelompok', '2024-03-15 14:20:00'),
('Oscar Lawalata', 'Mencari buku teknologi', '2024-03-20 16:00:00'),

-- April 2024
('Putri Maharani', 'Membaca buku self-development', '2024-04-01 09:30:00'),
('Qori Sandioriva', 'Mencari referensi tugas', '2024-04-05 11:00:00'),
('Rina Nose', 'Belajar mandiri', '2024-04-10 13:30:00'),
('Sandi Uno', 'Meminjam buku sejarah', '2024-04-15 15:00:00'),
('Tina Turner', 'Membaca buku filsafat', '2024-04-20 16:30:00');

-- ============================================
-- INSERT BORROWED_BOOKS (Peminjaman & Pengembalian)
-- ============================================

-- Peminjaman yang sudah dikembalikan (return_date terisi)
INSERT INTO borrowed_books (user_id, book_id, borrowed_date, return_date) VALUES
-- budi_santoso - sudah mengembalikan
((SELECT id FROM users WHERE username = 'budi_santoso'), 1, '2024-01-20 10:00:00', '2024-01-27 14:30:00'),  -- Laskar Pelangi
((SELECT id FROM users WHERE username = 'budi_santoso'), 6, '2024-02-05 09:15:00', '2024-02-12 11:20:00'),  -- Harry Potter

-- siti_rahma - sudah mengembalikan
((SELECT id FROM users WHERE username = 'siti_rahma'), 3, '2024-01-25 11:30:00', '2024-02-01 10:15:00'),  -- Ayat-Ayat Cinta
((SELECT id FROM users WHERE username = 'siti_rahma'), 11, '2024-02-10 13:00:00', '2024-02-17 15:45:00'), -- Sejarah Indonesia
((SELECT id FROM users WHERE username = 'siti_rahma'), 12, '2024-03-01 09:30:00', '2024-03-08 14:00:00'), -- Pengantar Ilmu Komputer

-- ahmad_fauzi - sudah mengembalikan
((SELECT id FROM users WHERE username = 'ahmad_fauzi'), 5, '2024-02-15 10:45:00', '2024-02-22 16:20:00'),  -- Negeri 5 Menara
((SELECT id FROM users WHERE username = 'ahmad_fauzi'), 16, '2024-03-05 11:00:00', '2024-03-12 13:30:00'), -- Clean Code

-- dewi_lestari - sudah mengembalikan
((SELECT id FROM users WHERE username = 'dewi_lestari'), 4, '2024-02-20 14:15:00', '2024-02-27 10:45:00'),  -- Perahu Kertas
((SELECT id FROM users WHERE username = 'dewi_lestari'), 8, '2024-03-10 09:00:00', '2024-03-17 14:15:00'),  -- 1984

-- rudi_hartono - sudah mengembalikan
((SELECT id FROM users WHERE username = 'rudi_hartono'), 13, '2024-03-15 10:30:00', '2024-03-22 15:00:00'), -- Ekonomi Makro
((SELECT id FROM users WHERE username = 'rudi_hartono'), 20, '2024-04-01 11:45:00', '2024-04-08 13:20:00'); -- JavaScript

-- Peminjaman yang masih aktif (return_date NULL)
INSERT INTO borrowed_books (user_id, book_id, borrowed_date, return_date) VALUES
-- Peminjaman aktif (belum dikembalikan)
((SELECT id FROM users WHERE username = 'budi_santoso'), 2, '2025-12-15 09:00:00', NULL),  -- Budi meminjam Bumi Manusia
((SELECT id FROM users WHERE username = 'siti_rahma'), 7, '2025-12-20 10:30:00', NULL),  -- Siti meminjam The Hobbit
((SELECT id FROM users WHERE username = 'ahmad_fauzi'), 9, '2025-12-22 11:15:00', NULL),  -- Ahmad meminjam To Kill a Mockingbird
((SELECT id FROM users WHERE username = 'dewi_lestari'), 10, '2025-12-28 14:00:00', NULL), -- Dewi meminjam The Great Gatsby
((SELECT id FROM users WHERE username = 'rudi_hartono'), 14, '2026-01-02 09:30:00', NULL), -- Rudi meminjam Filsafat Ilmu
((SELECT id FROM users WHERE username = 'budi_santoso'), 15, '2026-01-03 10:45:00', NULL), -- Budi meminjam Psikologi Pendidikan
((SELECT id FROM users WHERE username = 'siti_rahma'), 17, '2026-01-05 13:20:00', NULL), -- Siti meminjam Python for Data Science
((SELECT id FROM users WHERE username = 'ahmad_fauzi'), 18, '2026-01-06 15:00:00', NULL); -- Ahmad meminjam Design Patterns

-- ============================================
-- UPDATE available_copies untuk buku yang dipinjam
-- ============================================
-- Kurangi available_copies untuk buku yang sedang dipinjam
UPDATE books SET available_copies = available_copies - 1 WHERE id IN (2, 7, 9, 10, 14, 15, 17, 18);

-- ============================================
-- SUMMARY
-- ============================================
-- Total Users: 6 (1 Admin + 5 Pengunjung)
-- Total Books: 20 buku
-- Total Visitors Log: 20 entries
-- Total Borrowed Books: 19 transaksi
--   - 11 sudah dikembalikan
--   - 8 masih dipinjam
-- ============================================
