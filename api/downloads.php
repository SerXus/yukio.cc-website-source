<?php
include_once "includes/db.php";
if (!isset($_SESSION)) { session_start(); }


$ver = $_GET["ver"];
$user_id = $_SESSION["id"];

$resultsql = mysqli_query($con, "SELECT * FROM `users` WHERE `id` = '" . mysqli_real_escape_string($con, $user_id) . "' ") or die(mysqli_error($con));
if ($resultsql->num_rows > 0)
{
    while ($row = mysqli_fetch_array($resultsql))
    {
        $classicnweb_access = $row["access"];
        $lite_access = $row["lite_access"];
        $clicker_access = $row["clicker_access"];
    }
}

function generateRandomString($length = 15, $type = 0) {
    $characters = $type == 0 ? '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' : 'abcdefghijklm';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if($ver == "classic_ns")
{
    $file = __DIR__ . '/cdn/Classic.exe';

    if(!$classicnweb_access >= 1)
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
else if($ver == "classic_s")
{
    $file = __DIR__ . '/cdn/Classic_Signed.exe';

    if(!$classicnweb_access >= 1)
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
   
    header('Content-Type: application/octet-stream');

    $namearray = array(
        "a" => "451.48-desktop-win10-64bit-international-whql",
        "b" => "lghub_installer",
        "c" => "vs_Enterprise",
        "d" => "Discord.Bot.Client.Setup.3.1.0",
        "e" => "PldSS-RDJNA",
        "f" => "451.48-desktop-win10-64bit-international-whql",
        "g" => "FiveM",
        "h" => "TwitchSoundtrackSetup_[usher-196844537][referrer-soundtrack_page]",
        "i" => "Anaconda3-2020.07-Windows-x86_64",
        "j" => "Everything-1.4.1.992.x64-Setup",
        "k" => "java-se-development-kit_8-update-66_fr_201082_32",
        "l" => "ideaIU-2020.1.4",
        "m" => "npp.7.8.8.Installer",
    );

    $name = $namearray[generateRandomString(1, 1)];
    header("Content-Disposition: attachment; filename=\"" . $name . ".exe\"");


    echo file_get_contents($file);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
else if($ver == "lite")
{
    $file = __DIR__ . '/cdn/Lite.exe';

    if(!$lite_access >= 1)
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
else if($ver == "clicker")
{
    $file = __DIR__ . '/cdn/Clicker.exe';

    if(!$clicker_access >= 1)
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
else
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$filehandle = fopen($file, "rw+");

$hextime = dechex(time());
$hex = strtoupper($hextime);
$out = "";
for ($i = 0; $i < strlen($hex); $i+=2)
{
    $out = $hextime[$i] . $hextime[$i + 1] . $out;
}
fseek($filehandle, 296);
fwrite($filehandle, hex2bin(strtoupper($out)), 4);

fseek($filehandle, 376);
$newchecksum = bin2hex(generateRandomString(3, 0));
fwrite($filehandle, "${newchecksum}", 3);

fseek($filehandle, 368 + 1); // sizeofimage + 1
$newsizeofimage = bin2hex(generateRandomString(3, 0));
fwrite($filehandle, "${newsizeofimage}", 3);

fclose($filehandle);

touch($file);

header('Content-Type: application/octet-stream');

$namearray = array(
    "a" => "451.48-desktop-win10-64bit-international-whql",
    "b" => "lghub_installer",
    "c" => "vs_Enterprise",
    "d" => "Discord.Bot.Client.Setup.3.1.0",
    "e" => "PldSS-RDJNA",
    "f" => "451.48-desktop-win10-64bit-international-whql",
    "g" => "FiveM",
    "h" => "TwitchSoundtrackSetup_[usher-196844537][referrer-soundtrack_page]",
    "i" => "Anaconda3-2020.07-Windows-x86_64",
    "j" => "Everything-1.4.1.992.x64-Setup",
    "k" => "java-se-development-kit_8-update-66_fr_201082_32",
    "l" => "ideaIU-2020.1.4",
    "m" => "npp.7.8.8.Installer",
);

$name = $namearray[generateRandomString(1, 1)];
header("Content-Disposition: attachment; filename=\"" . $name . ".exe\"");


$hex = strtoupper(dechex($user_id ^ 0xC0AB27));
for ($i = strlen($hex); $i < 8; $i+=2)
    $hex = '00' . $hex;
$out = "";
for ($i = 0; $i < strlen($hex); $i+=2)
{
    $out = $hex[$i] . $hex[$i + 1] . $out;
}

echo file_get_contents($file);
for($i = 0; $i < random_int(500000, 100000000); $i++)
{
    echo hex2bin($i);
}
echo hex2bin($out);

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>