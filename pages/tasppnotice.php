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
$user_id = mysqli_escape_string($db, $_COOKIE['userid']);
$sql_check = mysqli_query($db,"SELECT * FROM `tbl_taspp_subscription` WHERE user_id = '$user_id'");
if(mysqli_num_rows($sql_check) > 0)
{
    ?>
    <script type="text/javascript">
        setTimeout(function(){
            window.location.href = 'index.php?p=taspp';
        }, 100);
    </script>
    <?php
    exit;
}
?>
<section class="section section--first section--bg section-mobile-view" data-bg="img/section/section.jpg" style="background: url(&quot;img/section/section.jpg&quot;) center center / cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__wrap">
                    <!-- section title -->
                    <h2 class="section__title">TASPP INTRODUCTION</h2>
                    <!-- end section title -->

                    <!-- breadcrumb -->
                    <ul class="breadcrumb">
                        <li class="breadcrumb__item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb__item breadcrumb__item--active">TASPP INTRODUCTION</li>
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
            <!-- section list -->
            <div class="col-12">
                <div class="section__text">
                    <p>
                        On TASPP, you may need, if there are more than 20 entries in your category of interest, to VOTE to get into the Top 20 for your entry to be reviewed.
                    </p>
                    <p>
                        Note: You could still be in the Top 20 with zero votes if enough don’t audition or vote in your category.
                    </p>
                    <div>
                        <p>Do you wish to continue?</p>

                        <p class="main__table-text">
                            <a href="index.php?p=taspp" class="btn btn-success margin-right-20">
                                <span>Continue</span>
                            </a>
                            <a href="index.php" class="btn btn-danger">
                                <span>Cancel</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <!-- end section list -->
        </div>
    </div>
</section>