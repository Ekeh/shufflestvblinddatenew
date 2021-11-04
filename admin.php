<?php
$page='';
$msg='';
if(isset($_GET['p'])){
    $page=$_GET['p'];
}
if($page =='logout'){
    setcookie('useremail',$_COOKIE['useremail'], time() - (3600*24*365)); // 3600 = 1 hour
    setcookie('userid',$_COOKIE['userid'], time() - (3600*24*365)); // 3600 = 1 hour
    setcookie('fname',$_COOKIE['fname'], time() - (3600*24*365)); // 3600 = 1 hour
    setcookie('lname',$_COOKIE['lname'], time() - (3600*24*365)); // 3600 = 1 hour
    setcookie('username',$_COOKIE['username'], time() - (3600*24*365)); // 3600 = 1 hour
    setcookie('role',$_COOKIE['role'], time() - (3600*24*365)); // 3600 = 1 hour

    ?>
    <script type="text/javascript">window.location.replace("index.php");</script>
    <?php
    exit;
}


if(isset($_POST['searchuserweb'])) {
    search_user($db, $_POST['searchuserfieldweb']);
}

if(isset($_POST['searchusermobile'])) {
    search_user($db, $_POST['searchuserfieldmobile']);
}

function search_user($db, $ref_id) {
    $ref_id = mysqli_real_escape_string($db, $ref_id);
    $sql_search = mysqli_query($db,"SELECT userid FROM tbl_users where userid ='$ref_id'");
    $count = mysqli_num_rows($sql_search);
    if($count != '0'){
        ?>
        <script type="text/javascript">window.location.replace("index.php?p=dgallery&u=<?=$ref_id?>");</script>
        <?php
    }else {
        ?>
        <script type="text/javascript">alert('Ref ID not found.');</script>
        <?php
    }
}

