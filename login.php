<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // DB connection
    $db = new mysqli('localhost', 'root', '', 'bibloteka');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Check user credentials
    $stmt = $db->prepare("SELECT id, password, role FROM users WHERE name = ?");
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password, $role);
    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;

            // Redirect based on role
            if ($role === 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
    $stmt->close();
    $db->close();
}
?>
<!DOCTYPE html>
<html>
<body>
    <form method="POST" action="login.php">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Log In</button>
    </form>
</body>
</html>
<?php
echo password_hash('admin', PASSWORD_DEFAULT);
?>