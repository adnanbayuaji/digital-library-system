<?php
// Session started by Session helper
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../src/Models/Borrowing.php';
require_once '../../src/Models/Book.php';
require_once '../../src/Models/User.php';
require_once '../../src/Helpers/Session.php';

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use App\Helpers\Session;

// Check if user is logged in and is admin
if (!Session::has('user_id') || Session::get('user_role') !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$user_role = Session::get('user_role');
$username = Session::get('username');
$page_title = 'Pinjam Buku';

$borrowingModel = new Borrowing($db);
$bookModel = new Book($db);
$userModel = new User($db);

// Get available books
$books = $bookModel->getAll();
$availableBooks = array_filter($books, function($book) {
    return $book['available_copies'] > 0;
});

// Get users with role pengunjung
$sql = "SELECT id, username, full_name, email FROM users WHERE role = 'pengunjung' ORDER BY full_name, username";
$result = $db->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $book_id = intval($_POST['book_id']);
    $due_date = $_POST['due_date'];

    if (!empty($user_id) && !empty($book_id) && !empty($due_date)) {
        // Check if user already borrowed this book
        if ($borrowingModel->hasActiveBorrowing($user_id, $book_id)) {
            $_SESSION['error'] = current_lang() == 'id' ? 'Pengguna sudah meminjam buku ini.' : 'User already borrowed this book.';
        } else {
            if ($borrowingModel->borrowBook($user_id, $book_id, $due_date)) {
                $_SESSION['success'] = current_lang() == 'id' ? 'Peminjaman buku berhasil dicatat.' : 'Book borrowing recorded successfully.';
                header('Location: index.php');
                exit();
            } else {
                $_SESSION['error'] = current_lang() == 'id' ? 'Gagal meminjam buku. Stok tidak tersedia.' : 'Failed to borrow book. Stock not available.';
            }
        }
    } else {
        $_SESSION['error'] = current_lang() == 'id' ? 'Mohon isi semua field.' : 'Please fill all fields.';
    }
}

// Default due date (7 days from now)
$defaultDueDate = date('Y-m-d', strtotime('+7 days'));
?>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="page-header">
        <h1><i class="bi bi-bookmark-plus"></i> <?php echo current_lang() == 'id' ? 'Pinjam Buku' : 'Borrow Book'; ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php"><?php echo __('dashboard.title'); ?></a></li>
                <li class="breadcrumb-item"><a href="index.php"><?php echo current_lang() == 'id' ? 'Peminjaman' : 'Borrowings'; ?></a></li>
                <li class="breadcrumb-item active"><?php echo current_lang() == 'id' ? 'Pinjam Buku' : 'Borrow Book'; ?></li>
            </ol>
        </nav>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pencil-square"></i> <?php echo current_lang() == 'id' ? 'Form Peminjaman Buku' : 'Book Borrowing Form'; ?>
                </div>
                <div class="card-body">
                    <form action="borrow.php" method="POST">
                        <div class="mb-3">
                            <label for="user_id" class="form-label fw-semibold"><?php echo current_lang() == 'id' ? 'Peminjam' : 'Borrower'; ?> <span class="text-danger">*</span></label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value=""><?php echo current_lang() == 'id' ? '-- Pilih Peminjam --' : '-- Select Borrower --'; ?></option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?php echo $user['id']; ?>">
                                        <?php echo htmlspecialchars($user['full_name'] ?: $user['username']) . ' (' . htmlspecialchars($user['username']) . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="book_id" class="form-label fw-semibold"><?php echo current_lang() == 'id' ? 'Buku' : 'Book'; ?> <span class="text-danger">*</span></label>
                            <select class="form-select" id="book_id" name="book_id" required>
                                <option value=""><?php echo current_lang() == 'id' ? '-- Pilih Buku --' : '-- Select Book --'; ?></option>
                                <?php foreach ($availableBooks as $book): ?>
                                    <option value="<?php echo $book['id']; ?>">
                                        <?php echo htmlspecialchars($book['title']) . ' - ' . htmlspecialchars($book['author']) . ' (Tersedia: ' . $book['available_copies'] . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="due_date" class="form-label fw-semibold"><?php echo current_lang() == 'id' ? 'Tanggal Jatuh Tempo' : 'Due Date'; ?> <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo $defaultDueDate; ?>" min="<?php echo date('Y-m-d'); ?>" required>
                            <small class="text-muted"><?php echo current_lang() == 'id' ? 'Default: 7 hari dari sekarang' : 'Default: 7 days from now'; ?></small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> <?php echo current_lang() == 'id' ? 'Pinjamkan' : 'Borrow'; ?>
                            </button>
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> <?php echo __('form.back'); ?>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>
