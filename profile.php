<?php
session_start();
include("connection.php");
$sql = "SELECT user_name FROM users";
$result = $con->query($sql);


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
</style>
</head>
<body>
<h1>Profiel</h1>
<div class="profile">
<h2>Gegevens</h2><?php if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<p>Profielnaam<br></p>" . $row["user_name"]. "<br>";
    }
  } else {
    echo "0 results";
  } ?><br><br><br><br>
</div>
<a href="Logout1.php">Uitloggen</a><br>
<a href="Index.php">Berichten</a>
</body>
</html>











