<?php
// Session will be started by language.php
require_once '../config/config.php';
require_once '../config/language.php';
require_once '../config/database.php';
require_once '../src/Models/Visitor.php';

use App\Models\Visitor;

// This page is accessible without login
$page_title = 'Catat Kunjungan';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $purpose = trim($_POST['purpose']);

    if (!empty($name) && !empty($purpose)) {
        $visitorModel = new Visitor($db);
        if ($visitorModel->addVisitor($name, $purpose)) {
            $_SESSION['visitor_success'] = current_lang() == 'id' ? "Kunjungan berhasil dicatat. Terima kasih!" : "Visit logged successfully. Thank you!";
            header("Location: visitor_log_public.php");
            exit();
        } else {
            $error = current_lang() == 'id' ? "Gagal mencatat kunjungan." : "Failed to log visit.";
        }
    } else {
        $error = current_lang() == 'id' ? "Mohon isi semua field." : "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('visitors.log_visit'); ?> - <?php echo __('site_name'); ?></title>
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .visitor-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .visitor-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .visitor-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 35px 30px;
            text-align: center;
        }
        .visitor-header i {
            font-size: 45px;
            margin-bottom: 10px;
        }
        .visitor-header h3 {
            margin: 0;
            font-weight: 600;
        }
        .visitor-body {
            padding: 35px;
            background: white;
        }
        .form-control, .form-select, textarea {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus, textarea:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: transform 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
        .language-switcher {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
        .language-switcher .dropdown-toggle {
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(102, 126, 234, 0.3);
            color: #667eea;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Language Switcher -->
    <div class="language-switcher">
        <div class="dropdown">
            <button class="btn btn-sm dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown">
                <i class="bi bi-translate"></i>
                <?php echo current_lang() == 'id' ? 'Indonesia' : 'English'; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                <li><a class="dropdown-item <?php echo current_lang() == 'id' ? 'active' : ''; ?>" href="?lang=id">Indonesia</a></li>
                <li><a class="dropdown-item <?php echo current_lang() == 'en' ? 'active' : ''; ?>" href="?lang=en">English</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="visitor-container">
            <div class="visitor-card card">
                <div class="visitor-header">
                    <i class="bi bi-journal-check"></i>
                    <h3><?php echo __('visitors.log_visit'); ?></h3>
                    <p class="mb-0 mt-2" style="font-size: 14px; opacity: 0.9;">
                        <?php echo current_lang() == 'id' ? 'Silakan catat kunjungan Anda' : 'Please log your visit'; ?>
                    </p>
                </div>
                <div class="visitor-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div><?= htmlspecialchars($error) ?></div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['visitor_success'])): ?>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div><?= htmlspecialchars($_SESSION['visitor_success']) ?></div>
                        </div>
                        <?php unset($_SESSION['visitor_success']); ?>
                    <?php endif; ?>
                    
                    <form method="POST" action="visitor_log_public.php">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold"><?php echo __('visitors.visitor_name'); ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo __('visitors.visitor_name'); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="purpose" class="form-label fw-semibold"><?php echo __('visitors.visit_purpose'); ?> <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="purpose" name="purpose" rows="4" placeholder="<?php echo __('visitors.visit_purpose'); ?>" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-check-circle me-2"></i><?php echo current_lang() == 'id' ? 'Catat Kunjungan' : 'Log Visit'; ?>
                        </button>
                    </form>
                    
                    <div class="login-link">
                        <p class="mb-0">
                            <?php echo current_lang() == 'id' ? 'Staf perpustakaan?' : 'Library staff?'; ?> 
                            <a href="login.php"><?php echo __('auth.login_here'); ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
