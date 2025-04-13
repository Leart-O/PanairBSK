<?php
session_start();
include("config.php"); // Include the database connection

// Fetch all books or filter by category
$category = isset($_GET['category']) ? $_GET['category'] : '';
$query = "SELECT id, title, author, foto, total_books, available_books FROM librat";
if ($category) {
    $query .= " WHERE category = '$category'";
}
$result = $db->query($query);
?>
<?php include("header.php"); ?>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">All Books</h1>

    <!-- Category Filter -->
    <div class="mb-4 text-center">
        <a href="books.php" class="btn btn-outline">Të gjitha</a>
        <a href="books.php?category=Klasa+1-5" class="btn btn-outline">Klasa 1-5</a>
        <a href="books.php?category=Klasa+6-9" class="btn btn-outline">Klasa 6-9</a>
        <a href="books.php?category=Klasa+10-12" class="btn btn-outline">Klasa 10-12</a>
        <a href="books.php?category=Fantazi" class="btn btn-outline">Fantazi</a>
        <a href="books.php?category=Dramë" class="btn btn-outline">Dramë</a>
        <a href="books.php?category=Aventurë" class="btn btn-outline">Aventurë</a>
        <a href="books.php?category=Mister" class="btn btn-outline">Mister</a>
    </div>

    <!-- Books Grid -->
    <div class="books-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="book-card">
                <div class="book-img">
                    <img src="view.php?id=<?php echo $row['id']; ?>" alt="Book Image">
                </div>
                <div class="book-info">
                    <h3 class="book-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p class="book-author"><?php echo htmlspecialchars($row['author']); ?></p>
                    <p class="book-status">
                        <strong>Total Copies:</strong> <?php echo $row['total_books']; ?><br>
                        <strong>Available Copies:</strong> <?php echo $row['available_books']; ?>
                    </p>
                    <a href="details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include("footer.php"); ?>