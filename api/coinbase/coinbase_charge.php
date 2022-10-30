<?php
if (!isset($_SESSION)) { session_start(); }

require_once "../vendor/autoload.php";

use CoinbaseCommerce\Resources\Charge;
use CoinbaseCommerce\ApiClient;

ApiClient::init('');


$chargeData = [
    'name' => 'yukio classic',
    'description' => 'yukio classic lifetime subscription',
    "metadata" => [
        "customer_id" => $_SESSION["id"],
    ],
    'local_price' => [
        'amount' => '0.05',
        'currency' => 'EUR'
    ],
    'pricing_type' => 'fixed_price'
];
$chargeObj = Charge::create($chargeData);

//var_dump($chargeObj);
var_dump($chargeObj->hosted_url);
header("Location: {$chargeObj->hosted_url}");

?>