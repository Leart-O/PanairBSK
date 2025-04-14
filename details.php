<?php
session_start(); // Start the session to access session variables

if (!empty($_GET['id'])) {
    include("config.php");

    // Fetch book details from the database
    $id = intval($_GET['id']); // Sanitize the input
    $result = $db->query("SELECT * FROM librat WHERE id = $id");

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        // Handle case where no book is found
        echo "<p>Book not found. Please go back to the <a href='index.php'>main page</a>.</p>";
        exit; // Stop further execution
    }

    // Handle hold request
    if (isset($_POST['hold_book'])) {
        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $pickup_date = $_POST['pickup_date'];

        // Insert into `book_holds` table
        $stmt = $db->prepare("INSERT INTO book_holds (user_id, book_id, hold_date, pickup_date) VALUES (?, ?, CURDATE(), ?)");
        $stmt->bind_param('iis', $user_id, $id, $pickup_date);
        if ($stmt->execute()) {
            // Decrease available_books in `librat` table
            $db->query("UPDATE librat SET available_books = available_books - 1 WHERE id = $id");
            $book['available_books'] -= 1;

            // Display success message
            $success_message = "Libri u rezervua me sukses!";
        } else {
            $error_message = "Rezervimi i librit dështoi. Ju lutem provoni përsëri.";
        }
    }
}
?>

<?php include("header.php"); ?>

   

<div class="container mt-5">
    <div class="row">
        <!-- Book Image -->
        <div class="col-md-4">
            <img src="view.php?id=<?php echo $book['id']; ?>" alt="Book Image" class="img-fluid rounded shadow">
        </div>

        <!-- Book Details -->
        <div class="col-md-8">
            <h1 class="text-primary"><?php echo htmlspecialchars($book['title']); ?></h1>
            <p><strong>Autori:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
            <p><strong>Përshkrimi:</strong> <?php echo htmlspecialchars($book['description']); ?></p>
            <p><strong>Kopje gjithsej:</strong> <?php echo $book['total_books']; ?></p>
            <p><strong>Kopje në dispozicion:</strong> <?php echo $book['available_books']; ?></p>
            <p><strong>Statusi:</strong> 
                <span class="badge <?php echo $book['is_held'] ? 'bg-danger' : 'bg-success'; ?>">
                    <?php echo $book['is_held'] ? 'Held' : 'Available'; ?>
                </span>
            </p>

            <!-- Hold Book Form -->
            <form method="post" class="mt-4">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <div class="alert alert-warning">
                        Ju duhet të<a href="login.php" class="alert-link"> kyqeni</a> ose <a href="signup.php" class="alert-link">krijoni llogari</a> për të rezervuar këtë libër.
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <label for="pickup_date" class="form-label">Data e marrjes:</label>
                        <input type="date" name="pickup_date" id="pickup_date" class="form-control" required>
                    </div>
                    <button type="submit" name="hold_book" class="btn btn-primary" <?php echo ($book['available_books'] == 0 || $book['is_held']) ? 'disabled' : ''; ?>>
                        Rezervo Librin
                    </button>
                    <?php if (isset($success_message)): ?>
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <strong>Sukses!</strong> <?php echo $success_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <strong>Gabim!</strong> <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </form>

            <a href="index.php" class="btn btn-secondary mt-3">Kthehu</a>
        </div>
    </div>
</div>

<br><br><br><br>

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
</div>
<?php include("footer.php"); ?>