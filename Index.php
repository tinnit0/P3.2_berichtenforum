<?php
session_start();

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

?>

<!DOCTYPE html>
<html>
<head>
    <title>My website</title>
</head>
<body>

    <a href="logout.php">Logout</a>
    <h1>This is the index page</h1>

    <br>
    Hello, <?php echo $user_data['user_name'];?>.
</body>
</html>