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

if(isset($_POST['submitjoin']))
{
   $bank_id = mysqli_escape_string($db, $_POST['bank_id']);
   $account_name = mysqli_escape_string($db, $_POST['account_name']);
   $account_number = mysqli_escape_string($db, $_POST['account_number']);
   if(empty($bank_id) || empty($account_name) || empty($account_number)) {
       ?>
       <script type="text/javascript">
           alert("Bank and account number are required.");
       </script>
       <?php
   }else{
$sql_check =  mysqli_query($db, "SELECT id FROM `tbl_taspp_subscription` WHERE user_id = '$user_id'");
if(mysqli_num_rows($sql_check) != '0')
{
    ?>
    <script type="text/javascript">
        alert("You are already subscribed to a category.");
    </script>
    <?php
}else {
   /* dump("INSERT INTO `tbl_taspp_subscription`(`user_id`, `category_id`, `created_at`)
                      VALUES ('$user_id','$category_id', '" . date("Y-m-d H:i:s") . "')");*/
    $sql_subscribe = mysqli_query($db, "INSERT INTO `tbl_taspp_subscription`(`user_id`, `category_id`, `created_at`)
                      VALUES ('$user_id','$category_id', '" . date("Y-m-d H:i:s") . "')");
    if (mysqli_affected_rows($db) > 0) {
        $sql_bank_details = mysqli_query($db,
            "INSERT INTO `tbl_bank_details`(`user_id`, `bank_id`, `account_name`, `account_number`, `created_at`) 
                          VALUES ('$user_id','$bank_id','$account_name','$account_number', '" . date("Y-m-d H:i:s") . "')");
        mysqli_query($db,
            "UPDATE `tbl_users` SET profile_type = '" . PROFILE_TASPP . "' WHERE userid = '$user_id'");
        ?>
        <script type="text/javascript">
            alert("Your registration has been completed successfully.");
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Error occurred while registering your information.");
        </script>
        <?php
    }
}
   }

}

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
                                                <h4 class="form__title">Account Details</h4>
                                            </div>
                                            <div class="col-12">
                                                <div class="form__group">
                                                    <?php
                                                    $banks_sql = mysqli_query($db,"SELECT * FROM `tbl_banks` WHERE is_available='1'");

                                                    ?>
                                                    <label class="form__label" for="gender">Bank</label>
                                                    <select name="bank_id" required id="bank-id" class="form__select">
                                                        <option value="">&lt;-- Choose Bank --&gt;</option>
                                                    <?php
                                                    while($bank = mysqli_fetch_assoc($banks_sql)){
                                                    ?>
                                                        <option <?=isset($_POST['bank_id']) && $_POST['bank_id'] === $bank['id'] ? 'selected' : '' ?> data-bankcode="<?=$bank['code']?>" value="<?=$bank['id']?>"><?=$bank['name']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form__group">
                                                    <label class="form__label" for="email">Account Number</label>
                                                    <input id="account-number" type="number" required value="0236070315" name="account_number" class="form__input no-margin-bottom" placeholder="Enter Account Number">
                                                    <input id="account-name-hidden" type="hidden" name="account_name" value="Chuks" />
                                                    <div class="margin-left-10"><span id="account-name" class="section__text"><?=isset($_POST['account_name']) ? $_POST['account_name'] : ''?></span></div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button class="form__btn margin-top-20" id="submitjoin" name="submitjoin" value="1" type="submit" >JOIN</button>
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
<script src="js/jquery-3.5.1.min.js" type="text/javascript"></script>
<script>
    $(function () {
        $(document).on('blur', '#account-number', function () {
            if ($('#account-number').val() === '' || $('#bank-id').val() === '') {
                return;
            }
            $('#account-name').text('');
            var postForm = { //Fetch form data
                'resolve_account_number': true,
                'account_number': $('#account-number').val(),
                'bank_code': $('#bank-id option:selected').data('bankcode')
            };
            $.ajax({ //Process the form using $.ajax()
                type: 'POST', //Method type
                url: 'apirequests.php', //Your form processing file URL
                data: JSON.stringify(postForm), //Forms name
                dataType: 'json',
                success: function (data) {
                    if (data.status) {
                        $('#account-name').text(data.data.account_name);
                        $('#account-name-hidden').val(data.data.account_name);
                        $('#submitjoin').removeAttr('data-disabled');
                    } else {
                        $('#submitjoin').attr('data-disabled', 'true');
                        alert('Account name not resolved. Ensure your bank and account number are correct.');
                    }
                }
            });
        });
        $(document).on('click', '#submitjoin', function (e) {
            if($('#bank-id').val() === '')
            {
                e.preventDefault();
                alert('Select bank.');
            }else if($('#account-number').val() === '')
            {
                e.preventDefault();
                alert('Enter account number.');
            }else{
                if( $('#account-name').html() === ''){
                    e.preventDefault();
                    alert('Account name not resolved. Ensure your bank and account number are correct.');
                }
            }

        });
    });
</script>