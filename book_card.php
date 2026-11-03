<?php
// One catalog card. Expects $row (a librat record) and $en from header.php.
$cardTotal = (int) $row['total_books'];
$cardAvailable = (int) $row['available_books'];
$cardTitle = htmlspecialchars($row['title']);
?>
<article class="book-card">
    <div class="book-img">
        <img src="view.php?id=<?php echo (int) $row['id']; ?>" alt="<?php echo ($en ? 'Cover of ' : 'Kopertina e librit ') . $cardTitle; ?>" loading="lazy">
    </div>
    <div class="book-info">
        <h3 class="book-title"><?php echo $cardTitle; ?></h3>
        <p class="book-author"><?php echo htmlspecialchars($row['author']); ?></p>
        <?php if ($cardAvailable > 0): ?>
            <p class="status-pill status-ok"><?php echo $en
                ? "$cardAvailable of $cardTotal copies available"
                : "$cardAvailable nga $cardTotal kopje në dispozicion"; ?></p>
        <?php else: ?>
            <p class="status-pill status-none"><?php echo $en
                ? "None of $cardTotal copies available"
                : "Asnjë nga $cardTotal kopje në dispozicion"; ?></p>
        <?php endif; ?>
        <a href="details.php?id=<?php echo (int) $row['id']; ?>" class="btn btn-primary" aria-label="<?php echo ($en ? 'View details: ' : 'Shiko detajet: ') . $cardTitle; ?>"><?php echo $en ? 'View Details' : 'Shiko Detajet'; ?></a>
    </div>
</article>
