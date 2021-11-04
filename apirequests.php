<?php
/**
 * Created by IntelliJ IDEA.
 * User: DELL
 * Date: 11/3/2021
 * Time: 1:55 AM
 */
require('inc/db.php');
$input = json_decode(file_get_contents('php://input'), true); //convert JSON into array
header('Content-Type: application/json; charset=utf-8');
if(isset($input['resolve_account_number']))
{
    if(empty($input['account_number']) || empty($input['bank_code']))
    {
        echo json_encode(['status' => false, 'message' => 'Bank and account number are required.']);
        exit();
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number={$input['account_number']}&bank_code={$input['bank_code']}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ". PAYSTACK_SECRET_KEY,
            "Cache-Control: no-cache",
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $err = curl_error($curl);
    if ($err) {
        echo $err;
    } else {
        echo $response;
    }

    // API URL
  /*  $url = 'https://api.flutterwave.com/v3/accounts/resolve';
// Create a new cURL resource
    $curl = curl_init($url);
// Setup request to send json via POST
    $data = array(
        'account_number' => $input['account_number'],
        'account_bank' => $input['bank_code']
    );
    $payload = json_encode($data);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo json_encode($err);
    } else {
        echo json_encode($response);
    }*/
}