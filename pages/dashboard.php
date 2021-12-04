<?php
/**
 * Created by IntelliJ IDEA.
 * User: DELL
 * Date: 9/30/2021
 * Time: 5:13 AM
 */
?>
<!-- home -->
<style>
    .blink_me {
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
</style>
<section class="home section-mobile-view">
    <section class="section__text news-wrapper no-margin-bottom">
            <marquee scrollamount="10" direction="left">
                <p>Watch The BlindDate House Reality TV Dating Game Show Season 1, Episode 1 at 7pm, November 6th, 2021.
                    Audition for Partner Persons & Brands for Season 2 of The BlindDate House Reality TV Dating Game Show begins on Sunday, 7th November, 2021.</p>
            </marquee>

    </section>
    <section class="section__text blink_me" style="position: relative; z-index: 9999;">Season 3 is live now... <a href="index.php?p=episodes"> Click here to watch.</a></section>

    <!-- home bg -->
    <div class="owl-carousel home__bg">
        <div class="item home__cover" data-bg="img/home/home__bg.jpg"></div>
        <div class="item home__cover" data-bg="img/home/home__bg2.jpg"></div>
        <div class="item home__cover" data-bg="img/home/home__bg3.jpg"></div>
        <div class="item home__cover" data-bg="img/home/home__bg4.jpg"></div>
        <div class="item home__cover" data-bg="img/home/home__bg5.jpg"></div>
    </div>
    <div class="container">

        <div class="row">

            <!-- content -->
            <!-- player -->
            <div class="col-12 col-xl-6">

                <!-- title -->
                <div class="col-12">
                    <h1 class="home__title"><b>SHUFFLES</b>TV</h1>
                </div>
                <!-- end title -->

                <div tabindex="0" style="padding-bottom: 49px;padding-top: 19px;background-color: #1a191f;" class="plyr plyr--full-ui plyr--video plyr--html5 plyr--paused plyr--stopped plyr--pip-supported plyr--fullscreen-enabled plyr--captions-enabled">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/VnxKnnZj64M" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            <!-- end player -->
            <div class="col-12 col-xl-6">
                <!-- title -->
                <div class="col-12">
                    <div class="section__title-wrap" style="margin-bottom: 0 !important;">
                        <h2 class="section__title">TRENDING PROFILES</h2>
                        <div class="section__nav-wrap">
                            <a href="index.php?p=trendinglist" class="section__view">View All &nbsp; <i class="icon ion-ios-arrow-forward"></i> </a>
                        </div>
                    </div>
                </div>

                <!-- end title -->
                <div class="content__head">
                    <div class="container">
                        <section class="row">
                            <div class="col-12">
                                <div class="row row--grid feature-profile">
                                    <?php
                                    $count = 0;
                                    //// get profile of those that are trendinghave public profile
                                    $sql = mysqli_query($db,
                                        "SELECT fp.*, u.photo, u.userid, u.username FROM tbl_trending_profile fp
                                                JOIN tbl_users u on fp.user_id = u.userid
                                                WHERE start_date <='" . date("Y-m-d H:i:s") . "' AND end_date >= '" . date("Y-m-d H:i:s") . "' order by rand() limit 6");
                                    $num = mysqli_num_rows($sql);
                                  /*  dump("SELECT fp.*, u.photo, u.userid, u.username FROM tbl_trending_profile fp
                                                JOIN tbl_users u on fp.user_id = u.userid
                                                WHERE start_date <='" . date("Y-m-d") . "' AND end_date >= '" . date("Y-m-d") . "' order by rand() limit 6");*/
                                    if($num !='0' && $num != null){
                                        while ($rows = mysqli_fetch_array($sql)) {
                                            $photo = $rows['photo'];
                                            $user_id = $rows['userid'];
                                            $username = $rows['username'];
                                            ?>
                                            <div class="col-6 col-sm-4 col-lg-4">
                                                <div class="card">
                                                    <div class="card__cover">
                                                        <img src="uploads/profile/<?=$photo?>" alt="<?=$username?>">
                                                        <a href="index.php?p=dgallery&amp;u=<?=$user_id?>" class="card__play" title="View Details">
                                                            <i class="icon ion-ios-list"></i>
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>


                                            <?php
                                        }
                                    }else {

                                            ?>

                                            <div class="row">
                                                <div class="col-12 col-xl-10">
                                                    <p class="section__title section__title--mb"><b>Trend your profile here</b></p>

                                                    <p class="section__text">Did you know that your profile can be featured and made to appear here. Do you want to get more matches? Get started now.</p>

                                                    <p class="section__text"><a href="index.php?p=trendprofile" class="sign__btn" type="button">Feature Profile</a></p>
                                                </div>
                                            </div>
                                    <?php
                                    }
                                    ?>
                                    <!-- card -->

                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- end content -->


        </div>


    </div>
    <!-- end home bg -->


</section>
<!-- end home -->

<!-- section -->
<section class="section section--border">
    <div class="container">
        <div class="row">
            <!-- section title -->
            <div class="col-12">
                <div class="section__title-wrap">
                    <h2 class="section__title"><b>MATCHED</b> MEMBERS</h2>

                    <div class="section__nav-wrap">
                        <a href="index.php?p=gallery" class="section__view">View All</a>

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
                <div class="owl-carousel section__carousel" id="carousel1">

                    <?php
                    //// get profile of those that are trendinghave public profile
                    $sql = mysqli_query($db,"SELECT userid, username, photo, description FROM tbl_users WHERE profile_type='" . PROFILE_ON_DATE . "' order by rand() limit 12");
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



