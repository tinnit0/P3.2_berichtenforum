<?php
include("connection.php");
if (isset($_POST['submit'])) {
    $question = mysqli_real_escape_string($con, $_POST['question']);
    $sql = "INSERT INTO vragen (vraag_text) VALUES ('$question')";
    if ($con->query($sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

<<<<<<< Updated upstream
<<<<<<< Updated upstream
    include("connection.php");
    include("functions.php");
=======
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'login_sample_db';
>>>>>>> Stashed changes

    $user_data = check_login($con);
=======
$sql = "SELECT vraag_text FROM vragen";
$result = $con->query($sql);
>>>>>>> Stashed changes

?>

<!DOCTYPE html>
<html>

<head>
    <title>Vragen</title>
</head>

<body>
    <div>
        <form method="POST">
            <label for="question">Schrijf een vraag:</label>
            <input type="text" id="question" name="question" required>
            <button type="submit" name="submit">Versturen</button>
        </form>
    </div>

    <div>
        <center>
            <?php
            if ($result->num_rows > 0) {
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . $row["vraag_text"] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "Geen vragen gevonden.";
            }
            ?>
        </center>
    </div>

</body>

</html>

<?php
$con->close();
?>