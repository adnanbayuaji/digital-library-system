<?php
// Session started by Session helper
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../src/Helpers/Session.php';

use App\Helpers\Session;

// Check if user is logged in and is admin
if (!Session::has('user_id') || Session::get('user_role') !== 'admin') {
    header('Location: ../dashboard.php');
    exit();
}

$user_role = Session::get('user_role');
$username = Session::get('username');
$page_title = 'Laporan';

// Get reports data
$booksReport = [];
$visitorsReport = [];

// Query for books
$result = $db->query("SELECT * FROM books ORDER BY created_at DESC LIMIT 10");
if ($result) {
    $booksReport = $result->fetch_all(MYSQLI_ASSOC);
}

// Query for visitors
$result = $db->query("SELECT * FROM visitors ORDER BY visit_date DESC LIMIT 10");
if ($result) {
    $visitorsReport = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="page-header">
        <h1><i class="bi bi-file-earmark-text"></i> Laporan</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan</li>
            </ol>
        </nav>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-book"></i> Laporan Buku Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($booksReport)): ?>
                                    <?php $no = 1; foreach ($booksReport as $book): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                                            <td><?php echo htmlspecialchars($book['author']); ?></td>
                                            <td><span class="badge bg-success"><?php echo $book['total_copies'] ?? 0; ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-people"></i> Laporan Pengunjung Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tujuan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($visitorsReport)): ?>
                                    <?php $no = 1; foreach ($visitorsReport as $visitor): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($visitor['name']); ?></td>
                                            <td><?php echo htmlspecialchars($visitor['visit_purpose'] ?? '-'); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($visitor['visit_date'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>