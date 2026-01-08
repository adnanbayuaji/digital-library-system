<?php
// Session started by Session helper
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../src/Models/Borrowing.php';
require_once '../../src/Helpers/Session.php';

use App\Models\Borrowing;
use App\Helpers\Session;

// Check if user is logged in
if (!Session::has('user_id')) {
    header('Location: ../login.php');
    exit();
}

$user_role = Session::get('user_role');
$username = Session::get('username');
$user_id = Session::get('user_id');
$page_title = 'Riwayat Peminjaman';

$borrowingModel = new Borrowing($db);
$myBorrowings = $borrowingModel->getUserBorrowings($user_id);
?>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="page-header">
        <h1><i class="bi bi-clock-history"></i> <?php echo current_lang() == 'id' ? 'Riwayat Peminjaman Saya' : 'My Borrowing History'; ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php"><?php echo __('dashboard.title'); ?></a></li>
                <li class="breadcrumb-item active"><?php echo current_lang() == 'id' ? 'Riwayat' : 'History'; ?></li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-list"></i> <?php echo current_lang() == 'id' ? 'Daftar Riwayat Peminjaman' : 'Borrowing History List'; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?php echo current_lang() == 'id' ? 'Judul Buku' : 'Book Title'; ?></th>
                            <th><?php echo current_lang() == 'id' ? 'Penulis' : 'Author'; ?></th>
                            <th><?php echo current_lang() == 'id' ? 'Tgl Pinjam' : 'Borrow Date'; ?></th>
                            <th><?php echo current_lang() == 'id' ? 'Jatuh Tempo' : 'Due Date'; ?></th>
                            <th><?php echo current_lang() == 'id' ? 'Tgl Kembali' : 'Return Date'; ?></th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($myBorrowings)): ?>
                            <?php $no = 1; foreach ($myBorrowings as $borrow): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($borrow['book_title']); ?></strong>
                                        <?php if ($borrow['isbn']): ?>
                                            <br><small class="text-muted">ISBN: <?php echo htmlspecialchars($borrow['isbn']); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($borrow['author']); ?></td>
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
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center"><?php echo current_lang() == 'id' ? 'Belum ada riwayat peminjaman' : 'No borrowing history'; ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>
