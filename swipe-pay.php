<?php
/**
Plugin Name: Swipe Pay API
Description: Add Github project information using shortcode.
Version: 1.0
Author: Lourine Millicent
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

//$curl = curl_init();

//curl_setopt_array($curl, array(
  //CURLOPT_URL => "https://www.api.swypepay.africa/v3/apis/credentials",
  //CURLOPT_RETURNTRANSFER => true,
  //CURLOPT_ENCODING => "",
  //CURLOPT_MAXREDIRS => 10,
 // CURLOPT_TIMEOUT => 0,
  //CURLOPT_FOLLOWLOCATION => true,
  //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //CURLOPT_CUSTOMREQUEST => "POST",
 // CURLOPT_POSTFIELDS => array('consumer_key' => $consumer_key,'consumer_secret' => $consumer_secret,'merchant_code' => $merchant_code),
//));

//$response = curl_exec($curl);

//Parse JSON response
//$response_obj = json_decode($response);
//curl_close($curl);

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

$beneficiary ="DESIGNKE";//Your approved merchant code e.g SAMPLECODE or Wallet Phone Number e.g 2547XXXXXXXX
//$wallet ="1"; //Change to 1 to enable SwypePay e-wallet payments
$card_number = "4407830095727609"; //This is the number on the cardholders card. E.g. 5399 6701 2349 0229.
$cvv= "183"; //Card security code. This is 3/4 digit code at the back of the customers card, used for web payments.
$expiry_month="03"; //Two-digit number representing the card's expiration month.
$expiry_year="24"; // Two- digit number representing the card's expiration year.
$first_name = "RACHEL"; //This is the first name of the card holder or the customer.
$last_name = "WACHEKE"; // This is the last name of the card holder or the customer
$address="Thome 1st Avenue";//This is the address of the card holder or the customer.
$email= "rachelmugo90@gmail.com"; //This is the email address of the customer.
$country ="KE"; //This is the specified currency to charge the card in. With SwypePay you can charge cards in "KE" only.
$order_ref="ANOTHER TEST TRANSACTION"; //This is your unique reference, unique to the particular transaction being carried out.
$callback_url="https://www.swypepay.africa"; //This is a url you provide, we redirect to it after the customer completes payment and append the response to it as query parameters.
$currency="KES";
$amount ="10";

$curl = curl_init();


curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.api.swypepay.africa/v3/apis/charge-card",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => array('beneficiary' =>$beneficiary,'card_number' => $card_number,'cvv'=> $cvv,'expiry_month'=>$expiry_month,'expiry_year'=>$expiry_year,'first_name'=> $first_name, 'last_name'=>$last_name,
  'address'=> $address, 'email'=> $email,'country'=>$country, 'order_ref'=>$order_ref,'callback_url'=>$callback_url,
  'currency'=> $currency,'amount' => $amount),
  CURLOPT_HTTPHEADER => array(
    "Global-key: $global_key",
    "Server-url: $server_url",
    "Access-Token: $token"
  ),
));

$charge_card = curl_exec($curl);

curl_close($curl);

//Parse JSON response
$response_obj = json_decode($charge_card);
//Get back iframe link
$request_id= $response_obj->data->request_id;
$amount= $response_obj->data->amount;


echo $request_id;
echo "<br>";
echo $amount;




?>

<!-- Display iframe on your website-->
 