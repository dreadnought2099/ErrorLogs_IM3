<?php
include 'db.php';


$sql = "SELECT id, error_message, error_time FROM ErrorLogs";
$logs = $conn->query($sql);
logError($conn, "Test error logged from logs.php.");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Error Logs</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a class="navbar-brand">Error Logs</a>
            <a href="profile.html" class="navbar-brand">Profile</a>
        </div>
    </nav>
    <div class="container mt-4">
        <h2>Error Logs</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Error Message</th>
                    <th>Error Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($logs && $logs->num_rows > 0): ?>
                    <?php while ($row = $logs->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['error_message']); ?></td>
                            <td><?php echo htmlspecialchars($row['error_time']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No errors logged.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
<?php
$conn->close();
?>