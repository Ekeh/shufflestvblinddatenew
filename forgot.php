<?php
session_start();
require('inc/db.php');
$msg = '';
if(isset($_POST['enter'])){
    $stremail=mysqli_real_escape_string($db, $_POST['email']);


    if($stremail==''){
        echo '<div class="alert alert-block alert-danger fade in"> You have left a required field blank</div>';
    }else{
        $sql2 = mysqli_query($db,"SELECT * FROM tbl_users where email='$stremail'");
        $nums2=mysqli_num_rows($sql2);
        if($nums2=='0'){

            $msg="<b>Failed</b><br> Email  - ".$stremail."  does not exist.";
        }
        else
        {
            $msg= "<b>Failed</b><br>Password does not match email provided";
            $rows = mysqli_fetch_array($sql2,MYSQLI_ASSOC);
            $astat=$rows['activation_status'];
            $fname=$rows['fname'];
            $lname=$rows['lname'];
            $userphone=$rows['phone'];
            $useremail=$rows['email'];
            $userid=$rows['userid'];
            $time=md5(time());
            $code=substr($time,0,5);
            $pwd=md5($code);
            $sql2 = mysqli_query($db,"UPDATE tbl_users set password='$pwd' where userid='$userid' ");
            include('reset_email.php');
//// send reset password to email
            ?>
            <script type="text/javascript">alert("We have sent a reset password to your email address");</script><?php
            $redirectnow=$_COOKIE['redirectnow'];
            if($redirectnow!=''){
                ?>
                <script type="text/javascript">window.location.replace("<?php echo $redirectnow; ?>");</script><?php
            }
            else{
                ?><script type="text/javascript">window.location.replace("<?php echo SITE_MAIN; ?>signin.php");</script><?php
            }

        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once ('inc/guest_header.php')?>
	<title>ShufflesTV – Sign in</title>
</head>

<body class="body">

<div class="sign section--bg" data-bg="img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sign__content">
                    <!-- authorization form -->
                    <form action="" class="sign__form" method="post">
                        <a href="index.php" class="sign__logo">
                            <img src="img/logo.png" alt="ShufflesTV">
                        </a>
                        <?php if($msg != ''){ ?> <div class="alert alert-danger"><?=$msg; ?></div>    <?php } ?>
                        <div class="sign__group">
                            <input name="email" type="email" class="sign__input" required placeholder="Email">
                        </div>

                        <div class="sign__group sign__group--checkbox">
                            <input id="remember" name="remember" required type="checkbox" checked="checked">
                            <label for="remember">I agree to the <a href="index.php?p=privacy" target="_blank">Privacy Policy</a></label>
                        </div>

                        <button class="sign__btn" type="submit" name="enter" value="1">Send</button>

                        <span class="sign__text">We will send a password to your Email</span>
                    </form>
                    <!-- end authorization form -->
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once ('inc/guest_footer.php');?>
</body>
</html>