<?php
$curl = curl_init();
$email = "your@email.com";
$amount = 30000; 
$callback_url = 'myapp.com/pay/callback.php';  

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'email'=>$email,
    'callback_url' => $callback_url
  ]),
  CURLOPT_HTTPHEADER => [
    "authorization: Bearer sk_test_36658e3260b1d1668b563e6d8268e46ad6da3273",
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

print_r($tranx);
header('Location: ' . $tranx['data']['authorization_url']);