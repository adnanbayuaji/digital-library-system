-- ============================================
-- Migration: Remove UNIQUE constraint from ISBN
-- ============================================
-- This migration allows multiple books to have the same ISBN
-- Useful when library has multiple copies from different sources
-- ============================================

-- Drop the UNIQUE constraint on isbn column
ALTER TABLE books 
DROP INDEX isbn;

-- Verify the change
SHOW INDEX FROM books;

-- ============================================
-- NOTES:
-- ============================================
-- After running this migration, books can have duplicate ISBNs
-- This is useful for tracking different copies or editions
-- ============================================
