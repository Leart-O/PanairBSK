<?php
session_start();
?>
<?php include("header.php"); ?>
<?php include("config.php"); ?>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Regjistrohu</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="signup.php" class="p-4 border rounded shadow bg-white">
                <div class="mb-3">
                    <label for="name" class="form-label">Emri</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Shkruaj Emrin" required>
                </div>   
                <div class="mb-3">
                    <label for="mbiemri" class="form-label">Mbiemri</label>
                    <input type="text" name="mbiemri" id="mbiemri" class="form-control" placeholder="Shkruaj Mbiemrin" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Fjalëkalimi</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Shkruaj Fjalëkalimin" required>
                </div>
                <div class="mb-3">
                    <label for="kartela_id" class="form-label">Nr. Studentor</label>
                    <input type="text" name="kartela_id" id="kartela_id" class="form-control" placeholder="Shkruaj Nr. identifikues" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Regjistrohu</button>
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


    // Insert student into the `users` table
    $stmt = $db->prepare("INSERT INTO users (name, password, role, mbiemri, kartela_id) VALUES (?, ?, 'student', ?, ?)");
    $stmt->bind_param('ssss', $name, $password, $mbiemri, $kartela_id);
    if ($stmt->execute()) {
        // Set session variables
        $_SESSION['user_id'] = $db->insert_id;
        $_SESSION['role'] = 'student';

        // Redirect to index.php
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