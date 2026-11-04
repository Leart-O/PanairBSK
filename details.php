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
        $pickup_date = isset($_POST['pickup_date']) ? trim($_POST['pickup_date']) : null;

        if (!$pickup_date) {
            echo "<p style='color: red;'>Pickup date is required.</p>";
            exit;
        }

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

<div class="container page-head">
    <div class="detail-layout">
        <!-- Book Image -->
        <div class="detail-cover" data-intro>
            <img src="view.php?id=<?php echo $book['id']; ?>" alt="Kopertina e librit <?php echo htmlspecialchars($book['title']); ?>">
        </div>

        <!-- Book Details -->
        <div>
            <h1 data-intro><?php echo htmlspecialchars($book['title']); ?></h1>
            <dl class="detail-meta" data-intro>
                <dt>Autori</dt>
                <dd><?php echo htmlspecialchars($book['author']); ?></dd>
                <dt>Përshkrimi</dt>
                <dd><?php echo htmlspecialchars($book['description']); ?></dd>
                <dt>Kopje gjithsej</dt>
                <dd><?php echo $book['total_books']; ?></dd>
                <dt>Kopje në dispozicion</dt>
                <dd><?php echo $book['available_books']; ?></dd>
                <dt>Statusi</dt>
                <dd>
                    <span class="status-pill <?php echo $book['is_held'] ? 'status-none' : 'status-ok'; ?>">
                        <?php echo $book['is_held'] ? 'Held' : 'Available'; ?>
                    </span>
                </dd>
            </dl>

            <!-- Hold Book Form -->
            <form method="post" class="hold-form" data-intro>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <div class="alert alert-warning">
                        Ju duhet të <a href="login.php" class="alert-link">kyçeni</a> ose <a href="signup.php" class="alert-link">krijoni llogari</a> për të rezervuar këtë libër.
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <label for="pickup_date" class="form-label">Data e marrjes:</label>
                        <input type="date" name="pickup_date" id="pickup_date" class="form-control" min="<?php echo date('Y-m-d'); ?>" data-datepicker required>
                    </div>
                    <button type="submit" name="hold_book" class="btn btn-primary" <?php echo ($book['available_books'] == 0 || $book['is_held']) ? 'disabled' : ''; ?>>
                        Rezervo Librin
                    </button>
                    <?php if (isset($success_message)): ?>
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <strong>Sukses!</strong> <?php echo $success_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Mbyll"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <strong>Gabim!</strong> <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Mbyll"></button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </form>

            <a href="books.php" class="btn btn-secondary" data-intro>Kthehu</a>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
