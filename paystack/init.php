<?php
session_start();
include('../includes/config.php');
//error_reporting(0);

function getPaymentKeys()
{
  global $dbh;
  $sql = $dbh ->query("SELECT PaymentSecretKey, PaymentPublicKey FROM admin");
  $results = $sql->fetchAll(PDO::FETCH_OBJ);
  foreach ($results as $result) {
    return $result;
  }
}

  // Function get users Ip Address
function getIp() {
  $ip = $_SERVER['REMOTE_ADDR'];

  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  
  return  ip2long($ip);
}

$curl = curl_init();
$paymentSecretKey = getPaymentKeys()->PaymentSecretKey;
$VehicleId = $_POST['VehicleId'];
$email = $_POST['userEmail'];
$amount = $_POST['amount']; 
$message = $_POST['message']; 
$trx = mt_rand(100000000, 999999999);
$callback_url = 'paystack/callback.php'; 

curl_setopt_array($curl, array(
   CURLOPT_SSL_VERIFYHOST =>  false,
  CURLOPT_SSL_VERIFYPEER  => false,
  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'email'=>$email,
    'callback_url' => $callback_url
  ]),
  CURLOPT_HTTPHEADER => [
    "authorization: $paymentSecretKey",
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response, true);

if(!$tranx['status']){
  print_r('API returned error: ' . $tranx['message']);
}

$IP_ADDRESS = getIP();
$access_code = $tranx['data']['access_code']; 
$reference = $tranx['data']['reference'];
$destination = $tranx['data']['authorization_url'];

$sql = $dbh ->query("INSERT INTO `payments` (`userEmail`, `VehicleId`, `IP_ADDRESS`, `access_code`, `paymentReference`, `TXN_ID`, `AMOUNT_TO_PAY`, `DESTINATION`, `STATUS`, `message`) VALUES ('$email', '$VehicleId', '$IP_ADDRESS', '$access_code', '$reference', '$trx', '$amount', '$destination', 'initialize', '$message')");
 
  //Database insert initializing
print_r($tranx);
header('Location: ' . $tranx['data']['authorization_url']);