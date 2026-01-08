<?php
// Session started by Session helper
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../src/Controllers/ReportController.php';

$reportController = new ReportController();
$visitorReports = $reportController->getVisitorReports();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Reports</title>
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Visitor Reports</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Visit Purpose</th>
                    <th>Visit Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($visitorReports)): ?>
                    <?php foreach ($visitorReports as $report): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($report['id']); ?></td>
                            <td><?php echo htmlspecialchars($report['name']); ?></td>
                            <td><?php echo htmlspecialchars($report['purpose']); ?></td>
                            <td><?php echo htmlspecialchars($report['visit_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No visitor reports found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="../index.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
    <script src="../assets/js/custom.js"></script>
</body>
</html>