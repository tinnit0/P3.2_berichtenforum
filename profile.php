<?php
session_start();
include("connection.php");
if ($_SESSION["loggin"] != true) {
    Header("Location: login.php");}
$users = $con->query("SELECT * FROM users WHERE id = '" . $_SESSION['user_id'] . "'");

$userdata = $users->fetch_assoc();

?>
<!DOCTYPE html>
<html>
    <head>
        <style>
h1{
    text-align: center;
}

h2{
    border-left: 650px solid blue;
    border-right: 650px solid blue;
    color: #000!important;
    background-color: #ddffff!important;
    font-size: 16px;
    text-align: center;
}
div{
    border-style: solid;
    border-color: black;
    text-align: center;
}
p{
    border-left: 650px solid blue;
    border-right: 650px solid blue;
    color: #000!important;
    background-color: rgb(220, 250, 250);
    text-align: center;
}
h3{
    border-left: 650px solid blue;
    border-right: 650px solid blue;
    color: #000!important;
    background-color: #ddffff!important;
    font-size: 16px;
    text-align: center;
}
</style>
</head>
<body>
<h1>Profiel</h1>
<div class="profile">
<h2>Gegevens</h2><?php   
echo "<p>Profielnaam<br></p>";

?>
<p>Dit zijn je badges:</p><br><br><br><br>
</div>
<a href="Logout1.php">Uitloggen</a><br>
<a href="Index.php">Berichten</a>
</body>
</html>









