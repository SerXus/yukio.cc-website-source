<?php
include_once '../api/includes/db.php';
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

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">

      
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
                   $rank = $row["rank"];
                   $locked = $row["locked"];

                   if($locked)
                   {
                       header('Location: https://yukio.cc/pages/banned.php');
                   }

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
                        <li class="active-page">
                            <a href="dash.php" class="active"><i class="material-icons-outlined">video_label</i>Dashboard</a>
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
                        <div class="row stats-row">
                            <div class="col-lg-4 col-md-12">
                                <div class="card card-transparent stats-card">
                                    <div class="card-body">
                                        <div class="stats-info">
                                            <h5 class="card-title"><?php echo $registeredusercountvar ?></h5>
                                            <p class="stats-text">Registered Users</p>
                                        </div>
                                        <div class="stats-icon change-success">
                                            <i class="material-icons">account_circle</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="card card-transparent stats-card">
                                    <div class="card-body">
                                        <div class="stats-info">
                                            <h5 class="card-title">Version<span class="stats-change stats-change-success">1.0.0</span></h5>
                                            <p class="stats-text">12/02/20</p>
                                        </div>
                                        <div class="stats-icon change-success">
                                            <i class="material-icons">done</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="card card-transparent stats-card">
                                    <div class="card-body">
                                        <div class="stats-info">
                                            <h5 class="card-title">UUID<span class="stats-change stats-change-success"><?php echo $user_id ?></span></h5>
                                            <p class="stats-text">Your unique user ID</p>
                                        </div>
                                        <div class="stats-icon change-success">
                                            <i class="material-icons">fingerprint</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Frequently Asked Questions</h5>
                                        <div class="accordion" id="accordionExample">
                                            <div class="card">
                                                <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    WHAT ARE THE ACCEPTED PAYMENTS METHOD
                                                </div>
                                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        Yukio currently accept Paypal, Stripe and bitcoin.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    WHAT operating systems DOES YUKIO SUPPORT
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        Yukio is built and has been tested for windows 10 64bits build 1809, 1703 and 1803. Yukio may work with other Windows versions. 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    HOW TO GET MY HWID
                                                </div>
                                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        When your HWID is incorrect, your yukio version should give it for you.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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