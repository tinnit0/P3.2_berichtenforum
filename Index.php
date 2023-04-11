<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sort'])) {
    $sortOption = $_POST['sort'];
} else {
    $sortOption = 'newest';
}

if ($sortOption === 'newest') {
    $stmt = $db->prepare('SELECT * FROM answers ORDER BY id DESC');
} elseif ($sortOption === 'oldest') {
    $stmt = $db->prepare('SELECT * FROM answers ORDER BY id ASC');
} elseif ($sortOption === 'most_likes') {
    $stmt = $db->prepare('SELECT * FROM answers ORDER BY score DESC');
} elseif ($sortOption === 'least_likes') {
    $stmt = $db->prepare('SELECT * FROM answers ORDER BY score ASC');
}

$stmt->execute();

$answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['action'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];
    $user_id = $_SESSION['user_id'];

    $stmt = $db->prepare('SELECT COUNT(*) FROM votes WHERE answer_id = ? AND user_id = ? AND action = ?');
    $stmt->execute([$id, $user_id, $action]);
    $result = $stmt->fetch(PDO::FETCH_NUM);

    if ($result[0] == 0) {
        if ($action === 'upvote') {
            $stmt = $db->prepare('UPDATE answers SET score = score + 1 WHERE id = ?');
        } elseif ($action === 'downvote') {
            $stmt = $db->prepare('UPDATE answers SET score = score - 1 WHERE id = ?');
        }
        $stmt->execute([$id]);
        $stmt = $db->prepare('INSERT INTO votes (answer_id, user_id, action) VALUES (?, ?, ?)');
        $stmt->execute([$id, $user_id, $action]);
    }

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

?>

<!DOCTYPE html>
<html>
<style>
    .boxreply {
        width: 50vw;
        max-width: 50vw;
        font-size: 1.25vw;
        border: 0.2vw #383838;
        position: none;
        margin-bottom: 1vw;
        background-color: #383838;
        word-wrap: break-word;
    }
</style>

<head>
    <title>Answers</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<body class="body">
    <form method="post" action="">
        <label for="answer">Vraag:</label><br>
        <textarea id="answer" name="answer" rows="4" cols="50" min="3" required></textarea><br>
        <button type="submit">verstuur</button>
    </form>
    <div id="profielknop">
        <a href="profile.php">Profiel</a>
    </div>
    <div id="answers">
        <form method="get" action="">
            <label for="filter">Filter bij:</label>
            <select id="filter" name="filter">
                <option value="new">New</option>
                <option value="old">Old</option>
                <option value="most_likes">Most Likes</option>
                <option value="least_likes">Least Likes</option>
            </select>
            <button type="submit">Filter</button>
        </form>
        <?php
        $orderBy = '';
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['filter'])) {
            $filter = $_GET['filter'];
            if ($filter === 'new') {
                $orderBy = 'ORDER BY id DESC';
            } elseif ($filter === 'old') {
                $orderBy = 'ORDER BY id ASC';
            } elseif ($filter === 'most_likes') {
                $orderBy = 'ORDER BY score DESC';
            } elseif ($filter === 'least_likes') {
                $orderBy = 'ORDER BY score ASC';
            }
        }
        $stmt = $db->query('SELECT * FROM answers ' . $orderBy);
        $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($answers as $answer) {
            echo '<div class="box">';
            echo '<p>' . htmlspecialchars($answer['answer']) . '</p>';
            echo '<form method="post">';
            echo '<input type="hidden" name="id" required value="' . $answer['id'] . '">';
            echo '<button type="submit" name="action" value="upvote">Upvote</button>';
            echo '<p style="display: inline-block;">' . $answer['score'] . '</p>';
            echo '<button type="submit" name="action" value="downvote">Downvote</button>';
            echo '</form>';
            echo '<form method="post">';
            echo '<div style="display: inline-block;">';
            echo '<textarea id="reply" name="reply" rows="2" cols="50" required></textarea>';
            echo '<input type="hidden" name="answer_id" value="' . $answer['id'] . '">';
            echo '<button type="submit">verstuur</button>';
            echo '</div>';
            echo '</form>';

            $replyStmt = $db->prepare('SELECT * FROM replies WHERE answer_id = ?');
            $replyStmt->execute([$answer['id']]);
            $replies = $replyStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($replies as $reply) {
                echo '<div class="boxreply" style="display: inline-block;">';
                echo '<p>' . htmlspecialchars($reply['reply']) . '</p>';
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>


</body>

</html>