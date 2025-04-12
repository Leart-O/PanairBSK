<?php
if (isset($_POST['release_book'])) {
    
    include("config.php");
    
    // Release the book
    $id = $_POST['id'];
    $db->query("UPDATE librat SET available_books = available_books + 1, is_held = 0 WHERE id = $id");

    // Redirect back to admin panel
    header("Location: admin.php");
    exit;
}
?>