<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hold_id'])) {
    include("config.php");

    $hold_id = intval($_POST['hold_id']); // Sanitize input

    // Update the record in the `book_holds` table to mark it as returned
    $stmt = $db->prepare("UPDATE book_holds SET return_status = 'returned' WHERE id = ?");
    $stmt->bind_param('i', $hold_id);

    if ($stmt->execute()) {
        // Redirect back to admin panel with success message
        header('Location: admin.php?message=Book+marked+as+returned+successfully');
        exit;
    } else {
        // Redirect back to admin panel with error message
        header('Location: admin.php?error=Failed+to+mark+book+as+returned');
        exit;
    }
}
?>