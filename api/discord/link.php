<?php
include_once "../includes/db.php";
error_reporting(0);
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
exit();
}
 
require __DIR__ . "/discord.php";
 
$user_id = $_SESSION["id"];

$access_token = init("https://yukio.cc/api/discord/link.php", "770443425328660501", "C9DCGCFmTpLDNcPElU3AXtvYpXy5eSGS");

$ret = get_user($access_token);
$discordid = $ret['id'];

$updatediscordid = mysqli_query($con, "UPDATE users set discord_id='" . $discordid . "' WHERE id='" . $user_id . "'");

join_guild($access_token, $discordid);
 
header("Location: https://yukio.cc/pages/settings.php");

?>
 
 
