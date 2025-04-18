<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka Shkollore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Loading Screen */
        #loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff; /* Ngjyra e sfondit të loading */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3; /* Ngjyra e jashtme */
            border-top: 5px solid #3498db; /* Ngjyra e brendshme */
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Animacioni i rrotullimit */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>

<!-- Loading Animation -->
<div id="loading">
    <div class="spinner"></div>
</div>

<header>
    <div class="container">
        <div class="header-inner">
            <a href="index.php" class="logo">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnpRjK0y6ryJlazJhzOrwJO7t6xppvj2pLjikw2xzhupMWG216NvKchLiyn9KCSRcniEw&usqp=CAU" alt="Logo">
                <span>Biblioteka </span>BSK
            </a>

            <ul class="nav-links" id="navLinks">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="admin.php" class="active">Paneli Administratorit</a></li>
                    <li><a href="upload.php">Shto një libër</a></li>
                    <li><a href="logout.php">Shkyçu</a></li>
                <?php elseif (isset($_SESSION['user_id'])): ?>
                    <li><a href="index.php" class="active">Kryefaqja</a></li>
                    <li><a href="#kontakt">Rreth nesh</a></li>
                    <li><a href="logout.php">Shkyqu</a></li>
                <?php else: ?>
                    <li><a href="signup.php">Regjistrohu</a></li>
                    <li><a href="login.php">Hyr</a></li>
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

<script>
    // Hide loading animation after page load
    window.addEventListener('load', () => {
        const loading = document.getElementById('loading');
        if (loading) {
            setTimeout(() => {
                loading.style.display = 'none';
            }, 500); // 2 seconds
        }
    });
</script>
</body>
</html>
