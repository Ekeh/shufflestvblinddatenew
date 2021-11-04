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
$userid = $_COOKIE['userid'];
?>
<?php
$d='';
function insert_date_request($db, $user_id, $to_user_id)
{
    $q = mysqli_query($db,"INSERT into tbl_blind_date_request SET user_id='$user_id', to_user_id='$to_user_id', created_at = '" . date('Y-m-d H:i:s', time()) . "'");
    if(mysqli_affected_rows($db) > 0) {
        mysqli_query($db, "UPDATE tbl_users SET profile_type = '" . PROFILE_FREE . "' WHERE userid='$user_id'");
        mysqli_query($db, "UPDATE tbl_users SET profile_type = '" . PROFILE_FREE . "' WHERE userid='$to_user_id'");
        return true;
    }
    return false;
}

if(isset($_COOKIE['userid']))
{
    if(isset($_GET['u'])){
        $uid=$db -> real_escape_string($_GET['u']);
    }else{
        echo "<div class='alert alert-danger'> Unknown User ID</div>";
        ?>
        <script>
            setTimeout(function(){
                window.location.href = 'index.php?p=gallery';
            }, 1000);
        </script>
        <?php
        exit;

    }


    $userid=$_COOKIE['userid'];
    $price_per_view=5;

    if(isset($_POST['request_date']) || isset($_GET['chargeaccepted'])) {
        if($userid == $uid) {
            ?>
            <script>
                alert('You can not send request to yourself.');
                setTimeout(function(){
                    window.location.href = 'index.php?p=gallery';
                }, 1000);
            </script>
            <?php
        }
        //TODO: Is the send on a date
        $checkUserOnDate = mysqli_query($db,"SELECT  id FROM tbl_blind_date_request WHERE (user_id='$userid' OR to_user_id = '$userid') AND status='" . BLIND_DATE_STATUS_ACCEPTED . "'");
        //TODO: Is the friend on a date with this user
        $checkUserAndFriend = mysqli_query($db,"SELECT  id FROM tbl_blind_date_request WHERE ((user_id='$userid' AND to_user_id = '$uid') OR (user_id='$uid' AND to_user_id = '$userid')) AND (status='" . BLIND_DATE_STATUS_PENDING . "' OR status='" . BLIND_DATE_STATUS_ACCEPTED . "')");
        $friendOnDate = mysqli_query($db,"SELECT  id FROM tbl_blind_date_request WHERE (user_id='$uid' OR to_user_id = '$uid') AND status='" . BLIND_DATE_STATUS_ACCEPTED . "'");

        //TODO: Check how many pending requests this user has.
        $checkPendingRequests = mysqli_query($db,"SELECT id FROM tbl_blind_date_request WHERE user_id='$userid' AND status='" . BLIND_DATE_STATUS_PENDING . "'");
        //exit();
        if(mysqli_num_rows($checkUserOnDate) > 0) {
            ?>
            <script>
                alert("You are already on a date.");
            </script>
            <?php
        }else if(mysqli_num_rows($checkUserAndFriend) > 0) {
            ?>
            <script>
                alert("You already have an active request with this user.");
            </script>
            <?php
        }else if(mysqli_num_rows($friendOnDate) > 0) {
            ?>
            <script>
                alert("This user is already on a date.");
            </script>
            <?php
        }else if(mysqli_num_rows($checkPendingRequests) >= FREE_REQUEST_QUOTA) {
            if($_GET['chargeaccepted'] === '1') {
                //TODO: charge users wallet
                $checkCredit = mysqli_query($db,"SELECT credit FROM  tbl_users  WHERE userid='$userid'");
                $credit = 0;
                if($row = mysqli_fetch_assoc($checkCredit)) {
                    $credit =  intval($row['credit']);
                }
                if($credit < AMOUNT_PER_REQUEST) {
                    ?>
                    <script>
                        alert('Insufficient credit. Please, fund your wallet.');
                    </script>
                    <?php
                }else {
                    if(insert_date_request($db, $userid, $uid)) {
                        $debit= mysqli_query($db,"UPDATE  tbl_users set credit=credit - '" . AMOUNT_PER_REQUEST . "'  WHERE userid='$userid'");
                        ?>
                        <script>
                            alert('Request sent successfully.');
                            setTimeout(function(){
                                window.location.href = 'index.php?p=dgallery&u=<?=$uid?>';
                            }, 1000);
                        </script>
                        <?php
                    }else {
                        ?>
                        <script>
                            alert('Error occurred while sending your request.');
                        </script>
                        <?php
                    }
                }
            }else{
                ?>
                <script>
                    if (confirm("You have exceeded your '<?=FREE_REQUEST_QUOTA?>' free request quota. Any other request will be charged '<?=AMOUNT_PER_REQUEST?>'.")) {
                        window.location.href = 'index.php?p=dgallery&u=<?=$uid?>&chargeaccepted=1';
                    }
                </script>
                <?php
            }
        }else{
            if(insert_date_request($db, $userid, $uid)) {
                ?>
                <script>
                    alert('Request sent successfully.');
                </script>
                <?php
            }else {
                ?>
                <script>
                    alert('Error occurred while sending your request.');
                </script>
                <?php
            }

        }

    }
    //// get profile of those that are trending
    $sq = mysqli_query($db,"SELECT * FROM tbl_users WHERE userid='$uid'");
    $nu=mysqli_num_rows($sq);

    if($nu=='0'){
        ?>
        <div class='alert alert-danger'> Photo is not trending at the moment</div>
        <?php
    }else{

        while($rows=mysqli_fetch_array($sq))
        {
            $photo=$rows['photo'];
            $name=$rows['username'];
            $description=$rows['description'];
            $uid=$rows['userid'];
            $nam=substr($name,0,15);
            $s = mysqli_query($db,"SELECT * FROM tbl_trend WHERE viewer_id='$userid' and owner_id='$uid'");
            $n=mysqli_num_rows($s);

            if($n=='0'){
                $q = mysqli_query($db,"INSERT into tbl_trend SET viewer_id='$userid', owner_id='$uid'");
                $p = mysqli_query($db,"UPDATE tbl_users SET views=views + 1, credit=credit-'$price_per_view' WHERE userid='$uid'");
            }



            ?>

            <section class="section section--details section--bg section-mobile-view" data-bg="img/section/details.jpg" style="background: url(&quot;img/section/details.jpg&quot;) center center / cover no-repeat;">
                <!-- details content -->
                <div class="container">
                    <div class="row">
                        <!-- player -->
                        <div class="col-12 col-xl-4 col-sm-6">
                            <div class="card__cover">
                                <img src="uploads/profile/<?=$photo; ?>" alt="<?=$name?>">
                            </div>
                        </div>
                        <!-- end player -->
                        <!-- content -->
                        <div class="col-12 col-xl-4 col-sm-6">
                            <div class="card card--details">
                                <div class="card__content">
                                    <ul class="card__meta">
                                        <li><h1 class="section__title section__title--mb"><?=$name ?></h1></li>
                                        <li><span>Description:</span><?=$description?></li>
                                    </ul>
                                    <?php if($userid != $uid) {?>
                                        <form action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" method="post">
                                            <input type="hidden" name="chargeaccepted" value="<?=empty($_GET['chargeaccepted'])? '0' : $_GET['chargeaccepted']?>"/>
                                            <button class="btn btn-default"  type="submit" name="request_date" value="1"> Send Date Request </button>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- end content -->

                    </div>
                <!-- end details content -->
            </section>

            <?php
        }

    }

}

?>



