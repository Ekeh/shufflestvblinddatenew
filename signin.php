<?php
session_start();
require('inc/db.php');
$msg = '';
if(isset($_POST['submit'])){
    $stremail = mysqli_real_escape_string($db,$_POST['username']);
    $pwd=mysqli_real_escape_string($db,$_POST['password']);

    if($stremail=='' || $pwd==''){
        echo '<div class="alert alert-block alert-danger fade in"> You have left a required field blank</div>';
    }else{
        $password=md5($pwd);
        $sql4 = mysqli_query($db,"SELECT * FROM tbl_users where (email='$stremail' OR phone='$stremail') and password='$password'");
        $nums2=mysqli_num_rows($sql4);
        if($nums2=='0'){
            $sql1 = mysqli_query($db,"SELECT * FROM tbl_users where email='$stremail' OR phone='$stremail'");
            $nums=mysqli_num_rows($sql1);

            if($nums=='0'){
                $msg="<b>Failed</b><br> Email or Phone - ".$stremail."  does not exist.";
            }
            else
            {
                $msg= "<b>Failed</b><br>Password does not match email provided";
            }
        }else{
            $rows = mysqli_fetch_array($sql4,MYSQLI_ASSOC);
            /*  echo '<pre>';
                  var_dump($rows);
                  echo '</pre>';
              exit();*/
            $fname=$rows['fname'];
            $lname=$rows['lname'];
            $useremail=$rows['email'];
            $userid=$rows['userid'];
            $adminphone=$rows['phone'];
            $gender=$rows['gender'];
            $role = $rows['role'];
            $msg= "Login Succesful";

            setcookie("fname", $fname, time() + (3600*24*365)); // 3600 = 1 hour
            setcookie("lname", $lname, time() + (3600*24*365)); // 3600 = 1 hour
            $username=$fname." ".$lname;
            setcookie("username", $username, time() + (3600*24*365)); // 3600 = 1
            setcookie("useremail",$useremail, time() + (3600*24*365)); // 3600 = 1 hour
            setcookie("userid", $userid, time() + (3600*24*365)); // 3600 = 1 hour hour
            setcookie("role", base64_encode($role), time() + (3600*24*365)); // 3600 = 1 hour hour
            if($fname==''){
                ?><script type="text/javascript">
                    alert('Kindly update your profile and include gender');
                    window.location.replace("index.php?p=profile");</script><?php
            }else{
                ?><script type="text/javascript">window.location.replace("index.php");</script><?php
            }
            exit;
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
								<input type="text" class="sign__input" name="username" placeholder="Email">
							</div>

							<div class="sign__group">
								<input type="password" class="sign__input" name="password" placeholder="Password">
							</div>

							<div class="sign__group sign__group--checkbox">
								<input id="remember" name="remember" type="checkbox" checked="checked">
								<label for="remember">Remember Me</label>
							</div>
							
							<button class="sign__btn" type="submit" name="submit" value="login">Sign in</button>



							<span class="sign__text">Don't have an account? <a href="signup.php">Sign up!</a></span>

							<span class="sign__text"><a href="forgot.php">Forgot password?</a></span>
						</form>
						<!-- end authorization form -->
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- JS -->
    <?php require_once ('inc/guest_footer.php');?>
</body>
</html>