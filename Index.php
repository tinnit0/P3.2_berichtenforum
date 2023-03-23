<?php
session_start();
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
$sql = "SELECT vraag_text FROM vragen";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="css/index.css">

<body class="body">

    <head>
        <title>Vragen</title>
    </head>
    <div>
        <form method="POST">
            <label for="question">Schrijf een vraag:</label>
            <input type="text" name="question" required>
            <button type="submit" name="submit">Versturen</button>
        </form>
    </div>

    <div>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div name='vraag' class='box'>" . "<p class='name_card'>gepost door: (hier komt account naam)</p>" ;
                echo $row["vraag_text"] . "<br>" ."<input type='text' required>" ."</div>";
            }
        } else {
            echo "Geen vragen gevonden.";
        }
        ?>
    </div>
</body>

</html>

<?php
$con->close();
?>