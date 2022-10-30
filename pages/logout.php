<?php

error_reporting(0);
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['id'])) 
{
    header('Location: https://yukio.cc');
    exit();
}
else
{
    session_destroy();
    header('Location: https://yukio.cc');
}

?>