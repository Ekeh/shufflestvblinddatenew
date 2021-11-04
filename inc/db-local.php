<?php



$servername = "localhost";
$username = "root";
$password = "mysql";
$database = "campout_db";

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
/*
define("SITE_URL","https://campoutnaija.com/memberarea");
define("URL_PATH","https://campoutnaija.com/memberarea/index.php");
define("IMAGE_FOLDER","../dashboard/campout9ja_api/profile");
*/

define("SITE_URL","http://localhost/shuffles-v3");
define("URL_PATH","http://localhost/shuffles-v3/index.php");
define("IMAGE_FOLDER","../dashboard/campout9ja_api/profile");

//// where the video and coverimage is stored
define("VIDEO_PATH","http://localhost/shufflestv/uploads/videos");
define("COVERIMAGE_PATH","http://localhost/shufflestv/uploads/coverimage");


///// this is the website title
define("SITE_TITLE","ShufflesTV");
define("MAIN_SITE","https://shufflestv.com");





function setmycookie($cookiename,$cookievalue,$duration){
setcookie($cookiename, $cookievalue, $duration);
}


function unsetmycookie($cookiename,$cookievalue,$duration){
setcookie($cookiename, $cookievalue, $duration);
}
error_reporting(E_WARNING);
?>