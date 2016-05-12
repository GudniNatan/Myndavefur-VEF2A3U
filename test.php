<?php
$headers = array(
	   'Content-Type' => 'application/json',
	);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://api.projectoxford.ai/vision/v1.0/analyze?visualFeatures=Description,Tags&subscription-key=f2967b0e51bc4c848838814ae877780e");

curl_setopt($ch, CURLOPT_POST, 1);
$encoded = json_encode(array('Url' => 'http://tsuts.tskoli.is/2t/1803982879/vef2a3u/myndavefur/img/large/30_-_Zp6N4Zs_1.png'), JSON_UNESCAPED_SLASHES);
echo "$encoded";
curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	//Bilar annars
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$server_output = curl_exec ($ch);

if(curl_exec($ch) === false)
{
    echo 'Curl error: ' . curl_error($ch);
}
curl_close ($ch);
$yoyo = json_decode($server_output);
echo($server_output);
var_dump($yoyo);