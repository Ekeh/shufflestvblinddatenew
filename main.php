<?php
$page='';
$msg='';
if(isset($_GET['p'])){
    $page=$_GET['p'];
}
if($page =='logout'){
    setcookie('useremail',$_COOKIE['useremail'], time() - (3600*24*365)); // 3600 = 1 hour
    setcookie('userid',$_COOKIE['userid'], time() - (3600*24*365)); // 3600 = 1 hour
    setcookie('fname',$_COOKIE['fname'], time() - (3600*24*365)); // 3600 = 1 hour
    setcookie('lname',$_COOKIE['lname'], time() - (3600*24*365)); // 3600 = 1 hour
    setcookie('username',$_COOKIE['username'], time() - (3600*24*365)); // 3600 = 1 hour
    setcookie('role',$_COOKIE['role'], time() - (3600*24*365)); // 3600 = 1 hour

    ?>
    <script type="text/javascript">window.location.replace("index.php");</script>
    <?php
    exit;
}


if(isset($_POST['searchuserweb'])) {
    search_user($db, $_POST['searchuserfieldweb']);
}

if(isset($_POST['searchusermobile'])) {
    search_user($db, $_POST['searchuserfieldmobile']);
}

function search_user($db, $ref_id) {
    $ref_id = mysqli_real_escape_string($db, $ref_id);
    $sql_search = mysqli_query($db,"SELECT userid FROM tbl_users where userid ='$ref_id'");
    $count = mysqli_num_rows($sql_search);
    if($count != '0'){
        ?>
        <script type="text/javascript">window.location.replace("index.php?p=dgallery&u=<?=$ref_id?>");</script>
        <?php
    }else {
        ?>
        <script type="text/javascript">alert('Ref ID not found.');</script>
        <?php
    }
}

