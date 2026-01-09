<?php
// Session started by Session helper
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../src/Models/Book.php';
require_once '../../src/Helpers/Session.php';

use App\Models\Book;
use App\Helpers\Session;

// Check if user is logged in
if (!Session::has('user_id')) {
    header('Location: ../login.php');
    exit();
}

$user_role = Session::get('user_role');
$username = Session::get('username');
$page_title = 'Detail Buku';

$bookId = $_GET['id'] ?? null;

if ($bookId) {
    $bookModel = new Book($db);
    $book = $bookModel->read($bookId);

    if (!$book) {
        $_SESSION['error'] = 'Buku tidak ditemukan';
        header("Location: index.php");
        exit;
    }
} else {
    $_SESSION['error'] = 'ID buku tidak valid';
    header("Location: index.php");
    exit;
}
?>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="page-header">
        <h1><i class="bi bi-eye"></i> Detail Buku</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php">Buku</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-book"></i> <?php echo htmlspecialchars($book['title']); ?></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Penulis:</div>
                        <div class="col-md-8"><?php echo htmlspecialchars($book['author']); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">ISBN:</div>
                        <div class="col-md-8"><?php echo htmlspecialchars($book['isbn'] ?? '-'); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tahun Terbit:</div>
                        <div class="col-md-8"><?php echo htmlspecialchars($book['published_year'] ?? '-'); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Asal Buku:</div>
                        <div class="col-md-8">
                            <?php if (!empty($book['source'])): ?>
                                <span class="badge bg-info fs-6"><?php echo htmlspecialchars($book['source']); ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Stok Tersedia:</div>
                        <div class="col-md-8">
                            <span class="badge bg-success fs-6"><?php echo htmlspecialchars($book['available_copies'] ?? 0); ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Total Stok:</div>
                        <div class="col-md-8">
                            <span class="badge bg-primary fs-6"><?php echo htmlspecialchars($book['total_copies'] ?? 0); ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal Input:</div>
                        <div class="col-md-8"><?php echo date('d/m/Y H:i', strtotime($book['created_at'])); ?></div>
                    </div>
                    <?php if (!empty($book['description'])): ?>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Keterangan:</div>
                        <div class="col-md-8">
                            <div class="alert alert-light mb-0">
                                <?php echo nl2br(htmlspecialchars($book['description'])); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex gap-2">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <?php if ($user_role === 'admin'): ?>
                            <a href="edit.php?id=<?php echo $book['id']; ?>" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>