<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("config.php"); // Lidhja me bazën e të dhënave

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'registration') {
    // Validate input
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $password = isset($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_DEFAULT) : null;
    $mbiemri = isset($_POST['mbiemri']) ? trim($_POST['mbiemri']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;

    // Check if any field is missing
    if (!$name || !$password || !$mbiemri || !$email) {
        echo "<p style='color: red;'>All fields are required.</p>";
        exit;
    }

    // Shto përdoruesin në tabelën `users`
    $stmt = $db->prepare("INSERT INTO users (name, password, role, mbiemri, email) VALUES (?, ?, 'student', ?, ?)");
    $stmt->bind_param('ssss', $name, $password, $mbiemri, $email);

    if ($stmt->execute()) {
        // Ruaj të dhënat e përdoruesit në sesion
        $_SESSION['user_id'] = $db->insert_id;
        $_SESSION['role'] = 'student';

        // Ridrejto te index.php
        header('Location: index.php');
        exit;
    } else {
        // Log error për debugging
        error_log("Error: " . $stmt->error);
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $db->close();
}

// Shared layout: pages set $lang = 'en' (via headerA.php) before including this file.
$lang = (isset($lang) && $lang === 'en') ? 'en' : 'sq';
$en = $lang === 'en';
$currentPage = basename($_SERVER['PHP_SELF']);
$homeUrl = $en ? 'indexAnglisht.php' : 'index.php';

$navItems = [];
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    $navItems = [
        ['admin.php', $en ? 'Administrator Panel' : 'Paneli Administratorit'],
        ['upload.php', $en ? 'Add a book' : 'Shto një libër'],
        ['logout.php', $en ? 'Log out' : 'Shkyçu'],
    ];
} elseif (isset($_SESSION['user_id'])) {
    $navItems = [
        [$homeUrl, $en ? 'Home' : 'Kryefaqja'],
        ['books.php', $en ? 'Books' : 'Librat'],
        ['#kontakt', $en ? 'About Us' : 'Rreth nesh'],
        ['logout.php', $en ? 'Log out' : 'Shkyçu'],
    ];
} else {
    $navItems = [
        ['books.php', $en ? 'Books' : 'Librat'],
        ['signup.php', $en ? 'Sign Up' : 'Regjistrohu'],
        ['login.php', $en ? 'Log In' : 'Hyr'],
    ];
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $en ? 'BSK School Library' : 'Biblioteka Shkollore'; ?></title>
    <script>
        // Hide only the intro elements until motion.js takes over. The timer keeps
        // the page readable if the animation scripts fail to load.
        (function () {
            var root = document.documentElement;
            root.classList.add('js');
            if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                root.classList.add('motion-pending');
                setTimeout(function () { root.classList.remove('motion-pending'); }, 1500);

                // Arriving from the other language: keep the title page in place until
                // motion.js turns it. The timer shows the page if that script never runs.
                try {
                    var turnTo = sessionStorage.getItem('langTurn');
                    sessionStorage.removeItem('langTurn');
                    if (turnTo === root.lang) {
                        root.classList.add('lang-turn-in');
                        setTimeout(function () { root.classList.remove('lang-turn-in'); }, 2500);
                    }
                } catch (error) {}
            }
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo filemtime(__DIR__ . '/style.css'); ?>">
</head>
<body>

<div class="page-turn" id="pageTurn" data-show="<?php echo $lang; ?>" aria-hidden="true">
    <div class="page-turn-shade"></div>
    <div class="page-turn-sheet">
        <div class="page-turn-frame">
            <p class="page-turn-school">The British School of Kosova</p>
            <p class="page-turn-word" data-word="sq" lang="sq">Shqip</p>
            <p class="page-turn-word" data-word="en" lang="en">English</p>
        </div>
        <div class="page-turn-sheen"></div>
    </div>
</div>

<a class="skip-link" href="#main"><?php echo $en ? 'Skip to content' : 'Kalo te përmbajtja'; ?></a>

<header class="site-header" id="siteHeader">
    <div class="container">
        <div class="header-inner">
            <a href="<?php echo $homeUrl; ?>" class="logo">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnpRjK0y6ryJlazJhzOrwJO7t6xppvj2pLjikw2xzhupMWG216NvKchLiyn9KCSRcniEw&usqp=CAU" alt="" width="44" height="44">
                <span><?php echo $en ? 'BSK Library' : 'Biblioteka BSK'; ?></span>
            </a>

            <nav aria-label="<?php echo $en ? 'Main navigation' : 'Navigimi kryesor'; ?>">
                <ul class="nav-links" id="navLinks">
                    <?php foreach ($navItems as $item): ?>
                        <?php $isCurrent = $item[0] === $currentPage; ?>
                        <li><a href="<?php echo $item[0]; ?>"<?php echo $isCurrent ? ' class="active" aria-current="page"' : ''; ?>><?php echo $item[1]; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <div class="language-switch" id="languageSwitch" role="group" aria-label="<?php echo $en ? 'Language' : 'Gjuha'; ?>">
                <span class="lang-thumb" aria-hidden="true"></span>
                <a href="index.php"<?php echo !$en ? ' class="active" aria-current="true"' : ''; ?> lang="sq" data-lang="sq" aria-label="Shqip">AL</a>
                <a href="indexAnglisht.php"<?php echo $en ? ' class="active" aria-current="true"' : ''; ?> lang="en" data-lang="en" aria-label="English">EN</a>
            </div>

            <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" aria-controls="navLinks" aria-expanded="false"
                    aria-label="<?php echo $en ? 'Open menu' : 'Hap menunë'; ?>"
                    data-label-open="<?php echo $en ? 'Open menu' : 'Hap menunë'; ?>"
                    data-label-close="<?php echo $en ? 'Close menu' : 'Mbyll menunë'; ?>">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <div class="scroll-progress" aria-hidden="true"></div>
</header>

<main id="main">
