-- Migration: Add source field to books table and update borrowed_books table

-- Add source/origin field to books table
ALTER TABLE books 
ADD COLUMN source VARCHAR(100) AFTER isbn,
ADD COLUMN description TEXT AFTER source;

-- Update borrowed_books table to include status and due date
ALTER TABLE borrowed_books
ADD COLUMN due_date DATE AFTER borrowed_date,
ADD COLUMN returned_date TIMESTAMP NULL AFTER return_date,
ADD COLUMN status ENUM('borrowed', 'returned', 'overdue') DEFAULT 'borrowed' AFTER returned_date;

-- Drop old return_date column if exists
ALTER TABLE borrowed_books DROP COLUMN IF EXISTS return_date;

-- Add index for better performance
CREATE INDEX idx_borrowed_status ON borrowed_books(status);
CREATE INDEX idx_borrowed_user ON borrowed_books(user_id);
CREATE INDEX idx_borrowed_book ON borrowed_books(book_id);
