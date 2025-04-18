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
                    <p>Biblioteka Shkollore Online është platforma kryesore për huazimin e librave arsimorë brenda shkolles.</p>
                    <div class="social-links">
                        <a href="https://britishschoolkosova.com/"><i class="fa fa-globe"></i></a>
                        <a href="https://www.facebook.com/BritishSchoolKosova/"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/thebritishschoolofkosova/?hl=en"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/bsk-the-british-school-of-kosova-a2b5051a5"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>


                <div class="footer-col">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2935.012643531661!2d21.10708847661339!3d42.639891917375856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13549e09a30ff837%3A0xd43d44deb9fe3567!2sThe%20British%20School%20of%20Kosova!5e0!3m2!1sen!2s!4v1744883171335!5m2!1sen!2s" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div class="footer-col">
                    <h3>Kontakt</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Rr Aleks Çaçi, Fushë Kosovë</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <span> +383 48 999 172 / 173</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>info@britishschoolkosova.com</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>E Hënë - E Premte: 08:00 - 16:00</span>
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
 <script src="main.js"></script>
   
 <?php include("footer.php");?>