<?php
include_once '../api/includes/db.php';
error_reporting(0);
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
exit();
}

require_once '../api/stripe/config.php';  
require_once '../api/paypal/PaypalPayment.php';

$payment = new PaypalPayment();
$clienteIDSandbox = $payment->getClienteIDSandbox();
$clienteIDLive = $payment->getClienteIDLive();
$mode = $payment->mode;
$currency = $payment->currency;

$orderNumber = time();
$amount = 10.99;
$description = 'yukio classic lifetime subscription';

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

        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://www.paypalobjects.com/api/checkout.js"></script>

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
                    $referrer_id = $row["referrer_id"];
                    $rank = $row["rank"];

                    $locked = $row["locked"];

                    if($locked)
                    {
                        header('Location: https://yukio.cc/pages/banned.php');
                    }

                }
            }

            if($referrer_id != 0)
            {
                $amount = 9.99;
            }
            else
            {
                $amount = 10.99;
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
                            <li class="active-page">
                                <a href="purchase.php" class="active"><i class="material-icons-outlined">shopping_cart</i>Purchase</a>
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
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Yukio Classic</h5>
                                        <p>Subscription lenght:</p>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="" id="lifetimecheck">
                                            <label class="custom-control-label" for="lifetimecheck">
                                                Lifetime
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="" id="3monthscheck" disabled>
                                            <label class="custom-control-label" for="3monthscheck">
                                                3 Months
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="" id="1monthcheck" disabled>
                                            <label class="custom-control-label" for="1monthcheck">
                                                1 Month
                                            </label>
                                        </div>


                                        <!----------------------------------->
                                        <p><br>Payment Method:</p>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="" name="paypalcheck" id="paypalcheck">
                                            <label class="custom-control-label" for="paypalcheck">
                                                PayPal
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="" name="btccheck" id="btccheck" disabled>
                                            <label class="custom-control-label" for="btccheck">
                                                Crypto
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="" name="stripecheck" id="stripecheck" disabled>
                                            <label class="custom-control-label" for="stripecheck">
                                                Stripe
                                            </label>
                                        </div>

                                        <p><br>Total: <?php echo $amount ?>€</p>

                                    </div>
                                    <div id="paypal-button-container" style="padding: 9px 24px; font-weight: 700; line-height: 22px; font-size: 13px; position: relative;"></div>

                                    <?php

                                    if(!$classicnweb_access < 1)
                                    {
                                        echo '<button id="payButton" class="btn btn-info" disabled>Purchased</button>';
                                    }
                                    else
                                    {
                                        echo '<button id="payButton" class="btn btn-info">Pay</button>';
                                    }
                                    

                                    ?>

                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="card card-transactions">
                                    <div class="card-body">
                                        <h5 class="card-title">Owned Products</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Expire</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if($classicnweb_access >= 1)
                                                {
                                                    echo
                                                    '
                                                    <tr>
                                                        <td>Yukio Classic</td>
                                                        <td>Never</td>
                                                    </tr>
                                                    ';
                                                }

                                                if($lite_access >= 1)
                                                {
                                                    echo
                                                    '
                                                    <tr>
                                                        <td>Yukio Lite</td>
                                                        <td>Never</td>
                                                    </tr>
                                                    ';
                                                }

                                                if($clicker_access >= 1)
                                                {
                                                    echo
                                                    '
                                                    <tr>
                                                        <td>Yukio Clicker</td>
                                                        <td>Never</td>
                                                    </tr>
                                                    ';
                                                }

                                                if($clicker_access < 1 && $classicnweb_access < 1 && $lite_access < 1)
                                                {
                                                    if($lite_access >= 1)
                                                {
                                                    echo
                                                    '
                                                    <tr>
                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                    </tr>
                                                    ';
                                                }
                                                }
                                                    
                                                ?>
                                                </tbody>
                                            </table> 
                                        </div>     
                                    </div>
                                </div>

                                <div class="card card-transactions">
                                <form method="POST">
                                    <div class="card-body">
                                        <h5 class="card-title">Redeem</h5>
                                        <p>still having a redeem key of the old system? you can still redeem it here. Want cheaper license? <a href="https://spezz.exchange" target="_BLANK">click here</a></p>
                                        <input class="form-control mb-3" type="text" id="keyinput" name="keyinput" value="" placeholder="ex: yukio-web-bulk-2121sfd4">
                                        <button type="submit" class="btn btn-info btn-sm btn-block" href="">Redeem</button>
                                        <?php

                                            if(isset($_POST) && isset($_POST["keyinput"]))
                                            {
                                                $key = $_POST["keyinput"];
                                                $result = mysqli_query($con, "SELECT * FROM `tokens` WHERE `name` = '". mysqli_real_escape_string($con,$key) ."' AND `active`='1' " ) or die(mysqli_error($con));
                                                if ($result->num_rows > 0) 
                                                {
                                                    if(strpos($key, "clicker"))
                                                    {
                                                        $updateaccess = mysqli_query($con, "UPDATE users set clicker_access='1' WHERE id='" . $user_id . "'");
                                                    }
                                                    else if(strpos($key, "lite-invite"))
                                                    {
                                                        $updateaccess = mysqli_query($con, "UPDATE users set lite_invited='1' WHERE id='" . $user_id . "'");
                                                    }
                                                    else if(strpos($key, 'lite'))
                                                    {
                                                        $updateinvite = mysqli_query($con, "UPDATE users set lite_invited='1' WHERE id='" . $user_id . "'");
                                                        $updateaccess = mysqli_query($con, "UPDATE users set lite_access='1' WHERE id='" . $user_id . "'");
                                                        // create an invite key when the invite system will be back
                                                    }
                                                    else
                                                    {
                                                        $updateaccess = mysqli_query($con, "UPDATE users set access='1' WHERE id='" . $user_id . "'");
                                                    }
                                                    $updatekey = mysqli_query($con, "UPDATE tokens set active='0' WHERE name='" . $key . "'");
                                                    $updatekeyuser = mysqli_query($con, "UPDATE tokens set usedby=$user_id WHERE name='" . $key . "'");
                                                    echo "successfully redeemed the key.";
                                                }
                                                else
                                                {
                                                    echo "error: code has been already used/or does not exist.";
                                                }
                                            }

                                        ?>
                                    </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-3.4.1.min.js"></script>


        <?php 
        if($classicnweb_access < 1){
            echo '
            <script>
            var lifetimecheck = $("#lifetimecheck");
                var stripecheck = $("#stripecheck");
                var btccheck = $("#btccheck");
                var paypalcheck = $("#paypalcheck");
                var purchasebtn = $("#payButton");
                var ppbtncontainer = $("#paypal-button-container");
                paypalcheck.prop("checked", true);
                purchasebtn.prop("disabled", true);

                ppbtncontainer.hide();
            
                var gaypal = 0;

                paypalcheck.on("change", function() {
                    if (paypalcheck.is(":checked")) {
                        stripecheck.prop("checked", false);
                        btccheck.prop("checked", false);
                        if (lifetimecheck.is(":checked")) 
                        {
                            purchasebtn.prop("disabled", false);
                        }
                    } else {
                        purchasebtn.prop("disabled", true);
                    }
                });

                stripecheck.on("change", function() {
                    if (stripecheck.is(":checked")) {
                        paypalcheck.prop("checked", false);
                        btccheck.prop("checked", false);

                        purchasebtn.show();
                        ppbtncontainer.hide();


                        if (lifetimecheck.is(":checked")) {
                            purchasebtn.prop("disabled", false);
                        }
                    } else {
                        purchasebtn.prop("disabled", true);
                    }
                });

                btccheck.on("change", function() {
                    if (btccheck.is(":checked")) {
                        paypalcheck.prop("checked", false);

                        purchasebtn.show();
                        ppbtncontainer.hide();
                        
                        
                        stripecheck.prop("checked", false);
                        if (lifetimecheck.is(":checked")) {
                            purchasebtn.prop("disabled", false);
                        }
                    } else {
                        purchasebtn.prop("disabled", true);
                    }
                });

                lifetimecheck.on("change", function() {
                    if ((stripecheck.is(":checked") || paypalcheck.is(":checked") || btccheck.is(":checked")) && lifetimecheck.is(":checked")) 
                    {
                        purchasebtn.prop("disabled", false);
                    } 
                    else 
                    {
                        purchasebtn.prop("disabled", true);
                    }
                });


                var buyBtn = document.getElementById("payButton");
                var responseContainer = document.getElementById("paymentResponse");


                buyBtn.addEventListener("click", function(evt) 
                {
                    if (stripecheck.is(":checked")) 
                    {

                        var createCheckoutSession = function(stripe) {
                            return fetch("https://yukio.cc/api/stripe/stripe_charge.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify({
                                    checkoutSession: 1,
                                    amount: ' . $amount * 100 .',
                                }),
                            }).then(function(result) {
                                return result.json();
                            });
                        };
                        
                        var handleResult = function(result) {
                            if (result.error) {
                                responseContainer.innerHTML = "<p>" + result.error.message + "</p>";
                            }

                            buyBtn.disabled = false;
                            buyBtn.textContent = "Buy Now";
                        };

                        var stripe = Stripe("pk_live_51HYHFiEsCeznFiWgovyvUIFw3BiST5ITY3dQhkjx4HCW4TiVVQoOMcTHwdbuaOnNHUhgI8Q6g6XC3lirUhnHvYjx00CBIgFBoD");

                        buyBtn.disabled = true;
                        buyBtn.textContent = "Please wait...";

                        createCheckoutSession().then(function(data) {
                            if (data.sessionId) {
                                stripe.redirectToCheckout({
                                    sessionId: data.sessionId,
                                }).then(handleResult);
                            } else {
                                handleResult(data);
                            }
                        });
                    }
                    
                    if(paypalcheck.is(":checked"))
                    {
                        ppbtncontainer.show();
                        purchasebtn.hide();
                        paypal.Button.render({

                            env: "' . $mode .'", // or production
                                client: {
                                sandbox: "' . $clienteIDSandbox . '",
                                production: "' . $clienteIDLive .'"
                                },

                                style: {
                                    label: "checkout",
                                    size: "responsive",
                                    color: "blue",
                                    shape: "pill",
                                },

                                commit: true,

                                payment: function(data, actions) {
                                return actions.payment.create({
                                    transactions: [{
                                    amount: {
                                        total: "' . $amount . '",
                                        currency: " '. $currency . '"
                                    },
                                    description: " '. $description . '",
                                    custom: "'.$_SESSION["id"].':'.$referrer_id.'"
                                    }]
                                });
                                },

                                onAuthorize: function(data, actions) {
                                return actions.payment.execute().then(function() {
                                    window.location = "https://yukio.cc/api/paypal/confirm.php?paymentId=" + data.paymentID;
                                });
                                }

                        }, "#paypal-button-container");
                        

                    }
                    
                    if(btccheck.is(":checked"))
                    {
                        window.location.href = "https://yukio.cc/api/coinbase/coinbase_charge.php";
                    }
                });
                                        
            </script>'; } ?>

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