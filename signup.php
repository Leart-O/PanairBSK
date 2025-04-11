<?php include("header.php");?>

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
    </header>



<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $mbiemri = $_POST['mbiemri'];
    $kartela_id = $_POST['kartela_id'];

    // DB connection
    $db = new mysqli('localhost', 'root', '', 'bibloteka');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Insert student into the `users` table
    $stmt = $db->prepare("INSERT INTO users (name, password, role, mbiemri, kartela_id) VALUES (?, ?, 'student', ?, ?)");
    $stmt->bind_param('ssss', $name, $password, $mbiemri, $kartela_id);
    if ($stmt->execute()) {
        echo "Signup successful! You can now log in.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $db->close();
}
?>

    <form method="POST" action="signup.php">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="mbiemri" placeholder="Last Name" required><br>
        <input type="text" name="kartela_id" placeholder="Kartela ID" required><br>
        <button type="submit">Sign Up</button>
    </form>
</body>
</html>