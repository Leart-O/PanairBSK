<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    
    include("config.php");


    $stmt = $db->prepare("SELECT id, password, role FROM users WHERE name = ?");
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password, $role);
    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
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
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
    $stmt->close();
    $db->close();
}
?>

<?php include("header.php"); ?>

<div class="container page-head">
    <div class="form-card" data-intro>
        <h1>Hyr</h1>
        <form method="POST" action="login.php">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="name" class="form-label">Emri</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Shkruaj Emrin" autocomplete="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Fjalëkalimi</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Shkruaj Fjalëkalimin" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Hyr</button>
        </form>
    </div>
</div>

<?php include("footer.php"); ?>
