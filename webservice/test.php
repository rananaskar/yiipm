<?php

$ProductName   = "Diamond455";
$ProductCat    = "Gem331";
$ProductSubCat = "GemSub4443";
$Color         = "Yellow";
$Benefits      = "There are many benefits";
$Description      = "Buying diamonds can be exhilarating, but choosing the perfect diamond can have its challenges if you’re not sure what to look for. We’ll make it easy for you to find diamond jewelry that fits your budget and personal style.";
$imgid      = "http://happinessquotations.com/wp-content/uploads/2014/05/diamonds-sparkle.jpeg";

 define('POSTURL', 'http://59.162.181.92/dtswork/wordpressapi/webservice_woo/serverx.php');   
 $ch = curl_init(POSTURL);
 curl_setopt($ch, CURLOPT_POST      ,1);
 curl_setopt($ch, CURLOPT_POSTFIELDS    , "action=saveProduct&name=$ProductName&catname=$ProductCat&subcatname=$ProductSubCat&description=$Description&color=$Color&benefits=$Benefits&imgid=$imgid");
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
 curl_setopt($ch, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS
 curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
 $Rec_Data = curl_exec($ch);
 
 print_r($Rec_Data);
 
 ?>