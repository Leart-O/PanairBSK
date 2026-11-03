<?php
// The one place a book return is recorded. return_book.php forwards here.
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['hold_id'])) {
    header('Location: admin.php');
    exit;
}

include("config.php");

$hold_id = intval($_POST['hold_id']);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $db->begin_transaction();

    // Only a pending hold can change, so a repeated submit can't add a second copy.
    $stmt = $db->prepare("UPDATE book_holds SET return_status = 'returned' WHERE id = ? AND return_status = 'pending'");
    $stmt->bind_param('i', $hold_id);
    $stmt->execute();
    $was_pending = $stmt->affected_rows === 1;

    if ($was_pending) {
        // The status and the copy count change together, and the count never passes the total.
        $stmt = $db->prepare("UPDATE librat l
                              JOIN book_holds bh ON l.id = bh.book_id
                              SET l.available_books = LEAST(l.available_books + 1, l.total_books)
                              WHERE bh.id = ?");
        $stmt->bind_param('i', $hold_id);
        $stmt->execute();
    }

    $db->commit();
} catch (Throwable $error) {
    $db->rollback();
    error_log("Return failed for hold $hold_id: " . $error->getMessage());
    header('Location: admin.php?error=Failed+to+mark+book+as+returned');
    exit;
}

if ($was_pending) {
    header('Location: admin.php?message=Book+marked+as+returned+successfully');
} else {
    header('Location: admin.php?message=This+book+was+already+returned');
}
exit;
