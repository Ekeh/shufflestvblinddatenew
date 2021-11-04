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
$userid=$_COOKIE['userid'];

if(isset($_POST['vote'])){
//dump($_POST);
$total_vote = intval(mysqli_escape_string($db, $_POST['total_vote']));
$request_id= intval(mysqli_escape_string($db, $_POST['request_id']));
$checkCredit = mysqli_query($db,"SELECT credit FROM  tbl_users  WHERE userid='$userid'");
$credit = 0;
if($row = mysqli_fetch_assoc($checkCredit)) {
    $credit =  intval($row['credit']);
}
$total_amount = $total_vote * VOTE_AMOUNT;
if($credit < $total_amount) {
    ?>
    <script>
        alert('Insufficient credit. Please, fund your wallet.');
    </script>
    <?php
}else {
    $updat_amount= mysqli_query($db,"UPDATE tbl_users set credit=credit - $total_amount where userid='$userid'");
    $query=mysqli_query($db,"INSERT into tbl_vote_record set post_id='$request_id', amount='$total_amount',vuser_id='$userid' ");
    if(mysqli_affected_rows($db) > 0){
        ?>
        <script>
            alert('Vote submitted successfully.');
        </script>
        <?php
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
						<h1 class="section__title">Matches</h1>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="index.php">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Matches</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

    <!-- section -->
    <section class="section section--border" style="padding-bottom: 0;">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-12">
                    <div class="section__title-wrap">
                        <h2 class="section__title">Matches</h2>

                        <div class="section__nav-wrap">
                            <a href="index.php?p=makepayment" class="btn btn-success margin-right-20">Fund Wallet</a>
                            <a href="index.php?p=voteresults" class="btn btn-default">View Results</a>
                        </div>
                    </div>
                </div>
                <!-- end section title -->
            </div>
        </div>
    </section>
    <!-- end section -->

	<!-- catalog -->
	<div class="catalog">
		<div class="container">
			<div class="row row--grid">
                <!-- section title -->
                <div class="col-12">
                    <div class="section__title-wrap">

                    </div>
                </div>
                <!-- end section title -->

                    <?php
                    $page = isset($_GET['page']) ? $db->real_escape_string($_GET['page']) : 1;
                    $limit = 10;
                    // Find out how many items are in the table
                    //$sqlCount = mysqli_query($db,"SELECT COUNT(*) AS total FROM tbl_users WHERE profile_type='" . PROFILE_FREE . "' AND userid != '$userid' ");
                    $sqlCount = mysqli_query($db,"SELECT COUNT(*) AS total FROM tbl_blind_date_request WHERE status='" . BLIND_DATE_STATUS_ACCEPTED . "'");
                    $total = mysqli_fetch_assoc($sqlCount);
                    $total = intval($total['total']);
                    //var_dump($total);
                    //exit();
                    // How many pages will there be
                    $pages = ceil($total / $limit);

                    // Calculate the offset for the query
                    $offset = ($page - 1)  * $limit;

                    // Some information to display to the user
                    $start = $offset + 1;
                    $end = min(($offset + $limit), $total);
                    $pagination = '';
                    // The "back" link
                    //$prevlink = ($page > 1) ? "<a href='index.php?p=matches&page=1' title='First page'>&laquo;</a> <a href='index.php?p=matches&page='" . ($page - 1) . " title='Previous page'>&lsaquo;</a>" : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
                    $prevlink = ($page > 1) ? "<li class=\"paginator__item paginator__item--prev\">
							<a href=\"index.php?p=matches&page=" . ($page - 1) . "\"><i class=\"icon ion-ios-arrow-back\"></i></a>
						</li>" : '<li class="paginator__item"><a class="disabled" style=\'color: #aaa;\'>&lsaquo;</a></li>';

                    // The "forward" link
                    //$nextlink = ($page < $pages) ? '<a href="index.php?p=matches&page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="index.php?p=matches&page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
                    $nextlink = ($page < $pages) ? "<li class=\"paginator__item paginator__item--next\">
							<a href=\"index.php?p=matches&page=" . ($page + 1) . "\"><i class=\"icon ion-ios-arrow-forward\"></i></a></li>" : "<li class=\"paginator__item\"><a class=\"disabled\" style='color: #aaa;'>&rsaquo;</a></li>";

                    // Display the paging information
                    // $pagination = "<div id='paging'><p>, $prevlink,  Page , $page, of , $pages, pages, displaying , $start, -, $end, of, $total, results, $nextlink, </p></div>";

                    //$sql = mysqli_query($db,"SELECT * FROM tbl_users WHERE profile_type='" . PROFILE_FREE . "' AND userid != '$userid' order by rand() LIMIT $limit OFFSET $offset");
                    $sql = mysqli_query($db,"SELECT * FROM tbl_blind_date_request WHERE status='" . BLIND_DATE_STATUS_ACCEPTED . "' LIMIT $limit OFFSET $offset");
                    $num = mysqli_num_rows($sql);

                    if($num == '0') {
                             ?>
                            <div class='alert alert-danger'> No Public Profile at the moment</div>
                            <div class='alert alert-success'> Would you like to feature your profile here ? <a
                                        href='index.php?p=trend' target='_blank'>LEARN MORE</a></div>
                            <?php
                        }
                    else {
                        while ($rows = mysqli_fetch_array($sql)) {
                            $from_user_id = $rows['user_id'];
                            $to_user_id = $rows['to_user_id'];
                            $sqlUser1 = mysqli_query($db, "SELECT userid, username, photo, gender FROM tbl_users WHERE userid = '$from_user_id'");
                            $sqlUser2 = mysqli_query($db, "SELECT  userid, username, photo, gender FROM tbl_users WHERE userid = '$to_user_id'");
                            $row_from_user = mysqli_fetch_array($sqlUser1);
                            $row_to_user = mysqli_fetch_array($sqlUser2);
                            $from_user_photo = $row_from_user['photo'];
                            $from_user_username = $row_from_user['username'];
                            $from_user_gender = $row_from_user['gender'];

                            $to_user_photo = $row_to_user['photo'];
                            $to_user_username = $row_to_user['username'];
                            $to_user_gender = $row_to_user['gender'];
                            if($from_user_gender == 'male' && $to_user_gender == 'male') continue;
                            else if($from_user_gender == 'female' && $to_user_gender == 'female') continue;
                            else if (!is_file("uploads/profile/$from_user_photo") || !file_exists("uploads/profile/$from_user_photo")) {
                                continue;
                            }
                            else if (!is_file("uploads/profile/$to_user_photo") || !file_exists("uploads/profile/$to_user_photo")) {
                                continue;
                            }
                            ?>
                                <!-- card -->
                                <section class="row">
                                    <div class="col-6 col-sm-6 col-md-6 col-xl-5">
                                        <div class="card">
                                            <div class="card__cover">
                                                <img src="uploads/profile/<?=$from_user_photo?>" alt="<?=$from_user_username?>" title="<?=$from_user_username?>" style="height: 450px;" />
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-6 col-md-6 col-xl-5">
                                        <div class="card">
                                            <div class="card__cover">
                                                <img src="uploads/profile/<?=$to_user_photo?>" alt="<?=$to_user_username?>" title="<?=$to_user_username?>" style="height: 450px;" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-6 col-md-6 col-xl-2">
                                        <p class="section__title">Vote</p>

                                        <form action="<?= $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ?>"
                                              method="post">
                                            <input type="number" name="total_vote" class="form-control" placeholder="Enter your vote"
                                                   value="1" min="1"/>
                                            <input type="hidden" name="request_id"
                                                   value="<?=$rows['id'] ?>"/>
                                            <button type="submit" name="vote" value="1" class="btn btn-default" onclick="return confirm('Each vote costs N<?=VOTE_AMOUNT?>? Click Ok to continue...')">Vote</button>
                                        </form>
                                        <div class="section__text">
                                            <small class="text-danger"><strong>Note:</strong> Each vote costs
                                                N<?= VOTE_AMOUNT ?></small>
                                        </div>
                                    </div>
                                </section>
                            <div class="clear-fix"></div>
                                <!-- end card -->
                                <?php
                        }
                    }
                    ?>

			</div>

			<div class="row">
				<!-- paginator -->
				<div class="col-12">
                    <ul class="paginator">
                        <?=$prevlink?>
                       <?=$nextlink?>
                    </ul>
				</div>
				<!-- end paginator -->
			</div>
		</div>
	</div>
	<!-- end catalog -->
