<?php

/*
$servername = "localhost";
$username = "root";
$password = "";
$database = "campout9ja_db";
*/

$servername = "localhost";
$username = "shuffles_db";
$password = "simpleas123";
$database = "shuffles_db";
/*

$servername = "localhost";
$username = "campoutn_campout";
$password = "simpleas123";
$database = "campoutn_db";
*/
// Create connection
$db = new mysqli($servername, $username, $password, $database);

// Check connection
if ($db->connect_error) {

     /// echo "Connection Failed:No ID:NO Email";
 die("Connection failed: " . $db->connect_error);

} 



define("SITE_MAIN","https://shufflestv.com/");
define("SITE_URL","https://shufflestv.com");
//define("SITE_MAIN","http://localhost/shufflestvnew/Website/");
//define("SITE_URL","http://localhost/shufflestvnew/Website");
define("SITE_VIP","https://shufflestv.com/vip");
define("PATH_VIP","https://shufflestv.com/vip/index.php");
define("URL_PATH","https://shufflestv.com/index.php");
define("IMAGE_FOLDER","uploads/coverimage");
define("VIDEO_PATH","https://shufflestv.com/uploads/videos");
define("UPLOAD_PROFILE","https://shufflestv.com/dashboard/campout9ja_api/profile");
define("PROFILE_FREE","1");
define("PROFILE_ON_DATE","2");
define("PROFILE_TRENDING","3");
define("PROFILE_TASPP","4");

define("BLIND_DATE_STATUS_PENDING","0");
define("BLIND_DATE_STATUS_ACCEPTED","1");
define("BLIND_DATE_STATUS_REJECTED","2");
define("BLIND_DATE_STATUS_EXPIRED","3");
define("BLIND_DATE_STATUS_UNMATCHED","4");
define("FREE_REQUEST_QUOTA",3);
define("AMOUNT_PER_REQUEST", 100);
define("AMOUNT_PER_UNMATCH", 100);

define("PHONE_NUMBER_NOT_NUMBER", 111);
define("PHONE_NUMBER_MUST_BE_080_070_090_081", 110);
define("PHONE_NUMBER_MUST_BE_11_DIGITS", 120);
define("PHONE_NUMBER_VALID", 200);
define("ROLE_ADMIN", "1");
define("TREND_PROFILE_ONE_DAY_AMOUNT", 100);
define("TREND_PROFILE_FIVE_DAYS_AMOUNT", 500);
define("TREND_PROFILE_FIVE_DAYS", '5 Days');
define("TREND_PROFILE_ONE_DAY", '1 Day');
define("TREND_PROFILE_STATUS_PENDING", '0');
define("TREND_PROFILE_STATUS_ACTIVE", '1');
define("TREND_PROFILE_STATUS_EXPIRED", '2');
define("TREND_PROFILE_STATUS_CANCELLED", '3');
define("EPISODE_VIEW_AMOUNT", 500);
define("VOTE_AMOUNT", 50);
define("DEFAULT_IMAGE_WIDTH", 350);
define("DEFAULT_IMAGE_HEIGHT", 450);
define("TASPP_VOTE_PERCENTAGE", 20);

define("PAYSTACK_VERIFICATION_PAGE", 'https://shufflestv.com/verifypayment.php');
define("PAYSTACK_SECRET_KEY", 'sk_live_0a9a2951181ee5a01f62778bd452bf7bc8995a75');
define("PAYSTACK_PUBLIC_KEY", 'pk_live_c724a86a10ca880f74262ad70f6e99d5be821943');
//define("PAYSTACK_VERIFICATION_PAGE", 'http://localhost/shufflestvnew/Website/verifypayment.php');
define("FLUTTERWAVE_VERIFICATION_PAGE", 'https://shufflestv.com/verifypaymentflutterwave.php');
//define("FLUTTERWAVE_VERIFICATION_PAGE", 'http://localhost/shufflestvnew/Website/verifypaymentflutterwave.php');

define("SMS_TOKEN","ukrDmtb09tYy7zBqCHOyJkI1piZoRzhTxgkFe00v16KfpRRuf7gBVRWeX90f");


///// this is the website title
define("SITE_TITLE","ShufflesTV");
define("MAIN_SITE","https://shufflestv.com");

/*
function setmycookie($cookiename,$cookievalue,$duration){
setcookie($cookiename, $cookievalue, $duration);
}



function imageResize($imageResourceId,$width,$height) {


    $targetWidth =400;
    $targetHeight =400;


    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);


    return $targetLayer;
}




//Here is the function to send via POST using CURL
function sendViaPost($url, $arr_params, $headers = array('Content-Type: application/x-www-form-urlencoded')) {
    $response = array();
    $final_url_data = $arr_params;
    if (is_array($arr_params)) {
        $final_url_data = http_build_query($arr_params, '', '&');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $final_url_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response['body'] = curl_exec($ch);
    $response['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $response['body'];
}


function unsetmycookie($cookiename,$cookievalue,$duration){
setcookie($cookiename, $cookievalue, $duration);
}*/
error_reporting(E_ALL);
?>