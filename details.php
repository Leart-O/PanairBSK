<?php
session_start(); // Start the session to access session variables

if (!empty($_GET['id'])) {
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
        $stmt->execute();

        // Decrease available_books in `librat` table
        $db->query("UPDATE librat SET available_books = available_books - 1 WHERE id = $id");
        $book['available_books'] -= 1;
        echo "Book held successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($book['title']); ?></h1>
    <img src="view.php?id=<?php echo $book['id']; ?>" alt="Book Image">
    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($book['description']); ?></p>
    <p><strong>Total Copies:</strong> <?php echo $book['total_books']; ?></p>
    <p><strong>Available Copies:</strong> <?php echo $book['available_books']; ?></p>
    <p><strong>Status:</strong> <?php echo $book['is_held'] ? 'Held' : 'Available'; ?></p>

    <form method="post">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <p>You must <a href="login.php">log in</a> or <a href="signup.php">sign up</a>  to hold a book.</p>
        <?php else: ?>
            <label for="pickup_date">Pickup Date:</label>
            <input type="date" name="pickup_date" required><br>
            <button type="submit" name="hold_book" <?php echo ($book['available_books'] == 0 || $book['is_held']) ? 'disabled' : ''; ?>>
                Hold Book
            </button>
        <?php endif; ?>
    </form>

    <a href="index.php">Back to Books</a>
</body>
</html>