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
?>
<!-- page title -->
	<section class="section section--first section--bg section-mobile-view" data-bg="img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h1 class="section__title">Gallery</h1>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="index.php">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Gallery</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

    <!-- section -->
    <section class="section section--border">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-12">
                    <div class="section__title-wrap">
                        <h2 class="section__title">Trending Profile</h2>

                        <div class="section__nav-wrap">
                            <a href="index.php?p=trendinglist" class="section__view">View All</a>

                            <button class="section__nav section__nav--prev" type="button" data-nav="#carousel1">
                                <i class="icon ion-ios-arrow-back"></i>
                            </button>

                            <button class="section__nav section__nav--next" type="button" data-nav="#carousel1">
                                <i class="icon ion-ios-arrow-forward"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- end section title -->

                <!-- carousel -->
                <div class="col-12">
                    <div class="owl-carousel section__carousel feature-profile" id="carousel1">

                        <?php
                        //// get profile of those that are trendinghave public profile
                       // $sql = mysqli_query($db,"SELECT userid, username, photo, description FROM tbl_users WHERE profile_type = '" . PROFILE_ON_DATE . "' order by rand() limit 20");
                        $sql = mysqli_query($db,
                            "SELECT fp.*, u.photo, u.userid, u.username, u.description FROM tbl_trending_profile fp
                                                JOIN tbl_users u on fp.user_id = u.userid
                                                WHERE start_date <='" . date("Y-m-d") . "' AND end_date >= '" . date("Y-m-d") . "' order by userid desc limit 20");
                        $num=mysqli_num_rows($sql);
                        if($num !='0'){
                            while ($rows = mysqli_fetch_array($sql)) {
                                $photo = $rows['photo'];
                                $username = $rows['username'];
                                $user_id = $rows['userid'];
                                $description = strlen($rows['description']) > 50 ? substr($rows['description'], 0, 50).'...' : $rows['description'];
                                if (!is_file("uploads/profile/$photo") || !file_exists("uploads/profile/$photo")) {
                                    continue;
                                }
                                ?>
                                <div class="card">
                                    <div class="card__cover">
                                        <img src="uploads/profile/<?=$photo?>" alt="<?=$username?>">
                                        <a href="index.php?p=dgallery&amp;u=<?=$user_id?>" class="card__play">
                                            <i class="icon ion-ios-list"></i>
                                        </a>
                                    </div>
                                    <div class="card__content">
                                        <h3 class="card__title"><a href="index.php?p=dgallery&amp;u=<?=$user_id?>"><?=$username?></a></h3>
                                        <span class="card__category">
									<a href="index.php?p=dgallery&amp;u=<?=$user_id?>"><?=$description?></a>
								</span>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>
                </div>
                <!-- carousel -->
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
                        <h2 class="section__title">Gallery</h2>


                    </div>
                </div>
                <!-- end section title -->
                <?php
                $page = isset($_GET['page']) ? $db->real_escape_string($_GET['page']) : 1;
                $limit = 50;
                // Find out how many items are in the table
                $sqlCount = mysqli_query($db,"SELECT COUNT(*) AS total FROM tbl_users WHERE profile_type='" . PROFILE_FREE . "' AND userid != '$userid' ");
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
                //$prevlink = ($page > 1) ? "<a href='index.php?p=gallery&page=1' title='First page'>&laquo;</a> <a href='index.php?p=gallery&page='" . ($page - 1) . " title='Previous page'>&lsaquo;</a>" : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
                $prevlink = ($page > 1) ? "<li class=\"paginator__item paginator__item--prev\">
							<a href=\"index.php?p=gallery&page=" . ($page - 1) . "\"><i class=\"icon ion-ios-arrow-back\"></i></a>
						</li>" : '<li class="paginator__item"><a class="disabled" style=\'color: #aaa;\'>&lsaquo;</a></li>';

                // The "forward" link
                //$nextlink = ($page < $pages) ? '<a href="index.php?p=gallery&page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="index.php?p=gallery&page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
                $nextlink = ($page < $pages) ? "<li class=\"paginator__item paginator__item--next\">
							<a href=\"index.php?p=gallery&page=" . ($page + 1) . "\"><i class=\"icon ion-ios-arrow-forward\"></i></a></li>" : "<li class=\"paginator__item\"><a class=\"disabled\" style='color: #aaa;'>&rsaquo;</a></li>";

                // Display the paging information
               // $pagination = "<div id='paging'><p>, $prevlink,  Page , $page, of , $pages, pages, displaying , $start, -, $end, of, $total, results, $nextlink, </p></div>";


                $sql = mysqli_query($db,"SELECT * FROM tbl_users WHERE profile_type='" . PROFILE_FREE . "' AND userid != '$userid' ORDER BY userid DESC LIMIT $limit OFFSET $offset");
                $num=mysqli_num_rows($sql);

                if($num=='0'){
                    ?>
                    <div class='alert alert-danger'> No Public Profile at the moment</div>
                    <div class='alert alert-success'> Would you like to feature your profile here ? <a href='index.php?p=trend' target='_blank'>LEARN MORE</a></div>
                    <?php
                }else {

                    while ($rows = mysqli_fetch_array($sql)) {
                        $photo = $rows['photo'];
                        $username = $rows['username'];
                        $user_id = $rows['userid'];
                        $description = strlen($rows['description']) > 50 ? substr($rows['description'], 0, 50).'...' : $rows['description'];
                        if (!is_file("uploads/profile/$photo") || !file_exists("uploads/profile/$photo")) {
                            continue;
                        }

                ?>
				<!-- card -->
				<div class="col-6 col-sm-4 col-md-3 col-xl-2">
                    <div class="card">
                        <div class="card__cover">
                            <img src="uploads/profile/<?=$photo?>" alt="<?=$username?>">
                            <a href="index.php?p=dgallery&amp;u=<?=$user_id?>" class="card__play">
                                <i class="icon ion-ios-list"></i>
                            </a>
                        </div>
                        <div class="card__content">
                            <h3 class="card__title"><a href="index.php?p=dgallery&amp;u=<?=$user_id?>"><?=$username?></a></h3>
                            <span class="card__category">
									<a href="index.php?p=dgallery&amp;u=<?=$user_id?>"><?=$description?></a>
								</span>
                        </div>
                    </div>
				</div>
				<!-- end card -->
<?php

                    }
                }
?>
			</div>

			<div class="row">
				<!-- paginator -->
				<div class="col-12">
					<!--<ul class="paginator">
						<li class="paginator__item paginator__item--prev">
							<a href="#"><i class="icon ion-ios-arrow-back"></i></a>
						</li>
						<li class="paginator__item"><a href="#">1</a></li>
						<li class="paginator__item paginator__item--active"><a href="#">2</a></li>
						<li class="paginator__item"><a href="#">3</a></li>
						<li class="paginator__item"><a href="#">4</a></li>
						<li class="paginator__item paginator__item--next">
							<a href="#"><i class="icon ion-ios-arrow-forward"></i></a>
						</li>
					</ul>-->
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
