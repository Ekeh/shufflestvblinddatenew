<?php
$msg = '';
if(!isset($_COOKIE['userid'])){
    ?>
    <script type="text/javascript">
        alert("You Must Login to view this page");
        setTimeout(function(){
            window.location.href = '<?=SITE_MAIN?>index.php?p=login';
        }, 1000);
    </script>
    <?php
    exit;
}

global $user_id;
$user_id = $_COOKIE['userid'];
$from_user_id = '';
$to_user_id = '';
$request_id = '';
if(isset($_POST['unmatch']) || isset($_GET['chargeaccepted'])) {
    if(isset($_POST['unmatch'])) {
        $from_user_id = mysqli_real_escape_string($db, $_POST['from_user_id']);
        $to_user_id = mysqli_real_escape_string($db, $_POST['to_user_id']);
        $request_id = mysqli_real_escape_string($db, $_GET['request_id']);
    }

    $check_unmatch = mysqli_query($db,"SELECT id FROM tbl_blind_date_request WHERE unmatched_request_user_id  = '$user_id'");
    if(mysqli_num_rows($check_unmatch) > 0) {
        if($_GET['chargeaccepted'] === '1') {
            //TODO: charge users wallet
            $checkCredit = mysqli_query($db,"SELECT credit FROM  tbl_users  WHERE userid='$user_id'");
            $credit = 0;
            if($row = mysqli_fetch_assoc($checkCredit)) {
                $credit =  intval($row['credit']);
            }
            if($credit < AMOUNT_PER_UNMATCH) {
                $msg= "Insufficient credit. Please, fund your wallet.";
                $is_error = true;
            }else {

                $request_id = mysqli_real_escape_string($db, $_GET['request_id']);
                $from_user_id = mysqli_real_escape_string($db, $_GET['from_user_id']);
                $to_user_id = mysqli_real_escape_string($db, $_GET['to_user_id']);
                if (empty($request_id) || empty($to_user_id)) {
                    ?>
                    <script type="text/javascript">
                        alert("Invalid request. Click to refresh.");
                        setTimeout(function () {
                            window.location.href = 'index.php?p=blinddateunmatch';
                        }, 1000);
                    </script>
                    <?php
                } else {
                    if (unmatch($db, $user_id, $from_user_id, $request_id, $to_user_id)) {
                        $debit = mysqli_query($db, "UPDATE  tbl_users set credit=credit - '" . AMOUNT_PER_UNMATCH . "'  WHERE userid='$user_id'");
                        ?>
                        <script type="text/javascript">
                            alert("Users unmatched successfully.");
                            setTimeout(function () {
                                window.location.href = 'index.php?p=blinddateunmatch';
                            }, 1000);
                        </script>
                        <?php
                    } else {
                        $msg = "Error occurred while sending your request.";
                        $is_error = true;
                    }
                }
            }
        }else {
            ?>
            <script>
                if (confirm("You will be charged 'NGN<?=AMOUNT_PER_UNMATCH?>' to be unmatched. Press Ok to continue.")) {
                    window.location.href = 'index.php?p=blinddateunmatch&chargeaccepted=1&request_id=<?=$_POST['request_id']?>&from_user_id=<?=$_POST['from_user_id']?>&to_user_id=<?=$_POST['to_user_id']?>';
                }
            </script>
            <?php
        }
    }else {
        $request_id = mysqli_real_escape_string($db,$_POST['request_id']);
        $from_user_id = mysqli_real_escape_string($db, $_POST['from_user_id']);
        $to_user_id = mysqli_real_escape_string($db,$_POST['to_user_id']);
        if(unmatch($db, $user_id, $from_user_id, $request_id, $to_user_id)) {
            $msg= "Users unmatched successfully.";
        }else {
            $msg= "Error occurred while sending your request.";
            $is_error = true;
        }
    }
}

function unmatch($db, $user_id, $from_user_id, $request_id, $to_user_id) {
    $q = mysqli_query($db,"UPDATE tbl_blind_date_request SET status = '" . BLIND_DATE_STATUS_UNMATCHED ."', unmatched_request_user_id  = '$user_id', updated_at = '" . date('Y-m-d H:i:s', time()) . "' WHERE id = '$request_id'");
    mysqli_query($db, "UPDATE tbl_users SET profile_type = '" . PROFILE_FREE . "' WHERE userid='$from_user_id'");
    mysqli_query($db, "UPDATE tbl_users SET profile_type = '" . PROFILE_FREE . "' WHERE userid='$to_user_id'");
    unset($_POST);
    return true;
}

$sql4 = mysqli_query($db,"SELECT bdr.*, fromu.userid AS fromuserid, fromu.fname AS fromfname, fromu.lname AS fromlname, fromu.username AS fromusername,
 fromu.photo AS fromphoto, fromu.description AS fromdescription, tou.userid AS touserid, tou.fname AS tofname, tou.lname AS tolname, tou.username AS tousername  FROM  tbl_blind_date_request AS bdr
JOIN `tbl_users` AS fromu ON bdr.user_id = fromu.userid
JOIN `tbl_users` AS tou ON bdr.to_user_id = tou.userid WHERE (bdr.user_id = '$user_id' OR bdr.to_user_id = '$user_id') AND bdr.status = '" . BLIND_DATE_STATUS_ACCEPTED ."'");
$total_users = mysqli_num_rows($sql4);


?>
<section class="section section--first section--bg section-mobile-view" data-bg="img/section/section.jpg" style="background: url(&quot;img/section/section.jpg&quot;) center center / cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__wrap">
                    <!-- section title -->
                    <h2 class="section__title">Unmatch</h2>
                    <!-- end section title -->

                    <!-- breadcrumb -->
                    <ul class="breadcrumb">
                        <li class="breadcrumb__item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb__item breadcrumb__item--active">Unmatch</li>
                    </ul>
                    <!-- end breadcrumb -->
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row">

    <!-- content -->
    <?php
    if($total_users > 0) {
    while($row = mysqli_fetch_array($sql4,MYSQLI_ASSOC)) {
    ?>
        <!-- player -->
        <div class="col-12 col-xl-4 col-sm-6">
            <div class="card__cover">
                <img src="uploads/profile/<?=$row['fromphoto']?>" alt="<?=$row['fromusername']?>" style="width: 200px;  ">
            </div>
        </div>
        <!-- end player -->
    <div class="col-12 col-xl-4 col-sm-6">
        <div class="card card--details">
            <div class="card__content">
                <ul class="card__meta">
                    <li><h1 class="section__title section__title--mb"><?=$row['fromusername']?></h1></li>
                    <li><span>Description:</span> <a><?=$row['fromdescription']?></a>
                    <li>
                        <form action="<?= $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ?>"
                              method="post">
                            <input type="hidden" name="request_id"
                                   value="<?=$row['id'] ?>"/>
                            <input type="hidden" name="from_user_id"
                                   value="<?=$row['fromuserid'] ?>"/>
                            <input type="hidden" name="to_user_id"
                                   value="<?=$row['touserid'] ?>"/>
                            <button type="submit" name="unmatch" value="1"
                                    class="btn btn-danger" onclick="return confirm('Are you sure you want to unmatch? Click Ok to continue...')"
                                    style="float: left; position: relative; left: 10px;">Unmatch<i class="fa fa-arrow-right"></i>
                            </button>
                        </form>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <!-- end content -->
        <?php
    }
    }else {
        ?>
        <div class="col-12">
            <div class="alert alert-info" style="margin: 20px;">No matched users</div>
        </div>

        <?php
    }
    ?>
</div>

