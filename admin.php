<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// DB details
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'bibloteka';

// Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch held books
$result = $db->query("SELECT bh.id, u.name, u.mbiemri, u.kartela_id, l.title, bh.hold_date, bh.pickup_date, bh.return_status 
                      FROM book_holds bh
                      JOIN users u ON bh.user_id = u.id
                      JOIN librat l ON bh.book_id = l.id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Held Books</h1>
    <table border="1">
        <tr>
            <th>Student Name</th>
            <th>Kartela ID</th>
            <th>Book Title</th>
            <th>Hold Date</th>
            <th>Pickup Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name'] . ' ' . $row['mbiemri']; ?></td>
                <td><?php echo $row['kartela_id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['hold_date']; ?></td>
                <td><?php echo $row['pickup_date']; ?></td>
                <td><?php echo $row['return_status']; ?></td>
                <td>
                    <?php if ($row['return_status'] === 'pending'): ?>
                        <form method="POST" action="return_book.php">
                            <input type="hidden" name="hold_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Mark as Returned</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>