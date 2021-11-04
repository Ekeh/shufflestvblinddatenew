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
        alert("Required parameters missing");
        setTimeout(function(){
            window.location.href = 'index.php?p=taspp';
        }, 1000);
    </script>
    <?php
    exit;
}
$user_id = $_COOKIE['userid'];
$category_id = mysqli_escape_string($db,  $_GET['token']);
$category_sql = mysqli_query($db,"SELECT * FROM `tbl_category` WHERE id = '$category_id' AND is_available='1'");
$nu =mysqli_num_rows($category_sql);
if($nu == 0){
    ?>
    <script type="text/javascript">
        alert("Category not found.");
        setTimeout(function(){
            window.location.href = 'index.php?p=taspp';
        }, 1000);
    </script>
    <?php
    exit;
}
$category = mysqli_fetch_assoc($category_sql);
?>
<section class="section section--first section--bg section-mobile-view" data-bg="img/section/section.jpg" style="background: url(&quot;img/section/section.jpg&quot;) center center / cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__wrap">
                    <!-- section title -->
                    <h2 class="section__title">TASPP JOIN</h2>
                    <!-- end section title -->

                    <!-- breadcrumb -->
                    <ul class="breadcrumb">
                        <li class="breadcrumb__item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb__item breadcrumb__item--active">TASPP JOIN</li>
                    </ul>
                    <!-- end breadcrumb -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row">
                <div class="col-12">
                    <div class="dashbox">

                        <div class="dashbox__title">
                            <h3><i class="icon ion-ios-list"></i> <?=$category['name']?></h3>

                        </div>

                        <div class="dashbox__table-wrap mCustomScrollbar _mCS_2" style="overflow: visible;">
                            <div id="mCSB_2" class="mCustomScrollBox mCS-custom-bar2 mCSB_horizontal mCSB_outside" tabindex="0" style="max-height: none;">
                                <div id="mCSB_2_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px; width: 501px; min-width: 100%; overflow-x: auto;" dir="ltr">
                                    <form action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" class="form form--profile" method="post" enctype="multipart/form-data">
                                        <div class="row row--form padding-20">
                                            <div class="col-12">
                                                <div class="alert alert-info">Enter your bank details to join <b><?=$category['name']?></b>.
                                                <p>A profile will be generated for you which you can share to be voted for. You will make <?=TASPP_VOTE_PERCENTAGE?>% of all your votes at the end of the voting cycle. </p></div>
                                            </div>
                                            <div class="col-12">
                                                <h4 class="form__title">Account Details</h4>
                                            </div>
                                            <div class="col-12">
                                                <div class="form__group">
                                                    <?php
                                                    $banks_sql = mysqli_query($db,"SELECT * FROM `tbl_banks` WHERE is_available='1'");
                                                    ?>
                                                    <label class="form__label" for="gender">Bank</label>
                                                    <select name="gender" required id="gender" class="form__select">
                                                        <option value="">&lt;-- Choose Bank --&gt;</option>
                                                    <?php
                                                    while($bank = mysqli_fetch_assoc($banks_sql)){
                                                    ?>
                                                        <option value="<?=$bank['code']?>"><?=$bank['name']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form__group">
                                                    <label class="form__label" for="email">Account Number</label>
                                                    <input id="email" type="number" required name="email" class="form__input" placeholder="Enter Account Number">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button class="form__btn" name="updatenow" value="1" type="submit" >JOIN</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="mCSB_2_scrollbar_horizontal" class="mCSB_scrollTools mCSB_2_scrollbar mCS-custom-bar2 mCSB_scrollTools_horizontal" style="display: block;"
                            ><div class="mCSB_draggerContainer"><div id="mCSB_2_dragger_horizontal" class="mCSB_dragger" style="position: absolute; min-width: 30px; display: block; width: 499px; max-width: 490px; left: 0px;">
                                        <div class="mCSB_dragger_bar"></div><div class="mCSB_draggerRail"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        

    </div>
</section>