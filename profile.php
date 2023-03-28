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
    border-left: 6px solid blue;
    color: #000!important;
    background-color: #ddffff!important;
    font-size: 16px;
}
div{
    border-style: solid;
    border-color: black;
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
<a href="Logout1.php">Uitloggen</a>

<p>gegevens</p>
</body>
</html>











