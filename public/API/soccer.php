<?php 
//$url="http://3.7.102.54/oddslist"; // for all match list//
$url="http://3.7.102.54/listMarketBookBetfair/1.186216337,1.186223321,1.186232268,1.186215991,1.186216163,1.186331946,1.186045765,1.186298949,1.186298697,1.186078879,1.186196931,1.186242016,1.186254436,1.186316933,1.186320431,1.186185936,1.185982587,1.185982062,1.185027563,1.185384461,1.186051953,1.186320611,1.186320521,1.186390266,1.185028318,1.185384839,1.186052373,1.186390181,1.186319865,1.186077854,1.186320243,1.186320369,1.186299579,1.186222933,1.186298067";

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