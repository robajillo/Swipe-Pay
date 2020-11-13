<?php
/**
Plugin Name: Swypepay
Description: Add Github project information using shortcode.
Version: 1.0
Author: Amimo
License: GPLv2 or later
Text Domain: github-api
*/

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
/*
SwypePay Keys & Variables Definition

Your SwypePay Merchant Code
*/
$merchant_code = 'DEMO1';
$consumer_key = 'NDBRSnR4ZE1TWmxsemlndWROdUIzMk9uV0xS';//Your SwypePay Live App Consumer Key Register a developer account on developer.swypepay.africa
                  
$consumer_secret = 'NDBlZ0FtSVFiakh1UExueTY3alNxZlVWSW5KNVdGblJFZW1NYUJsQ0lT';//Your SwypePay Merchant Live App Consumer Secret Use the secret from your developer account as well.

// Generate youe secure credentials

$curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => "https://www.api.swypepay.africa/v3/apis/credentials",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "POST",
//   CURLOPT_POSTFIELDS => array('consumer_key' => $consumer_key,'consumer_secret' => $consumer_secret,'merchant_code' => $merchant_code),
// ));

// $response = curl_exec($curl);

//Parse JSON response
// $response_obj = json_decode($response);
// curl_close($curl);

//These parameters will be passed in your header for the next requests to SwypePay.
$credentials = "MDgyOTE1MTk2MDc1NTk1NGFiZmM3MDE2ZjMxNGRlN2RjYzM1MjcyZmQ4OTRjMzFmZDIyNzdiODQwNWRhMWY3YzU2ZjY4MjJjZGEwMGNkZTMyNDc2ZTJkYmIxMjdjOGJkZWNlNTVlMDU0Y2MzY2FmODcyMWRkM2Q0Mjk1M2E0MTk=";
$global_key = "eRaMidkYj4R1vrkglUhh";
$server_url = "100.100.100.1";
//Generate API token for your call

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.api.swypepay.africa/v3/apis/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => array('merchant_code' => $merchant_code,'credentials' => $credentials),
));

$response = curl_exec($curl);

curl_close($curl);

//Parse your token validation response
 $response_obj_token=json_decode($response);
 
 //Get your token
 
 $token = $response_obj_token->data->token;
 
// Finally let's generate the iframe and load payment options. 

//Begin by filling your form data, this data can be passed to the iframs from your checkout form

//Form Data

$phone ="254719657770";//or could be $_POST['phone']; if you're collecting information from a form. :-) Simple huh?
$wallet ="1"; //Change to 1 to enable SwypePay e-wallet payments
$amount = "10"; //Amount you wish to charge your customer
$currency = "KES";//Don't change the currency. Only KES is currently supported. 
$merchantcode = "DEMO1"; //Your verified merchant code e.g. SAMPLECODE
$ecommerce = "1"; //1 to enable payment method; 0 to disable
$mpesa = "1";//1 to enable payment method; 0 to disable
$tkash = "1";//1 to enable payment method; 0 to disable
$visa = "1";//1 to enable payment method; 0 to disable
$mastercard = "1";//1 to enable payment method; 0 to disable
$american_express = "1";//1 to enable payment method; 0 to disable
$order_ref = "1";//Your unique order reference
$callback = "https://www.yourdomain.com";//We'll navigate to this URL after a successful payment
$curl = curl_init();


curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.api.swypepay.africa/v3/apis/mpesa-stk",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => array('phone' => $phone,'amount' => $amount,),
  CURLOPT_HTTPHEADER => array(
    "Global-key: $global_key",
    "Server-url: $server_url",
    "Access-Token: $token"
  ),
));

$mpesa_stk = curl_exec($curl);

curl_close($curl);

//Parse JSON response
$response_obj = json_decode($mpesa_stk);
//Get back iframe link

$reference_code= $response_obj->data->reference_code;
$phone= $response_obj->data->phone;



 echo $reference_code;
 echo $phone
?>