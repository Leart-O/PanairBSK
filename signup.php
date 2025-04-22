<?php
session_start();
include("config.php");

$error_message = ""; // Variabël për të ruajtur mesazhin e gabimit

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $mbiemri = isset($_POST['mbiemri']) ? trim($_POST['mbiemri']) : null;
    $email = isset($_POST['email']) ? strtolower(trim($_POST['email'])) : null;
    $password = isset($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_DEFAULT) : null;

    // Kontrollo nëse ndonjë fushë është bosh
    if (!$name || !$mbiemri || !$email || !$password) {
        $error_message = "Të gjitha fushat janë të detyrueshme.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Validimi i email-it
        $error_message = "Email nuk është i vlefshëm.";
    } elseif (substr($email, -strlen('@britishschoolkosova.com')) !== '@britishschoolkosova.com') {
        // Kontrollo nëse email-i përfundon me @britishschoolkosova.com
        $error_message = "Email duhet të përmbush kërkesat e shkollës. Ju lutem përdorni email-in tuaj shkollor";
    } else {
        // Kontrollo nëse email-i ekziston në bazën e të dhënave
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Ky email është përdorur tashmë. Ju lutem përdorni një email tjetër.";
        } else {
            // Fut përdoruesin në bazën e të dhënave
            $stmt = $db->prepare("INSERT INTO users (name, mbiemri, email, password, role) VALUES (?, ?, ?, ?, 'student')");
            $stmt->bind_param('ssss', $name, $mbiemri, $email, $password);

            if ($stmt->execute()) {
                $_SESSION['user_id'] = $db->insert_id;
                $_SESSION['role'] = 'student';

                // Ridrejto te index.php
                header('Location: index.php');
                exit;
            } else {
                // Log error për debugging
                error_log("Error: " . $stmt->error);
                $error_message = "Ka ndodhur një gabim. Ju lutem provoni përsëri.";
            }
        }
        $stmt->close();
    }
    $db->close();
}
?>

<?php include("header.php"); ?>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Regjistrohu</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger text-center">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
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
                    <label for="email" class="form-label">Email Shkollor</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Shkruaj email-in tuaj (@britishschoolkosova.com)" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Fjalëkalimi</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Shkruaj Fjalëkalimin" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Regjistrohu</button>
            </form>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>