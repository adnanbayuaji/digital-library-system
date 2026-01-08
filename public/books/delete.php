<?php
// Session started by Session helper
require_once '../../config/database.php';
require_once '../../src/Models/Book.php';
require_once '../../src/Helpers/Session.php';

use App\Models\Book;
use App\Helpers\Session;

// Check if user is logged in and is admin
if (!Session::has('user_id') || Session::get('user_role') !== 'admin') {
    header('Location: ../dashboard.php');
    exit();
}

if (isset($_GET['id'])) {
    $bookId = intval($_GET['id']);
    $bookModel = new Book($db);
    
    if ($bookModel->delete($bookId)) {
        $_SESSION['success'] = 'Buku berhasil dihapus';
    } else {
        $_SESSION['error'] = 'Gagal menghapus buku';
    }
} else {
    $_SESSION['error'] = 'ID buku tidak valid';
}

header("Location: index.php");
exit();
?>