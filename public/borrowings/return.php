<?php
// Session started by Session helper
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../config/language.php';
require_once '../../src/Models/Borrowing.php';
require_once '../../src/Helpers/Session.php';

use App\Models\Borrowing;
use App\Helpers\Session;

// Check if user is logged in and is admin
if (!Session::has('user_id') || Session::get('user_role') !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$borrowingModel = new Borrowing($db);

if (isset($_GET['id'])) {
    $borrow_id = intval($_GET['id']);
    
    if ($borrowingModel->returnBook($borrow_id)) {
        Session::set('success', current_lang() == 'id' ? 'Buku berhasil dikembalikan.' : 'Book returned successfully.');
    } else {
        Session::set('error', current_lang() == 'id' ? 'Gagal mengembalikan buku.' : 'Failed to return book.');
    }
} else {
    Session::set('error', current_lang() == 'id' ? 'ID peminjaman tidak valid.' : 'Invalid borrowing ID.');
}

header('Location: index.php');
exit();
