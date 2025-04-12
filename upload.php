<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
include("config.php"); // Include the database connection
?>

<?php include("header.php"); ?>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Upload a New Book</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="upload.php" method="post" enctype="multipart/form-data" class="p-4 border rounded shadow bg-white">
                <div class="mb-3">
                    <label for="title" class="form-label">Book Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter book title" required>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" name="author" id="author" class="form-control" placeholder="Enter author name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter book description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="total_books" class="form-label">Total Books in Stock</label>
                    <input type="number" name="total_books" id="total_books" class="form-control" placeholder="Enter total number of books" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Book Image</label>
                    <input type="file" name="image" id="image" class="form-control" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100">Upload Book</button>
            </form>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

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