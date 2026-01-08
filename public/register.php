<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/config.php';
require_once '../config/language.php';
require_once '../config/database.php';
require_once '../src/Models/User.php';
require_once '../src/Helpers/Session.php';
require_once '../src/Helpers/Validator.php';

use App\Models\User;
use App\Helpers\Session;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    $errors = [];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = __('messages.fill_all_fields');
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = __('messages.invalid_email');
    }

    if ($password !== $confirm_password) {
        $errors[] = __('messages.password_mismatch');
    }
    
    if (strlen($password) < 6) {
        $errors[] = __('messages.min_password');
    }

    if (empty($errors)) {
        $userModel = new User($db);
        if ($userModel->create($username, $password, $email, 'pengunjung', $full_name, $phone)) {
            $_SESSION['success'] = __('messages.register_success');
            header("Location: login.php");
            exit;
        } else {
            $errors[] = __('messages.register_failed');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('auth.register'); ?> - <?php echo __('site_name'); ?></title>
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
        .register-container {
            max-width: 500px;
            margin: 0 auto;
        }
        .register-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 35px 30px;
            text-align: center;
        }
        .register-header i {
            font-size: 45px;
            margin-bottom: 10px;
        }
        .register-header h3 {
            margin: 0;
            font-weight: 600;
        }
        .register-body {
            padding: 35px;
            background: white;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }
        .input-group-text {
            background: transparent;
            border-radius: 10px 0 0 10px;
            border-right: none;
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: transform 0.2s;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
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
        
        /* Mobile Responsive Styles */
        @media (max-width: 576px) {
            body {
                padding: 20px 0;
            }
            
            .register-container {
                padding: 15px;
            }
            
            .register-header {
                padding: 25px 20px;
            }
            
            .register-header i {
                font-size: 35px;
            }
            
            .register-header h3 {
                font-size: 1.4rem;
            }
            
            .register-body {
                padding: 25px 20px;
            }
            
            .form-control, .form-select {
                padding: 10px 12px;
                font-size: 14px;
            }
            
            .btn-register {
                padding: 10px;
                font-size: 14px;
            }
            
            .language-switcher {
                top: 10px;
                right: 10px;
            }
            
            .language-switcher .dropdown-toggle {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }
            
            .form-label {
                font-size: 14px;
            }
        }
        
        @media (max-width: 400px) {
            .register-header {
                padding: 20px 15px;
            }
            
            .register-body {
                padding: 20px 15px;
            }
            
            .form-control, .form-select {
                font-size: 13px;
            }
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
        <div class="register-container">
            <div class="register-card card">
                <div class="register-header">
                    <i class="bi bi-person-plus"></i>
                    <h3><?php echo __('auth.register_title'); ?></h3>
                    <p class="mb-0 mt-2" style="font-size: 14px; opacity: 0.9;"><?php echo __('auth.register_subtitle'); ?></p>
                </div>
                <div class="register-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                                <div class="d-flex align-items-start mb-1">
                                    <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                                    <div><?php echo $error; ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold"><?php echo __('auth.username'); ?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="username" placeholder="<?php echo __('auth.username'); ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold"><?php echo __('auth.email'); ?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="<?php echo __('auth.email'); ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="full_name" class="form-label fw-semibold"><?php echo __('auth.full_name'); ?></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <input type="text" class="form-control" name="full_name" placeholder="<?php echo __('auth.full_name'); ?>">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold"><?php echo __('auth.phone'); ?></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="tel" class="form-control" name="phone" placeholder="<?php echo __('auth.phone'); ?>">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold"><?php echo __('auth.password'); ?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" name="password" placeholder="<?php echo __('auth.password'); ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label fw-semibold"><?php echo __('auth.confirm_password'); ?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" name="confirm_password" placeholder="<?php echo __('auth.confirm_password'); ?>" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-register">
                            <i class="bi bi-check-circle me-2"></i><?php echo __('auth.register'); ?>
                        </button>
                    </form>
                    
                    <div class="login-link">
                        <p class="mb-0"><?php echo __('auth.have_account'); ?> <a href="login.php"><?php echo __('auth.login_here'); ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>