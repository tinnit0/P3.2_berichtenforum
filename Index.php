<?php
session_start();
include("connection.php");

if (isset($_POST['submit_answer'])) {
    $answer = mysqli_real_escape_string($con, $_POST['answer']);
    $question_id = mysqli_real_escape_string($con, $_POST['question_id']);
    $sql = "INSERT INTO Antwoorden (antwoord_text, vraag_id) VALUES ('$answer', '$question_id')";
    if ($con->query($sql) === false) {
        echo "Error: " . $sql . "<br>" . $con->error;
    } else {
        header("Location: index.php");
        exit();
    }
}

if (isset($_POST['submit_question'])) {
    $question = mysqli_real_escape_string($con, $_POST['question']);
    $sql = "INSERT INTO Vragen (vraag_text) VALUES ('$question')";
    if ($con->query($sql) === false) {
        echo "Error: " . $sql . "<br>" . $con->error;
    } else {
        $question_id = mysqli_insert_id($con);
        header("Location: index.php");
        exit();
    }
}

$sql = "SELECT vraag_text, vraag_id FROM vragen";
$result = $con->query($sql);
$sql = "SELECT antwoord_text, antwoord_id, vraag_id FROM antwoorden";
$result2 = $con->query($sql);

?>


<!DOCTYPE html>
<html>

<head>
    <title>Vragen</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<body class="body">
    <div>
        <form method="POST">
            <label for="question">Schrijf een vraag:</label>
            <textarea class="txt_area" type="text" name="question" required></textarea>
            <button type="submit" name="submit_question">Versturen</button>
        </form>
    </div>

    <div>
        <?php
        $sql = "SELECT V.vraag_text, V.vraag_id, A.antwoord_text, A.antwoord_id 
        FROM Vragen V 
        LEFT JOIN Antwoorden A ON V.vraag_id = A.vraag_id";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $questions = array();
            while ($row = $result->fetch_assoc()) {
                $question_id = $row["vraag_id"];
                if (!isset($questions[$question_id])) {
                    $questions[$question_id] = array(
                        "vraag_text" => $row["vraag_text"],
                        "antwoorden" => array()
                    );
                }
                if (!empty($row["antwoord_text"])) {
                    $questions[$question_id]["antwoorden"][] = array(
                        "antwoord_text" => $row["antwoord_text"],
                        "antwoord_id" => $row["antwoord_id"]
                    );
                }
            }
            foreach ($questions as $question_id => $question) {
                echo "<form method='post'>" . "<div class='box'>" . "<p class='name_card'>gepost door: (hier komt account naam)</p>";
                echo $question["vraag_text"] . "<br>" . "<textarea name='answer' class='txt_area' required></textarea>" .  "<input type='hidden' name='question_id' value='" . $question_id . "'>" . "<button type='submit' name='submit_answer'>Versturen</button>" ."</form>" . "</div>";
                foreach ($question["antwoorden"] as $answer) {
                    echo "<div class='box answer_box' id='answer_box_" . $answer['antwoord_id'] . "'>" . "<p class='name_card'>gepost door: (hier komt account naam)</p>" . $answer["antwoord_text"] . "</div>";
                }
            }
        } else {
            echo "Geen vragen gevonden.";
        }

        $con->close();
        ?>
    </div>
</body>

</html>