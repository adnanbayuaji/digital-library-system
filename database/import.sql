-- ============================================
-- COMPLETE DATABASE IMPORT SCRIPT
-- For Digital Library System
-- ============================================
-- 
-- HOW TO USE:
-- 1. Open phpMyAdmin or MySQL CLI
-- 2. Create database: CREATE DATABASE digital_library;
-- 3. Select database: USE digital_library;
-- 4. Run this file OR run files in this order:
--    a. schema.sql
--    b. dummy_data.sql (optional)
--    c. migration_add_features.sql (if needed)
--
-- Or using MySQL CLI:
-- mysql -u root -p digital_library < import.sql
-- ============================================

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS digital_library;
USE digital_library;

-- Drop existing tables (CAUTION: This will delete all data!)
DROP TABLE IF EXISTS borrowed_books;
DROP TABLE IF EXISTS visitors;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS users;

-- ============================================
-- CREATE TABLES (from schema.sql)
-- ============================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'pengunjung') DEFAULT 'pengunjung',
    full_name VARCHAR(100),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100) NOT NULL,
    published_year YEAR,
    isbn VARCHAR(20) UNIQUE,
    available_copies INT DEFAULT 0,
    total_copies INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    visit_purpose TEXT,
    visit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE borrowed_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    borrowed_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    return_date TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

-- Insert default admin user
-- Username: admin
-- Password: admin123
INSERT INTO users (username, password, email, role, full_name, phone) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@library.com', 'admin', 'Administrator', '081234567890');

-- ============================================
-- IMPORT DUMMY DATA (Optional)
-- ============================================
-- Uncomment the SOURCE command below if you want to import dummy data
-- SOURCE dummy_data.sql;

-- ============================================
-- VERIFICATION QUERIES
-- ============================================
-- Run these to verify the import:
-- SELECT COUNT(*) as total_users FROM users;
-- SELECT COUNT(*) as total_books FROM books;
-- SELECT COUNT(*) as total_visitors FROM visitors;
-- SELECT COUNT(*) as total_borrowings FROM borrowed_books;
-- ============================================
