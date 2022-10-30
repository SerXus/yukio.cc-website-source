<?php
include_once 'api/includes/db.php';
error_reporting(0);
if(!isset($_SESSION)) { session_start(); }
// if(isset($_SESSION['id'])) {
//   header('Location: dashboard');
// exit();
// }
// if(isset($_GET["ref"]))
// {
//   $_SESSION["ref"] = $_GET["ref"];
// }
// ee

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
        <title>yukio.cc</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="landing_assets/fonts/icomoon/style.css">
        <link rel="stylesheet" href="landing_assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="landing_assets/css/jquery-ui.css">
        <link rel="stylesheet" href="landing_assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="landing_assets/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="landing_assets/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="landing_assets/css/jquery.fancybox.min.css">
        <link rel="stylesheet" href="landing_assets/css/bootstrap-datepicker.css">
        <link rel="stylesheet" href="landing_assets/fonts/flaticon/font/flaticon.css">
        <link rel="stylesheet" href="landing_assets/css/aos.css">
        <link rel="stylesheet" href="landing_assets/css/style.css">
    </head>
    <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
        <div id="overlayer"></div>
        <div class="loader">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="site-wrap" id="home-section">
            <div class="site-mobile-menu site-navbar-target">
                <div class="site-mobile-menu-header">
                    <div class="site-mobile-menu-close mt-3">
                        <span class="icon-close2 js-menu-toggle"></span>
                    </div>
                </div>
                <div class="site-mobile-menu-body"></div>
            </div>
            <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-6 col-md-3 col-xl-4  d-block">
                            <h1 class="mb-0 site-logo"><a href="#" class="text-black h2 mb-0">yukio<span class="text-primary">.cc</span> </a></h1>
                        </div>
                        <div class="col-12 col-md-9 col-xl-8 main-menu">
                            <nav class="site-navigation position-relative text-right" role="navigation">
                                <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block ml-0 pl-0">
                                    <li><a href="#home-section" class="nav-link">Home</a></li>
                                    <li><a href="https://yukio.cc/pages/login" class="nav-link">Login</a></li>
                                    <li><a href="https://yukio.cc/pages/register" class="nav-link">Register</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-6 col-md-9 d-inline-block d-lg-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle text-black float-right"><span class="icon-menu h3"></span></a></div>
                    </div>
                </div>
            </header>
            <div class="site-blocks-cover" style="overflow: hidden;">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-12" style="position: relative;" data-aos="fade-up" data-aos-delay="200">
                          <img class="img-fluid img-absolute" src="landing_assets/images/yukiogui.gif" alt="alternative" style="top: -40%;transform: scaleX(1) scaleY(1) perspective(500px) rotateY(-10deg) rotateX(8deg) rotateZ(-1deg); -webkit-filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.5)); filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.5));">
                            <div class="row mb-4" data-aos="fade-up" data-aos-delay="200">
                                <div class="col-lg-6 mr-auto">
                                    <h1>YUKIO</h1>
                                    <p class="mb-5">The best and cheapest alternative to be the best at minecraft.</p>
                                    <div>
                                        <a href="https://t.me/yukiocl" target="_blank" class="btn btn-primary mr-2 mb-2">Telegram</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-section" id="features-section">
                <div class="container">
                    <div class="row mb-5 justify-content-center text-center" data-aos="fade-up">
                        <div class="col-7 text-center  mb-5">
                            <h2 class="section-title">Features</h2>
                            <p class="lead">Here is what you're paying for</p>
                        </div>
                    </div>
                    <div class="row align-items-stretch">
                        <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
                            <div class="unit-4 d-block">
                                <div class="unit-4-icon mb-3">
                                    <span class="icon-wrap"><span class="text-primary icon-shield"></span></span>
                                </div>
                                <div>
                                    <h3>Security</h3>
                                    <p>Your information are always safe when using any yukio products.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="unit-4 d-block">
                                <div class="unit-4-icon mb-3">
                                    <span class="icon-wrap"><span class="text-primary icon-user-secret"></span></span>
                                </div>
                                <div>
                                    <h3>Undetected</h3>
                                    <p>Yukio uses the latest and most secure methods in our products. Detection is not in our list of worries.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="unit-4 d-block">
                                <div class="unit-4-icon mb-3">
                                    <span class="icon-wrap"><span class="text-primary icon-shopping_basket"></span></span>
                                </div>
                                <div>
                                    <h3>Easy Purchase</h3>
                                    <p>Yukio is partnered with the most trusted reseller, Spezz. All your payments will be safe, and fast.</p>
                                    <p><a href="https://spezz.exchange" target="_blank">Learn More</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
                            <div class="unit-4 d-block">
                                <div class="unit-4-icon mb-3">
                                    <span class="icon-wrap"><span class="text-primary icon-settings_backup_restore"></span></span>
                                </div>
                                <div>
                                    <h3>Frequent Updates</h3>
                                    <p>Our team work hard every day to keep the client undetected and up to date.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="unit-4 d-block">
                                <div class="unit-4-icon mb-3">
                                    <span class="icon-wrap"><span class="text-primary icon-dollar"></span></span>
                                </div>
                                <div>
                                    <h3>Affordable</h3>
                                    <p>Yukio is very cheap. Everyone can afford it.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="unit-4 d-block">
                                <div class="unit-4-icon mb-3">
                                    <span class="icon-wrap"><span class="text-primary icon-power"></span></span>
                                </div>
                                <div>
                                    <h3>User Friendly</h3>
                                    <p>Our website and products are designed to be user friendly and very easy to use.</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer py-5 text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0">
                             <a> © Mynt SAS, trading as Yukio.</a>
                              <br>SIRET: 891 507 485 00011
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="landing_assets/js/jquery-3.3.1.min.js"></script>
        <script src="landing_assets/js/jquery-ui.js"></script>
        <script src="landing_assets/js/popper.min.js"></script>
        <script src="landing_assets/js/bootstrap.min.js"></script>
        <script src="landing_assets/js/owl.carousel.min.js"></script>
        <script src="landing_assets/js/jquery.countdown.min.js"></script>
        <script src="landing_assets/js/bootstrap-datepicker.min.js"></script>
        <script src="landing_assets/js/jquery.easing.1.3.js"></script>
        <script src="landing_assets/js/aos.js"></script>
        <script src="landing_assets/js/jquery.fancybox.min.js"></script>
        <script src="landing_assets/js/jquery.sticky.js"></script>
        <script src="landing_assets/js/main.js"></script>
    </body>
</html>