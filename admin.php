<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// DB details
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'bibloteka';

// Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch held books
$result = $db->query("SELECT bh.id, u.name, u.mbiemri, u.kartela_id, l.title, bh.hold_date, bh.pickup_date, bh.return_status 
                      FROM book_holds bh
                      JOIN users u ON bh.user_id = u.id
                      JOIN librat l ON bh.book_id = l.id");
?>

<?php include("header.php"); ?>

 <!-- Header -->
 <header>
        <div class="container">
            <div class="header-inner">
                <a href="index.php" class="logo">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnpRjK0y6ryJlazJhzOrwJO7t6xppvj2pLjikw2xzhupMWG216NvKchLiyn9KCSRcniEw&usqp=CAU" alt="Logo">
                    <span>Biblioteka </span>BSK
                </a>

                <ul class="nav-links" id="navLinks">
                    <li><a href="index.php" class="active">Kryefaqja</a></li>
                    <li><a href="#kontakt">Rreth nesh</a></li>
                    <li><a href="signup.php">Regjistrohu</a></li>
                    <li><a href="login.php">Kyqu</a></li>
                </ul>
            </div>
        </div>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Held Books</h1>
    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Student Name</th>
                    <th>Kartela ID</th>
                    <th>Book Title</th>
                    <th>Hold Date</th>
                    <th>Pickup Date</th>
                    <th>Status</th>
                    <th>Actions</th>
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
                                <!-- Show action button only if status is pending -->
                            <?php if ($row['return_status'] === 'pending'): ?>
                                <form method="POST" action="return_book.php">
                                    <input type="hidden" name="hold_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-success">Mark as Returned</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-sm btn-secondary" disabled>Returned</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
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