<?php

$consumer_key = "d14d29bb1adb4881baf4eb67bc9fe786";
$secret_key = "a81fff61c04d4d8fac872e2fc5cf4c44";
//Signature Base String 
//<HTTP Method>&<Request URL>&<Normalized Parameters> 
$base = rawurlencode("GET") . "&";
$base .= "http%3A%2F%2Fplatform.fatsecret.com%2Frest%2Fserver.api&";

//sort params by abc....necessary to build a correct unique signature 
$params = "method=foods.search&";
$params .= "oauth_consumer_key=$consumer_key&"; // ur consumer key 
$params .= "oauth_nonce=123&";
$params .= "oauth_signature_method=HMAC-SHA1&";
$params .= "oauth_timestamp=" . time() . "&";
$params .= "oauth_version=1.0&";
$params .= "search_expression=apple";
$params2 = rawurlencode($params);
$base .= $params2;

//encrypt it!
$sig = base64_encode(hash_hmac('sha1', $base, "$secret_key&", true));
// replace xxx with Consumer Secret
//now get the search results and write them down 
$url = "http://platform.fatsecret.com/rest/server.api?" . $params . "&oauth_signature=" . rawurlencode($sig);

//$food_feed = file_get_contents($url); 
list($output, $error, $info) = loadFoods($url);

if ($error == 0) {
    if ($info['http_code'] == '200') {
        echo "<pre>";
        print_r($output);
        echo "</pre>";
        exit;
    } else
        die('Status INFO : ' . $info['http_code']);
}
else {
    die('Status ERROR : ' . $error);
}

function loadFoods($url) {

    // create curl resource 
    $ch = curl_init();

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);

    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string 
    $output = curl_exec($ch);

    $error = curl_error($ch);

    $info = curl_getinfo($ch);
    // close curl resource to free up system resources 
    curl_close($ch);

//    return array($output, $error, $info);
    
    $xml = simplexml_load_string($output);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
//    return array($array,$error,$info);
    return array($array,$error,$info);
}

?>