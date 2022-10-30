<?php

session_start();

$GLOBALS['base_url'] = "https://discord.com";

function gen_state()
{
    $_SESSION['state'] = bin2hex(openssl_random_pseudo_bytes(12));
    return $_SESSION['state'];
}

function url($clientid, $redirect, $scope)
{
    $state = gen_state();
	return 'https://discordapp.com/oauth2/authorize?response_type=code&client_id=' . $clientid . '&redirect_uri=' . $redirect . '&scope=' . $scope . "&state=" . $state;
}

function init($redirect_url, $client_id, $client_secret)
{
    $code = $_GET['code'];
    $state = $_GET['state'];
    $url = $GLOBALS['base_url'] . "/api/oauth2/token";
    $headers = array ('Content-Type: application/x-www-form-urlencoded');
    $data = array(
    "client_id" => $client_id,
    "client_secret" => $client_secret,
    "grant_type" => "authorization_code",
    "code" => $code,
    "redirect_uri" => $redirect_url,
    "scope" => "identify guilds.join"
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response, true);
    return $results['access_token'];
}

function get_user($accesstoken)
{
    $url = $GLOBALS['base_url'] . "/api/users/@me";
    $headers = array ('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $accesstoken);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response, true);
    return $results;
}

function join_guild($access_token, $userid)
{
    $url = $GLOBALS['base_url'] . "/api/guilds/767889369833930842/members/$userid";
    $headers = array('Content-Type: application/json', 'Authorization: Bot NzcwNDQzNDI1MzI4NjYwNTAx.X5dpWg.zoZJujYLkRkK_QK32K9Zf-NGIw4');
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(["access_token" => $access_token, "roles" => ["787434620609495090"]]));
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response, true);
    return json_encode($results);
}


?>