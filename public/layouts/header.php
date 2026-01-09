<?php
// Load language configuration
require_once __DIR__ . '/../../config/language.php';

// Determine correct path to assets based on current location
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$assets_path = in_array($current_dir, ['books', 'visitors', 'reports', 'borrowings']) ? '../assets' : 'assets';
?>
<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? __('dashboard.title'); ?> - <?php echo __('site_name'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo $assets_path; ?>/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?php echo $assets_path; ?>/css/responsive.css?v=<?php echo time(); ?>">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-width: 250px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar {
            background: var(--primary-gradient);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 0.75rem 1rem;
            z-index: 1050;
            height: 60px;
        }
        
        .navbar .container-fluid {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        
        .navbar-brand {
            color: white !important;
            font-weight: 600;
            font-size: 1.2rem;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }
        
        .navbar-brand img {
            height: 40px;
            width: 40px;
            object-fit: contain;
            flex-shrink: 0;
        }
        
        .navbar-brand .full-name {
            display: inline;
        }
        
        .navbar-brand .short-name {
            display: none;
        }
        
        .navbar-brand i {
            font-size: 1.3rem;
            margin-right: 0.5rem;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 65px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background: white;
        }
        
        .sidebar .nav-link {
            font-weight: 500;
            color: #333;
            padding: 0.8rem 1.5rem;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover {
            color: #667eea;
            background-color: #f8f9fa;
            border-left-color: #667eea;
        }
        
        .sidebar .nav-link.active {
            color: #667eea;
            background-color: #f0f1ff;
            border-left-color: #667eea;
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        .user-info .avatar i {
            font-size: 4rem;
            color: #667eea;
        }
        
        main {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            padding-top: 80px;
        }
        
        .card {
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .card-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 15px 15px 0 0 !important;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }
        
        /* Don't override card-body padding - let responsive.css handle it */
        
        .stat-card {
            padding: 1.5rem;
            border-radius: 15px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .stat-card .icon {
            font-size: 3rem;
            opacity: 0.3;
            position: absolute;
            right: 1rem;
            bottom: 1rem;
        }
        
        .stat-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-card p {
            margin: 0;
            font-size: 0.95rem;
            opacity: 0.9;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        
        .bg-gradient-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .bg-gradient-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .bg-gradient-danger {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: transform 0.2s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .table {
            background: white;
            border-radius: 10px;
        }
        
        .table thead th {
            border-bottom: 2px solid #667eea;
            color: #667eea;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        
        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }
        
        .page-header h1 {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }
        
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .language-switcher {
            margin: 0;
        }
        
        .language-switcher .dropdown-toggle {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
            font-weight: 500;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        .language-switcher .dropdown-toggle:hover {
            background: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.5);
        }
        
        .language-switcher .dropdown-menu {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .language-switcher .dropdown-item {
            padding: 0.6rem 1.2rem;
            transition: all 0.2s;
        }
        
        .language-switcher .dropdown-item:hover {
            background-color: #f0f1ff;
            color: #667eea;
        }
        
        .language-switcher .dropdown-item.active {
            background-color: #667eea;
            color: white;
        }
        
        .navbar-toggler {
            border: 2px solid rgba(255,255,255,0.7) !important;
            padding: 0.5rem !important;
            background: transparent;
            cursor: pointer;
        }
        
        .navbar-toggler:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(255,255,255,0.25);
            outline: none;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            width: 1.5rem;
            height: 1.5rem;
        }
        
        /* Mobile Menu Styles */
        .mobile-menu {
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            background: white;
            z-index: 1040;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            max-height: calc(100vh - 60px);
            overflow-y: auto;
            
            /* Hidden by default */
            visibility: hidden;
            opacity: 0;
            transform: translateY(-20px);
            transition: all 0.3s ease;
        }
        
        .mobile-menu.show {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }
        
        .mobile-menu .nav-link {
            font-weight: 500;
            color: #333;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            transition: all 0.3s;
        }
        
        .mobile-menu .nav-link:hover {
            color: #667eea;
            background-color: #f8f9fa;
        }
        
        .mobile-menu .nav-link.active {
            color: #667eea;
            background-color: #f0f1ff;
            border-left: 4px solid #667eea;
        }
        
        .mobile-menu .nav-link i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        .mobile-menu .user-info {
            padding: 1.5rem;
            background: var(--primary-gradient);
            color: white;
        }
        
        .mobile-menu .user-info .avatar i {
            font-size: 3rem;
            color: white;
        }
        
        @media (max-width: 767.98px) {
            main {
                margin-left: 0;
                padding: 1rem;
                padding-top: 75px;
            }
            
            .sidebar {
                display: none !important;
            }
            
            .navbar {
                padding: 0.5rem 0.75rem;
            }
            
            .navbar .container-fluid {
                gap: 0.5rem;
            }
            
            .navbar-brand {
                font-size: 0.95rem;
                gap: 0.3rem;
                flex: 1;
                min-width: 0;
            }
            
            .navbar-brand img {
                height: 32px;
                width: 32px;
            }
            
            .navbar-brand .full-name {
                display: none;
            }
            
            .navbar-brand .short-name {
                display: inline;
            }
            
            .navbar-actions {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                flex-shrink: 0;
            }
            
            .language-switcher .dropdown-toggle {
                padding: 0.4rem 0.5rem;
                font-size: 0.85rem;
            }
            
            .navbar-toggler {
                padding: 0.4rem 0.5rem;
                font-size: 1rem;
            }
            
            .page-header h1 {
                font-size: 1.5rem;
            }
            
            .card {
                margin-bottom: 1rem;
            }
            
            .stat-card h3 {
                font-size: 2rem;
            }
            
            .table-responsive {
                border-radius: 10px;
                overflow-x: auto;
            }
            
            .btn {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
            
            /* Ensure mobile menu is visible in mobile */
            .mobile-menu {
                display: block !important;
            }
        }
        
        @media (min-width: 768px) {
            .mobile-menu {
                display: none !important;
            }
            
            .navbar-toggler {
                display: none;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">
                <img src="<?php echo $assets_path; ?>/images/logo.png" alt="Logo">
                <span class="full-name"><?php echo __('site_name'); ?></span>
                <span class="short-name">Sudut Baca</span>
            </a>
            <div class="navbar-actions">
                <!-- Language Switcher -->
                <div class="language-switcher">
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-translate"></i>
                            <span class="d-none d-sm-inline"><?php echo current_lang() == 'id' ? 'ID' : 'EN'; ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                            <li>
                                <a class="dropdown-item <?php echo current_lang() == 'id' ? 'active' : ''; ?>" href="?lang=id">
                                    <i class="bi bi-check2 <?php echo current_lang() == 'id' ? '' : 'invisible'; ?>"></i>
                                    Indonesia
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo current_lang() == 'en' ? 'active' : ''; ?>" href="?lang=en">
                                    <i class="bi bi-check2 <?php echo current_lang() == 'en' ? '' : 'invisible'; ?>"></i>
                                    English
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Mobile Menu Toggle -->
                <button class="navbar-toggler d-md-none" type="button" id="mobileMenuToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        $current_dir = basename(dirname($_SERVER['PHP_SELF']));
        $user_role = \App\Helpers\Session::get('user_role') ?? 'pengunjung';
        $username = \App\Helpers\Session::get('username') ?? 'Guest';
        
        function getMobilePath($target) {
            $current_dir = basename(dirname($_SERVER['PHP_SELF']));
            if (in_array($current_dir, ['books', 'visitors', 'reports', 'borrowings'])) {
                return '../' . $target;
            }
            return $target;
        }
        ?>
        
        <div class="user-info text-center">
            <div class="avatar mb-2">
                <i class="bi bi-person-circle"></i>
            </div>
            <h6 class="mb-0"><?php echo htmlspecialchars($username); ?></h6>
            <small class="badge <?php echo $user_role === 'admin' ? 'bg-light' : 'bg-light'; ?>">
                <?php echo __('roles.' . $user_role); ?>
            </small>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>" 
                   href="<?php echo getMobilePath('dashboard.php'); ?>">
                    <i class="bi bi-speedometer2"></i> <?php echo __('nav.dashboard'); ?>
                </a>
            </li>
            
            <?php if ($user_role === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_dir === 'books' ? 'active' : ''; ?>" 
                   href="<?php echo getMobilePath('books/index.php'); ?>">
                    <i class="bi bi-book"></i> <?php echo __('books.title'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_dir === 'borrowings' ? 'active' : ''; ?>" 
                   href="<?php echo getMobilePath('borrowings/index.php'); ?>">
                    <i class="bi bi-bookmark-check"></i> <?php echo current_lang() == 'id' ? 'Peminjaman' : 'Borrowings'; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_dir === 'visitors' ? 'active' : ''; ?>" 
                   href="<?php echo getMobilePath('visitors/index.php'); ?>">
                    <i class="bi bi-people"></i> <?php echo __('visitors.title'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_dir === 'reports' ? 'active' : ''; ?>" 
                   href="<?php echo getMobilePath('reports/index.php'); ?>">
                    <i class="bi bi-file-earmark-text"></i> <?php echo __('reports.title'); ?>
                </a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_dir === 'books' ? 'active' : ''; ?>" 
                   href="<?php echo getMobilePath('books/index.php'); ?>">
                    <i class="bi bi-book"></i> <?php echo __('books.list'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'history.php' ? 'active' : ''; ?>" 
                   href="<?php echo getMobilePath('borrowings/history.php'); ?>">
                    <i class="bi bi-clock-history"></i> <?php echo current_lang() == 'id' ? 'Riwayat Saya' : 'My History'; ?>
                </a>
            </li>
            <?php endif; ?>
            
            <li class="nav-item">
                <a class="nav-link text-danger" href="<?php echo getMobilePath('logout.php'); ?>">
                    <i class="bi bi-box-arrow-right"></i> <?php echo __('nav.logout'); ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="container-fluid">
        <div class="row">
