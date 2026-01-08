<?php
// Session dan user info sudah di-load dari halaman parent
// Menggunakan fully qualified class name untuk menghindari masalah namespace

$current_page = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$user_role = \App\Helpers\Session::get('user_role') ?? 'pengunjung';
$username = \App\Helpers\Session::get('username') ?? 'Guest';

// Function to get correct path based on current location
function getPath($target) {
    $current_dir = basename(dirname($_SERVER['PHP_SELF']));
    
    // If we're in a subdirectory (books, visitors, reports, borrowings), go up one level
    if (in_array($current_dir, ['books', 'visitors', 'reports', 'borrowings'])) {
        return '../' . $target;
    }
    // If we're in public root
    return $target;
}
?>

<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="user-info text-center mb-4 pb-3 border-bottom">
            <div class="avatar mb-2">
                <i class="bi bi-person-circle"></i>
            </div>
            <h6 class="mb-0"><?php echo htmlspecialchars($username); ?></h6>
            <small class="badge <?php echo $user_role === 'admin' ? 'bg-danger' : 'bg-success'; ?>">
                <?php echo __('roles.' . $user_role); ?>
            </small>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>" href="<?php echo getPath('dashboard.php'); ?>">
                    <i class="bi bi-speedometer2"></i> <?php echo __('nav.dashboard'); ?>
                </a>
            </li>
            
            <?php if ($user_role === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_dir === 'books' ? 'active' : ''; ?>" 
                   href="<?php echo getPath('books/index.php'); ?>">
                    <i class="bi bi-book"></i> <?php echo __('books.title'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_dir === 'borrowings' ? 'active' : ''; ?>" 
                   href="<?php echo getPath('borrowings/index.php'); ?>">
                    <i class="bi bi-bookmark-check"></i> <?php echo current_lang() == 'id' ? 'Peminjaman' : 'Borrowings'; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_dir === 'visitors' ? 'active' : ''; ?>" 
                   href="<?php echo getPath('visitors/index.php'); ?>">
                    <i class="bi bi-people"></i> <?php echo __('visitors.title'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_dir === 'reports' ? 'active' : ''; ?>" 
                   href="<?php echo getPath('reports/index.php'); ?>">
                    <i class="bi bi-file-earmark-text"></i> <?php echo __('reports.title'); ?>
                </a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_dir === 'books' ? 'active' : ''; ?>" 
                   href="<?php echo getPath('books/index.php'); ?>">
                    <i class="bi bi-book"></i> <?php echo __('books.list'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'history.php' ? 'active' : ''; ?>" 
                   href="<?php echo getPath('borrowings/history.php'); ?>">
                    <i class="bi bi-clock-history"></i> <?php echo current_lang() == 'id' ? 'Riwayat Saya' : 'My History'; ?>
                </a>
            </li>
            <?php endif; ?>
            
            <li class="nav-item mt-3 pt-3 border-top">
                <a class="nav-link text-danger" href="<?php echo getPath('logout.php'); ?>">
                    <i class="bi bi-box-arrow-right"></i> <?php echo __('nav.logout'); ?>
                </a>
            </li>
        </ul>
    </div>
</nav>
