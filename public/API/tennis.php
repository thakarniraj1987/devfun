<?php 
//$url="http://3.7.102.54/oddslist"; // for all match list//
$url="http://3.7.102.54/listMarketBookBetfair/1.186495943,1.186438258,1.186495900,1.186406311,1.186442753,1.186407171,1.186407171,1.186430631,1.186441743,1.186439236,1.186406299,1.186497578,1.186441597,1.186443205,1.186442060,1.186439125,1.186407558,1.186440359,1.186407409,1.186442722,1.186439913,1.186439913,1.186408654,1.186440829,1.186441088,1.186441263,1.186495857,1.186439948,1.186440085,1.186405498,1.186425229,1.186420927,1.186420003,1.186420499,1.186430647,1.186420091,1.186419952,1.186419733,1.186406595,1.186405707,1.186405799,1.186403594,1.186420025,1.186420800,1.186408179,1.186408350,1.186404095,1.186403371,1.186406669,1.186420585,1.186419774,1.186420690,1.186419686,1.186420160,1.186419871,1.186419838,1.186420733,1.186420886,1.186420607,1.186407981,1.186420252,1.186404096,1.186406297,1.186403876,1.186404298,1.186420647";

//$url="http://69.30.238.2:3644/odds/multiple?ids=1.178229330"; // for tenish and soccer

//$url="http://139.162.20.164:3000/getDFancy?eventId=30648186"; 
//$url="http://3.7.102.54/DaimondApi/30692109";

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