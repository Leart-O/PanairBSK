<?php
if (!empty($_GET['id'])) {
    include("config.php");
    
    // Get image data from database
    $result = $db->query("SELECT foto FROM librat WHERE id = {$_GET['id']}");
    if ($result->num_rows > 0) {
        $imgData = $result->fetch_assoc();

        // Render image
        header("Content-type: image/jpeg");
        echo $imgData['foto'];
    } else {
        echo 'Imazhi nuk u gjet...';
    }
}
?>

<?php include("header.php");?>
    <h1>Book Image</h1>
    <img src="view.php?id=1" alt="Book Image">
<?php include("footer.php");?>