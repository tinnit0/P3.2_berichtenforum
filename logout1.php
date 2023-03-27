<?php

session_start();
if($_SESSION['user_id']){
echo "Welkom" . $_SESSION['user_id'];
}else{
    header("Location: login.php");
}
?>