function get_trend_profile_status_name($status) {
   switch ($status){
       case TREND_PROFILE_STATUS_PENDING:
           return 'Pending';
       case TREND_PROFILE_STATUS_ACTIVE:
           return 'Active';
       case TREND_PROFILE_STATUS_EXPIRED:
           return 'Expired';
       case TREND_PROFILE_STATUS_CANCELLED:
           return 'Cancelled';
       default:
           return '';
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSS -->

	<link rel="stylesheet" href="lib/bootstrap/dist/css/bootstrap.css">
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
	<title>ShufflesTV – Online Reality TV Show</title>
    <?php
    if(!isset($_REQUEST['JS'])){
        ?>
        <noscript>
        <meta http-equiv="refresh" content="0; url='<?php echo basename($_SERVER['PHP_SELF']);?>?JS='"/>
        </noscript><?php
    }

    ?>
</head>

<body class="body">
	<!-- header -->
	<header class="header">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="header__content">
						<!-- header logo -->
						<a href="index.php" class="header__logo">
							<img src="img/logo_head.jpg" alt="ShufflesTV" style="width: 32px;">
							<img src="img/logo.png" alt="ShufflesTV">
						</a>
						<!-- end header logo -->
						<!-- header nav -->
						<ul class="header__nav">
							<!-- dropdown -->
							<li class="header__nav-item">
								<a class="dropdown-toggle header__nav-link" href="index.php" role="button" aria-haspopup="true" aria-expanded="false">Home</a>
							</li>
							<!-- end dropdown -->

							<!-- dropdown -->
							<li class="header__nav-item">
								<a class="dropdown-toggle header__nav-link" href="index.php?p=blinddate" role="button" aria-haspopup="true" aria-expanded="false">Blind Date</a>
							</li>
							<!-- end dropdown -->
                            <!-- dropdown Skilled Partner Program (SPP)-->
                            <li class="header__nav-item">
                                <a class="dropdown-toggle header__nav-link" href="index.php?p=taspp" role="button" aria-haspopup="true" aria-expanded="false">TASPP</a>
                            </li>
                            <!-- end dropdown -->

							<li class="header__nav-item">
								<a href="index.php?p=gallery" class="header__nav-link">Gallery</a>
							</li>

							<!-- dropdown -->
							<li class="dropdown header__nav-item">
								<a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>

								<ul class="dropdown-menu header__dropdown-menu scrollbar-dropdown" aria-labelledby="dropdownMenuMore">
									<li><a href="index.php?p=episodes">Episodes</a></li>
									<li><a href="index.php?p=matches">Matches</a></li>
									<li><a href="index.php?p=voteresults">Voting Results</a></li>
								</ul>
							</li>
							<!-- end dropdown -->
						</ul>
						<!-- end header nav -->

						<!-- header auth -->
						<div class="header__auth">
							<form action="index.php" class="header__search" method="post">
								<input class="header__search-input" required name="searchuserfieldweb" type="text" placeholder="Type in Ref ID here..." />
								<button class="header__search-button" name="searchuserweb" type="submit">
									<i class="icon ion-ios-search"></i>
								</button>
							</form>

							<!-- end dropdown -->
                            <?php
                            if(!isset($_COOKIE['userid'])) {
                                ?>
                                <a href="signin.php" class="header__sign-in">
                                    <i class="icon ion-ios-log-in"></i>
                                    <span>sign in</span>
                                </a>
                                <a href="signup.php" class="btn">
                                    <span>Register</span>
                                </a>
                                <?php
                            }else {
                                ?>
                                <li class="dropdown header__nav-item">
                                    <a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-person"></i>&nbsp;&nbsp;
                                        <span><?=trim($_COOKIE['username']) != '' ? $_COOKIE['username'] : $_COOKIE['useremail'] ?></span><i class="icon ion-ios-arrow-down" style="font-size: 12px;margin-top: 3px;"></i></a>
                                    <ul class="dropdown-menu header__dropdown-menu scrollbar-dropdown" aria-labelledby="dropdownMenuMore">
                                        <li><a href="index.php?p=profile">Update Profile</a></li>
                                        <li><a href="index.php?p=makepayment">Fund Wallet</a></li>
                                        <li><a href="index.php?p=blinddaterequests">Date Requests</a></li>
                                        <li><a href="index.php?p=blinddateunmatch">Unmatch</a></li>
                                        <li><a href="index.php?p=trendprofile">Trend Profile</a></li>
                                        <li><a href="index.php?p=logout">Sign Out</a></li>
                                    </ul>
                                </li>

                            <?php
                            }
                            ?>
						</div>
						<!-- end header auth -->

						<!-- header menu btn -->
						<button class="header__btn" type="button">
							<span></span>
							<span></span>
							<span></span>
						</button>
						<!-- end header menu btn -->
					</div>
				</div>
			</div>
		</div>
        <section class="mobile-search">
            <form action="index.php" class="form form--profile" method="post">
                <div class="row row--form">
                    <div class="col-9">
                        <div class="form__group">
                            <input id="search" type="text" required name="searchuserfieldmobile" class="form__input" placeholder="Type in Ref ID here...">
                        </div>
                    </div>
                    <div class="col-3">
                            <button class="form__btn" type="submit" name="searchusermobile">Search</button>
                    </div>
                </div>
            </form>
        </section>


	</header>
	<!-- end header -->
    <?php
    if(isset($_REQUEST['JS'])){ ?>
        <section style="position: absolute; top: 100px;margin-left: 20px;">
            <h4 class="section__text"> Kindly Enable Javascript in your browser to continue. </h4><a href='index.php'>Try again</a>
        </section>
        <?php
        exit;
    }
    ?>
<?php
if($page=='' || !file_exists("pages/".$page.".php")){
    include("pages/dashboard.php");
}else{
    include("pages/".$page.".php");
}
?>
	<!-- footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="footer__content">
						<a href="index.php" class="footer__logo">
							<img src="img/logo.png" alt="ShufflesTV">
						</a>

						<span class="footer__copyright">© ShufflesTV, 2021 </span>

						<nav class="footer__nav">
                            <a href="index.php?p=voting" target='_blank'>  Voting Policy</a> |
                            <a href="index.php?p=privacy" target='_blank'>Privacy policy</a>
                            <p><a href="index.php?p=tandc" target='_blank'>  Terms & Conditions</a> |

                        </nav>

						<button class="footer__back" type="button">
							<i class="icon ion-ios-arrow-round-up"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- end footer -->

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