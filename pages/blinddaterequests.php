<?php
if(!isset($_COOKIE['userid'])){
    ?>
    <script type="text/javascript">
        alert("You Must Login to view this page");
        setTimeout(function(){
            window.location.href = 'https://shufflestv.com/register.php';
        }, 1000);
    </script>
    <?php
    exit;
}
$userid=$_COOKIE['userid'];
?>
<?php
$d='';
?>
<?php
if(isset($_COOKIE['userid']))
{
    $userid=$_COOKIE['userid'];

    if(isset($_POST['accept_request'])) {
        $request_id = $_POST['request_id'];
        $from_user_id = $_POST['from_user_id'];
        $q = mysqli_query($db,"UPDATE tbl_blind_date_request SET status='" . BLIND_DATE_STATUS_ACCEPTED . "', updated_at = '" . date('Y-m-d H:i:s', time()) . "' WHERE id='$request_id'");
        mysqli_query($db, "UPDATE tbl_users SET profile_type = '" . PROFILE_ON_DATE . "' WHERE userid='$userid'");
        mysqli_query($db, "UPDATE tbl_users SET profile_type = '" . PROFILE_ON_DATE . "' WHERE userid='$from_user_id'");
        //TODO: Expire other requests from any of these users
        $q = mysqli_query($db,"UPDATE tbl_blind_date_request SET status='" . BLIND_DATE_STATUS_EXPIRED . "', updated_at = '" . date('Y-m-d H:i:s', time()) . "' WHERE id !='$request_id' AND user_id = '$userid'");
        $q = mysqli_query($db,"UPDATE tbl_blind_date_request SET status='" . BLIND_DATE_STATUS_EXPIRED . "', updated_at = '" . date('Y-m-d H:i:s', time()) . "' WHERE id !='$request_id' AND to_user_id = '$userid'");

        ?>
        <script>
            alert('Request accepted successfully.');
        </script>
        <?php
    }

    if(isset($_POST['reject_request'])) {
        $request_id = $_POST['request_id'];
        $from_user_id = $_POST['from_user_id'];
        $q = mysqli_query($db,"UPDATE tbl_blind_date_request SET status='" . BLIND_DATE_STATUS_REJECTED . "', updated_at = '" . date('Y-m-d H:i:s', time()) . "' WHERE id='$request_id'");
        mysqli_query($db, "UPDATE tbl_users SET profile_type = '" . PROFILE_FREE . "' WHERE userid='$userid'");
        mysqli_query($db, "UPDATE tbl_users SET profile_type = '" . PROFILE_FREE . "' WHERE userid='$from_user_id'");
        ?>
        <script>
            alert('Request rejected successfully.');
        </script>
        <?php
    }


}

?>
<section class="section section--first section--bg section-mobile-view" data-bg="img/section/section.jpg" style="background: url(&quot;img/section/section.jpg&quot;) center center / cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__wrap">
                    <!-- section title -->
                    <h2 class="section__title">Blind Date Requests</h2>
                    <!-- end section title -->

                    <!-- breadcrumb -->
                    <ul class="breadcrumb">
                        <li class="breadcrumb__item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb__item breadcrumb__item--active">Blind Date Requests</li>
                    </ul>
                    <!-- end breadcrumb -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">

        <?php
        //// get profile of those that are trending
        $checkRequest = mysqli_query($db,"SELECT * FROM tbl_blind_date_request WHERE to_user_id='$userid' AND status = '" . BLIND_DATE_STATUS_PENDING ."'");
        $nu=mysqli_num_rows($checkRequest);
        if($nu== 0){
            ?>
            <div class='alert alert-info'>No pending date request</div>
            <?php
        }else{
            while ($request = mysqli_fetch_assoc($checkRequest)){

                $requestDetails = mysqli_query($db, "SELECT * FROM tbl_users WHERE userid='" . $request['user_id'] . "'");
                while ($rows = mysqli_fetch_assoc($requestDetails))
                {
                    $photo = $rows['photo'];
                    $name = $rows['username'];
                    $uid = $rows['userid'];
                    $description = $rows['description'];
                    $nam = substr($name, 0, 15);
                    ?>
         <div class="row">
            <!-- player -->
            <div class="col-12 col-xl-4 col-sm-6">
                <div class="card__cover">
                    <img src="uploads/profile/<?=$photo; ?>" alt="<?=$name?>" style="width: 200px;  ">
                </div>
            </div>
            <!-- end player -->
            <!-- content -->
            <div class="col-12 col-xl-4 col-sm-6">
                <div class="card card--details">
                    <div class="card__content">
                        <ul class="card__meta">
                            <li><h1 class="section__title section__title--mb"><?=$name ?></h1></li>
                            <li><span>Description:</span> <a><?=$description?></a>
                            <li><span>Date:</span> <a><?=$request['created_at']?></a></li>
                            <li>
                                <form action="<?= $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ?>" method="post" style="margin-right: 20px;">
                                    <input type="hidden" name="request_id" value="<?= $request['id'] ?>"/>
                                    <input type="hidden" name="from_user_id" value="<?= $request['user_id'] ?>"/>
                                    <button type="submit" name="accept_request" value="1" class="btn btn-success"
                                            style="float: left; position: relative; left: 10px; margin-right: 5px;">Accept</button>

                                </form>
                                <form action="<?= $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ?>" method="post">
                                    <input type="hidden" name="request_id" value="<?= $request['id'] ?>"/>
                                    <input type="hidden" name="from_user_id" value="<?= $request['user_id'] ?>"/>
                                    <button type="submit" name="reject_request" value="1" class="btn btn-danger"
                                            style="float: left; position: relative; left: 10px;">Reject
                                    </button>

                                </form>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
            <!-- end content -->

        </div>
<br />
<br />


                    <?php
                }

            }
        }
        ?>
    </div>
</section>