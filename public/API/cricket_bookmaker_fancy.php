<?php
//$url="http://3.7.102.54/oddslist"; // for all match list//


//$url="http://69.30.238.2:3644/odds/multiple?ids=1.178229330"; // for tenish and soccer

//$url="http://139.162.20.164:3000/getDFancy?eventId=30648186"; 
$url="http://3.7.102.54/DaimondApi/30775612";

$headers = array('Content-Type: application/json');
$process = curl_init();
curl_setopt($process, CURLOPT_URL, $url);
curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
#curl_setopt($process, CURLOPT_HEADER, 1);
curl_setopt($process, CURLOPT_TIMEOUT, 30);
curl_setopt($process, CURLOPT_HTTPGET, 1);
#curl_setopt($process, CURLOPT_VERBOSE, 1);
curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
$return = curl_exec($process);
curl_close($process);
// echo $return;

$return_array = json_decode($return, true);
print_r($return_array);
?>