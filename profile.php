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
    border-style: solid;
    border-color: black;
    font-size: 16px;
}
</style>
</head>
<body>
<h1>Profiel</h1>
<h2>Gegevens<br><?php if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo " - Name: " . $row["user_name"]. "<br>";
    }
  } else {
    echo "0 results";
  } ?><br><br><br><br></h2>
<a href="Logout1.php">Uitloggen</a>

<p>gegevens</p>
</body>
</html>