<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
$user_id = $_COOKIE['userid'];
$msg='';
$image = '';

if(isset($_POST['updatenow'])){
    $strfname=mysqli_real_escape_string($db,$_POST['fname']);
    $strlname=mysqli_real_escape_string($db,$_POST['lname']);
    $stremail=mysqli_real_escape_string($db,$_POST['email']);
    $phone=mysqli_real_escape_string($db,$_POST['phone']);
    $gender=mysqli_real_escape_string($db,$_POST['gender']);
    $profile=mysqli_real_escape_string($db,$_POST['profile']);
    $username=mysqli_real_escape_string($db,$_POST['username']);
    $phone = ltrim($phone, '0');
    $profile_type =  mysqli_real_escape_string($db,$_POST['profile_type']);
    $strphone=$phone;
    $description = mysqli_real_escape_string($db,$_POST['description']);

    $error=0;


    if($strfname=='' || $strlname==''||$stremail=='' || $gender=='' ){
        $msg= '<div class="alert alert-block alert-danger fade in"> You have left a required field blank</div>';
        $error++;
    }else{
        $sql2 = mysqli_query($db,"SELECT * FROM tbl_users where (email='$stremail' OR phone='$strphone') and userid!='$user_id'");
        $nums2 = mysqli_num_rows($sql2);
        if($nums2 != '0'){
            $msg="<div class='alert alert-block alert-danger fade in'> Failed: Phone - <b>".$strphone." or Email  - <b>".$stremail."</b>  already exists for another user.</div>";
            $error++;
        }else{

            if(isset($_FILES["photo"])){
                $image = $_FILES["photo"]["name"];
                if($error=='0'){
                    if($image != ''){
//////manage image upload here
                        $target_dir = "uploads/profile/";
                        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check file size
                        if ($_FILES["photo"]["size"] > 3000000) {
                            $msg= "<div class='alert-danger alert'>File must be smaller than 3MB.</div>";
                            $uploadOk = 0;
                            $error=1;
                        }

// Allow certain file formats
                        elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                            && $imageFileType != "gif" ) {
                            $msg= "<div class='alert-danger alert'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
                            $uploadOk = 0;
                            $error=1;
                        } else {
                            $imagename=$phone.".png";
                            $filename=$target_dir .$imagename;
                            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $filename)) {
                                resizeImage($filename,$filename,DEFAULT_IMAGE_WIDTH,DEFAULT_IMAGE_HEIGHT,80);
                                $msg= "<div class='alert-success alert'>The file ". $imagename. " has been uploaded.</div>";
                            } else {
                                $msg= "<div class='alert-danger alert'>Sorry, there was an error uploading your file.</div>";
                                $uploadOk = 0;
                                $error=1;
                            }
                        }

                    }
                }
            }

            if($error=='0'){

                if($image==''){


                    $sql3 = mysqli_query(
                        $db,"UPDATE tbl_users set fname='$strfname',lname='$strlname', username='$username', gender='$gender', description = '$description', profile_type = '". $profile_type ."' where userid='$user_id'");
                }else{
                    $sql3 = mysqli_query(
                        $db,"UPDATE tbl_users set fname='$strfname',lname='$strlname', username='$username',gender='$gender',photo='$imagename', description = '$description', profile_type = '". $profile_type ."' where userid='$user_id'");
                }
                if($sql3){

                    ?>
                    <script type="text/javascript">window.location.replace("signin.php");</script>
                    <?php
                    exit();
////// ask if activation code shoule be sent
                /*    $msg= "Update Successful";
                    $cookie_username = "fname";
                    $cookie_uservalue = $strfname;
                    setcookie($cookie_username, $cookie_uservalue, time() + (3600*24*365)); // 3600 = 1 hour
                    $cookie_username = "lname";
                    $cookie_uservalue = $strlname;
                    setcookie($cookie_username, $cookie_uservalue, time() + (3600*24*365)); // 3600 = 1 hour
                    $cookie_username = "phone";
                    $cookie_uservalue = $strphone;
                    setcookie($cookie_username, $cookie_uservalue, time() + (3600*24*365)); // 3600 = 1 hour
                    $username=$strfname." ".$strlname;
                    $cookie_username = "username";
                    $cookie_uservalue = $username;
                    setcookie($cookie_username, $cookie_uservalue, time() + (3600*24*365)); // 3600 = 1 hour
                    $cookie_name = "useremail";
                    $cookie_value = $stremail;
                    setcookie($cookie_name,$cookie_value, time() + (3600*24*365)); // 3600 = 1 hour
                    $cookie_id = "userid";
                    $cookie_idvalue = $user_id;
                    setcookie($cookie_id, $cookie_idvalue, time() + (3600*24*365)); // 3600 = 1 hour*/

                }

            }
        }
    }
}

