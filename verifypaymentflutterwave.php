<?php
//// if this code doesn't work try another server
include("inc/db.php"); 


    if (isset($_GET['transaction_id'])) {

              $userid=$_COOKIE['userid'];


              ///paystack validate
                 echo "Please wait<br>";
              $reference = $_GET['transaction_id'];

        $ref = $_GET['transaction_id'];
        $amount = ""; //Correct Amount from Server
        $currency = ""; //Correct Currency from Server


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/".$ref."/verify",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer FLWSECK-ffb449ff0b97d2011d2d8a2c88819717-X"
    /////FLWSECK-ffb449ff0b97d2011d2d8a2c88819717-X"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
///echo $response;
$result = json_decode($response, true);
////echo "<br>";
////echo $result['customer']['email'];
////echo "<br>";
if($result['status'] == 'success'){
 $email=$result['data']['customer']['email'];
  $tx_ref=$result['data']['tx_ref'];
                            
 $txamount=$result['data']['amount'];
/*
 echo $tx_ref;
 echo "<br>";
 echo $txamount;
*/
                            ////check if the transaction alredy exists

 $chk= mysqli_query($db,"SELECT *  from tbl_credit_record where txref='$tx_ref'");
                           $n=mysqli_num_rows($chk);
                           if($n!='0'){
                                echo "<h6>Transaction already exists.</h6>"; 
                               ///// since the transaction exits redirect the person to the home page
                                ?>
                        <script type="text/javascript">

                           setTimeout(function(){
                                    window.location.href = '<?php echo SITE_URL; ?>';
                                 }, 500);
                        </script>
                        <?php

                        //// transaction does not exist
                           }else{
                               
      $sql= mysqli_query($db,"INSERT into tbl_credit_record set userid='$userid',trans_email='$email',trans_status='1',amount='$txamount',txref='$tx_ref',authorized_by='flutterwave'");

         $s= mysqli_query($db,"UPDATE tbl_users set credit=credit +'$txamount' WHERE userid='$userid'");
                        if($sql){
                         
                               echo "<h6>Your wallet has been funded.<br></h6>"; 
                              
                                      ?>
                        <script type="text/javascript">

                           setTimeout(function(){
                                    window.location.href = '<?php echo SITE_URL; ?>';
                                 }, 1000);
                        </script>
                        <?php

                  

                            //// end of $sql check 
                          }

                          ////end of transaction exists
                          }    
               
               //// ends success
}else{
echo  "<h4>Unsuccessful payment</h4>";
                ?>
                        <script type="text/javascript">

                           setTimeout(function(){
                                    window.location.href = '<?php echo SITE_URL; ?>';
                                 }, 1000);
                        </script>
                        <?php
}


}
else{
  echo "Transaction reference not found";
  ?>
                        <script type="text/javascript">

                           setTimeout(function(){
                                    window.location.href = '<?php echo SITE_URL; ?>';
                                 }, 1000);
                        </script>
                        <?php
}
?>