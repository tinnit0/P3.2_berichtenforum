<?php
session_start();
include("connection.php");

if(isset($_SESSION['user_id'])){
     // ingelogd
}else{
    //niet
    die("U bent niet ingelogd, ga terug naar de login pagina");
}
$users = $con->query("SELECT * FROM users WHERE id = '" . $_SESSION['id'] . "'");

$userdata = $users->fetch_assoc()
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
echo $userdata['username'];
?>
<p>Dit zijn je badges:</p><br><br><br><br>
</div>
<a href="Logout1.php">Uitloggen</a><br>
<a href="Index.php">Berichten</a>
</body>
</html>









