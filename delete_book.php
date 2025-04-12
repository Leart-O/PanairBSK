<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hold_id'])) {
    include("config.php");

    $hold_id = intval($_POST['hold_id']); // Sanitize input

    // Delete the record from the `book_holds` table
    $stmt = $db->prepare("DELETE FROM book_holds WHERE id = ?");
    $stmt->bind_param('i', $hold_id);

    if ($stmt->execute()) {
        // Redirect back to admin panel with success message
        header('Location: admin.php?message=Book+record+deleted+successfully');
        exit;
    } else {
        // Redirect back to admin panel with error message
        header('Location: admin.php?error=Failed+to+delete+book+record');
        exit;
    }
}
?>