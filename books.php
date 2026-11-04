<?php
session_start();
include("config.php");

// Fetch all books or filter by category
$category = isset($_GET['category']) ? $_GET['category'] : '';
$query = "SELECT id, title, author, foto, total_books, available_books FROM librat";
if ($category) {
    $query .= " WHERE category = '$category'";
}
$result = $db->query($query);
$books = array_merge($result ? $result->fetch_all(MYSQLI_ASSOC) : [], demo_books_in_category($category));

$useScrollMotion = true;
$categoryLinks = [
    '' => 'Të gjitha',
    'Klasa 1-5' => 'Klasa 1-5',
    'Klasa 6-9' => 'Klasa 6-9',
    'Klasa 10-12' => 'Klasa 10-12',
    'Fantazi' => 'Thriller',
    'Dramë' => 'Romancë',
    'Aventurë' => 'Poezia',
    'Mister' => 'Klasikët',
];
?>
<?php include("header.php"); ?>

<div class="container page-head">
    <h1 class="page-title" data-intro>Librat</h1>

    <!-- Categories -->
    <div class="filter-row" data-intro>
        <?php foreach ($categoryLinks as $value => $label): ?>
            <?php $isActive = $category === (string) $value; ?>
            <a href="books.php<?php echo $value === '' ? '' : '?category=' . urlencode($value); ?>" class="btn btn-outline<?php echo $isActive ? ' active' : ''; ?>"<?php echo $isActive ? ' aria-current="true"' : ''; ?>><?php echo $label; ?></a>
        <?php endforeach; ?>
    </div>

    <!-- Books Grid -->
    <?php if ($books): ?>
        <div class="books-grid">
            <?php foreach ($books as $row): ?>
                <?php include("book_card.php"); ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <p>Nuk ka libra në këtë kategori për momentin.</p>
        </div>
    <?php endif; ?>
</div>

<?php include("footer.php"); ?>
