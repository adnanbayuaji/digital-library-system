<?php
// Session started by Session helper
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../src/Models/Visitor.php';
require_once '../../src/Helpers/Session.php';

use App\Models\Visitor;
use App\Helpers\Session;

// Check if user is logged in and is admin
if (!Session::has('user_id') || Session::get('user_role') !== 'admin') {
    header('Location: ../dashboard.php');
    exit();
}

$user_role = Session::get('user_role');
$username = Session::get('username');
$page_title = 'Data Pengunjung';

$visitorModel = new Visitor($db);
$visitors = $visitorModel->getVisitors();
?>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="page-header">
        <h1><i class="bi bi-people"></i> Data Pengunjung</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengunjung</li>
            </ol>
        </nav>
    </div>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-list"></i> Daftar Pengunjung</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tujuan Kunjungan</th>
                            <th>Tanggal Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($visitors)): ?>
                            <?php $no = 1; foreach ($visitors as $visitor): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($visitor['name']); ?></td>
                                    <td><?php echo htmlspecialchars($visitor['visit_purpose'] ?? '-'); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($visitor['visit_date'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data pengunjung</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>