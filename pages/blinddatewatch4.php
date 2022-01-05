<?php
if(!isset($_COOKIE['userid'])){
    ?>
    <script type="text/javascript">
        alert("You Must Login to view this page");
        setTimeout(function(){
            window.location.href = 'signup.php';
        }, 1000);
    </script>
    <?php
    exit;
}
$user_id = $_COOKIE['userid'];
//TODO: charge users wallet
$checkCredit = mysqli_query($db,"SELECT credit FROM  tbl_users  WHERE userid='$user_id'");
$credit = 0;
if($row = mysqli_fetch_assoc($checkCredit)) {
    $credit =  intval($row['credit']);
}
if($credit < EPISODE_VIEW_AMOUNT) {
    ?>
    <script type="text/javascript">
        alert("Insufficient credit. Please, fund your wallet.");
        setTimeout(function () {
            window.location.href = 'index.php?p=episodes';
        }, 1000);
    </script>
    <?php
}else {
    $debit = mysqli_query($db, "UPDATE  tbl_users set credit=credit - '" . EPISODE_VIEW_AMOUNT . "'  WHERE userid='$user_id'");
if(!$debit)
{
    ?>
        <script type="text/javascript">
            alert("Error occurred while charging your wallet.");
            setTimeout(function () {
                window.location.href = 'index.php?p=episodes';
            }, 1000);
        </script>
        <?php
}
    /*$request_id = mysqli_real_escape_string($db, $_GET['request_id']);
    $from_user_id = mysqli_real_escape_string($db, $_GET['from_user_id']);
    $to_user_id = mysqli_real_escape_string($db, $_GET['to_user_id']);
    if (empty($request_id) || empty($to_user_id)) {
        */?><!--
        <script type="text/javascript">
            alert("Invalid request. Click to refresh.");
            setTimeout(function () {
                window.location.href = 'index.php?p=blinddateunmatch';
            }, 1000);
        </script>
        <?php
/*    } else {
        if (unmatch($db, $user_id, $from_user_id, $request_id, $to_user_id)) {
            $debit = mysqli_query($db, "UPDATE  tbl_users set credit=credit - '" . AMOUNT_PER_UNMATCH . "'  WHERE userid='$user_id'");
            */?>
            <script type="text/javascript">
                alert("Users unmatched successfully.");
                setTimeout(function () {
                    window.location.href = 'index.php?p=blinddateunmatch';
                }, 1000);
            </script>
            --><?php
/*        } else {
            $msg = "Error occurred while sending your request.";
            $is_error = true;
        }
    }*/
}


?>
<style>
    video {
        width: 100%;
        max-height: 100%;
    }
</style>
<section class="section section--first section--bg section-mobile-view" data-bg="img/section/section.jpg" style="background: url(&quot;img/section/section.jpg&quot;) center center / cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__wrap">
                    <!-- section title -->
                    <h2 class="section__title">Blind Date Watch</h2>
                    <!-- end section title -->

                    <!-- breadcrumb -->
                    <ul class="breadcrumb">
                        <li class="breadcrumb__item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb__item breadcrumb__item--active">Blind Date Watch</li>
                    </ul>
                    <!-- end breadcrumb -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <video id="vid" controls autoplay>
            <source src="uploads/videos/blinddate_episode4shuffles.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        

    </div>
</section>
<script src="js/jquery-3.5.1.min.js" type="text/javascript"></script>
<script>
$(function () {
   document.getElementById('vid').play();
});

</script>