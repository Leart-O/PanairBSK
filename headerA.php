<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka Shkollore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<header>


    <div class="container">
        <div class="header-inner">
            <a href="index.php" class="logo">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnpRjK0y6ryJlazJhzOrwJO7t6xppvj2pLjikw2xzhupMWG216NvKchLiyn9KCSRcniEw&usqp=CAU" alt="Logo">
                BSK <span>Library</span>
            </a>

            <ul class="nav-links" id="navLinks">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="admin.php" class="active">Administrator Panel</a></li>
                    <li><a href="upload.php">Add a book</a></li>
                    <li><a href="logout.php">Log out</a></li>
                <?php elseif (isset($_SESSION['user_id'])): ?>
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="#kontakt">About Us</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                <?php else: ?>
                    <li><a href="signup.php">Sign Up</a></li>
                    <li><a href="login.php">Log In</a></li>
                <?php endif; ?>
            </ul>

            <div class="language-switch">
                <a href="index.php">AL</a>
                <span>/</span>
                <a href="indexAnglisht.php">EN</a>
            </div>
  
        </div>
    </div>
    
</header>
