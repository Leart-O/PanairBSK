<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
include("config.php"); 
?>

<?php include("header.php"); ?>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Ngarko një libër të ri</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="upload.php" method="post" enctype="multipart/form-data" class="p-4 border rounded shadow bg-white">
                <div class="mb-3">
                    <label for="title" class="form-label">Titulli i Librit</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter book title" required>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Autori</label>
                    <input type="text" name="author" id="author" class="form-control" placeholder="Enter author name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Përshkrimi</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter book description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Kategoria</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="Klasa 1-5">Klasa 1-5</option>
                        <option value="Klasa 6-9">Klasa 6-9</option>
                        <option value="Klasa 10-12">Klasa 10-12</option>
                        <option value="Fantazi">Thriller</option>
                        <option value="Dramë">Romancë</option>
                        <option value="Aventurë">Poezia</option>
                        <option value="Mister">Klasikët</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="total_books" class="form-label">Totali i librave në stok</label>
                    <input type="number" name="total_books" id="total_books" class="form-control" placeholder="Enter total number of books" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Imazhi i Librit</label>
                    <input type="file" name="image" id="image" class="form-control" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100">Ngarko Librin</button>
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
    $category = $_POST['category']; // Get the selected category
    $total_books = intval($_POST['total_books']); // Ensure it's an integer
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        // Insert the new book into the database
        $insert = $db->query("INSERT INTO librat (title, author, description, category, foto, total_books, available_books) 
            VALUES ('$title', '$author', '$description', '$category', '$imgContent', $total_books, $total_books)");
        if ($insert) {
            echo "Libri u ngarkua me sukses.";
        } else {
            echo "Ngarkimi i librit ka dështuar, ju lutem provoni përsëri.";
        }
    } else {
        echo "Ju lutem zgjidhni një skedar imazhi të vlefshëm për të ngarkuar.";
    }
}
?>