if(isset($_POST['change_password'])) {
    $old_pass = mysqli_real_escape_string($db, $_POST['oldpass']);
    $new_pass = mysqli_real_escape_string($db, $_POST['newpass']);
    $confirm_new_pass = mysqli_real_escape_string($db, $_POST['confirmpass']);
    if ($new_pass !== $confirm_new_pass) {
        ?>
        <script type="text/javascript">alert('Failed: password does not match.');</script>
        <?php
    } else {

        $pass_md5 = md5($old_pass);

        $sqlCheckInfo = mysqli_query($db, "SELECT userid FROM tbl_users where password = '$pass_md5'  and userid ='$user_id'");
        $nums2 = mysqli_num_rows($sqlCheckInfo);
        if ($nums2 == '0') {
            ?>
            <script type="text/javascript">alert('Failed: Old password does not match your account password.');</script>
            <?php
        } else {
            $new_pass = md5($new_pass);
            $sqlUpdate = mysqli_query($db, "UPDATE tbl_users set password = '$new_pass' where userid='$user_id'");
            if (mysqli_affected_rows($db) == 1) {
                ?>
                <script type="text/javascript">window.location.replace("signin.php");</script>
                <?php
                exit();
            } else {
                ?>
                <script type="text/javascript">alert('Failed: Error occurred while updating your password.');</script>
                <?php
            }
        }
    }
}

$queryUserInfo = mysqli_query($db,"SELECT * FROM tbl_users where userid='$user_id'");
$rows = mysqli_fetch_array($queryUserInfo,MYSQLI_ASSOC);
$fname = $rows['fname'];
$lname = $rows['lname'];
$credit = $rows['credit'];
$email=$rows['email'];
$phone=$rows['phone'];
$photo=$rows['photo'];
$username=$rows['username'];
$gender=$rows['gender'];
$description=$rows['description'];
$profile_type = $rows['profile_type'];
?>


<!-- page title -->
<section class="section section--first section--bg section-mobile-view" data-bg="img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__wrap">
                    <!-- section title -->
                    <h2 class="section__title">Update Profile</h2>
                    <!-- end section title -->

                    <!-- breadcrumb -->
                    <ul class="breadcrumb">
                        <li class="breadcrumb__item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb__item breadcrumb__item--active">Update Profile</li>
                    </ul>
                    <!-- end breadcrumb -->

                </div>

            </div>
        </div>
        <?php if($msg != ''){ ?> <div><?php echo $msg; ?></div>    <?php } ?>


    </div>
</section>
<!-- end page title -->

