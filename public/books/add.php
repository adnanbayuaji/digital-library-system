<?php
// Session started by Session helper
require_once '../../config/config.php';
require_once '../../config/language.php';
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
$page_title = 'Tambah Buku';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'title' => trim($_POST['title']),
        'author' => trim($_POST['author']),
        'isbn' => trim($_POST['isbn']),
        'published_year' => trim($_POST['published_year']),
        'source' => trim($_POST['source'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'total_copies' => intval($_POST['total_copies'] ?? 1)
    ];

    $bookModel = new Book($db);
    if ($bookModel->create($data)) {
        $_SESSION['success'] = 'Buku berhasil ditambahkan';
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['error'] = 'Gagal menambahkan buku';
    }
}
?>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="page-header">
        <h1><i class="bi bi-plus-circle"></i> Tambah Buku</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php">Buku</a></li>
                <li class="breadcrumb-item active">Tambah</li>
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
                    <i class="bi bi-pencil-square"></i> Form Tambah Buku
                </div>
                <div class="card-body">
                    <form method="POST" action="add.php">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul buku" required>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label fw-semibold">Penulis <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="author" name="author" placeholder="Masukkan nama penulis" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="isbn" class="form-label fw-semibold">ISBN</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Masukkan ISBN">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="published_year" class="form-label fw-semibold">Tahun Terbit</label>
                                <input type="number" class="form-control" id="published_year" name="published_year" placeholder="2024" min="1900" max="2100">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="source" class="form-label fw-semibold"><?php echo current_lang() == 'id' ? 'Asal Buku' : 'Book Source'; ?></label>
                            <input type="text" class="form-control" id="source" name="source" placeholder="<?php echo current_lang() == 'id' ? 'Contoh: Hibah, Pembelian, Donasi' : 'e.g: Grant, Purchase, Donation'; ?>">
                            <small class="text-muted"><?php echo current_lang() == 'id' ? 'Keterangan dari mana buku ini diperoleh' : 'Information about where this book was obtained'; ?></small>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold"><?php echo current_lang() == 'id' ? 'Deskripsi' : 'Description'; ?></label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="<?php echo current_lang() == 'id' ? 'Deskripsi atau ringkasan buku' : 'Book description or summary'; ?>"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="total_copies" class="form-label fw-semibold">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="total_copies" name="total_copies" value="1" min="1" required>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan Buku
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
</main>

<?php include '../layouts/footer.php'; ?>