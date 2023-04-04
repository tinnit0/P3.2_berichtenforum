<?php
// Verbinding maken met de database en controleren of er op de knoppen is geklikt
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_sample_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleren of de verbinding werkt
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query's uitvoeren om het aantal upvotes en downvotes voor het bericht te verkrijgen
$post_id = $_POST['post_id'];
$stmt = $conn->prepare("SELECT upvotes, downvotes FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$upvotes = 0;
$downvotes = 0;

// Controleren of de query is uitgevoerd en het resultaat correct is
if ($result === false) {
    echo "Er is een fout opgetreden bij het uitvoeren van de query: " . $conn->error;
} elseif ($result->num_rows == 0) {
    echo "Er zijn geen rijen gevonden voor de opgegeven post.";
} else {
    $row = $result->fetch_assoc();
    $upvotes = $row['upvotes'];
    $downvotes = $row['downvotes'];
}

$stmt->close();
$conn->close();
?>

<!-- HTML-code voor het formulier en het tonen van de upvotes en downvotes -->
<!DOCTYPE html>
<html lang="nl">
<head>
    <style>
      .upvote {
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-bottom: 5px solid black;
}

.downvote {
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 5px solid black;
}

    </style>
</head>
<body>
  <form method="POST" action="">
    <div class="upvote-container">
      <button class="upvote" type="submit" name="upvote" value="<?php echo $post_id; ?>">
        <i class="fas fa-arrow-up"></i>
      </button>
      <span class="upvote-count"><?php echo $upvotes; ?></span>
    </div>

    <div class="downvote-container">
      <button class="downvote" type="submit" name="downvote" value="<?php echo $post_id; ?>">
        <i class="fas fa-arrow-down"></i>
      </button>
      <span class="downvote-count"><?php echo $downvotes; ?></span>
    </div>
  </form>

  <p>Aantal upvotes: <?php echo $upvotes; ?></p>
  <p>Aantal downvotes: <?php echo $downvotes; ?></p>
</body>
</html>
