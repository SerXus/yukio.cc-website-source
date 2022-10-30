<?php
include_once '../api/includes/db.php';
error_reporting(0);
if(!isset($_SESSION)) { session_start(); }
if(isset($_SESSION['id'])) {
  header('Location: dash.php');
exit();
}

if($_GET["ref"] != NULL)
{
    $_SESSION["ref"] = $_GET["ref"];
}
else
{
    $_SESSION["ref"] = "";
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="yukio.cc">
        <meta name="keywords" content="minecraft,reach,lunar,modification">
        <meta name="author" content="rzy">
        
        <!-- Title -->
        <title>yukio.cc</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
        <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">

      
        <!-- Theme Styles -->
        <link href="../assets/css/connect.min.css" rel="stylesheet">
        <link href="../assets/css/dark_theme.css" rel="stylesheet">

    </head>
    <body class="auth-page sign-in dark-theme">
        
        <div class='loader'>
            <div class='spinner-border text-info' role='status'>
                <span class='sr-only'>Loading...</span>
            </div>
        </div>


        <div class="connect-container align-content-stretch d-flex flex-wrap">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5">

                        <div class="auth-form">
                            <div class="row">
                                <div class="col">
                                    <div class="logo-box"><a href="#" class="logo-text">Login</a></div>
                                    <form method="POST">
                                        <div class="form-group">
                                            <input name="username" id="username" type="text" class="form-control" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block btn-submit">Sign In</button>
                                        <?php

                                            if(isset($_POST) && isset($_POST['username']) && isset($_POST['password'])) 
                                            {
                                                if (!isset($_SESSION)) 
                                                { 
                                                    session_start(); 
                                                }

                                                $username = $_POST['username'];
                                                $password = $_POST['password'];

                                                if(empty($username) || empty($password))
                                                {
                                                    echo 'error';
                                                }
                                                else
                                                {
                                                    $result = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '". mysqli_real_escape_string($con,$username) ."' " ) or die(mysqli_error($con));
                                                    if ($result->num_rows > 0) 
                                                    {
                                                        while($row = mysqli_fetch_array($result))
                                                        {
                                                            $oldencryption = $row["old"];
                                                            $hashedpass = "";
                                                            $isValid = false;

                                                            if ($oldencryption == 1) 
                                                            {
                                                                $salt = $row['salt'];
                                                                $hashedpass = md5(md5($salt).md5($password));
                                                                $isValid = $hashedpass === $row["password"];
                                                            } 
                                                            else 
                                                            {
                                                                $isValid = password_verify($password, $row["password"]);
                                                            }

                                                            if(!$isValid)
                                                            {
                                                                echo "pass error";
                                                            }
                                                            else
                                                            {
                                                                echo "good pass";
                                                                $_SESSION["id"] = $row["id"];
                                                                header("Location: dash.php");
                                                            }

                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo 'error: unknow account';
                                                    }                
                                                }
                                            }

                                        ?>


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block d-xl-block">
                        <div class="auth-image"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-3.4.1.min.js"></script>
        <script src="../assets/plugins/bootstrap/popper.min.js"></script>
        <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../assets/js/connect.min.js"></script>
    </body>
</html>