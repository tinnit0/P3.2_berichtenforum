<?php
session_start();
include("connection.php");

if (isset($_POST['submit_answer'])) {
    $answer = mysqli_real_escape_string($con, $_POST['answer']);
    $sql = "INSERT INTO antwoorden (antwoord_text, antwoord_id) VALUES ('$answer', $answer_id)";
    if ($con->query($sql) === false) {
        echo "Error: " . $sql . "<br>" . $con->error;
    } else {
        header("Location: index.php");
        exit();
    }
}

if (isset($_POST['submit_question'])) {
    $question = mysqli_real_escape_string($con, $_POST['question']);
    $sql = "INSERT INTO Vragen (vraag_text, vraag_id) VALUES ('$question', $qstion_id)";
    if ($con->query($sql) === false) {
        echo "Error: " . $sql . "<br>" . $con->error;
    } else {
        header("Location: index.php");
        exit();
    }
}

        $sql = "SELECT vraag_text FROM vragen";
        $result = $con->query($sql);
        $sql = "SELECT antwoord_text FROM antwoorden";
        $result2 = $con->query($sql);
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
            <textarea class="txt_area" type="text" name="question" required></textarea>
            <button type="submit" name="submit_question">Versturen</button>
        </form>
    </div>

    <div>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<form method='post'>" . "<div name='vraag' class='box'>" . "<p class='name_card'>gepost door: (hier komt account naam)</p>";
                echo $row["vraag_text"] . "<br>" . "<textarea name='answer' class='txt_area' required></textarea>" .  "<button type='submit' name='submit_answer'>Versturen</button>" . "</div>" . "</form>";
            }
        } else {
            echo "Geen vragen gevonden.";
        }
        if ($result->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                echo $row["antwoord_text"];
            }
        } else {
            echo "Geen antwoorden gevonden.";
        }
        $con->close();
        ?>
    </div>
    <div>

    </div>
</body>

</html>
