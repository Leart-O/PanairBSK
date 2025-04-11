<?php
if (!empty($_GET['id'])) {
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

    // Get image data from database
    $result = $db->query("SELECT foto FROM librat WHERE id = {$_GET['id']}");
    if ($result->num_rows > 0) {
        $imgData = $result->fetch_assoc();

        // Render image
        header("Content-type: image/jpeg");
        echo $imgData['foto'];
    } else {
        echo 'Image not found...';
    }
}
?>

<?php include("header.php");?>
    <h1>Book Image</h1>
    <img src="view.php?id=1" alt="Book Image">
</body>
</html>