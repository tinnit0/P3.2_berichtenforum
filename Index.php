<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['action'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action === 'upvote') {
        $stmt = $db->prepare('UPDATE answers SET score = score + 1 WHERE id = ?');
    } elseif ($action === 'downvote') {
        $stmt = $db->prepare('UPDATE answers SET score = score - 1 WHERE id = ?');
    }

    $stmt->execute([$id]);

    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply']) && isset($_POST['answer_id'])) {
    $reply = $_POST['reply'];
    $answer_id = $_POST['answer_id'];

    $stmt = $db->prepare('SELECT COUNT(*) FROM answers WHERE id = ?');
    $stmt->execute([$answer_id]);
    $result = $stmt->fetch(PDO::FETCH_NUM);
    if ($result[0] > 0) {

        $stmt = $db->prepare('INSERT INTO replies (reply, answer_id) VALUES (?, ?)');
        $stmt->execute([$reply, $answer_id]);
    } else {
    }

    header('Location: index.php');
    exit;
}



$stmt = $db->query('SELECT * FROM answers');
$answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $answer = $_POST['answer'];
    $stmt = $db->prepare('INSERT INTO answers (answer) VALUES (?)');
    $stmt->execute([$answer]);

    header('Location: index.php');
    exit;
}

$stmt = $db->query('SELECT * FROM answers');
$answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Answers</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<body class="body">
    <form method="post" action="">
        <label for="answer">Vraag:</label><br>
        <textarea id="answer" name="answer" rows="4" cols="50" min="3" required></textarea><br>
        <button type="submit">Submit</button>
    </form>
    <div id="answers">
        <?php
        foreach ($answers as $answer) {
            echo '<div class="box">';
            echo '<p>' . htmlspecialchars($answer['answer']) . '</p>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id" required value="' . $answer['id'] . '">';
            echo '<button type="submit" name="action" value="upvote">Upvote</button>';
            echo '<button type="submit" name="action" value="downvote">Downvote</button>';
            echo '</form>';

            echo '<form method="post" action="">';
            echo '<label for="reply">Reply:</label><br>';
            echo '<textarea id="reply" name="reply" rows="2" cols="50" required></textarea><br>';
            echo '<input type="hidden" name="answer_id" value="' . $answer['id'] . '">';
            echo '<button type="submit">Submit</button>';
            echo '</form>';

            $replyStmt = $db->prepare('SELECT * FROM replies WHERE answer_id = ?');
            $replyStmt->execute([$answer['id']]);
            $replies = $replyStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($replies as $reply) {
                echo '<div class="reply">';
                echo '<p>' . htmlspecialchars($reply['reply']) . '</p>';
                echo '</div>';
            }

            echo '<p class="score">' . $answer['score'] . '</p>';
            echo '</div>';
        }
        ?>
    </div>
</body>

</html>