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

$user_role = Session::get('user_role') ?? 'pengunjung';
$username = Session::get('username') ?? 'Guest';
$page_title = 'Kelola Buku';

$bookModel = new Book($db);
$books = $bookModel->getAll();
?>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="page-header">
        <h1><i class="bi bi-book"></i> <?php echo $user_role === 'admin' ? __('books.title') : __('books.list'); ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php"><?php echo __('dashboard.title'); ?></a></li>
                <li class="breadcrumb-item active"><?php echo __('nav.books'); ?></li>
            </ol>
        </nav>
    </div>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-list"></i> <?php echo __('books.list'); ?></span>
            <?php if ($user_role === 'admin'): ?>
                <a href="add.php" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle"></i> <?php echo __('books.add'); ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?php echo __('books.book_title'); ?></th>
                            <th><?php echo __('books.author'); ?></th>
                            <th><?php echo __('books.isbn'); ?></th>
                            <th><?php echo __('books.year'); ?></th>
                            <th><?php echo current_lang() == 'id' ? 'Tersedia' : 'Available'; ?></th>
                            <th>Total</th>
                            <th><?php echo __('books.actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($books)): ?>
                            <?php $no = 1; foreach ($books as $book): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                                    <td><?php echo htmlspecialchars($book['isbn'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($book['published_year'] ?? '-'); ?></td>
                                    <td><span class="badge bg-success"><?php echo htmlspecialchars($book['available_copies'] ?? 0); ?></span></td>
                                    <td><span class="badge bg-primary"><?php echo htmlspecialchars($book['total_copies'] ?? 0); ?></span></td>
                                    <td>
                                        <a href="view.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <?php if ($user_role === 'admin'): ?>
                                            <a href="edit.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="delete.php?id=<?php echo $book['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               title="Hapus"
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data buku</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>