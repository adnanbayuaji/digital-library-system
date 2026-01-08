<?php

namespace App\Models;

class Visitor {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function addVisitor($name, $purpose) {
        $stmt = $this->db->prepare("INSERT INTO visitors (name, purpose, visit_date) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $name, $purpose);
        return $stmt->execute();
    }

    public function getVisitors() {
        $result = $this->db->query("SELECT * FROM visitors ORDER BY visit_date DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getVisitorById($id) {
        $stmt = $this->db->prepare("SELECT * FROM visitors WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function deleteVisitor($id) {
        $stmt = $this->db->prepare("DELETE FROM visitors WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getTotalCount() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM visitors");
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
}