<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include("config.php");

// Fetch held books
$result = $db->query("SELECT bh.id, u.name, u.mbiemri, u.kartela_id, l.title, bh.hold_date, bh.pickup_date, bh.return_status 
                      FROM book_holds bh
                      JOIN users u ON bh.user_id = u.id
                      JOIN librat l ON bh.book_id = l.id");
?>

<?php include("header.php"); ?>

<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success text-center">
        <?php echo htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Paneli i Administratorit</h1>
    <div class="table-responsive">
        <p>Mirësevini në panelin e administratorit. Menaxhoni sistemin tuaj të bibliotekës këtu.</p>
    </div>
</div>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Librat e rezervuar</h1>
    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Emri i Studentit</th>
                    <th>Kartela ID</th>
                    <th>Titulli i Librit</th>
                    <th>Data e rezervimit</th>
                    <th>Data e tërheqjes</th>
                    <th>Statusi</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['name'] . ' ' . $row['mbiemri']; ?></td>
                        <td><?php echo $row['kartela_id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['hold_date']; ?></td>
                        <td><?php echo $row['pickup_date']; ?></td>
                        <td><?php echo $row['return_status']; ?></td>
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

<br><br><br><br>

 <!-- Footer -->
 <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div id="kontakt"></div>
                    <h3>Rreth nesh</h3>
                    <p>Biblioteka Shkollore Online është platforma kryesore për blerjen e librave arsimorë në Kosovë. Misioni ynë është të bëjmë arsimin më të arritshëm për të gjithë.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h3>Linqe të shpejta</h3>
                    <ul class="footer-links">
                        <li><a href="index.html">Kryefaqja</a></li>
                        <li><a href="about.html">Rreth nesh</a></li>
                        <li><a href="books.html">Të gjithë librat</a></li>
                        <li><a href="new-books.html">Libra të rinj</a></li>
                        <li><a href="offers.html">Oferta</a></li>
                        <li><a href="contact.html">Kontakt</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Klasat</h3>
                    <ul class="footer-links">
                        <li><a href="grade1-4.html">Klasa 1-4</a></li>
                        <li><a href="grade5-8.html">Klasa 5-8</a></li>
                        <li><a href="grade9-12.html">Klasa 9-12</a></li>
                        <li><a href="mathematics.html">Matematikë</a></li>
                        <li><a href="language.html">Gjuhë Shqipe</a></li>
                        <li><a href="science.html">Shkencë</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Kontakt</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Rruga e Arsimit, Nr. 15, Prishtinë, Kosovë</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <span>+383 44 123 456</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>info@bibliotekashkollore.com</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>E Hënë - E Premte: 08:00 - 20:00<br>E Shtunë: 09:00 - 15:00</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2023 Biblioteka Shkollore Online. Të gjitha të drejtat e rezervuara.</p>
            </div>
        </div>
    </footer>

<?php include("footer.php"); ?>