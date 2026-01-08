<?php
// Session started by Session helper
require_once '../../config/config.php';
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

$user_role = Session::get('user_role');
$username = Session::get('username');
$page_title = 'Edit Buku';

$bookId = $_GET['id'] ?? null;
$book = null;

if ($bookId) {
    $bookModel = new Book($db);
    $book = $bookModel->read($bookId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => trim($_POST['title']),
        'author' => trim($_POST['author']),
        'isbn' => trim($_POST['isbn']),
        'published_year' => trim($_POST['published_year']),
        'source' => trim($_POST['source'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'available_copies' => intval($_POST['available_copies']),
        'total_copies' => intval($_POST['total_copies'])
    ];

    $bookModel = new Book($db);
    if ($bookModel->update($bookId, $data)) {
        $_SESSION['success'] = 'Buku berhasil diupdate';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['error'] = 'Gagal mengupdate buku';
    }
}
?>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="page-header">
        <h1><i class="bi bi-pencil"></i> Edit Buku</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php">Buku</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($book): ?>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pencil-square"></i> Form Edit Buku
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label fw-semibold">Penulis <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="isbn" class="form-label fw-semibold">ISBN</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo htmlspecialchars($book['isbn'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="published_year" class="form-label fw-semibold">Tahun Terbit</label>
                                <input type="number" class="form-control" id="published_year" name="published_year" value="<?php echo htmlspecialchars($book['published_year'] ?? ''); ?>" min="1900" max="2100">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="source" class="form-label fw-semibold"><?php echo current_lang() == 'id' ? 'Asal Buku' : 'Book Source'; ?></label>
                            <input type="text" class="form-control" id="source" name="source" value="<?php echo htmlspecialchars($book['source'] ?? ''); ?>" placeholder="<?php echo current_lang() == 'id' ? 'Contoh: Hibah, Pembelian, Donasi' : 'e.g: Grant, Purchase, Donation'; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold"><?php echo current_lang() == 'id' ? 'Deskripsi' : 'Description'; ?></label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($book['description'] ?? ''); ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="available_copies" class="form-label fw-semibold">Stok Tersedia</label>
                                <input type="number" class="form-control" id="available_copies" name="available_copies" value="<?php echo htmlspecialchars($book['available_copies'] ?? 0); ?>" min="0" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="total_copies" class="form-label fw-semibold">Total Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="total_copies" name="total_copies" value="<?php echo htmlspecialchars($book['total_copies'] ?? 0); ?>" min="1" required>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Buku
                            </button>
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</main>

<?php include '../layouts/footer.php'; ?>