<?php
// Public page - no login required
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Models/Book.php';

use App\Models\Book;

$bookModel = new Book($db);
$books = $bookModel->getAll();

// Get search parameter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Filter books if search query exists
if (!empty($search)) {
    $books = array_filter($books, function($book) use ($search) {
        $searchLower = strtolower($search);
        return stripos($book['title'], $search) !== false || 
               stripos($book['author'], $search) !== false ||
               stripos($book['isbn'], $search) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Buku - Sudut Baca Kreatif Muttu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 0;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-section {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-title {
            color: #667eea;
            font-weight: bold;
            font-size: 1.5rem;
            margin: 0;
            text-align: center;
        }

        .search-container {
            background: white;
            border-radius: 15px;
            padding: 0.8rem;
            margin: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .search-input {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s;
        }

        .search-input:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .book-container {
            padding: 0 1rem 1rem 1rem;
        }

        .book-card {
            background: white;
            border-radius: 15px;
            padding: 1.2rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .book-card:active {
            transform: scale(0.98);
        }

        .book-title {
            color: #333;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .book-author {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 0.3rem;
        }

        .book-details {
            display: flex;
            gap: 1rem;
            margin-top: 0.8rem;
            flex-wrap: wrap;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.9rem;
            color: #555;
        }

        .detail-item i {
            color: #667eea;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.95rem;
            margin-top: 0.8rem;
        }

        .stock-available {
            background: #d4edda;
            color: #155724;
        }

        .stock-limited {
            background: #fff3cd;
            color: #856404;
        }

        .stock-empty {
            background: #f8d7da;
            color: #721c24;
        }

        .no-results {
            text-align: center;
            padding: 3rem 1rem;
            color: white;
        }

        .no-results i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .stats-container {
            display: flex;
            gap: 0.5rem;
            margin: 1rem;
            flex-wrap: wrap;
        }

        .stat-card {
            flex: 1;
            min-width: 150px;
            background: white;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: bold;
            color: #667eea;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.3rem;
        }

        .refresh-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #667eea;
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 999;
        }

        .refresh-btn:active {
            transform: scale(0.95);
        }

        /* Loading animation */
        .loading {
            text-align: center;
            padding: 2rem;
            color: white;
        }

        .loading i {
            font-size: 2rem;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .header-title {
                font-size: 1.3rem;
            }

            .book-card {
                padding: 1rem;
            }

            .book-title {
                font-size: 1rem;
            }

            .stat-card {
                min-width: 120px;
            }

            .stat-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-section">
        <h1 class="header-title">
            <i class="fas fa-book"></i> Stok Buku Perpustakaan
        </h1>
    </div>

    <!-- Statistics -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-number"><?php echo count($books); ?></div>
            <div class="stat-label">Total Judul</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php 
                $totalCopies = array_sum(array_column($books, 'total_copies'));
                echo $totalCopies; 
                ?>
            </div>
            <div class="stat-label">Total Eksemplar</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php 
                $availableCopies = array_sum(array_column($books, 'available_copies'));
                echo $availableCopies; 
                ?>
            </div>
            <div class="stat-label">Tersedia</div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
        <form method="GET" action="">
            <div class="input-group">
                <input type="text" 
                       name="search" 
                       class="search-input" 
                       placeholder="Cari judul, penulis, atau ISBN..." 
                       value="<?php echo htmlspecialchars($search); ?>"
                       autocomplete="off">
            </div>
        </form>
    </div>

    <!-- Books List -->
    <div class="book-container">
        <?php if (empty($books)): ?>
            <div class="no-results">
                <i class="fas fa-search"></i>
                <h3>Tidak ada buku ditemukan</h3>
                <p><?php echo $search ? 'Coba kata kunci lain' : 'Belum ada buku dalam sistem'; ?></p>
            </div>
        <?php else: ?>
            <?php foreach ($books as $book): ?>
                <div class="book-card">
                    <div class="book-title"><?php echo htmlspecialchars($book['title']); ?></div>
                    <div class="book-author">
                        <i class="fas fa-user-edit"></i> <?php echo htmlspecialchars($book['author']); ?>
                    </div>
                    
                    <div class="book-details">
                        <?php if (!empty($book['published_year'])): ?>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span><?php echo htmlspecialchars($book['published_year']); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($book['isbn'])): ?>
                            <div class="detail-item">
                                <i class="fas fa-barcode"></i>
                                <span><?php echo htmlspecialchars($book['isbn']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php 
                    $available = (int)$book['available_copies'];
                    $total = (int)$book['total_copies'];
                    $percentage = $total > 0 ? ($available / $total) * 100 : 0;
                    
                    if ($available == 0) {
                        $badgeClass = 'stock-empty';
                        $icon = 'fa-times-circle';
                        $text = 'Tidak Tersedia';
                    } elseif ($percentage <= 30) {
                        $badgeClass = 'stock-limited';
                        $icon = 'fa-exclamation-circle';
                        $text = "$available dari $total tersedia";
                    } else {
                        $badgeClass = 'stock-available';
                        $icon = 'fa-check-circle';
                        $text = "$available dari $total tersedia";
                    }
                    ?>
                    
                    <div class="stock-badge <?php echo $badgeClass; ?>">
                        <i class="fas <?php echo $icon; ?>"></i>
                        <span><?php echo $text; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Refresh Button -->
    <button class="refresh-btn" onclick="location.reload();" title="Refresh">
        <i class="fas fa-sync-alt"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-submit search form on input with debounce
        let searchTimeout;
        const searchInput = document.querySelector('.search-input');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    searchInput.form.submit();
                }, 500);
            });
        }

        // Add smooth scroll
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>
