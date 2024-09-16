<?php ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "vendor/autoload.php"; 
use Twilio\Rest\Client;

$account_sid = "AC25d770e26932b80420946ff5322ad6df";
$auth_token = "759d82988b19f48cada46695e1bb3164";
$twilio_phone_number = "+447401257072";

$client = new Client($account_sid, $auth_token);

$client->messages->create(
    '+919538114779',
    array(
        "from" => $twilio_phone_number,
        "body" => "Whaddup from PHP!"
    )
);



