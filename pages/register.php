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
                                    <div class="logo-box"><a href="#" class="logo-text">Register</a></div>
                                    <form method="POST">
                                        <div class="form-group">
                                            <input name="username" id="username" type="text" class="form-control" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="referrer" id="referrer" class="form-control" placeholder="Creator (optional)" value="<?php echo $_SESSION["ref"]; ?>">
                                        </div>

                                        <p>While registering, you agree the <a href="https://yukio.cc/tos">terms of service</a></p>

                                        <button type="submit" class="btn btn-primary btn-block btn-submit">Sign Up</button>
                                        
                                        <?php

                                            if(isset($_POST) && isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]))
                                            {
                                                $username = $_POST["username"];
                                                $email = $_POST["email"];
                                                $password = $_POST["password"];

                                                if(strpos($username, " ") || strpos($password, " "))
                                                {
                                                    echo 'error: your username or password contains invalid characters';
                                                }
                                                elseif(empty($username) || empty($password))
                                                {
                                                    echo 'error: your username or password cannot be empty';
                                                }
                                                else
                                                {
                                                    $isaccexist = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$username'" ) or die(mysqli_error($con));
                                                    if($isaccexist->num_rows != 0)
                                                    {
                                                        echo 'error: this username is already used.';
                                                    }
                                                    else
                                                    {
                                                        $ref = $_POST["referrer"];
                                                        $ref_id = 0;
    
                                                        $result = mysqli_query($con, "SELECT * FROM `creator_code` WHERE `code` = '$ref'" ) or die(mysqli_error($con));
                                                        if ($result->num_rows == 0 && $ref != "") 
                                                        {
                                                            $ref = null;
                                                            echo 'error: this referrer does not exist.';
                                                        }
                                                        else if($result->num_rows != 0 && $ref != "")
                                                        {
                                                            while($row = mysqli_fetch_array($result))
                                                            {
                                                                $ref_id = $row["id"];
                                                            }
    
                                                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                                                            $register = "INSERT INTO users (username, password, email)
                                                            VALUES ('$username', '$hashedPassword', '$email')";  
                                                            if($con->query($register))
                                                            {
                                                                echo 'success';
                                                            }
                                                            else
                                                            {
                                                                echo 'error: an unknow error occured while trying to register your account';
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                                                            if(strlen($ref) == 0)
                                                            {
                                                                $register = "INSERT INTO users (username, password, email, referrer_id)
                                                                VALUES ('$username', '$hashedPassword', '$email', '$ref_id')";  
                                                                if($con->query($register))
                                                                {
                                                                    echo 'success';
                                                                }
                                                                else
                                                                {
                                                                    echo 'error: an unknow error occured while trying to register your account';
                                                                }
                                                            }
                                                        }
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