function get_trend_profile_status_name($status) {
   switch ($status){
       case TREND_PROFILE_STATUS_PENDING:
           return 'Pending';
       case TREND_PROFILE_STATUS_ACTIVE:
           return 'Active';
       case TREND_PROFILE_STATUS_EXPIRED:
           return 'Expired';
       case TREND_PROFILE_STATUS_CANCELLED:
           return 'Cancelled';
       default:
           return '';
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/admin.css">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="icon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="icon/favicon-32x32.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>HotFlix – Online Movies, TV Shows & Cinema HTML Template</title>

</head>
<body>
<!-- header -->
<header class="header">
    <div class="header__content">
        <!-- header logo -->
        <a href="index.html" class="header__logo">
            <img src="img/logo.svg" alt="">
        </a>
        <!-- end header logo -->

        <!-- header menu btn -->
        <button class="header__btn" type="button">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <!-- end header menu btn -->
    </div>
</header>
<!-- end header -->

<!-- sidebar -->
<div class="sidebar">
    <!-- sidebar logo -->
    <a href="index.html" class="sidebar__logo">
        <img src="img/logo.svg" alt="">
    </a>
    <!-- end sidebar logo -->

    <!-- sidebar user -->
    <div class="sidebar__user">
        <div class="sidebar__user-img">
            <img src="img/user.svg" alt="">
        </div>

        <div class="sidebar__user-title">
            <span>Admin</span>
            <p>John Doe</p>
        </div>

        <button class="sidebar__user-btn" type="button">
            <i class="icon ion-ios-log-out"></i>
        </button>
    </div>
    <!-- end sidebar user -->

    <!-- sidebar nav -->
    <div class="sidebar__nav-wrap">
        <ul class="sidebar__nav">
            <li class="sidebar__nav-item">
                <a href="index.html" class="sidebar__nav-link sidebar__nav-link--active"><i class="icon ion-ios-keypad"></i> <span>Dashboard</span></a>
            </li>

            <li class="sidebar__nav-item">
                <a href="catalog.html" class="sidebar__nav-link"><i class="icon ion-ios-film"></i> <span>Catalog</span></a>
            </li>

            <!-- collapse -->
            <li class="sidebar__nav-item">
                <a class="sidebar__nav-link" data-toggle="collapse" href="#collapseMenu" role="button" aria-expanded="false" aria-controls="collapseMenu"><i class="icon ion-ios-copy"></i> <span>Pages</span> <i class="icon ion-md-arrow-dropdown"></i></a>

                <ul class="collapse sidebar__menu" id="collapseMenu">
                    <li><a href="add-item.html">Add item</a></li>
                    <li><a href="edit-user.html">Edit user</a></li>
                    <li><a href="signin.html">Sign in</a></li>
                    <li><a href="signup.html">Sign up</a></li>
                    <li><a href="forgot.html">Forgot password</a></li>
                    <li><a href="404.html">404 page</a></li>
                </ul>
            </li>
            <!-- end collapse -->

            <li class="sidebar__nav-item">
                <a href="users.html" class="sidebar__nav-link"><i class="icon ion-ios-contacts"></i> <span>Users</span></a>
            </li>

            <li class="sidebar__nav-item">
                <a href="comments.html" class="sidebar__nav-link"><i class="icon ion-ios-chatbubbles"></i> <span>Comments</span></a>
            </li>

            <li class="sidebar__nav-item">
                <a href="reviews.html" class="sidebar__nav-link"><i class="icon ion-ios-star-half"></i> <span>Reviews</span></a>
            </li>

            <li class="sidebar__nav-item">
                <a href="https://dmitryvolkov.me/demo/hotflix2.1/main/index.html" class="sidebar__nav-link"><i class="icon ion-ios-arrow-round-back"></i> <span>Back to HotFlix</span></a>
            </li>
        </ul>
    </div>
    <!-- end sidebar nav -->

    <!-- sidebar copyright -->
    <div class="sidebar__copyright">© HOTFLIX, 2019—2021. <br>Create by <a href="https://themeforest.net/user/dmitryvolkov/portfolio" target="_blank">Dmitry Volkov</a></div>
    <!-- end sidebar copyright -->
</div>
<!-- end sidebar -->

<!-- main content -->
<main class="main">
    <div class="container-fluid">
        <div class="row row--grid">
            <!-- main title -->
            <div class="col-12">
                <div class="main__title">
                    <h2>Dashboard</h2>

                    <a href="add-item.html" class="main__title-link">add item</a>
                </div>
            </div>
            <!-- end main title -->

            <!-- stats -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats">
                    <span>Unique views this month</span>
                    <p>5 678</p>
                    <i class="icon ion-ios-stats"></i>
                </div>
            </div>
            <!-- end stats -->

            <!-- stats -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats">
                    <span>Items added this month</span>
                    <p>172</p>
                    <i class="icon ion-ios-film"></i>
                </div>
            </div>
            <!-- end stats -->

            <!-- stats -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats">
                    <span>New comments</span>
                    <p>2 573</p>
                    <i class="icon ion-ios-chatbubbles"></i>
                </div>
            </div>
            <!-- end stats -->

            <!-- stats -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats">
                    <span>New reviews</span>
                    <p>1 021</p>
                    <i class="icon ion-ios-star-half"></i>
                </div>
            </div>
            <!-- end stats -->

            <!-- dashbox -->
            <div class="col-12 col-xl-6">
                <div class="dashbox">
                    <div class="dashbox__title">
                        <h3><i class="icon ion-ios-trophy"></i> Top items</h3>

                        <div class="dashbox__wrap">
                            <a class="dashbox__refresh" href="#"><i class="icon ion-ios-refresh"></i></a>
                            <a class="dashbox__more" href="catalog.html">View All</a>
                        </div>
                    </div>

                    <div class="dashbox__table-wrap">
                        <table class="main__table main__table--dash">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>TITLE</th>
                                <th>CATEGORY</th>
                                <th>RATING</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="main__table-text">321</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">I Dream in Another Language</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">Movie</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i> 9.2</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">54</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Benched</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">Movie</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i> 9.1</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">670</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Whitney</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">TV Show</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i> 9.0</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">241</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Blindspotting 2</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">TV Show</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i> 8.9</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">22</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Blindspotting</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">TV Show</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i> 8.9</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end dashbox -->

            <!-- dashbox -->
            <div class="col-12 col-xl-6">
                <div class="dashbox">
                    <div class="dashbox__title">
                        <h3><i class="icon ion-ios-film"></i> Latest items</h3>

                        <div class="dashbox__wrap">
                            <a class="dashbox__refresh" href="#"><i class="icon ion-ios-refresh"></i></a>
                            <a class="dashbox__more" href="catalog.html">View All</a>
                        </div>
                    </div>

                    <div class="dashbox__table-wrap">
                        <table class="main__table main__table--dash">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>TITLE</th>
                                <th>CATEGORY</th>
                                <th>STATUS</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="main__table-text">26</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">I Dream in Another Language</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">Movie</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--green">Visible</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">25</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Benched</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">Movie</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--green">Visible</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">24</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Whitney</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">TV Show</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--green">Visible</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">23</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Blindspotting 2</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">TV Show</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--green">Visible</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">22</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Blindspotting</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">TV Show</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--green">Visible</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end dashbox -->

            <!-- dashbox -->
            <div class="col-12 col-xl-6">
                <div class="dashbox">
                    <div class="dashbox__title">
                        <h3><i class="icon ion-ios-contacts"></i> Latest users</h3>

                        <div class="dashbox__wrap">
                            <a class="dashbox__refresh" href="#"><i class="icon ion-ios-refresh"></i></a>
                            <a class="dashbox__more" href="users.html">View All</a>
                        </div>
                    </div>

                    <div class="dashbox__table-wrap">
                        <table class="main__table main__table--dash">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>FULL NAME</th>
                                <th>EMAIL</th>
                                <th>USERNAME</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="main__table-text">23</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Brian Cranston</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--grey">bcxwz@email.com</div>
                                </td>
                                <td>
                                    <div class="main__table-text">BrianXWZ</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">22</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Jesse Plemons</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--grey">jess@email.com</div>
                                </td>
                                <td>
                                    <div class="main__table-text">Jesse.P</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">21</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Matt Jones</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--grey">matt@email.com</div>
                                </td>
                                <td>
                                    <div class="main__table-text">Matty</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">20</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Tess Harper</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--grey">harper@email.com</div>
                                </td>
                                <td>
                                    <div class="main__table-text">Harper123</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">19</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Jonathan Banks</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--grey">bank@email.com</div>
                                </td>
                                <td>
                                    <div class="main__table-text">Jonathan</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end dashbox -->

            <!-- dashbox -->
            <div class="col-12 col-xl-6">
                <div class="dashbox">
                    <div class="dashbox__title">
                        <h3><i class="icon ion-ios-star-half"></i> Latest reviews</h3>

                        <div class="dashbox__wrap">
                            <a class="dashbox__refresh" href="#"><i class="icon ion-ios-refresh"></i></a>
                            <a class="dashbox__more" href="reviews.html">View All</a>
                        </div>
                    </div>

                    <div class="dashbox__table-wrap">
                        <table class="main__table main__table--dash">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>ITEM</th>
                                <th>AUTHOR</th>
                                <th>RATING</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="main__table-text">51</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">I Dream in Another Language</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">Jonathan Banks</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i> 7.2</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">50</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Benched</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">Charles Baker</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i> 6.3</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">49</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Whitney</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">Matt Jones</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i> 8.4</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">48</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">Blindspotting</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">Jesse Plemons</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i> 9.0</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="main__table-text">47</div>
                                </td>
                                <td>
                                    <div class="main__table-text"><a href="#">I Dream in Another Language</a></div>
                                </td>
                                <td>
                                    <div class="main__table-text">Brian Cranston</div>
                                </td>
                                <td>
                                    <div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i> 7.7</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end dashbox -->
        </div>
    </div>
</main>
<!-- end main content -->

<!-- JS -->
<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/jquery.mousewheel.min.js"></script>
<script src="js/jquery.mCustomScrollbar.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/admin.js"></script>
</body>
</html>
