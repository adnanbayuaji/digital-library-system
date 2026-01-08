<?php
// Landing page with navigation options
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sudut Baca Kreatif Muttu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 1rem;
        }

        .container-main {
            max-width: 500px;
            width: 100%;
        }

        .welcome-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 25px;
            padding: 2.5rem 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            margin-bottom: 1.5rem;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .logo-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .welcome-title {
            color: #333;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: #666;
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .nav-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .nav-btn {
            display: flex;
            align-items: center;
            padding: 1.2rem 1.5rem;
            border-radius: 15px;
            text-decoration: none;
            transition: all 0.3s;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .nav-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(-100%);
            transition: transform 0.3s;
        }

        .nav-btn:hover::before {
            transform: translateX(0);
        }

        .nav-btn:active {
            transform: scale(0.98);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary-custom:hover {
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            transform: translateY(-2px);
        }

        .btn-success-custom {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
            color: white;
        }

        .btn-success-custom:hover {
            box-shadow: 0 10px 30px rgba(86, 171, 47, 0.4);
            transform: translateY(-2px);
        }

        .btn-info-custom {
            background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
            color: white;
        }

        .btn-info-custom:hover {
            box-shadow: 0 10px 30px rgba(0, 180, 219, 0.4);
            transform: translateY(-2px);
        }

        .btn-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .btn-icon i {
            font-size: 1.5rem;
        }

        .btn-content {
            text-align: left;
            flex: 1;
        }

        .btn-title {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 0.2rem;
        }

        .btn-description {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .btn-arrow {
            font-size: 1.2rem;
            opacity: 0.7;
            transition: transform 0.3s;
        }

        .nav-btn:hover .btn-arrow {
            transform: translateX(5px);
        }

        .footer-text {
            margin-top: 2rem;
            color: #999;
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .welcome-card {
                padding: 2rem 1.5rem;
            }

            .welcome-title {
                font-size: 1.5rem;
            }

            .logo-icon {
                width: 70px;
                height: 70px;
            }

            .logo-icon i {
                font-size: 2rem;
            }

            .nav-btn {
                padding: 1rem 1.2rem;
            }

            .btn-icon {
                width: 45px;
                height: 45px;
            }

            .btn-icon i {
                font-size: 1.3rem;
            }

            .btn-title {
                font-size: 1rem;
            }

            .btn-description {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-main">
        <div class="welcome-card">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <h1 class="welcome-title">Sudut Baca Kreatif Muttu</h1>
                <p class="welcome-subtitle">Selamat datang di sudut baca kreatif</p>
            </div>

            <!-- Navigation Buttons -->
            <div class="nav-buttons">
                <!-- Book Stock Button -->
                <a href="public/book_stock.php" class="nav-btn btn-primary-custom">
                    <div class="btn-icon">
                        <i class="fas fa-books"></i>
                    </div>
                    <div class="btn-content">
                        <div class="btn-title">Stok Buku</div>
                        <div class="btn-description">Lihat ketersediaan buku perpustakaan</div>
                    </div>
                    <div class="btn-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>

                <!-- Visitor Log Button -->
                <a href="public/visitor_log_public.php" class="nav-btn btn-success-custom">
                    <div class="btn-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="btn-content">
                        <div class="btn-title">Daftar Kunjungan</div>
                        <div class="btn-description">Catat kunjungan Anda ke perpustakaan</div>
                    </div>
                    <div class="btn-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>

                <!-- Login Button -->
                <a href="public/login.php" class="nav-btn btn-info-custom">
                    <div class="btn-icon">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <div class="btn-content">
                        <div class="btn-title">Login Petugas</div>
                        <div class="btn-description">Masuk ke sistem manajemen perpustakaan</div>
                    </div>
                    <div class="btn-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </div>

            <!-- Footer -->
            <div class="footer-text">
                &copy; 2026 Sudut Baca Kreatif Muttu
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
