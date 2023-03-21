<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'Berichtenforum';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die('Could not connect to MySQL: ' . mysqli_connect_error());
}

echo "hoi hoi";
?>