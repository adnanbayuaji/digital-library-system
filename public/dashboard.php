<?php
// Session started by Session helper
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/language.php';
require_once '../src/Helpers/Session.php';
require_once '../src/Models/Book.php';
require_once '../src/Models/Visitor.php';
require_once '../src/Models/User.php';
require_once '../src/Models/Borrowing.php';

use App\Helpers\Session;
use App\Models\Book;
use App\Models\Visitor;
use App\Models\User;
use App\Models\Borrowing;

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
$borrowingModel = new Borrowing($db);

// Fetch real statistics
$totalBooks = $bookModel->getTotalCount();
$totalCopies = $bookModel->getTotalCopiesCount();
$availableBooks = $bookModel->getAvailableCount();
$borrowedBooks = $totalCopies - $availableBooks;
$totalVisitors = $visitorModel->getTotalCount();

// Get monthly borrowing statistics for chart
$monthlyStats = $borrowingModel->getMonthlyStatistics(6);

// Get recent activities for admin dashboard
if ($user_role === 'admin') {
    $recentBooks = $bookModel->getRecentBooks(3);
    $recentUsers = $userModel->getRecentUsers(3);
    $recentBorrowings = $borrowingModel->getRecentActivities(10);
    
    // Combine all activities and sort by timestamp
    $activities = [];
    
    // Add recent books
    foreach ($recentBooks as $book) {
        $activities[] = [
            'type' => 'book',
            'icon' => 'bi-book-fill',
            'color' => 'primary',
            'title' => 'Buku baru: ' . $book['title'],
            'subtitle' => 'oleh ' . $book['author'],
            'timestamp' => strtotime($book['created_at'])
        ];
    }
    
    // Add recent users
    foreach ($recentUsers as $user) {
        $activities[] = [
            'type' => 'user',
            'icon' => 'bi-person-check',
            'color' => 'success',
            'title' => 'Pengunjung baru: ' . ($user['full_name'] ?: $user['username']),
            'subtitle' => $user['email'],
            'timestamp' => strtotime($user['created_at'])
        ];
    }
    
    // Add borrowing activities
    foreach ($recentBorrowings as $borrowing) {
        if ($borrowing['status'] === 'returned') {
            $activities[] = [
                'type' => 'return',
                'icon' => 'bi-arrow-return-left',
                'color' => 'info',
                'title' => ($borrowing['full_name'] ?: $borrowing['username']) . ' mengembalikan buku',
                'subtitle' => $borrowing['book_title'],
                'timestamp' => strtotime($borrowing['returned_date'])
            ];
        } else {
            $activities[] = [
                'type' => 'borrow',
                'icon' => 'bi-bookmark-check',
                'color' => 'warning',
                'title' => ($borrowing['full_name'] ?: $borrowing['username']) . ' meminjam buku',
                'subtitle' => $borrowing['book_title'],
                'timestamp' => strtotime($borrowing['borrowed_date'])
            ];
        }
    }
    
    // Sort by timestamp descending and limit to 5
    usort($activities, function($a, $b) {
        return $b['timestamp'] - $a['timestamp'];
    });
    $activities = array_slice($activities, 0, 5);
}

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
                    <h3><?php echo $totalCopies; ?></h3>
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
                    <h3><?php echo $borrowedBooks >= 0 ? $borrowedBooks : 0; ?></h3>
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
                    <i class="bi bi-graph-up"></i> Statistik Peminjaman (6 Bulan Terakhir)
                </div>
                <div class="card-body">
                    <canvas id="borrowingChart" height="250"></canvas>
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
                        <?php if (!empty($activities)): ?>
                            <?php foreach ($activities as $activity): ?>
                                <div class="list-group-item d-flex align-items-center">
                                    <i class="bi <?php echo $activity['icon']; ?> text-<?php echo $activity['color']; ?> me-3 fs-4"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0"><?php echo htmlspecialchars($activity['title']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($activity['subtitle']); ?></small>
                                        <br>
                                        <small class="text-muted">
                                            <?php 
                                            $diff = time() - $activity['timestamp'];
                                            if ($diff < 60) {
                                                echo 'Baru saja';
                                            } elseif ($diff < 3600) {
                                                echo floor($diff / 60) . ' menit yang lalu';
                                            } elseif ($diff < 86400) {
                                                echo floor($diff / 3600) . ' jam yang lalu';
                                            } elseif ($diff < 604800) {
                                                echo floor($diff / 86400) . ' hari yang lalu';
                                            } else {
                                                echo date('d M Y', $activity['timestamp']);
                                            }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="list-group-item text-center text-muted">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mb-0 mt-2">Belum ada aktivitas</p>
                            </div>
                        <?php endif; ?>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
<?php if ($user_role === 'admin'): ?>
// Prepare data for chart
const monthlyData = <?php echo json_encode($monthlyStats); ?>;

// Extract labels and data
const labels = monthlyData.map(item => item.month_name || 'N/A');
const borrowedData = monthlyData.map(item => parseInt(item.total_borrowed) || 0);
const returnedData = monthlyData.map(item => parseInt(item.total_returned) || 0);
const activeData = monthlyData.map(item => parseInt(item.total_active) || 0);

// Create chart
const ctx = document.getElementById('borrowingChart').getContext('2d');
const borrowingChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Total Dipinjam',
                data: borrowedData,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Dikembalikan',
                data: returnedData,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Aktif/Belum Kembali',
                data: activeData,
                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: {
                        size: 12
                    }
                }
            },
            title: {
                display: true,
                text: 'Tren Peminjaman Buku',
                font: {
                    size: 16
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
<?php endif; ?>
</script>

<?php include 'layouts/footer.php'; ?>