<?php
session_start();
include("connection.php");
include("functions.php");
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
    {
        //read from database
        $query = "SELECT * FROM users WHERE user_name = '$user_name' limit 1";
        $result = mysqli_query($con, $query);
        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $user_data = mysqli_fetch_assoc($result);
                if($user_data['password'] === $password)
                {
                    session_start();
                    $_SESSION['user_id'] = $user_data['user_id'];
                    $_SESSION['loggin'] = true;
                    header("Location: Index.php");
                    die;
                }
            }
        }
        echo "wrong username or password!";
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

    <style type="text/css">

        #text{
            height: 25px;
            border-radius: 100px;
            padding: 4px;
            border: solid black;
            width: 100%;
        }
        #button{
            padding: 10px;
            width: 100px;
            color: white;
            background-color: blue;
            border: none;
        }
        #box{
            margin: auto;
            width: 300px;
            padding: 20px;
        }
    </style>
    
    <div id="box">
        
    <form method="post">
        <div style="font-size: 20px; margin: 10px; color: black;">Login</div>
        <input id="text" type="text" name="user_name" required><br><br>
        <input id="text" type="password" name="password" required><br><br>
        <input id="button" type="submit" value="Login"><br><br>
        <a href="signup.php">Click to signup</a><br><br>
    </form>
    </div>
</body>
</html>