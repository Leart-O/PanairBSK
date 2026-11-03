<?php
session_start();
include("config.php"); // Lidhja me bazën e të dhënave

// Kontrollo nëse ekziston kërkimi
if (isset($_GET['kerko'])) {
    $kerko = $db->real_escape_string($_GET['kerko']); // Sanitizo inputin

    // Kërkimi në titull ose autor
    $sql = "SELECT * FROM librat WHERE title LIKE '%$kerko%' OR author LIKE '%$kerko%'";
    $result = $db->query($sql);
}
$useScrollMotion = true;
?>

<?php include("headerA.php"); ?>

<div class="container page-head">
    <h1 class="page-title" data-intro>Search Results</h1>

    <?php if (isset($result) && $result->num_rows > 0): ?>
        <div class="books-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php include("book_card.php"); ?>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="empty-state" data-intro>
            <p>No book was found for your search.</p>
        </div>
    <?php endif; ?>
</div>

<?php include("footer.php"); ?>
