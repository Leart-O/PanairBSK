<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>

<?php include("header.php"); ?>

 <!-- Header -->
 <header>
        <div class="container">
            <div class="header-inner">
                <a href="index.php" class="logo">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnpRjK0y6ryJlazJhzOrwJO7t6xppvj2pLjikw2xzhupMWG216NvKchLiyn9KCSRcniEw&usqp=CAU" alt="Logo">
                    <span>Biblioteka </span>BSK
                </a>

                <ul class="nav-links" id="navLinks">
                    <li><a href="index.php" class="active">Kryefaqja</a></li>
                    <li><a href="#kontakt">Rreth nesh</a></li>
                    <li><a href="signup.php">Regjistrohu</a></li>
                    <li><a href="login.php">Kyqu</a></li>
                </ul>
            </div>
        </div>

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

<br><br><br>

 <!-- Footer -->
 <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div id="kontakt"></div>
                    <h3>Rreth nesh</h3>
                    <p>Biblioteka Shkollore Online është platforma kryesore për blerjen e librave arsimorë në Kosovë. Misioni ynë është të bëjmë arsimin më të arritshëm për të gjithë.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h3>Linqe të shpejta</h3>
                    <ul class="footer-links">
                        <li><a href="index.html">Kryefaqja</a></li>
                        <li><a href="about.html">Rreth nesh</a></li>
                        <li><a href="books.html">Të gjithë librat</a></li>
                        <li><a href="new-books.html">Libra të rinj</a></li>
                        <li><a href="offers.html">Oferta</a></li>
                        <li><a href="contact.html">Kontakt</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Klasat</h3>
                    <ul class="footer-links">
                        <li><a href="grade1-4.html">Klasa 1-4</a></li>
                        <li><a href="grade5-8.html">Klasa 5-8</a></li>
                        <li><a href="grade9-12.html">Klasa 9-12</a></li>
                        <li><a href="mathematics.html">Matematikë</a></li>
                        <li><a href="language.html">Gjuhë Shqipe</a></li>
                        <li><a href="science.html">Shkencë</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Kontakt</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Rruga e Arsimit, Nr. 15, Prishtinë, Kosovë</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <span>+383 44 123 456</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>info@bibliotekashkollore.com</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>E Hënë - E Premte: 08:00 - 20:00<br>E Shtunë: 09:00 - 15:00</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2023 Biblioteka Shkollore Online. Të gjitha të drejtat e rezervuara.</p>
            </div>
        </div>
    </footer>

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