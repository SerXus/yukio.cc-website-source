<?php
require_once "../vendor/autoload.php";
include "../includes/db.php";

use CoinbaseCommerce\Webhook;

/**
 * To run this example please read README.md file
 * Past your Webhook Secret Key from Settings/Webhook section
 * Make sure you don't store your Secret Key in your source code!
 */
$secret = '';
$headerName = 'x-cc-webhook-signature';
$headers = getallheaders();
$signraturHeader = isset($headers[$headerName]) ? $headers[$headerName] : null;
$payload = trim(file_get_contents('php://input'));

try 
{
    $event = Webhook::buildEvent($payload, $signraturHeader, $secret);
    http_response_code(200);

    $type = $event->type;
    $sessionid = $event->data->metadata->customer_id;

    $create = "INSERT INTO coinbase_payments (type, session_id)
    VALUES ('$type', '$session_id')";

    if ($con->query($create)) 
    {
        echo 'success';
    }


    echo sprintf('Successully verified event with id %s and type %s.', $event->id, $event->type);
} 
catch (\Exception $exception) {
    http_response_code(400);
    echo 'Error occured. ' . $exception->getMessage();
}
?>