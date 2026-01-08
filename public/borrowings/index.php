<?php
// Session started by Session helper
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../src/Models/Borrowing.php';
require_once '../../src/Helpers/Session.php';

use App\Models\Borrowing;
use App\Helpers\Session;

// Check if user is logged in and is admin
if (!Session::has('user_id') || Session::get('user_role') !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$user_role = Session::get('user_role');
$username = Session::get('username');
$page_title = 'Manajemen Peminjaman';

$borrowingModel = new Borrowing($db);

// Update overdue status
$borrowingModel->updateOverdueStatus();

// Get filter
$filter = $_GET['filter'] ?? 'all';

if ($filter === 'active') {
    $borrowings = $borrowingModel->getActiveBorrowings();
} else {
    $borrowings = $borrowingModel->getAllBorrowings();
}

$stats = $borrowingModel->getStatistics();
?>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="page-header">
        <h1><i class="bi bi-bookmark-check"></i> <?php echo current_lang() == 'id' ? 'Manajemen Peminjaman' : 'Borrowing Management'; ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php"><?php echo __('dashboard.title'); ?></a></li>
                <li class="breadcrumb-item active"><?php echo current_lang() == 'id' ? 'Peminjaman' : 'Borrowings'; ?></li>
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

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="stat-card bg-gradient-warning">
                <div class="position-relative">
                    <h3><?php echo $stats['total_borrowed']; ?></h3>
                    <p><?php echo current_lang() == 'id' ? 'Sedang Dipinjam' : 'Currently Borrowed'; ?></p>
                    <i class="bi bi-bookmark icon"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="stat-card bg-gradient-danger">
                <div class="position-relative">
                    <h3><?php echo $stats['total_overdue']; ?></h3>
                    <p><?php echo current_lang() == 'id' ? 'Terlambat' : 'Overdue'; ?></p>
                    <i class="bi bi-exclamation-triangle icon"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="stat-card bg-gradient-success">
                <div class="position-relative">
                    <h3><?php echo $stats['total_returned']; ?></h3>
                    <p><?php echo current_lang() == 'id' ? 'Dikembalikan' : 'Returned'; ?></p>
                    <i class="bi bi-check-circle icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <span><i class="bi bi-list"></i> <?php echo current_lang() == 'id' ? 'Daftar Peminjaman' : 'Borrowing List'; ?></span>
                <div class="d-flex flex-wrap gap-2">
                    <a href="?filter=active" class="btn btn-sm btn-outline-primary <?php echo $filter === 'active' ? 'active' : ''; ?>">
                        <i class="bi bi-bookmark"></i> <?php echo current_lang() == 'id' ? 'Aktif' : 'Active'; ?>
                    </a>
                    <a href="?filter=all" class="btn btn-sm btn-outline-secondary <?php echo $filter === 'all' ? 'active' : ''; ?>">
                        <i class="bi bi-list-ul"></i> <?php echo current_lang() == 'id' ? 'Semua' : 'All'; ?>
                    </a>
                    <a href="borrow.php" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i> <span class="d-none d-sm-inline"><?php echo current_lang() == 'id' ? 'Pinjam Buku' : 'Borrow Book'; ?></span><span class="d-inline d-sm-none"><?php echo current_lang() == 'id' ? 'Pinjam' : 'Borrow'; ?></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?php echo current_lang() == 'id' ? 'Peminjam' : 'Borrower'; ?></th>
                            <th><?php echo current_lang() == 'id' ? 'Judul Buku' : 'Book Title'; ?></th>
                            <th><?php echo current_lang() == 'id' ? 'Tgl Pinjam' : 'Borrow Date'; ?></th>
                            <th><?php echo current_lang() == 'id' ? 'Jatuh Tempo' : 'Due Date'; ?></th>
                            <th><?php echo current_lang() == 'id' ? 'Tgl Kembali' : 'Return Date'; ?></th>
                            <th>Status</th>
                            <th><?php echo current_lang() == 'id' ? 'Aksi' : 'Actions'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($borrowings)): ?>
                            <?php $no = 1; foreach ($borrowings as $borrow): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($borrow['full_name'] ?? $borrow['username']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($borrow['username']); ?></small>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($borrow['book_title']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($borrow['author']); ?></small>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($borrow['borrowed_date'])); ?></td>
                                    <td><?php echo date('d M Y', strtotime($borrow['due_date'])); ?></td>
                                    <td><?php echo $borrow['returned_date'] ? date('d M Y', strtotime($borrow['returned_date'])) : '-'; ?></td>
                                    <td>
                                        <?php if ($borrow['status'] === 'borrowed'): ?>
                                            <span class="badge bg-warning"><?php echo current_lang() == 'id' ? 'Dipinjam' : 'Borrowed'; ?></span>
                                        <?php elseif ($borrow['status'] === 'returned'): ?>
                                            <span class="badge bg-success"><?php echo current_lang() == 'id' ? 'Dikembalikan' : 'Returned'; ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?php echo current_lang() == 'id' ? 'Terlambat' : 'Overdue'; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($borrow['status'] !== 'returned'): ?>
                                            <a href="return.php?id=<?php echo $borrow['id']; ?>" 
                                               class="btn btn-sm btn-success" 
                                               title="<?php echo current_lang() == 'id' ? 'Kembalikan' : 'Return'; ?>"
                                               onclick="return confirm('<?php echo current_lang() == 'id' ? 'Konfirmasi pengembalian buku ini?' : 'Confirm return this book?'; ?>')">
                                                <i class="bi bi-arrow-return-left"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center"><?php echo current_lang() == 'id' ? 'Belum ada data peminjaman' : 'No borrowing data'; ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>
