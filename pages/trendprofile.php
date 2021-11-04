<?php

if(!isset($_COOKIE['userid'])){
    ?>
    <script type="text/javascript">
        alert("You Must Login to view this page");
        setTimeout(function(){
            window.location.href = 'signin.php';
        }, 1000);
    </script>
    <?php
    exit;
}
$user_id=$_COOKIE['userid'];
$checkCredit = mysqli_query($db,"SELECT credit FROM  tbl_users  WHERE userid='$user_id'");
$credit = 0;
if($row = mysqli_fetch_assoc($checkCredit)) {
    $credit =  intval($row['credit']);
}
if(isset($_POST['cancel'])){
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $sp = mysqli_query($db,"UPDATE tbl_trending_profile SET end_date = '". date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').' -1 days')) ."' WHERE id = '$id'");
    if($sp){
        ?>
        <script>
           alert('Cancelled successfully.');
        </script>
        <?php
    }else{
        ?>
        <script>
            alert('Failed.');
        </script>
        <?php
    }

}

if(isset($_POST['trend'])){
    $sql = mysqli_query($db,
        "SELECT id FROM tbl_trending_profile   WHERE end_date > '" . date('Y-m-d H:i:s') ."' AND user_id = '$user_id'");
    $num=mysqli_num_rows($sql);
    if($num > 0){
        ?>
        <script>
            alert('You have a running profile. Kindly, cancel your subscription.');
        </script>
        <?php
    }else {
        $name = ($_POST['type'] === 'oneday' ? TREND_PROFILE_ONE_DAY : TREND_PROFILE_FIVE_DAYS);
        $end_date = ($_POST['type'] === 'oneday' ? date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').' +1 days')) :  date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +5 days')));
        $txamount = $_POST['type'] === 'oneday' ?  TREND_PROFILE_ONE_DAY_AMOUNT : TREND_PROFILE_FIVE_DAYS_AMOUNT;
        //TODO: charge users wallet
        $checkCredit = mysqli_query($db,"SELECT credit FROM  tbl_users  WHERE userid='$user_id'");
        if($row = mysqli_fetch_assoc($checkCredit)) {
            $credit =  intval($row['credit']);
        }
        if($credit < $txamount) {
            ?>
            <script>
                alert('Insufficient credit. Please, fund your wallet.');
            </script>
            <?php
        }else {
            $sp = mysqli_query($db, "INSERT INTO `tbl_trending_profile`(`user_id`, `name`, `start_date`, `end_date`) VALUES ('$user_id','$name','" . date('Y-m-d H:i:s') . "','$end_date')");
            if ($sp) {
                $addcredit = mysqli_query($db, "UPDATE tbl_users set credit= credit - '$txamount' where userid='$user_id'");
                $checkCredit = mysqli_query($db,"SELECT credit FROM  tbl_users  WHERE userid='$user_id'");
                if($row = mysqli_fetch_assoc($checkCredit)) {
                    $credit =  intval($row['credit']);
                }
                ?>
                <script>
                    alert('Your profile is trended successfully.');
                </script>
                <?php
            } else {
                ?>
                <script>
                    alert('Failed.');
                </script>
                <?php
            }
        }
    }
}

?>
<!-- page title -->
<section class="section section--first section--bg section-mobile-view" data-bg="img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__wrap">
                    <!-- section title -->
                    <h1 class="section__title">Feature Profile</h1>
                    <!-- end section title -->

                    <!-- breadcrumb -->
                    <ul class="breadcrumb">
                        <li class="breadcrumb__item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb__item breadcrumb__item--active">Feature Profile</li>
                    </ul>
                    <!-- end breadcrumb -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end page title -->
