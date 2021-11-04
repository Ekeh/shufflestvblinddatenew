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
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSS -->
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/plyr.css">
	<link rel="stylesheet" href="css/photoswipe.css">
	<link rel="stylesheet" href="css/default-skin.css">
	<link rel="stylesheet" href="css/main.css">

	<!-- Favicons -->
	<link rel="icon" type="image/png" href="icon/favicon-32x32.png" sizes="32x32">
	<link rel="apple-touch-icon" href="icon/favicon-32x32.png">

	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Dmitry Volkov">
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

							<span class="sign__text"><a href="#">Forgot password?</a></span>
						</form>
						<!-- end authorization form -->
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- JS -->
	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/jquery.mousewheel.min.js"></script>
	<script src="js/jquery.mCustomScrollbar.min.js"></script>
	<script src="js/wNumb.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/plyr.min.js"></script>
	<script src="js/photoswipe.min.js"></script>
	<script src="js/photoswipe-ui-default.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>