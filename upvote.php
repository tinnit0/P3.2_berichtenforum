<?php

// Verbinding maken met de database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_sample_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleren of de verbinding werkt
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Controleren of er op de upvote-knop is geklikt
if (isset($_POST['upvote'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    // De upvote toevoegen aan de database
    $sql = "UPDATE posts SET upvotes = upvotes + 1 WHERE id = '$post_id'";
    $conn->query($sql);

    // De gebruiker punten geven voor de upvote
    $sql = "UPDATE users SET points = points + 1 WHERE id = '$user_id'";
    $conn->query($sql);
}

if (isset($_POST['upvote'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    echo "Post ID: " . $post_id;
    echo "User ID: " . $user_id;

    // De upvote toevoegen aan de database
    $sql = "UPDATE posts SET upvotes = upvotes + 1 WHERE id = '$post_id'";
    $conn->query($sql);

    // De gebruiker punten geven voor de upvote
    $sql = "UPDATE users SET points = points + 1 WHERE id = '$user_id'";
    $conn->query($sql);
}

// Sluiten van de verbinding met de database
$conn->close();

?>
<?php
// code voor verbinding met de database en verwerking van het formulier
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>
    <?php include 'formulier.php'; ?>
</body>
</html>