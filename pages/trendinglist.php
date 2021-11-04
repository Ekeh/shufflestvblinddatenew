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
						<h1 class="section__title">Trending Profiles</h1>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="index.php">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Trending Profiles</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

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
                $limit = 50;
                // Find out how many items are in the table
               // $sqlCount = mysqli_query($db,"SELECT COUNT(*) AS total FROM tbl_users WHERE profile_type='" . PROFILE_FREE . "' AND userid != '$userid' ");
                $sqlCount = mysqli_query($db,
                    "SELECT COUNT(*) AS total FROM tbl_trending_profile WHERE start_date <='" . date("Y-m-d") . "' AND end_date >= '" . date("Y-m-d") . "'");

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


                //$sql = mysqli_query($db,"SELECT * FROM tbl_users WHERE profile_type='" . PROFILE_FREE . "' AND userid != '$userid' order by rand() LIMIT $limit OFFSET $offset");
                $sql = mysqli_query($db,
                    "SELECT fp.*, u.photo, u.userid, u.username, u.description FROM tbl_trending_profile fp
                                                JOIN tbl_users u on fp.user_id = u.userid
                                                WHERE start_date <='" . date("Y-m-d") . "' AND end_date >= '" . date("Y-m-d") . "' order by rand() LIMIT $limit OFFSET $offset");

                $num=mysqli_num_rows($sql);

                if($num=='0'){
                    ?>
                    <div>
                        <div class='alert alert-danger'>
                            <p>No Public Profile at the moment</p>
                            <p>Would you like to feature your profile here ? <a href='index.php?p=trendprofile'>LEARN MORE</a></p>
                        </div>
                    </div>
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
