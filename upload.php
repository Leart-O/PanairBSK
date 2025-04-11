<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Book Title" required><br>
        <input type="text" name="author" placeholder="Author" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="number" name="total_books" placeholder="Total Books in Stock" required><br>
        <input type="file" name="image" required><br>
        <input type="submit" name="submit" value="UPLOAD">
    </form>
</body>
</html>

<?php
if (isset($_POST["submit"])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $total_books = intval($_POST['total_books']); // Ensure it's an integer
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

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

        // Check if the book already exists
        $query = $db->query("SELECT * FROM librat WHERE title = '$title' AND author = '$author'");
        if ($query->num_rows > 0) {
            // Book exists, update the total_books and available_books
            $db->query("UPDATE librat SET 
                total_books = total_books + $total_books, 
                available_books = available_books + $total_books 
                WHERE title = '$title' AND author = '$author'");
            echo "Book updated successfully.";
        } else {
            // Book does not exist, insert a new record
            $insert = $db->query("INSERT INTO librat (title, author, description, foto, total_books, available_books) 
                VALUES ('$title', '$author', '$description', '$imgContent', $total_books, $total_books)");
            if ($insert) {
                echo "Book uploaded successfully.";
            } else {
                echo "Book upload failed, please try again.";
            }
        }
    } else {
        echo "Please select a valid image file to upload.";
    }
}
?>