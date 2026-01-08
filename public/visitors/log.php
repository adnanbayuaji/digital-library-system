<?php
// Session started by Session helper
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../src/Models/Visitor.php';
require_once '../../src/Helpers/Session.php';

use App\Models\Visitor;
use App\Helpers\Session;

// Check if user is logged in
if (!Session::has('user_id')) {
    header('Location: ../login.php');
    exit();
}

$user_role = Session::get('user_role');
$username = Session::get('username');
$page_title = 'Catat Kunjungan';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $purpose = trim($_POST['purpose']);

    if (!empty($name) && !empty($purpose)) {
        $visitorModel = new Visitor($db);
        if ($visitorModel->addVisitor($name, $purpose)) {
            $_SESSION['success'] = __('messages.visit_logged');
            // Redirect based on user role
            if ($user_role === 'admin') {
                header("Location: index.php");
            } else {
                header("Location: ../dashboard.php");
            }
            exit();
        } else {
            $_SESSION['error'] = __('messages.visit_log_failed');
        }
    } else {
        $_SESSION['error'] = __('messages.fill_all_fields');
    }
}
?>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/sidebar.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="page-header">
        <h1><i class="bi bi-journal-check"></i> <?php echo __('visitors.log_visit'); ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php"><?php echo __('dashboard.title'); ?></a></li>
                <li class="breadcrumb-item active"><?php echo __('visitors.log_visit'); ?></li>
            </ol>
        </nav>
    </div>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pencil-square"></i> <?php echo current_lang() == 'id' ? 'Form Kunjungan' : 'Visit Form'; ?>
                </div>
                <div class="card-body">
                    <form action="log.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold"><?php echo __('visitors.visitor_name'); ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo __('visitors.visitor_name'); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="purpose" class="form-label fw-semibold"><?php echo __('visitors.visit_purpose'); ?> <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="purpose" name="purpose" rows="3" placeholder="<?php echo __('visitors.visit_purpose'); ?>" required></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> <?php echo __('form.save'); ?>
                            </button>
                            <?php if ($user_role === 'admin'): ?>
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> <?php echo __('form.back'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>