<!-- content -->
<div class="content content--profile">
    <!-- profile -->
    <div class="profile">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="profile__content">
                        <div class="profile__user">
                            <div class="profile__avatar">
                                <img src="uploads/profile/<?=$photo; ?>" alt="<?=$username?>">
                            </div>
                            <div class="profile__meta">
                                <h3><?=$fname?> <?=$lname?></h3>
                                <span> Ref ID: <?=$user_id?></span>
                                <span> Units: <?=$credit?>&nbsp;&nbsp; <a href="index.php?p=makepayment">Fund Wallet</a></span>
                            </div>

                        </div>
                        <!-- content tabs nav -->
                        <ul class="nav nav-tabs content__tabs content__tabs--profile" id="content__tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Profile</a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Update Profile Information</a>
                            </li>
                        </ul>
                        <!-- end content tabs nav -->

                        <!-- content mobile tabs nav -->
                        <div class="content__mobile-tabs content__mobile-tabs--profile" id="content__mobile-tabs">
                            <div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <input type="button" value="Profile">
                                <span></span>
                            </div>

                            <div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Profile</a></li>


                                    <li class="nav-item"><a class="nav-link" id="3-tab" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Update Profile Information</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- end content mobile tabs nav -->

                        <a href="index.php?p=logout" class="profile__logout" type="button">
                            <i class="icon ion-ios-log-out"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end profile -->

    <div class="container">
        <!-- content tabs -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
                <div class="row row--grid">


                    <!-- dashbox -->
                    <div class="col-12 col-xl-6">
                        <div class="dashbox">
                            <?php if(file_exists("uploads/profile/$photo") && is_file("uploads/profile/$photo")) {
                                ?>
                                <img src="uploads/profile/<?=$photo ?>" class="img-responsive" alt="<?=$username?>">
                                <?php
                            }else {
                                ?>
                                <img src="img/user.png" class="img-responsive" alt="<?=$username?>">
                                <?php
                            } ?>
                        </div>
                    </div>
                    <!-- end dashbox -->
                    <!-- dashbox -->
                    <div class="col-12 col-xl-6">
                        <div class="dashbox">
                            <div class="dashbox__title">
                                <h3><i class="icon ion-ios-person"></i>Profile Information</h3>
                            </div>

                            <div class="dashbox__table-wrap">
                                <table class="main__table main__table--dash">

                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="main__table-text">First Name</div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?=$fname?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="main__table-text">Last Name</div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?=$lname?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="main__table-text">User Name</div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?=$username?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="main__table-text">Email</div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?=$email?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="main__table-text">Phone Number</div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?=$phone?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="main__table-text">Gender</div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?=$gender?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="main__table-text">Description</div>
                                        </td>
                                        <td>
                                            <div class="main__table-text"><?=$description?></div>
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

            <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="3-tab">
                <div class="row">
                    <!-- details form -->
                    <div class="col-12 col-lg-6 margin-top-20">
                        <form action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" class="form form--profile" method="post" enctype="multipart/form-data">
                            <div class="row row--form padding-20">
                                <div class="col-12">
                                    <div class="alert alert-info"><b>Note:</b> You will be logged out after a successful profile update.</div>
                                </div>
                                <div class="col-12">
                                    <h4 class="form__title">Profile details</h4>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <?php
                                if(empty($username))
                                {
                                    ?>
                                    <div class="form__group">
                                        <label class="form__label" for="username">Username </label>
                                        <input id="username" required type="text" name="username" class="form__input" placeholder="User Name">
                                    </div>
                                <?php
                                }else{
                                    ?>
                                    <div class="form__group">
                                        <label class="form__label" for="username">Username <small>(Cannot be changed)</small></label>
                                        <input id="username" readonly required type="text" name="username" value="<?=$username?>" class="form__input" placeholder="User Name">
                                    </div>
                                    <?php
                                }
                                    ?>

                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="form__group">
                                        <label class="form__label" for="email">Email <small>(Cannot be changed)</small></label>
                                        <input id="email" type="text" readonly required name="email" value="<?=$email?>" class="form__input" placeholder="Your Email">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="form__group">
                                        <label class="form__label" for="phone">Phone Number <small>(Cannot be changed)</small></label>
                                        <input id="phone" type="text" readonly required name="phone" value="<?=$phone?>" class="form__input" placeholder="Phone Number">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="form__group">
                                        <label class="form__label" for="firstname">First Name</label>
                                        <input id="firstname" type="text" required name="fname" class="form__input" value="<?=$fname?>" placeholder="First Name">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="form__group">
                                        <label class="form__label" for="lastname">Last Name</label>
                                        <input id="lastname" type="text" required name="lname" value="<?=$lname?>" class="form__input" placeholder="Doe">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="form__group">
                                        <label class="form__label" for="gender">Gender</label>
                                        <select name="gender" required id="gender" class="form__select">
                                            <option value="">&lt;-- Choose Gender --&gt;</option>
                                            <option value="male" <?php if($gender == 'male') echo 'selected'; ?>>Male</option>
                                            <option value="female" <?php if($gender == 'female') echo 'selected'; ?>>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="form__group">
                                        <label class="form__label" for="description">Description</label>
                                        <textarea id="description" type="text" required name="description" rows="5" class="form__input" placeholder="Description"><?=$description?></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="form__group">
                                        <label class="form__label" for="profile_type">Profile Type</label>
                                        <select name="profile_type" required id="profile_type" class="form__select">
                                            <option value="">&lt;-- Choose Profile Type --&gt;</option>
                                            <option value="<?=PROFILE_FREE?>" <?php if($profile_type == PROFILE_FREE) echo 'selected'; ?>>Blind Date</option>
                                            <option value="<?=PROFILE_TASPP?>" <?php if($profile_type == PROFILE_TASPP) echo 'selected'; ?>>Taspp</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="form__group">
                                        <label class="form__label" for="photo">Photo <small>(Size: width: 350px, height: 450px)</small></label>
                                        <?php
                                        if(empty($photo)) {
                                            ?>
                                            <input id="photo" required type="file" name="photo" class="form__input" />
                                            <?php
                                        }else {
                                            ?>
                                            <input id="photo" type="file" name="photo" class="form__input" />
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="form__btn" name="updatenow" value="1" type="submit" >Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end details form -->

                    <!-- password form -->
                    <div class="col-12 col-lg-6 margin-top-20">
                        <form action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" method="post" class="form form--profile">
                            <div class="row row--form padding-20 margin-top-20">
                                <div class="col-12">
                                    <div class="alert alert-info"><b>Note:</b> You will be logged out after a successful password change.</div>
                                </div>
                                <div class="col-12">
                                    <h4 class="form__title">Change password</h4>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="form__group">
                                        <label class="form__label" for="oldpass">Old password</label>
                                        <input id="oldpass" required type="password" name="oldpass" class="form__input">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="form__group">
                                        <label class="form__label" for="newpass">New password</label>
                                        <input id="newpass" required type="password" name="newpass" onkeyup='check();' class="form__input">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="form__group">
                                        <label class="form__label" for="confirmpass">Confirm new password</label>
                                        <input id="confirmpass" required type="password" onkeyup='check();' name="confirmpass" class="form__input">
                                        <div><span id="confirm_pass_val"></span></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="form__btn" type="submit" name="change_password" value="1">Change</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end password form -->
                </div>
            </div>
        </div>
        <!-- end content tabs -->
    </div>
</div>
<!-- end content -->
<script>
    var check = function() {
        if (document.getElementById('newpass').value ===
            document.getElementById('confirmpass').value) {
            document.getElementById('confirm_pass_val').style.color = 'green';
            document.getElementById('confirm_pass_val').innerHTML = '';
        } else {
            document.getElementById('confirm_pass_val').style.color = 'red';
            document.getElementById('confirm_pass_val').innerHTML = 'Not matching';
        }
    }
</script>