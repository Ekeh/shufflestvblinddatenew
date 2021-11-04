<?php

$amount=$amount;
////$amount_kobo=$amount.'00';
$time=time();
$md5code=md5($time);
$cartid=substr($md5code,0,8);
   

 /// echo $cartid;
 
  $email=$_COOKIE['useremail']; 

    $userid=$_COOKIE['userid']; 

    ?><br>
<form>
  <script src="https://checkout.flutterwave.com/v3.js"></script>
  <button type="button" onClick="makePayment()" class="btn btn-warning"  style="width: 100%"> Pay with Flutterwave - N <?php echo $amount; ?></button>
</form>

<script>
  function makePayment() {
    FlutterwaveCheckout({
      public_key: "FLWPUBK-e19da9cc8a9c63f5acada8d46bba1370-X",
      /////FLWPUBK-e19da9cc8a9c63f5acada8d46bba1370-X",
      tx_ref: '<?php echo $cartid; ?>',
      amount: '<?php echo $amount; ?>',
      currency: "NGN",
      country: "NG",
      payment_options: "card, mobilemoneyghana, ussd",
      redirect_url: // specified redirect URL
        "<?=FLUTTERWAVE_VERIFICATION_PAGE?>",
      meta: {
        consumer_id: '<?php echo $userid; ?>',
        consumer_mac: "92a3-912ba-1192a",
      },
      customer: {
        email: "<?php echo $email; ?>",
       /* phone_number: "08102909304",
        name: "yemi desola",*/
      },
      callback: function (data) {
        console.log(data);
      },
      onclose: function() {
        // close modal
      },
      customizations: {
        title: "shufflestv",
        description: "Fund Wallet",
        logo: "https://shufflestv.com/images/logo.png",
      },
    });
  }
</script>
