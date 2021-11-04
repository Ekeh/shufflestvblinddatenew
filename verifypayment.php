<?php
//// if this code doesn't work try another server
include("inc/db.php"); 
if(isset($_GET['reference']) ){  
  
              $userid=$_COOKIE['userid'];


              ///paystack validate
                 echo "Please wait";
              $reference = $_GET['reference'];
              $txref = $_GET['reference'];
              $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                    ////sk_live_182df3e51e359d66bd0e5878cd5c7d0437f266c7
                    "Authorization: Bearer sk_live_0a9a2951181ee5a01f62778bd452bf7bc8995a75",
                    "Cache-Control: no-cache",
                  ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                
                if ($err) {
                  echo "cURL Error #:" . $err;
                } else {
                  ///echo $response;
                $result = json_decode($response, true);

              if($result['data']['status'] == 'success'){
                          $email=$result['data']['customer']['email'];
                            
                         $txamount=substr($result['data']['amount'], 0, -2);
                            ////check if the transaction alredy exists

                          $chk= mysqli_query($db,"SELECT *  from tbl_credit_record where txref='$txref'");
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
                               
      $sql= mysqli_query($db,"INSERT into tbl_credit_record set userid='$userid',trans_email='$email',trans_status='1',amount='$txamount',txref='$txref'");
                        if($sql){
                            $commission=.1*$txamount; ////// 10% of amount as commission
                             $addcredit= mysqli_query($db,"UPDATE tbl_users set credit= credit+'$txamount' where email='$email'"); 
                           echo "<h5>Thank you for making a payment. Your transaction is noted</h5>"; 
                            if($addcredit){
                               echo "<h6>Your wallet has been funded.<br></h6>"; 
                              
                                      ?>
                        <script type="text/javascript">

                           setTimeout(function(){
                                    window.location.href = '<?php echo SITE_URL; ?>';
                                 }, 1000);
                        </script>
                        <?php

                        /// end of addcredit
                            }

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


              //// ends $err
           }  
}else{
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