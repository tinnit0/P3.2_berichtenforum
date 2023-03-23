<?php
// Verbinding maken met de database en controleren of er op de knoppen is geklikt
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "upvote.systeem";

$conn = new mysqli($servername, $username, $password, $dbname);

// Query's uitvoeren om het aantal upvotes en downvotes voor het bericht te verkrijgen
if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // Query uitvoeren om upvotes en downvotes te krijgen
    $stmt = $conn->prepare("SELECT upvotes, downvotes FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $upvotes = 0;
    $downvotes = 0;

    if ($result && $result->num_rows > 0) {
        $upvotes = $row['upvotes'];
        $downvotes = $row['downvotes'];
    } else {
        // er zijn geen rijen gevonden, doe hier iets anders
    }
}
?>
<!-- HTML-code voor het formulier en het tonen van de upvotes en downvotes -->
<form method="POST" action="">
    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
    <input type="hidden" name="user_id" value="1">
    <button type="submit" name="upvote">Upvote</button>
    <button type="submit" name="downvote">Downvote</button>
</form>

<p>Aantal upvotes: <?php echo $upvotes; ?></p>
<p>Aantal downvotes: <?php echo $downvotes; ?></p>