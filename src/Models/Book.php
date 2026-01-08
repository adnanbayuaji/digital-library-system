<?php

namespace App\Models;

class Book {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO books (title, author, published_year, isbn, source, description, available_copies, total_copies) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $available = $data['total_copies'] ?? 0;
        $total = $data['total_copies'] ?? 0;
        $source = $data['source'] ?? '';
        $description = $data['description'] ?? '';
        $stmt->bind_param("ssssssii", $data['title'], $data['author'], $data['published_year'], $data['isbn'], $source, $description, $available, $total);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function read($id) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE books SET title = ?, author = ?, published_year = ?, isbn = ?, source = ?, description = ?, available_copies = ?, total_copies = ? WHERE id = ?");
        $source = $data['source'] ?? '';
        $description = $data['description'] ?? '';
        $stmt->bind_param("sssssssii", $data['title'], $data['author'], $data['published_year'], $data['isbn'], $source, $description, $data['available_copies'], $data['total_copies'], $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getAll() {
        $result = $this->db->query("SELECT * FROM books ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalCount() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM books");
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function getAvailableCount() {
        $result = $this->db->query("SELECT SUM(available_copies) as total FROM books");
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
}