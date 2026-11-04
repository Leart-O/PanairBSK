<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hold_id'])) {
    include("config.php");

    $hold_id = intval($_POST['hold_id']); 

    if (demo_is_id($hold_id)) {
        $deleted = demo_delete_hold($hold_id);
    } else {
        // Only returned holds can be deleted. Deleting a pending hold would lose its copy for good.
        $stmt = $db->prepare("DELETE FROM book_holds WHERE id = ? AND return_status = 'returned'");
        $stmt->bind_param('i', $hold_id);
        $deleted = $stmt->execute() && $stmt->affected_rows === 1;
    }

    if ($deleted) {
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