<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hold_id = $_POST['hold_id'];

    // DB connection
    $db = new mysqli('localhost', 'root', '', 'bibloteka');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Update return status and increase available_books
    $db->query("UPDATE book_holds SET return_status = 'returned' WHERE id = $hold_id");
    $db->query("UPDATE librat l
                JOIN book_holds bh ON l.id = bh.book_id
                SET l.available_books = l.available_books + 1
                WHERE bh.id = $hold_id");
    header('Location: admin.php');
    exit;
}
?>