<section class="section section-mobile-view">
    <article class="container">
        <!-- contents -->
        <div class="main_content section__text">
            <br /> <br />
            <h2 class="section__title">Fund Wallet</h2>
            <div class="main_content_inner">



                <!-- find channals  header -->

                <div class="">
                    <div>

                        <?php
                        if(!isset($_COOKIE['userid'])){

                            echo "<h4>You must Register / login to view this content</h4>";
                            ?>
                            <script type="text/javascript">

                                setTimeout(function(){
                                    window.location.href = 'signin.php';
                                }, 1000);
                            </script>

                            <?php
                            exit;
                        }

                        ?>
                    </div>

                </div>
                <div class="" style="padding: 10px" align="center">
                    <div style="max-width: 300px; padding: 10px" align="left">

                        <?php
                        $msg='';
                        $email='';
                        if(isset($_POST['subscribe'])){
                            $subscription=$_POST['subscription'];


                            if(!$_COOKIE['userid']){
                                $msg= "<div class='uk-alert-danger fade in' uk-alert>  We are unable to locate your user id. Kindly login. <a href='".SITE_VIP."login.php'>Click Here </a></div>";
                            }else{

                                $userid=$_COOKIE['userid'];

                                //// this is the call to go to paystack

                                $amount=$subscription;
                                //require_once('paystackcall.php');
                                require_once('flutterwavecall.php');

                                ////paystackends here

                                ?>

                                <?php


                            }
                        }else{

                            if($msg!=''){echo $msg;}
                            ?>
                            <!-- find channals -->



                            <h5 class="txt3">Choose Amount</h5>
                            <form  method="POST" action=""  id='demo-form' >
                                <div class="wrap-input100 validate-input m-t-25 m-b-35" data-validate = "Choose Amount">
                                    <select name="subscription" class="" style="padding: 10px; width: 100%" >
                                        <option value="100">N100</option>
                                        <option value="500">N500</option>
                                        <option value="1000">N1,000</option>
                                        <option value="5000">N5,000</option>
                                        <option value="10000">N10,000</option>
                                        <option value="20000">N20,000</option>

                                    </select>
                                </div>

                                <div class="container-login100-form-btn" style="margin-top: 5px">
                                    <button class="btn btn-warning" name="subscribe" style="width: 100%">

                                        <i class="uil-wallet"></i>  Fund Wallet Now</button>

                                </div>



                            </form>

                        <?php } ?>
                        <div align="center" style="background-color: #ffffff;margin-top: 5px; padding: 5px"><img src="img/paystack.png" height="70px" width="auto"></div>

                    </div>         </div>

            </div>




            <br />
<br />
    </article>
</section>