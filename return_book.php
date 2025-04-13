<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hold_id = $_POST['hold_id'];

    include("config.php");

    // Update return status and increase available_books
    $db->query("UPDATE book_holds SET return_status = 'returned' WHERE id = $hold_id");
    $db->query("UPDATE librat l
                JOIN book_holds bh ON l.id = bh.book_id
                SET l.available_books = l.available_books + 1
                WHERE bh.id = $hold_id");

    // Redirect back to admin panel
    header('Location: admin.php');
    exit;
}
?>

<?php include("header.php"); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (isset($message)): ?>
                <div class="alert alert-success text-center">
                    <?php echo $message; ?>
                </div>
                <a href="admin.php" class="btn btn-primary d-block mt-3"> Kthehu në Panelin e Administratorit</a>
            <?php else: ?>
                <div class="alert alert-danger text-center">
                Nuk u përpunua asnjë kërkesë për kthim libri.
                </div>
                <a href="admin.php" class="btn btn-secondary d-block mt-3"> Kthehu në Panelin e Administratorit</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>