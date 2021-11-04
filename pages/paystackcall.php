<?php

$amount=$amount;
$amount_kobo=$amount.'00';
$time=time();
$md5code=md5($time);
$cartid=substr($md5code,0,8);
   

 /// echo $cartid;
 
  $email=$_COOKIE['useremail']; 

    $userid=$_COOKIE['userid']; 

    ?><br><Br><Br>
    <form >
  <script src="https://js.paystack.co/v1/inline.js"></script>
  <button type="button" onclick="payWithPaystack()" class="btn btn-warning"  style="width: 100%"> Pay with Paystack - N <?php echo $amount; ?>  </button> 
</form>
 
<script>
   function payWithPaystack(){
      var handler = PaystackPop.setup({
        ///pk_live_c724a86a10ca880f74262ad70f6e99d5be821943
        
      key: 'pk_live_c724a86a10ca880f74262ad70f6e99d5be821943',
      email: '<?php echo $email; ?>',
      amount: <?php echo $amount_kobo; ?>,
      currency: "NGN",
      ref: '<?php echo $cartid; ?>', // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
     
      // label: "Optional string that replaces customer email"
      metadata: {
         custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: "+2348012345678"
            }
         ]
      },
      callback: function(response){



          ///// validate the transaction here

      window.location.href = "<?=PAYSTACK_VERIFICATION_PAGE?>?reference=<?php echo $cartid;?>" ;




      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();
  }
</script>
