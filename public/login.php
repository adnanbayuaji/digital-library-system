<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/config.php';
require_once '../config/language.php';
require_once '../config/database.php';
require_once '../src/Models/User.php';
require_once '../src/Helpers/Session.php';

use App\Helpers\Session;
use App\Models\User;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $userModel = new User($db);
        $user = $userModel->findByUsername($username);
        
        if ($user && $userModel->verifyPassword($password, $user['password'])) {
            Session::set('user_id', $user['id']);
            Session::set('username', $user['username']);
            Session::set('user_role', $user['role']);
            Session::set('user_email', $user['email']);
            
            header('Location: dashboard.php');
            exit;
        } else {
            $error = __('messages.login_failed');
        }
    } else {
        $error = __('messages.fill_all_fields');
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('auth.login'); ?> - <?php echo __('site_name'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            max-width: 450px;
            margin: 0 auto;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .login-header i {
            font-size: 50px;
            margin-bottom: 15px;
        }
        .login-header h3 {
            margin: 0;
            font-weight: 600;
        }
        .login-body {
            padding: 40px 35px;
            background: white;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        .form-control:focus {
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
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: transform 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }
        .divider::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e0e0e0;
        }
        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            color: #999;
            font-size: 14px;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link a:hover {
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
            .login-container {
                padding: 15px;
            }
            
            .login-header {
                padding: 30px 20px;
            }
            
            .login-header i {
                font-size: 40px;
            }
            
            .login-header h3 {
                font-size: 1.5rem;
            }
            
            .login-body {
                padding: 30px 20px;
            }
            
            .form-control {
                padding: 10px 12px;
                font-size: 14px;
            }
            
            .btn-login {
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
        }
        
        @media (max-width: 400px) {
            .login-header {
                padding: 25px 15px;
            }
            
            .login-body {
                padding: 25px 15px;
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
        <div class="login-container">
            <div class="login-card card">
                <div class="login-header">
                    <i class="bi bi-book"></i>
                    <h3><?php echo __('site_name'); ?></h3>
                    <p class="mb-0 mt-2" style="font-size: 14px; opacity: 0.9;"><?php echo __('auth.login_subtitle'); ?></p>
                </div>
                <div class="login-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div><?= htmlspecialchars($error) ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div><?= htmlspecialchars($_SESSION['success']) ?></div>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                    
                    <form method="POST" action="login.php">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold"><?php echo __('auth.username'); ?></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="username" name="username" 
                                       placeholder="<?php echo __('auth.username'); ?>" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold"><?php echo __('auth.password'); ?></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="<?php echo __('auth.password'); ?>" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i><?php echo __('auth.login'); ?>
                        </button>
                    </form>
                    
                    <div class="divider">
                        <span><?php echo current_lang() == 'id' ? 'atau' : 'or'; ?></span>
                    </div>
                    
                    <div class="register-link">
                        <p class="mb-0"><?php echo __('auth.no_account'); ?> <a href="register.php"><?php echo __('auth.register_here'); ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>