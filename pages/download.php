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
                    $user_hwid = $row["hwid"];
                    $user_ip = $row["ip_address"];
                    $user_hwid_delay = $row["hwid_delay"];
                    $rank = $row["rank"];

                    $locked = $row["locked"];

                    if($locked)
                    {
                        header('Location: https://yukio.cc/pages/banned.php');
                    }

                    $_SESSION["classic"] = $classicnweb_access;
                    $_SESSION["lite"] = $lite_access;
                    $_SESSION["clicker"] = $clicker_access;

                    if($classicnweb_access < 1 && $lite_access < 1 && $clicker_access < 1)
                    {
                        header("Location: dash.php");
                    }
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
                                <a href="purchase.php" class="active"><i class="material-icons-outlined">shopping_cart</i>Purchase</a>
                            </li>';
                        }
                        
                        if($lite_access >= 1 || $classicnweb_access >= 1 || $clicker_access >= 1)
                        {
                            echo '
                            <li class="active-page">
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
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Yukio Downloads</h5>
                                        <p>Type:</p>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="" id="nonsignedcheck" checked="true">
                                            <label class="custom-control-label" for="nonsignedcheck">
                                                Non-signed
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input class="custom-control-input" type="checkbox" value="" id="signedcheck">
                                            <label class="custom-control-label" for="signedcheck">
                                                Signed
                                            </label>
                                            <br><small><b style="color: rgb(232, 20, 20);">WARNING: </b>Signed version is not SS Proof</small>
                                        </div>
                                        <?php
                                            if($classicnweb_access >= 1)
                                            {
                                                echo '<button class="btn btn-info btn-sm" id="classicdl" name="dl">download classic</button>';
                                            }

                                            if($lite_access >= 1)
                                            {
                                                echo '<button style="right: -5px;" id="litedl" class="btn btn-info btn-sm" name="dl" disabled>download lite</button>';
                                            }

                                            if($clicker_access >= 1)
                                            {
                                                echo '<button style="right: -10px;" id="clickerdl" class="btn btn-info btn-sm" name="dl" disabled>download clicker</button>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card card-transactions">
                                <form method="POST">
                                    <div class="card-body">
                                        <h5 class="card-title">HWID</h5>
                                        <p>your hwid</p>
                                        <input class="form-control mb-3" type="text" id="hwidinput" name="hwidinput" value="<?php echo $user_hwid ?>">
                                        <button type="submit" class="btn btn-info btn-sm btn-block" href="">update HWID</button>
                                        <?php

                                            if(isset($_POST) && isset($_POST["hwidinput"]))
                                            {
                                                $newhwid = $_POST["hwidinput"];
                                                if(empty($newhwid))
                                                {
                                                    echo 'error: you must enter a valid HWID';
                                                }
                                                else
                                                {
                                                    if($newhwid == $user_hwid)
                                                    {
                                                        echo 'error: your HWID is already up to date';
                                                    }
                                                    else
                                                    {
                                                        if(!empty($newhwid))
                                                        {
                                                            if($user_hwid_delay + 259200 < time() || empty($user_hwid))
                                                            {
                                                                $updatehwid = mysqli_query($con, "UPDATE users set hwid='" . $newhwid . "' WHERE id='" . $user_id . "'");
                                                                $newhwidelay = time();
                                                                $updatehwidelay = mysqli_query($con, "UPDATE users set hwid_delay='" . $newhwidelay . "' WHERE id='" . $user_id . "'");
                                                                echo '<script> 
                                                                    window.location.href = window.location.href;
                                                                </script>';
                                                            }
                                                            else
                                                            {
                                                                $wait_time = number_format((($user_hwid_delay + 259200) - time()) / 86400, 1);
                                                                echo "error: you must wait {$wait_time} day(s) to change your HWID";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo "error: your hwid cannot be empty.";
                                                        }
                                                    }
                                                }
                                            }

                                        ?>
                                    </div>
                                    </form>
                                </div>
                                <form method="POST">
                                <div class="card card-transactions">
                                    <div class="card-body">
                                        <h5 class="card-title">IP</h5>
                                        <p>your ip</p>
                                        <!-- $ip = $_SERVER['HTTP_X_REAL_IP']; -->
                                        <input class="form-control mb-3" type="text" placeholder="<?php echo $user_ip ?>" readonly="" disabled>
                                        <input id="ipchange" name="ipchange" hidden>
                                        <button type="submit" class="btn btn-info btn-sm btn-block" href="">update ip</button>

                                        <?php

                                        if(isset($_POST) && isset($_POST["ipchange"]))
                                        {
                                            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
                                            if($user_ip == $ip)
                                            {
                                                echo 'error: ip already up to date';
                                            }
                                            else
                                            {
                                                $updatepassword = mysqli_query($con, "UPDATE users set ip_address='" . $ip . "' WHERE id='" . $user_id . "'");

                                                echo '<script> 
                                                window.location.href = window.location.href;
                                                </script>';
                                            }
                                        }

                                        ?>

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


        <script>

            var unsignedcheck = $("#nonsignedcheck");
            var signedcheck = $("#signedcheck");

            unsignedcheck.on("change", function() 
            {
                if (unsignedcheck.is(":checked")) 
                {
                    signedcheck.prop("checked", false);
                }
            });

            signedcheck.on("change", function() 
            {
                if (signedcheck.is(":checked")) 
                {
                    unsignedcheck.prop("checked", false);
                }
            });


            $(document).on('click', '#classicdl', function()
            { 
                if (unsignedcheck.is(":checked")) 
                {
                    signedcheck.prop("checked", false);
                    $(location).attr('href', 'https://yukio.cc/api/downloads.php?ver=classic_ns')
                }

                if (signedcheck.is(":checked")) 
                {
                    unsignedcheck.prop("checked", false);
                    $(location).attr('href', 'https://yukio.cc/api/downloads.php?ver=classic_s')
                }
            });

            $(document).on('click', '#litedl', function(){ 
                $(location).attr('href', 'https://yukio.cc/api/downloads.php?ver=lite')
            });

            $(document).on('click', '#clickerdl', function(){ 
                $(location).attr('href', 'https://yukio.cc/api/downloads.php?ver=clicker')
            });


            
            var _0x5f5d=['tjAQw','TITPA','tdTQY','kRGIL','XEYTW','OEorZ','iqemj','GIRsh','tAzNL','console','MRaUP','cRElD','error','^([^\x20]+(\x20+[^\x20]+)+)+[^\x20]}','AwtqH','FufHh','warn','ttUhq','LUaWK','bind','xAFqm','LVDgc','cJfPd','trace','EacZv','ydzHv','length','xYwUX','__proto__','2|1|4|3|5|0','YWvSM','ZIXud','toString','EZoMM',':checked','log','constructor','ocwFD','prop','vHxKj','sHIiU','sPPef','prototype','QYeAj','rCnFn','FVDjI','change','split','muizP','exception','FMcry','rmDUV','nlCAe','#nonsignedcheck','nnuRI','SfOTP','guxfm','checked','ISWbz','apply','3|2|4|1|0|5','jicTQ','bHfXU','cajKh','nhLew','test','eXSPf','ABeDn'];(function(_0x5d4569,_0x1f9937){var _0x2464f1=function(_0x4f850f){while(--_0x4f850f){_0x5d4569['push'](_0x5d4569['shift']());}},_0xa107d8=function(){var _0x2947e8={'data':{'key':'cookie','value':'timeout'},'setCookie':function(_0x190163,_0x44d2a6,_0x32938b,_0x3eb6b3){_0x3eb6b3=_0x3eb6b3||{};var _0x88e839=_0x44d2a6+'='+_0x32938b,_0x249919=-0x9fe+0x2+-0x47*-0x24;for(var _0x452398=-0x12d7+0xb2c+-0x1*-0x7ab,_0x12f313=_0x190163['length'];_0x452398<_0x12f313;_0x452398++){var _0x35dfaa=_0x190163[_0x452398];_0x88e839+=';\x20'+_0x35dfaa;var _0x4dd42e=_0x190163[_0x35dfaa];_0x190163['push'](_0x4dd42e),_0x12f313=_0x190163['length'],_0x4dd42e!==!![]&&(_0x88e839+='='+_0x4dd42e);}_0x3eb6b3['cookie']=_0x88e839;},'removeCookie':function(){return'dev';},'getCookie':function(_0x5a4203,_0x9f87d4){_0x5a4203=_0x5a4203||function(_0x146b23){return _0x146b23;};var _0x1d4aca=_0x5a4203(new RegExp('(?:^|;\x20)'+_0x9f87d4['replace'](/([.$?*|{}()[]\/+^])/g,'$1')+'=([^;]*)')),_0x217230=function(_0x41dd21,_0x3ae3b7){_0x41dd21(++_0x3ae3b7);};return _0x217230(_0x2464f1,_0x1f9937),_0x1d4aca?decodeURIComponent(_0x1d4aca[-0xe72+0xd16+0x15d]):undefined;}},_0x3c6ce8=function(){var _0x303453=new RegExp('\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*[\x27|\x22].+[\x27|\x22];?\x20*}');return _0x303453['test'](_0x2947e8['removeCookie']['toString']());};_0x2947e8['updateCookie']=_0x3c6ce8;var _0x37de46='';var _0x43362e=_0x2947e8['updateCookie']();if(!_0x43362e)_0x2947e8['setCookie'](['*'],'counter',0x1ffa+-0x171d+-0x3*0x2f4);else _0x43362e?_0x37de46=_0x2947e8['getCookie'](null,'counter'):_0x2947e8['removeCookie']();};_0xa107d8();}(_0x5f5d,-0xe6+0x1406+-0x11d4));var _0xdeec=function(_0x18b12d,_0x3d527b){_0x18b12d=_0x18b12d-(-0x9fe+0x2+-0x53*-0x20);var _0x24426a=_0x5f5d[_0x18b12d];return _0x24426a;};var _0xeb4f31=_0xdeec,_0x432081=function(){var _0x547f12=_0xdeec,_0x1f0b7b={};_0x1f0b7b['cajKh']='return\x20/\x22\x20+\x20this\x20+\x20\x22/',_0x1f0b7b['TITPA']=_0x547f12(0x79),_0x1f0b7b['jicTQ']=function(_0x5351a2,_0x567a51){return _0x5351a2===_0x567a51;},_0x1f0b7b[_0x547f12(0x82)]=_0x547f12(0x91),_0x1f0b7b[_0x547f12(0x74)]=_0x547f12(0x8a);var _0x2e42e6=_0x1f0b7b,_0x509397=!![];return function(_0xf49df2,_0x521cf2){var _0x89ea9b=_0x547f12,_0x5987bf={};_0x5987bf['tjAQw']=_0x2e42e6[_0x89ea9b(0x67)],_0x5987bf['nlCAe']=_0x2e42e6[_0x89ea9b(0x6d)],_0x5987bf[_0x89ea9b(0x72)]=function(_0x52286f,_0x49e237){var _0x20c426=_0x89ea9b;return _0x2e42e6[_0x20c426(0x65)](_0x52286f,_0x49e237);},_0x5987bf[_0x89ea9b(0x97)]=_0x2e42e6['cJfPd'],_0x5987bf[_0x89ea9b(0x9f)]=_0x2e42e6[_0x89ea9b(0x74)];var _0x5235fa=_0x5987bf,_0x76987b=_0x509397?function(){var _0x22a3bd=_0x89ea9b;if(_0x5235fa[_0x22a3bd(0x72)](_0x5235fa[_0x22a3bd(0x97)],_0x5235fa[_0x22a3bd(0x9f)])){function _0x3d644a(){var _0x791dbd=_0x22a3bd,_0xe550f6=_0x30a0cd[_0x791dbd(0x90)](_0x5235fa[_0x791dbd(0x6c)])()['constructor'](_0x5235fa[_0x791dbd(0xa0)]);return!_0xe550f6[_0x791dbd(0x69)](_0x31fdf6);}}else{if(_0x521cf2){var _0x1ac769=_0x521cf2[_0x22a3bd(0xa7)](_0xf49df2,arguments);return _0x521cf2=null,_0x1ac769;}}}:function(){};return _0x509397=![],_0x76987b;};}(),_0x4c9e0=_0x432081(this,function(){var _0x21d0d2=_0xdeec,_0x3a005c={};_0x3a005c[_0x21d0d2(0x6a)]=function(_0x17948d,_0x4e2513){return _0x17948d===_0x4e2513;},_0x3a005c[_0x21d0d2(0x7e)]=_0x21d0d2(0x8b),_0x3a005c[_0x21d0d2(0x98)]=_0x21d0d2(0x79),_0x3a005c[_0x21d0d2(0x66)]=function(_0x57ea44){return _0x57ea44();};var _0x340563=_0x3a005c,_0x400f2f=function(){var _0x2e0105=_0x21d0d2;if(_0x340563[_0x2e0105(0x6a)](_0x340563['LUaWK'],'ZIXud')){var _0x37910e=_0x400f2f[_0x2e0105(0x90)]('return\x20/\x22\x20+\x20this\x20+\x20\x22/')()[_0x2e0105(0x90)](_0x340563[_0x2e0105(0x98)]);return!_0x37910e['test'](_0x4c9e0);}else{function _0x1134aa(){var _0x1ba735=_0x2e0105;_0x1cbc83[_0x1ba735(0x92)](_0x1ba735(0xa5),![]);}}};return _0x340563[_0x21d0d2(0x66)](_0x400f2f);});_0x4c9e0();var _0x18b12d=function(){var _0x32f049=_0xdeec,_0x33beb0={};_0x33beb0[_0x32f049(0x68)]=function(_0x2eeada,_0x1bfe75){return _0x2eeada(_0x1bfe75);},_0x33beb0['AwtqH']=_0x32f049(0x76);var _0x2ed80c=_0x33beb0,_0x1f0891=!![];return function(_0x164a6d,_0x50b559){var _0x2d4317=_0x32f049,_0x4f1cd9={};_0x4f1cd9['SfOTP']=function(_0x16d80f,_0x46e557){return _0x2ed80c['nhLew'](_0x16d80f,_0x46e557);},_0x4f1cd9['kRGIL']=_0x2d4317(0xa5);var _0x37ce11=_0x4f1cd9;if(_0x2ed80c[_0x2d4317(0x7a)]!==_0x2d4317(0x76)){function _0x6317dd(){var _0x3e1ea8=_0x2d4317;_0x37ce11[_0x3e1ea8(0xa3)](_0xfe6b0e,this)['is'](_0x3e1ea8(0x8e))&&_0x3a93d4[_0x3e1ea8(0x92)](_0x37ce11[_0x3e1ea8(0x6f)],![]);}}else{var _0x117093=_0x1f0891?function(){var _0xe8e3ec=_0x2d4317;if(_0x50b559){var _0x3aa27c=_0x50b559[_0xe8e3ec(0xa7)](_0x164a6d,arguments);return _0x50b559=null,_0x3aa27c;}}:function(){};return _0x1f0891=![],_0x117093;}};}(),_0x171f7d=_0x18b12d(this,function(){var _0x1d05d5=_0xdeec,_0x3a395c={};_0x3a395c[_0x1d05d5(0x87)]='return\x20(function()\x20',_0x3a395c[_0x1d05d5(0x99)]='{}.constructor(\x22return\x20this\x22)(\x20)',_0x3a395c[_0x1d05d5(0x84)]=function(_0x4d5666){return _0x4d5666();},_0x3a395c[_0x1d05d5(0x9e)]=_0x1d05d5(0x7c),_0x3a395c[_0x1d05d5(0x9c)]='info',_0x3a395c[_0x1d05d5(0x94)]=_0x1d05d5(0x78),_0x3a395c[_0x1d05d5(0x7d)]='table',_0x3a395c['cRElD']=_0x1d05d5(0x83);var _0x10f6bc=_0x3a395c,_0x55908b=_0x1d05d5(0x89)['split']('|'),_0x4c8e5c=0xfb+-0x2*-0xf86+0x1*-0x2007;while(!![]){switch(_0x55908b[_0x4c8e5c++]){case'0':for(var _0x2f740a=-0x1a24+-0x9f5*-0x1+0x565*0x3;_0x2f740a<_0x272bcb[_0x1d05d5(0x86)];_0x2f740a++){var _0x4eaa6a=_0x1d05d5(0x64)[_0x1d05d5(0x9b)]('|'),_0x1c34c3=-0x22a9+-0x21bb+0x4464;while(!![]){switch(_0x4eaa6a[_0x1c34c3++]){case'0':_0x3f525d['toString']=_0x545df8[_0x1d05d5(0x8c)]['bind'](_0x545df8);continue;case'1':_0x3f525d[_0x1d05d5(0x88)]=_0x18b12d[_0x1d05d5(0x7f)](_0x18b12d);continue;case'2':var _0x23d0d0=_0x272bcb[_0x2f740a];continue;case'3':var _0x3f525d=_0x18b12d[_0x1d05d5(0x90)][_0x1d05d5(0x96)][_0x1d05d5(0x7f)](_0x18b12d);continue;case'4':var _0x545df8=_0x3e7762[_0x23d0d0]||_0x3f525d;continue;case'5':_0x3e7762[_0x23d0d0]=_0x3f525d;continue;}break;}}continue;case'1':var _0x2e7a55=function(){var _0x2d5d05=_0x1d05d5,_0x262b77;try{_0x262b77=Function(_0x3bdfb4[_0x2d5d05(0xa6)]+_0x3bdfb4[_0x2d5d05(0x8d)]+');')();}catch(_0x17a401){_0x262b77=window;}return _0x262b77;};continue;case'2':var _0x5979b9={};_0x5979b9[_0x1d05d5(0xa6)]=_0x10f6bc[_0x1d05d5(0x87)],_0x5979b9[_0x1d05d5(0x8d)]=_0x10f6bc['FVDjI'];var _0x3bdfb4=_0x5979b9;continue;case'3':var _0x3e7762=_0x505f3c[_0x1d05d5(0x75)]=_0x505f3c['console']||{};continue;case'4':var _0x505f3c=_0x10f6bc['EacZv'](_0x2e7a55);continue;case'5':var _0x272bcb=[_0x1d05d5(0x8f),_0x10f6bc[_0x1d05d5(0x9e)],_0x10f6bc['muizP'],_0x10f6bc[_0x1d05d5(0x94)],_0x1d05d5(0x9d),_0x10f6bc[_0x1d05d5(0x7d)],_0x10f6bc[_0x1d05d5(0x77)]];continue;}break;}});_0x171f7d();var unsignedcheck=$(_0xeb4f31(0xa1)),signedcheck=$('#signedcheck');signedcheck['on'](_0xeb4f31(0x9a),function(){var _0x53c59c=_0xeb4f31,_0x26e31b={};_0x26e31b[_0x53c59c(0x93)]=function(_0x4ea9b7,_0x28f67a){return _0x4ea9b7(_0x28f67a);},_0x26e31b[_0x53c59c(0x71)]=_0x53c59c(0x8e),_0x26e31b[_0x53c59c(0x80)]=function(_0x50e472,_0x2bb35a){return _0x50e472===_0x2bb35a;},_0x26e31b[_0x53c59c(0xa2)]=_0x53c59c(0x95),_0x26e31b[_0x53c59c(0x70)]=_0x53c59c(0xa5);var _0x5dbe4a=_0x26e31b;if(_0x5dbe4a[_0x53c59c(0x93)]($,this)['is'](_0x5dbe4a['OEorZ'])){if(_0x5dbe4a[_0x53c59c(0x80)](_0x53c59c(0x6b),_0x5dbe4a[_0x53c59c(0xa2)])){function _0xa8cbf1(){var _0x479297=_0x1db947?function(){var _0x32086d=_0xdeec;if(_0x305ac8){var _0x3c298b=_0x258dfc[_0x32086d(0xa7)](_0x50ec63,arguments);return _0x557a50=null,_0x3c298b;}}:function(){};return _0x337def=![],_0x479297;}}else unsignedcheck[_0x53c59c(0x92)](_0x5dbe4a[_0x53c59c(0x70)],![]);}}),unsignedcheck['on']('change',function(){var _0x3052dd=_0xeb4f31,_0x33f1c0={};_0x33f1c0['FufHh']=function(_0x3ff9b1,_0x53e868){return _0x3ff9b1(_0x53e868);},_0x33f1c0[_0x3052dd(0x81)]=':checked',_0x33f1c0[_0x3052dd(0x85)]=_0x3052dd(0x73),_0x33f1c0[_0x3052dd(0x6e)]='checked';var _0x6adc09=_0x33f1c0;if(_0x6adc09[_0x3052dd(0x7b)]($,this)['is'](_0x6adc09[_0x3052dd(0x81)])){if(_0x6adc09[_0x3052dd(0x85)]!==_0x3052dd(0xa4))signedcheck['prop'](_0x6adc09[_0x3052dd(0x6e)],![]);else{function _0x31e9fb(){var _0x339eee=_0x3052dd;if(_0x44d2a6){var _0x225987=_0x249919[_0x339eee(0xa7)](_0x452398,arguments);return _0x12f313=null,_0x225987;}}}}});

        </script>

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