<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "login_sample_db";
if(!$con = mysqli_connect($dbhost, $dbuser,$dbpass,$dbname))
{
    die("fail to connect!");
}

try {
    $db = new PDO("mysql:host=localhost;dbname=$dbname", $dbuser, $dbpass,);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>