<section class="section section--border" style="margin-top: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashbox">
                    <div class="dashbox__title">
                        <h3><i class="icon ion-ios-wallet"></i> Subscriptions</h3>
                        <div class="dashbox__wrap" style="width: auto;">
                           <span class="text-white">Units: <?=$credit?></span><br /><a class="dashbox__more" style="width: auto; padding: 0 10px;" href="index.php?p=makepayment">Fund Wallet</a>
                        </div>
                    </div>

                    <div class="dashbox__table-wrap mCustomScrollbar _mCS_2" style="overflow: visible;"><div id="mCSB_2" class="mCustomScrollBox mCS-custom-bar2 mCSB_horizontal mCSB_outside" tabindex="0" style="max-height: none;"><div id="mCSB_2_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px; width: 501px; min-width: 100%; overflow-x: inherit;" dir="ltr">
                                <table class="main__table main__table--dash">
                                    <thead>
                                    <tr>
                                        <th>TITLE</th>
                                        <th>STATUS</th>
                                        <th>START DATE</th>
                                        <th>END DATE</th>
                                        <th>CREATED AT</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = mysqli_query($db,
                                        "SELECT * FROM tbl_trending_profile 
                                                WHERE user_id = '$user_id'");

                                    $num=mysqli_num_rows($sql);

                                    if($num=='0'){

                                    ?>
                                        <tr>
                                            <td colspan="4">
                                                <div class="main__table-text">No subscriptions.</div>
                                                <br />
                                            </td>
                                        </tr>
                                        <?php
                                    }else {

                                    while ($rows = mysqli_fetch_array($sql)) {
                                    $id = $rows['id'];
                                    $name = $rows['name'];
                                    $status = $rows['status'];
                                    $start_date = $rows['start_date'];
                                    $end_date = $rows['end_date'];
                                    $created_at = $rows['created_at'];
                                        ?>
                                    <tr>
                                        <td>
                                            <div class="main__table-text"><?=$name?></div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?=get_trend_profile_status_name($status)?></div>
                                        </td>

                                        <td>
                                            <div class="main__table-text"><?=$start_date?></div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?=$end_date?></div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?=$created_at?></div>
                                        </td>
                                        <td>
                                            <?php
                                            if(strtotime($end_date) >= time()){
                                            ?>
                                            <form action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" method="post" style="width: 100%;">
                                                <input type="hidden" name="id" value="<?=$id?>" />
                                                <button class="price__btn" type="submit" name="cancel" value="1" onclick="return confirm('Your subscription will be cancelled without a refund. Continue...')"> Cancel </button>
                                            </form>
                                            <?php
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                        <?php
                                    }
                                    }
                                    ?>
                                    <tr><td colspan="4"><br /></td></tr>
                                    </tbody>
                                </table>
                            </div></div><div id="mCSB_2_scrollbar_horizontal" class="mCSB_scrollTools mCSB_2_scrollbar mCS-custom-bar2 mCSB_scrollTools_horizontal" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_2_dragger_horizontal" class="mCSB_dragger" style="position: absolute; min-width: 30px; display: block; width: 499px; max-width: 490px; left: 0px;"><div class="mCSB_dragger_bar"></div><div class="mCSB_draggerRail"></div></div></div></div></div>
                </div>
                <br />
                <br />
                <br />
            </div>

            <div class="col-12 col-xl-10">
                <p class="section__text">Featuring your profile will make it visible at the home page and other strategic pages. Select your preferred plan and get started.</p>

            </div>
        </div>

        <div class="row row--grid">
            <!-- price -->
            <div class="col-12 col-md-6 col-lg-4 order-md-2 order-lg-1">
                <div class="price">
                    <div class="price__item price__item--first"><span>Basic</span> <span>Free</span></div>
                    <div class="price__item"><span><i class="icon ion-ios-checkmark"></i> Gallery</span></div>
                    <div class="price__item price__item--none"><span><i class="icon ion-ios-close"></i> Home Page</span></div>
                    <div class="price__item price__item--none"><span><i class="icon ion-ios-close"></i>Strategic Pages</span></div>
                    <br />
                    <br />
                    <br />
                </div>
            </div>
            <!-- end price -->

            <!-- price -->
            <div class="col-12 col-md-12 col-lg-4 order-md-1 order-lg-2">
                <div class="price price--premium">
                    <div class="price__item price__item--first"><span>Silver</span> <span>N<?=TREND_PROFILE_ONE_DAY_AMOUNT?> <sub>/ day</sub></span></div>
                    <div class="price__item"><span><i class="icon ion-ios-checkmark"></i> Gallery</span></div>
                    <div class="price__item"><span><i class="icon ion-ios-checkmark"></i> Home Page</span></div>
                    <div class="price__item"><span><i class="icon ion-ios-checkmark"></i> Strategic Pages</span></div>
                    <form action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" method="post" style="width: 100%;">
                        <input type="hidden" name="type" value="oneday" />
                        <button class="price__btn" onclick="return confirm('N<?=TREND_PROFILE_ONE_DAY_AMOUNT?> will be deducted from your wallet. Continue...')" type="submit" name="trend" value="1"> Choose Plan </button>
                    </form>
                </div>
            </div>
            <!-- end price -->

            <!-- price -->
            <div class="col-12 col-md-6 col-lg-4 order-md-3">
                <div class="price">
                    <div class="price__item price__item--first"><span>Diamond</span> <span>N<?=TREND_PROFILE_FIVE_DAYS_AMOUNT?> <sub>/ Week</sub></span></div>
                    <div class="price__item"><span><i class="icon ion-ios-checkmark"></i> Gallery</span></div>
                    <div class="price__item"><span><i class="icon ion-ios-checkmark"></i> Home Page</span></div>
                    <div class="price__item"><span><i class="icon ion-ios-checkmark"></i> Strategic Pages</span></div>
                    <form action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" method="post" style="width: 100%;">
                        <input type="hidden" name="type" value="fivedays" />
                        <button class="price__btn" type="submit" name="trend" value="1" onclick="return confirm('N<?=TREND_PROFILE_FIVE_DAYS_AMOUNT?> will be deducted from your wallet. Continue...')"> Choose Plan </button>
                    </form>
                </div>
            </div>
            <!-- end price -->
        </div>
    </div>
</section>