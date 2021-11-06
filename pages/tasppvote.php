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

if(!isset($_GET['token'])){
    ?>
    <script type="text/javascript">
        alert("Please, select a user to vote for.");
        setTimeout(function(){
            window.location.href = 'index.php?p=gallery';
        }, 1000);
    </script>
    <?php
    exit;
}

$user_id = $_COOKIE['userid'];
$user_to_vote_id = mysqli_real_escape_string($db, $_GET['token']);
$sql_user = mysqli_query($db, "SELECT u.userid, u.username, u.fname, u.lname, u.photo, u.description, c.id AS category_id, c.name AS category_name, 
                                ts.id AS subscription_id
                                FROM tbl_users u 
                                JOIN `tbl_taspp_subscription` ts ON ts.user_id = u.userid
                                JOIN `tbl_category` c ON ts.category_id = c.id
                                WHERE u.userid = '$user_to_vote_id' AND ts.status = '" . TASPP_SUBSCRIPTION_ACTIVE ."'");
$nu =mysqli_num_rows($sql_user);
if($nu == 0){
    ?>
    <script type="text/javascript">
        alert("User not found.");
        setTimeout(function(){
            window.location.href = 'index.php?p=gallery';
        }, 1000);
    </script>
    <?php
    exit;
}
$user_to_vote = mysqli_fetch_assoc($sql_user);

if(isset($_POST['vote']))
{
    $total_vote = intval($_POST['total_vote']);
    $category_id = $user_to_vote['category_id'];

    if($total_vote < 1)
    {
        ?>
        <script type="text/javascript">
            alert("Vote must be at least one.");
        </script>
        <?php
    }else{
        //TODO: charge users wallet
        $checkCredit = mysqli_query($db,"SELECT credit FROM  tbl_users  WHERE userid='$user_id'");
        $credit = 0;
        if($row = mysqli_fetch_assoc($checkCredit)) {
            $credit =  intval($row['credit']);
        }
        $total_vote = $total_vote * TASPP_VOTE_AMOUNT;
        if($credit < $total_vote) {
            ?>
            <script type="text/javascript">
                alert("Insufficient credit. Please, fund your wallet.");
            </script>
            <?php
        }else {
            $sql_insert = mysqli_query($db,"INSERT INTO `tbl_taspp_vote_record`(`from_user_id`, `to_user_id`, `category_id`, `amount`, `created_at`) 
                            VALUES ('$user_id','$user_to_vote_id','$category_id','$total_vote', '" . date('Y-m-d H:i:s') . "')");
              if(mysqli_affected_rows($db) > 0){
                  $debit = mysqli_query($db, "UPDATE  tbl_users set credit=credit - '" . $total_vote . "'  WHERE userid='$user_id'");
                  unset($_POST);
                  ?>
                  <script type="text/javascript">
                      alert("You have successfully voted.");
                  </script>
                  <?php
              }else {
                  ?>
                  <script type="text/javascript">
                      alert("Error occurred while casting your vote.");
                  </script>
                  <?php
              }
        }
    }
}

?>

<section class="section section--details section--bg section-mobile-view" data-bg="img/section/details.jpg" style="background: url(&quot;img/section/details.jpg&quot;) center center / cover no-repeat;">
    <!-- details content -->
    <div class="container">
        <div class="row">
            <!-- player -->
            <div class="col-12 col-xl-4 col-sm-6">
                <div class="card__cover">
                    <img src="uploads/profile/<?=$user_to_vote['photo']; ?>" alt="<?=$user_to_vote['username']?>">
                </div>
            </div>
            <!-- end player -->
            <!-- content -->
            <div class="col-12 col-xl-4 col-sm-6">
                <div class="card card--details">
                    <div class="card__content">
                        <ul class="card__meta">
                            <li><h1 class="section__title section__title--mb no-margin-bottom"><?=$user_to_vote['username'] ?></h1></li>
                            <li><span>Description:</span><?=$user_to_vote['description']?></li>
                            <li><span>Category:</span><?=$user_to_vote['category_name']?></li>
                        </ul>
                            <form class="form form--profile" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" method="post">

                                <div class="alert alert-info"><strong>Note:</strong> Each vote costs N<?=TASPP_VOTE_AMOUNT?>. You can enter as many votes as you wish.</div>
                                <div class="form__group">
                                    <input class="form__input" required type="number" name="total_vote" value="<?=!empty($_POST['total_vote'])? $_POST['total_vote'] : ''?>" placeholder="Enter your votes."/>
                                </div>
                                <button class="btn btn-default"  type="submit" name="vote" value="1">Vote </button>
                            </form>
                    </div>
                </div>
            </div>
            <!-- end content -->

        </div>
        <!-- end details content -->
</section>
