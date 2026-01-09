-- ============================================
-- UPDATE BOOK SOURCES (Asal Buku)
-- ============================================
-- File ini untuk update data asal buku pada data yang sudah ada
-- Jalankan setelah database sudah berisi data buku
-- ============================================

-- Update Novel Indonesia
UPDATE books SET source = 'Donasi PT. Gramedia' WHERE isbn = '978-602-03-0000-1'; -- Laskar Pelangi
UPDATE books SET source = 'Hibah Perpustakaan Nasional' WHERE isbn = '978-602-03-0000-2'; -- Bumi Manusia
UPDATE books SET source = 'Pembelian Perpustakaan' WHERE isbn = '978-602-03-0000-3'; -- Ayat-Ayat Cinta
UPDATE books SET source = 'Donasi Alumni' WHERE isbn = '978-602-03-0000-4'; -- Perahu Kertas
UPDATE books SET source = 'Pembelian Perpustakaan' WHERE isbn = '978-602-03-0000-5'; -- Negeri 5 Menara

-- Update Novel Dunia
UPDATE books SET source = 'Donasi Komunitas Baca' WHERE isbn = '978-602-03-0000-6'; -- Harry Potter
UPDATE books SET source = 'Hibah British Council' WHERE isbn = '978-602-03-0000-7'; -- The Hobbit
UPDATE books SET source = 'Pembelian Perpustakaan' WHERE isbn = '978-602-03-0000-8'; -- 1984
UPDATE books SET source = 'Donasi Kedutaan Amerika' WHERE isbn = '978-602-03-0000-9'; -- To Kill a Mockingbird
UPDATE books SET source = 'Pembelian Perpustakaan' WHERE isbn = '978-602-03-0000-10'; -- The Great Gatsby

-- Update Non-Fiksi
UPDATE books SET source = 'Hibah Kemendikbud' WHERE isbn = '978-602-03-0000-11'; -- Sejarah Indonesia Modern
UPDATE books SET source = 'Pembelian Perpustakaan' WHERE isbn = '978-602-03-0000-12'; -- Pengantar Ilmu Komputer
UPDATE books SET source = 'Hibah Perpustakaan Universitas' WHERE isbn = '978-602-03-0000-13'; -- Ekonomi Makro
UPDATE books SET source = 'Pembelian Perpustakaan' WHERE isbn = '978-602-03-0000-14'; -- Filsafat Ilmu
UPDATE books SET source = 'Donasi Yayasan Pendidikan' WHERE isbn = '978-602-03-0000-15'; -- Psikologi Pendidikan

-- Update Teknologi & Programming
UPDATE books SET source = 'Donasi Perusahaan IT' WHERE isbn = '978-602-03-0000-16'; -- Clean Code
UPDATE books SET source = 'Pembelian Perpustakaan' WHERE isbn = '978-602-03-0000-17'; -- Python for Data Science
UPDATE books SET source = 'Hibah Komunitas Developer' WHERE isbn = '978-602-03-0000-18'; -- Design Patterns
UPDATE books SET source = 'Pembelian Perpustakaan' WHERE isbn = '978-602-03-0000-19'; -- The Pragmatic Programmer
UPDATE books SET source = 'Donasi Tech Community' WHERE isbn = '978-602-03-0000-20'; -- JavaScript: The Good Parts

-- ============================================
-- Verifikasi hasil update
-- ============================================
SELECT 
    title, 
    author, 
    isbn,
    source as 'Asal Buku'
FROM books 
WHERE source IS NOT NULL
ORDER BY id;

-- ============================================
-- SUMMARY
-- ============================================
-- Total books updated: 20
-- Sources types:
--   - Pembelian Perpustakaan: 8 buku
--   - Donasi (berbagai): 7 buku
--   - Hibah (berbagai): 5 buku
-- ============================================
