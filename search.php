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
?>

<?php include("header.php"); ?>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Rezultatet e Kërkimit</h1>

    <?php if (isset($result) && $result->num_rows > 0): ?>
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
                            <strong>Kopje gjithsej:</strong> <?php echo $row['total_books']; ?><br>
                            <strong>Kopje në dispozicion:</strong> <?php echo $row['available_books']; ?>
                        </p>
                        <a href="details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Shiko Detajet</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center">Nuk u gjet asnjë libër për kërkimin tuaj.</p>
    <?php endif; ?>
</div>

<?php include("footer.php"); ?>