<?php
// Session started by Session helper
require_once '../../config/config.php';
require_once '../../src/Controllers/ReportController.php';

$reportController = new ReportController();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$borrowedBooks = $reportController->getBorrowedBooks();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books Report</title>
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Borrowed Books Report</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Borrower</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($borrowedBooks) > 0): ?>
                    <?php foreach ($borrowedBooks as $book): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo htmlspecialchars($book['borrower']); ?></td>
                            <td><?php echo htmlspecialchars($book['borrow_date']); ?></td>
                            <td><?php echo htmlspecialchars($book['return_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No borrowed books found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
    <script src="../assets/js/custom.js"></script>
</body>
</html>