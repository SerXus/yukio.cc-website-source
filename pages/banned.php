<?php
include_once '../api/includes/db.php';
//error_reporting(0);
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
exit();
}
?>


<html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">

<?php

$user_id = $_SESSION["id"];

$result = mysqli_query($con, "SELECT * FROM `users` WHERE `id` = '". mysqli_real_escape_string($con,$user_id) ."' " ) or die(mysqli_error($con));
if ($result->num_rows > 0) 
{
    while($row = mysqli_fetch_array($result))
    {
        $locked = $row["locked"];
        if(!$locked)
        {
            header('Location: https://yukio.cc');
        }

    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <!-- Title -->
        <title>Your banned !</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
        <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">

      
        <link href="../assets/css/connect.min.css" rel="stylesheet">
        <link href="../assets/css/dark_theme.css" rel="stylesheet">
        <link href="../assets/css/custom.css" rel="stylesheet">
    </head>
    <body class="error-page error-404">
        
        <div class='loader'>
            <div class='spinner-border text-primary' role='status'>
                <span class='sr-only'>Loading...</span>
            </div>
        </div>
        <div class="connect-container align-content-stretch d-flex flex-wrap">
            <div class="container d-flex align-content-stretch flex-wrap">
                <div class="row">
                    <div class="col d-flex align-content-stretch flex-wrap"">
                        <div class="error-page-image"></div>
                        <div class="error-page-text">
                            <h3>Oops.. Something went wrong</h3>
                            <p>It seems that you have been banned from our services.</p>
                            <div class="error-page-actions">
                                <a href="https://discord.gg/yukio" class="btn btn-secondary">Help Center</a>
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
        <script src="../assets/js/connect.min.js"></script>
    </body>
</html>


</html>