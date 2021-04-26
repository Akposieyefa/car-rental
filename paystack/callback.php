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

$curl = curl_init();
$paymentSecretKey = getPaymentKeys()->PaymentSecretKey;
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if(!$reference){
  $sql = $dbh->query("UPDATE `payments` SET `STATUS`='cancelled' WHERE `paymentReference` = '$reference'");
  die('No reference supplied');
}

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: $paymentSecretKey",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if(!$tranx->status){
   $sql = $dbh->query("UPDATE `payments` SET `STATUS`='failed' WHERE `paymentReference` = '$reference'");
  die('API returned error: ' . $tranx->message);
}

if('success' == $tranx->data->status){
 $sql = $dbh->query("UPDATE `payments` SET `STATUS`='success' WHERE `paymentReference` = '$reference'");
  echo "<h2>Thank you for making a purchase.</h2>";
}