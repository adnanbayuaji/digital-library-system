<?php

namespace App\Models;

class Borrowing {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Borrow a book
    public function borrowBook($user_id, $book_id, $due_date) {
        // Check if book is available
        $stmt = $this->db->prepare("SELECT available_copies FROM books WHERE id = ?");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $book = $result->fetch_assoc();

        if ($book && $book['available_copies'] > 0) {
            // Start transaction
            $this->db->begin_transaction();

            try {
                // Insert borrowing record
                $stmt = $this->db->prepare("INSERT INTO borrowed_books (user_id, book_id, borrowed_date, due_date, status) VALUES (?, ?, NOW(), ?, 'borrowed')");
                $stmt->bind_param("iis", $user_id, $book_id, $due_date);
                $stmt->execute();

                // Decrease available copies
                $stmt = $this->db->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ?");
                $stmt->bind_param("i", $book_id);
                $stmt->execute();

                $this->db->commit();
                return true;
            } catch (\Exception $e) {
                $this->db->rollback();
                return false;
            }
        }
        return false;
    }

    // Return a book
    public function returnBook($borrow_id) {
        // Get borrowing record
        $stmt = $this->db->prepare("SELECT book_id, status FROM borrowed_books WHERE id = ? AND status = 'borrowed'");
        $stmt->bind_param("i", $borrow_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $borrow = $result->fetch_assoc();

        if ($borrow) {
            // Start transaction
            $this->db->begin_transaction();

            try {
                // Update borrowing record
                $stmt = $this->db->prepare("UPDATE borrowed_books SET status = 'returned', returned_date = NOW() WHERE id = ?");
                $stmt->bind_param("i", $borrow_id);
                $stmt->execute();

                // Increase available copies
                $stmt = $this->db->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = ?");
                $stmt->bind_param("i", $borrow['book_id']);
                $stmt->execute();

                $this->db->commit();
                return true;
            } catch (\Exception $e) {
                $this->db->rollback();
                return false;
            }
        }
        return false;
    }

    // Get all borrowing records
    public function getAllBorrowings() {
        $sql = "SELECT bb.*, u.username, u.full_name, b.title as book_title, b.author 
                FROM borrowed_books bb
                JOIN users u ON bb.user_id = u.id
                JOIN books b ON bb.book_id = b.id
                ORDER BY bb.borrowed_date DESC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get active borrowings (not returned)
    public function getActiveBorrowings() {
        $sql = "SELECT bb.*, u.username, u.full_name, b.title as book_title, b.author 
                FROM borrowed_books bb
                JOIN users u ON bb.user_id = u.id
                JOIN books b ON bb.book_id = b.id
                WHERE bb.status = 'borrowed'
                ORDER BY bb.borrowed_date DESC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get borrowing history by user
    public function getUserBorrowings($user_id) {
        $stmt = $this->db->prepare("SELECT bb.*, b.title as book_title, b.author, b.isbn 
                                     FROM borrowed_books bb
                                     JOIN books b ON bb.book_id = b.id
                                     WHERE bb.user_id = ?
                                     ORDER BY bb.borrowed_date DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get borrowing by ID
    public function getBorrowingById($id) {
        $stmt = $this->db->prepare("SELECT bb.*, u.username, u.full_name, u.phone, b.title as book_title, b.author, b.isbn 
                                     FROM borrowed_books bb
                                     JOIN users u ON bb.user_id = u.id
                                     JOIN books b ON bb.book_id = b.id
                                     WHERE bb.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Check if user has active borrowing for a book
    public function hasActiveBorrowing($user_id, $book_id) {
        $stmt = $this->db->prepare("SELECT id FROM borrowed_books WHERE user_id = ? AND book_id = ? AND status = 'borrowed'");
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Update overdue status
    public function updateOverdueStatus() {
        $sql = "UPDATE borrowed_books 
                SET status = 'overdue' 
                WHERE status = 'borrowed' 
                AND due_date < CURDATE()";
        return $this->db->query($sql);
    }

    // Get statistics
    public function getStatistics() {
        $stats = [];
        
        // Total borrowed books (active)
        $result = $this->db->query("SELECT COUNT(*) as total FROM borrowed_books WHERE status = 'borrowed'");
        $stats['total_borrowed'] = $result->fetch_assoc()['total'];
        
        // Overdue books
        $result = $this->db->query("SELECT COUNT(*) as total FROM borrowed_books WHERE status = 'overdue'");
        $stats['total_overdue'] = $result->fetch_assoc()['total'];
        
        // Total returned
        $result = $this->db->query("SELECT COUNT(*) as total FROM borrowed_books WHERE status = 'returned'");
        $stats['total_returned'] = $result->fetch_assoc()['total'];
        
        return $stats;
    }
}
