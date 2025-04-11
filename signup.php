<?php include("header.php"); ?>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Sign Up</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="signup.php" class="p-4 border rounded shadow bg-white">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <div class="mb-3">
                    <label for="mbiemri" class="form-label">Last Name</label>
                    <input type="text" name="mbiemri" id="mbiemri" class="form-control" placeholder="Enter your last name" required>
                </div>
                <div class="mb-3">
                    <label for="kartela_id" class="form-label">Kartela ID</label>
                    <input type="text" name="kartela_id" id="kartela_id" class="form-control" placeholder="Enter your Kartela ID" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </form>
        </div>
    </div>
</div>

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
        // Redirect to index.php after successful signup
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $db->close();
}
?>

<?php include("footer.php"); ?>