<?php
// Session started by Session helper
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/language.php';
require_once '../src/Helpers/Session.php';
require_once '../src/Models/Book.php';
require_once '../src/Models/Visitor.php';
require_once '../src/Models/User.php';

use App\Helpers\Session;
use App\Models\Book;
use App\Models\Visitor;
use App\Models\User;

// Check if user is logged in
if (!Session::has('user_id')) {
    header('Location: login.php');
    exit();
}

$user_role = Session::get('user_role') ?? 'pengunjung';
$username = Session::get('username') ?? 'Guest';
$page_title = 'Dashboard';

// Initialize models
$bookModel = new Book($db);
$visitorModel = new Visitor($db);
$userModel = new User($db);

// Fetch real statistics
$totalBooks = $bookModel->getTotalCount();
$availableBooks = $bookModel->getAvailableCount();
$borrowedBooks = $totalBooks - $availableBooks;
$totalVisitors = $visitorModel->getTotalCount();

?>

<?php include 'layouts/header.php'; ?>
<?php include 'layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="page-header">
        <h1><i class="bi bi-speedometer2"></i> <?php echo __('dashboard.title'); ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><?php echo __('dashboard.title'); ?></li>
            </ol>
        </nav>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stat-card bg-gradient-primary">
                <div class="position-relative">
                    <h3><?php echo $totalBooks; ?></h3>
                    <p><?php echo __('dashboard.total_books'); ?></p>
                    <i class="bi bi-book icon"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stat-card bg-gradient-success">
                <div class="position-relative">
                    <h3><?php echo $availableBooks; ?></h3>
                    <p><?php echo __('dashboard.available_books'); ?></p>
                    <i class="bi bi-check-circle icon"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stat-card bg-gradient-warning">
                <div class="position-relative">
                    <h3><?php echo $borrowedBooks; ?></h3>
                    <p><?php echo __('dashboard.borrowed_books'); ?></p>
                    <i class="bi bi-bookmark icon"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stat-card bg-gradient-info">
                <div class="position-relative">
                    <h3><?php echo $totalVisitors; ?></h3>
                    <p><?php echo __('dashboard.total_visitors'); ?></p>
                    <i class="bi bi-people icon"></i>
                </div>
            </div>
        </div>
    </div>
    
    <?php if ($user_role === 'admin'): ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-graph-up"></i> Statistik Peminjaman
                </div>
                <div class="card-body">
                    <canvas id="borrowingChart" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-clock-history"></i> Aktivitas Terbaru
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex align-items-center">
                            <i class="bi bi-book-fill text-primary me-3 fs-4"></i>
                            <div>
                                <h6 class="mb-0">Buku baru ditambahkan</h6>
                                <small class="text-muted">5 menit yang lalu</small>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center">
                            <i class="bi bi-person-check text-success me-3 fs-4"></i>
                            <div>
                                <h6 class="mb-0">Pengunjung baru terdaftar</h6>
                                <small class="text-muted">15 menit yang lalu</small>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center">
                            <i class="bi bi-arrow-return-left text-info me-3 fs-4"></i>
                            <div>
                                <h6 class="mb-0">Buku dikembalikan</h6>
                                <small class="text-muted">1 jam yang lalu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-list-ul"></i> Buku Terpopuler
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Jumlah Peminjaman</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Laskar Pelangi</td>
                                    <td>Andrea Hirata</td>
                                    <td>Novel</td>
                                    <td><span class="badge bg-success">45</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Bumi Manusia</td>
                                    <td>Pramoedya Ananta Toer</td>
                                    <td>Novel</td>
                                    <td><span class="badge bg-success">38</span></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Ayat-Ayat Cinta</td>
                                    <td>Habiburrahman El Shirazy</td>
                                    <td>Novel</td>
                                    <td><span class="badge bg-success">32</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php else: ?>
    <!-- Pengunjung Dashboard -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-book"></i> Buku Baru
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary text-white p-3 rounded">
                                        <i class="bi bi-book fs-3"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6>Laskar Pelangi</h6>
                                    <p class="text-muted mb-0">Andrea Hirata</p>
                                    <small class="text-success"><i class="bi bi-check-circle"></i> Tersedia</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-success text-white p-3 rounded">
                                        <i class="bi bi-book fs-3"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6>Bumi Manusia</h6>
                                    <p class="text-muted mb-0">Pramoedya</p>
                                    <small class="text-success"><i class="bi bi-check-circle"></i> Tersedia</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-info-circle"></i> Informasi
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="bi bi-clock"></i> Jam Operasional</h6>
                        <p class="mb-0">Senin - Jumat: 08:00 - 16:00</p>
                        <p class="mb-0">Sabtu: 08:00 - 12:00</p>
                    </div>
                    <div class="alert alert-warning">
                        <h6><i class="bi bi-exclamation-triangle"></i> Peraturan</h6>
                        <p class="mb-0"><?php echo BORROWING_RULES; ?></p>
                        <p class="mb-0">Denda: Rp <?php echo number_format(FINE_PER_DAY * 1000, 0, ',', '.'); ?>/hari</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</main>

<?php include 'layouts/footer.php'; ?>