<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include("config.php");

// Fetch held books
$result = $db->query("SELECT bh.id, u.name, u.mbiemri, u.email, l.title, bh.hold_date, bh.pickup_date, bh.return_status
                      FROM book_holds bh
                      JOIN users u ON bh.user_id = u.id
                      JOIN librat l ON bh.book_id = l.id");
?>

<?php include("header.php"); ?>

<div class="container page-head">
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success text-center" role="status">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <h1 data-intro>Paneli i Administratorit</h1>
    <p data-intro>Mirësevini në panelin e administratorit. Menaxhoni sistemin tuaj të bibliotekës këtu.</p>

    <h2 class="mt-4" data-intro>Librat e rezervuar</h2>
    <div class="admin-table-wrap" data-intro>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Emri i Studentit</th>
                    <th>Email</th>
                    <th>Titulli i Librit</th>
                    <th>Data e rezervimit</th>
                    <th>Data e tërheqjes</th>
                    <th>Statusi</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">Nuk ka libra të rezervuar për momentin.</td>
                    </tr>
                <?php endif; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['name'] . ' ' . $row['mbiemri']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['hold_date']; ?></td>
                        <td><?php echo $row['pickup_date']; ?></td>
                        <td><span class="status-pill <?php echo $row['return_status'] === 'returned' ? 'status-ok' : 'status-neutral'; ?>"><?php echo $row['return_status']; ?></span></td>
                        <td>
                            <?php if ($row['return_status'] === 'pending'): ?>
                                <!-- Mark as Returned Button -->
                                <form method="POST" action="mark_returned.php" style="display:inline;">
                                    <input type="hidden" name="hold_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-success">Shëno si i kthyer</button>
                                </form>
                            <?php endif; ?>

                            <?php if ($row['return_status'] === 'returned'): ?>
                                <!-- Delete Button -->
                                <form method="POST" action="delete_book.php" style="display:inline;">
                                    <input type="hidden" name="hold_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Fshij</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("footer.php"); ?>
