<?php

require_once('lib/FatSecretAPI.php');
require_once('lib/config.php');

$API = new FatSecretAPI(API_KEY, API_SECRET);

$token;
$secret;
try {
    $data = $API->getFoods();

    echo "<pre>";
    print_r($data);
    echo "</pre>";
    exit;
} catch (Exception $ex) {
    
}
?>