<?php

include_once "../includes/db.php";
error_reporting(0);
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
exit();
}

$user_id = $_SESSION["id"];
$updatetoken = mysqli_query($con, "UPDATE users set access_token=null WHERE id='" . $user_id . "'");
$updatediscordid = mysqli_query($con, "UPDATE users set discord_id=null WHERE id='" . $user_id . "'");

header('Location: https://yukio.cc/pages/settings.php');
?>