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

                    $oldenc = $row["old"];
                    $salt = $row["salt"];
                    $password = $row["password"];

                    if($rank < 1)
                    {
                        header('Location: login.php');
                    }
                }
            }

            $mediaresult = mysqli_query($con, "SELECT * FROM `creator_code` WHERE `user_id` = '". mysqli_real_escape_string($con,$user_id) ."' " ) or die(mysqli_error($con));
            if ($mediaresult->num_rows > 0) 
            {
                while($rowmedia = mysqli_fetch_array($mediaresult))
                {
                    $creatorcode = $rowmedia["code"];
                    $codeused = $rowmedia["used"];
                    $owed = $rowmedia["owed"];
                    $lastpayout = $rowmedia["last_payout"];
                }
            }
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

                        echo '
                        <!-- only if they are media -->
                        <li class="sidebar-title">
                            Medias
                        </li>
                        <li class="active-page">
                            <a href="#" class="active"><i class="material-icons-outlined">attach_money</i>Earnings</a>
                        </li>';

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
                                        <!-- <img src="../assets/images/avatars/profile-image-1.png" alt="profile image"> -->
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
                                            <h5 class="card-title"><?php echo $codeused ?></h5>
                                            <p class="stats-text">Peoples who bought with your code</p>
                                        </div>
                                        <div class="stats-icon change-success">
                                            <i class="material-icons">data_usage</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="card card-transparent stats-card">
                                    <div class="card-body">
                                        <div class="stats-info">
                                            <h5 class="card-title"><?php echo $owed ?><span class="stats-change stats-change-success">$</span></h5>
                                            <p class="stats-text">How much we owe you</p>
                                        </div>
                                        <div class="stats-icon change-success">
                                            <i class="material-icons">point_of_sale</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="card card-transparent stats-card">
                                    <div class="card-body">
                                        <div class="stats-info">
                                            <h5 class="card-title"><?php echo $lastpayout ?><span class="stats-change stats-change-success">$</span></h5>
                                            <p class="stats-text">Last payout</p>
                                        </div>
                                        <div class="stats-icon change-success">
                                            <i class="material-icons">money_off</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Withdraw</h5>
                                        <p>You can here, request a withdraw. <b style="color: rgb(232, 20, 20);">WARNING: </b> you can't withdraw less than 15.0$ !</p>
                                        <form method="POST">
                                            <div class="form-group">
                                                <label for="paypalemailinput">Paypal email</label>
                                                <input type="email" class="form-control" id="paypalemailinput" name="paypalemailinput" placeholder="Ex: mypaypalemail@yukio.cc" minlength="6">
                                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                            </div>

                                            <div class="form-group">
                                                <label for="passwordinput">Your password</label>
                                                <input type="password" class="form-control" id="passwordinput" name="passwordinput" placeholder="" minlength="3">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block btn-submit">Submit Request</button>

                                            <?php

                                                if(isset($_POST) && isset($_POST["paypalemailinput"]) && isset($_POST["passwordinput"]))
                                                {
                                                    $paypalemail = $_POST["paypalemailinput"];
                                                    $confirmpassword = $_POST["passwordinput"];

                                                    if(strlen($paypalemail) < 5 && strlen($confirmpassword) < 5)
                                                    {
                                                        echo 'error';
                                                    }
                                                    else
                                                    {
                                                        $isValid = false;

                                                        if ($oldenc == 1) 
                                                        {
                                                            $hashedpass = md5(md5($salt).md5($confirmpassword));
                                                            $isValid = $hashedpass === $password;
                                                        } 
                                                        else 
                                                        {
                                                            $isValid = password_verify($confirmpassword, $password);
                                                        }

                                                        if(!$isValid)
                                                        {
                                                            echo "pass error";
                                                        }
                                                        else
                                                        {
                                                            $registerwithdraw = "INSERT INTO creator_payouts (user_id, amount, status)
                                                            VALUES ('$user_id', '$owed', 0)";  

                                                            if($con->query($registerwithdraw))
                                                            {
                                                                $updatelastpayout = mysqli_query($con, "UPDATE creator_code set last_payout=$owed WHERE user_id='" . $user_id . "'");
                                                                $updateowed = mysqli_query($con, "UPDATE creator_code set owed=0 WHERE user_id='" . $user_id . "'");

                                                                echo '<script> window.location.href = window.location.href </script>';
                                                            }
                                                            else
                                                            {
                                                                echo 'error: an unknow error occured while trying to register your account';
                                                                echo mysqli_error($con);
                                                            }

                                                        }

                                                    }
                                                }

                                            ?>

                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Last Payout</h5>
                                        <p>Here you can see all of your last payouts.</p>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">DATE</th>
                                                    <th scope="col">AMOUNT</th>
                                                    <th scope="col">STATUS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            $mediapayouts = mysqli_query($con, "SELECT * FROM `creator_payouts` WHERE `user_id` = '". mysqli_real_escape_string($con,$user_id) ."' " ) or die(mysqli_error($con));
                                            if ($mediapayouts->num_rows > 0) 
                                            {
                                                while($rowpayouts = mysqli_fetch_array($mediapayouts))
                                                {
                                                    if($rowpayouts["status"] == 0)
                                                    {
                                                        $status = "Pending...";
                                                    }
                                                    else if($rowpayouts["status"] == 1)
                                                    {
                                                        $status = "Sent";
                                                    }
                                                    else
                                                    {
                                                        $status = "Cancelled";
                                                    }

                                                    echo '
                                                    
                                                    <tr>
                                                        <th scope="row">'. $rowpayouts["id"] .'</th>
                                                        <td>'. $rowpayouts["date"] . '</td>
                                                        <td>'. $rowpayouts["amount"] .' $</td>
                                                        <td>'. $status .'</td>
                                                    </tr>
                                                    
                                                    ';
                                                }
                                            }
                                            else
                                            {
                                                echo '
                                                    
                                                    <tr>
                                                        <th scope="row">N/A</th>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                    </tr>
                                                    
                                                    ';
                                            }

                                            ?>
                                            </tbody>
                                        </table>       
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