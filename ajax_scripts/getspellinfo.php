<?php

$spell = $_GET["spellid"];
// var_dump($_GET);exit;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://us.battle.net/oauth/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_USERPWD, "$clientid" . ':' . $clientsecret);

$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$token = json_decode($result)->access_token;


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://us.api.blizzard.com/data/wow/spell/$spell?namespace=static-us&locale=en_US",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer $token"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;