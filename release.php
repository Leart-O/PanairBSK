<?php
if (isset($_POST['release_book'])) {
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

    // Release the book
    $id = $_POST['id'];
    $db->query("UPDATE librat SET available_books = available_books + 1, is_held = 0 WHERE id = $id");

    // Redirect back to admin panel
    header("Location: admin.php");
    exit;
}
?>