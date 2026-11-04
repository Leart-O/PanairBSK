<?php
session_start();
include("config.php"); // Lidhja me bazën e të dhënave

// Kontrollo nëse ekziston kërkimi
if (isset($_GET['kerko'])) {
    $kerko = $db->real_escape_string($_GET['kerko']); // Sanitizo inputin

    // Kërkimi në titull ose autor
    $sql = "SELECT * FROM librat WHERE title LIKE '%$kerko%' OR author LIKE '%$kerko%'";
    $result = $db->query($sql);
    $books = array_merge($result->fetch_all(MYSQLI_ASSOC), demo_search_books($_GET['kerko']));
}
$useScrollMotion = true;
?>

<?php include("header.php"); ?>

<div class="container page-head">
    <h1 class="page-title" data-intro>Rezultatet e Kërkimit</h1>

    <?php if (!empty($books)): ?>
        <div class="books-grid">
            <?php foreach ($books as $row): ?>
                <?php include("book_card.php"); ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state" data-intro>
            <p>Nuk u gjet asnjë libër për kërkimin tuaj.</p>
        </div>
    <?php endif; ?>
</div>

<?php include("footer.php"); ?>
