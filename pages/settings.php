<?php
include_once '../api/includes/db.php';
include_once '../api/discord/discord.php';
//error_reporting(0);
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
exit();
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
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
        <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">

      
        <!-- Theme Styles -->
        <link href="../assets/css/connect.min.css" rel="stylesheet">
        <link href="../assets/css/dark_theme.css" rel="stylesheet">

    </head>

    <body class="dark-theme">
        <div class='loader'>
            <div class='spinner-border text-info' role='status'>
                <span class='sr-only'>Loading...</span>
            </div>
        </div>

        <?php

            $user_id = $_SESSION["id"];

            $result = mysqli_query($con, "SELECT * FROM `users` WHERE `id` = '". mysqli_real_escape_string($con,$user_id) ."' " ) or die(mysqli_error($con));
            if ($result->num_rows > 0) 
            {
               while($row = mysqli_fetch_array($result))
               {
                   $classicnweb_access = $row["access"];
                   $lite_access = $row["lite_access"];
                   $clicker_access = $row["clicker_access"];
                   $username = $row["username"];
                   $email = $row["email"];
                   $rank = $row["rank"];

                   $locked = $row["locked"];

                   if($locked)
                   {
                       header('Location: https://yukio.cc/pages/banned.php');
                   }

                   // discord
                   $discordid = $row["discord_id"];
               }
            }
     

            $registeredusers = mysqli_query($con, "SELECT  COUNT(*) as count FROM `users`" ) or die(mysqli_error($con));
            while($row = mysqli_fetch_array($registeredusers)) { $registeredusercountvar = $row['count']; }
        

        ?>

        <div class="connect-container align-content-stretch d-flex flex-wrap">
            <div class="page-sidebar">
                <div class="logo-box"><a href="yukio.cc" class="logo-text">yukio</a></div>
                <div class="page-sidebar-inner slimscroll">
                    <ul class="accordion-menu">
                        <li class="sidebar-title">
                            Home
                        </li>
                        <li>
                            <a href="dash.php"><i class="material-icons-outlined">video_label</i>Dashboard</a>
                        </li>
                        <?php
                        if(!($lite_access >= 1 && $classicnweb_access >= 1) || $_SESSION["id"] == 1)
                        {
                            echo '
                            <li>
                                <a href="purchase.php"><i class="material-icons-outlined">shopping_cart</i>Purchase</a>
                            </li>';
                        }
                        
                        if($lite_access >= 1 || $classicnweb_access >= 1 || $clicker_access >= 1)
                        {
                            echo '
                            <li>
                                <a href="download.php"><i class="material-icons-outlined">backup</i>Download</a>
                            </li>';
                        }

                        if($rank == 1 || $rank == 3)
                        {
                            $mediaresult = mysqli_query($con, "SELECT * FROM `creator_code` WHERE `user_id` = '". mysqli_real_escape_string($con,$user_id) ."' " ) or die(mysqli_error($con));
                            if ($mediaresult->num_rows > 0) 
                            {
                                while($rowmedia = mysqli_fetch_array($mediaresult))
                                {
                                    echo '
                                    <!-- only if they are media -->
                                    <li class="sidebar-title">
                                        Medias
                                    </li>
                                    <li>
                                        <a href="medias.php"><i class="material-icons-outlined">attach_money</i>Earnings</a>
                                    </li>';
            
                                }
                            }
                        }

                        if($classicnweb_access >= 1)
                        {
                            echo '<li class="sidebar-title">
                                WebGui (UNAVAILABLE)
                            </li>
                            <li>
                                <a href="#"><i class="material-icons">app_settings_alt</i>Access<i class="material-icons has-sub-menu">add</i></a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="#">Gui</a>
                                    </li>
                                    <li>
                                        <a href="#">Cloud Configs</a>
                                    </li>
                                    <li>
                                        <a href="#">Private Configs</a>
                                    </li>
                                </ul>
                            </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="page-container">
                <div class="page-header">
                    <nav class="navbar navbar-expand">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                            <ul class="navbar-nav">
                                <li class="nav-item small-screens-sidebar-link">
                                    <a href="#" class="nav-link"><i class="material-icons-outlined">menu</i></a>
                                </li>
                                <li class="nav-item nav-profile dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span><?php echo $username ?></span><i class="material-icons dropdown-icon">keyboard_arrow_down</i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="settings.php">Settings</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="logout.php">Log out</a>
                                    </div>
                                </li>
                            </ul>
                            
                    </nav>
                </div>

                <div class="page-content">
                    <div class="main-wrapper">
                        <div class="row">
                            <div class="col-xl">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">General</h5>
                                        <form>
                                            <div class="form-group">
                                                <label >username</label>
                                                <input type="email" class="form-control" value="<?php echo $username ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label >email</label>
                                                <input type="email" class="form-control" value="<?php echo $email ?>" disabled>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl">
                                <form method="POST">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Discord</h5>
                                        <form>
                                            <?php 
                                            if(($discordid == NULL) && ($classicnweb_access >= 1 || $lite_access >= 1 || $clicker_access >= 1))
                                            {
                                                
                                                echo '<input id="discordsub" name="discordsub" class="form-control" hidden>';
                                                echo '<a href=" ' . url("770443425328660501", "https://yukio.cc/api/discord/link.php", "identify guilds.join") .' " class="btn btn-primary">Join Discord</a>';
                                            }
                                            else if(($discordid == NULL) && !($classicnweb_access >= 1 || $lite_access >= 1 || $clicker_access >= 1))
                                            {
                                                echo '<button class="btn btn-primary" disabled >Join Discord</button>';
                                                echo '<br>customers only';
                                            }

                                            if($discordid != NULL)
                                            {
                                                if($classicnweb_access >= 1 || $lite_access >= 1 || $clicker_access >= 1)
                                                {
                                                    echo '<div class="form-group">
                                                        <label >discord uid</label>
                                                        <input type="email" class="form-control" value=" '. $discordid .'" disabled>
                                                    </div>';

                                                    echo '<input id="discordsub" name="discordsub" class="form-control" hidden>';
                                                    echo '<a href="https://yukio.cc/api/discord/unlink.php" class="btn btn-primary">Unlink</a>';    
                                                }
                                            }
                                            ?>
                                        </form>
                                    </div>
                                </div>
                                </form>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xl">
                            <form method="POST">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Change your password</h5>
                                        <form>
                                            <div class="form-group">
                                                <label >password</label>
                                                <input type="password" id="currentpassword" name="currentpassword" class="form-control" placeholder="Current password">
                                            </div>
                                            <div class="form-group">
                                                <label >new password</label>
                                                <input type="password" id="newpassword1" name="newpassword1" class="form-control" placeholder="new password">
                                            </div>
                                            <div class="form-group">
                                                <label >repeat new password</label>
                                                <input type="password" id="newpassword2" name="newpassword2" class="form-control" placeholder="repeat new password">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Apply</button>
                                            <?php

                                                if(isset($_POST) && isset($_POST["currentpassword"]) && isset($_POST["newpassword1"]) && isset($_POST["newpassword2"]))
                                                {
                                                    $currentpassword = $_POST['currentpassword'];
                                                    $newpassword1 = $_POST['newpassword1'];
                                                    $newpassword2 = $_POST['newpassword2'];         
                                                    
                                                    if(empty($currentpassword) || empty($newpassword1) || empty($newpassword2))
                                                    {
                                                        echo 'error: you must enter your passwords';
                                                    }
                                                    else if($currentpassword == $newpassword1 || $currentpassword == $newpassword2)
                                                    {
                                                        echo 'error: passwords must be different than the current one';
                                                    }
                                                    else if($newpassword1 != $newpassword2)
                                                    {
                                                        echo 'error: password does not match';
                                                    }
                                                    else
                                                    {
                                                        $user_id = $_SESSION["id"];
                                                        $result = mysqli_query($con, "SELECT * FROM `users` WHERE `id` = '". mysqli_real_escape_string($con,$user_id) ."' " ) or die(mysqli_error($con));
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
                                                                    $isValid = password_verify($currentpassword, $row["password"]);
                                                                }

                                                                if(!$isValid)
                                                                {
                                                                    echo "error: password does not match with the database.";
                                                                }
                                                                else
                                                                {
                                                                    $newHashedPassword = password_hash($newpassword1, PASSWORD_DEFAULT);
                                                                    $updatepasswordhash = mysqli_query($con, "UPDATE users set old='0' WHERE id='" . $user_id . "'");
                                                                    $updatepass = mysqli_query($con, "UPDATE users set password='$newHashedPassword' WHERE id='" . $user_id . "'");
                                                                    echo 'success.';
                                                                }
                                                            }
                                                        }
                            
                                                    }
                                                }

                                            ?>
                                        </form>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-3.4.1.min.js"></script>
        <script src="../assets/plugins/bootstrap/popper.min.js"></script>
        <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="../assets/plugins/apexcharts/dist/apexcharts.min.js"></script>
        <script src="../assets/plugins/blockui/jquery.blockUI.js"></script>
        <script src="../assets/plugins/flot/jquery.flot.min.js"></script>
        <script src="../assets/plugins/flot/jquery.flot.time.min.js"></script>
        <script src="../assets/plugins/flot/jquery.flot.symbol.min.js"></script>
        <script src="../assets/plugins/flot/jquery.flot.resize.min.js"></script>
        <script src="../assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
        <script src="../assets/js/connect.min.js"></script>
        <script src="../assets/js/pages/dashboard.js"></script>
    </body>
</html>