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
$user_id = $_COOKIE['userid'];
?>

<section class="section section--first section--bg section-mobile-view" data-bg="img/section/section.jpg" style="background: url(&quot;img/section/section.jpg&quot;) center center / cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__wrap">
                    <!-- section title -->
                    <h2 class="section__title">TASPP</h2>
                    <!-- end section title -->

                    <!-- breadcrumb -->
                    <ul class="breadcrumb">
                        <li class="breadcrumb__item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb__item breadcrumb__item--active">TASPP</li>
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
                            <h3><i class="icon ion-ios-list"></i> Categories</h3>

                        </div>

                        <div class="dashbox__table-wrap mCustomScrollbar _mCS_2" style="overflow: visible;">
                            <div id="mCSB_2" class="mCustomScrollBox mCS-custom-bar2 mCSB_horizontal mCSB_outside" tabindex="0" style="max-height: none;">
                                <div id="mCSB_2_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px; width: 501px; min-width: 100%; overflow-x: auto;" dir="ltr">
                                    <table class="main__table main__table--dash">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $category = mysqli_query($db,"SELECT * FROM `tbl_category` WHERE is_available='1'");
                                        $nu =mysqli_num_rows($category);
                                        if($nu != 0){
                                            $s = 1;
                                        while ($rows = mysqli_fetch_assoc($category)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="main__table-text"><?=$s?></div>
                                                </td>
                                                <td>
                                                    <div class="main__table-text"><?=$rows['name']?></div>
                                                </td>
                                                <td>
                                                    <div class="main__table-text">
                                                        <a href="index.php?p=tasppjoin&token=<?=$rows['id']?>" class="btn btn-success margin-right-20">
                                                            <span>Join</span>
                                                        </a>
                                                        <a href="index.php?p=tasppresults&token=<?=$rows['id']?>" class="btn btn-default margin-right-20">
                                                            <span>View Results</span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $s++;
                                        }
                                        }

                                        ?>

<tr>
    <td>
        <br><br>
    </td>
</tr>

                                        </tbody>
                                    </table>
                                </div></div><div id="mCSB_2_scrollbar_horizontal" class="mCSB_scrollTools mCSB_2_scrollbar mCS-custom-bar2 mCSB_scrollTools_horizontal" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_2_dragger_horizontal" class="mCSB_dragger" style="position: absolute; min-width: 30px; display: block; width: 499px; max-width: 490px; left: 0px;"><div class="mCSB_dragger_bar"></div><div class="mCSB_draggerRail"></div></div></div></div></div>
                    </div>
            </div>
        </div>

        

    </div>
</section>