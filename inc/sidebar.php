<div class="container-scroller d-flex">
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <div class="navbar-brand-wrapper" align="center">
            <a class="navbar-brand brand-logo" href="index.php"><img src="<?php echo SITE_URL; ?>/images/logo.png" alt="logo" width="70px" height="auto" /><br><span class="" style="color: #ffffff;font-weight: bold;font-size: 12px;">... TV that pays !</span></a>
    <?php
    $credit='';
    $fname='';
    $userid='';
    if(isset($_COOKIE['userid'])){ 

             $userid=$_COOKIE['userid'];
                 	  
       $getcredit=mysqli_query($db,"SELECT * FROM tbl_users where userid='$userid'");
      $rod=mysqli_fetch_array($getcredit);
      $fname=$rod['fname'];
      $credit=$rod['credit'];
     

       }    

        ?>
          </div>
      <ul class="nav">
        <li class="nav-item sidebar-category">  Hi, <?php if($userid==''){ echo 'Guest'; }else{
          ?>
        <br> <?php echo $credit." units";  ?> 
      <br> Ref ID - <?php echo $_COOKIE['userid']; } ?>

    </li>
    <?php if(!isset($_COOKIE['userid']))
     {
?><li class="nav-item">
          <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php?p=login">
            <i class="mdi mdi-account menu-icon"></i>
            <span class="menu-title">Login / Register </span>
          </a>
        </li><?php
        }
       ?>

        <li class="nav-item sidebar-category">
          <p>Navigation</p>
          <span></span>
        </li>
           <li class="nav-item">
         <a class="nav-link" href="<?php echo SITE_URL; ?>">
            <i class="mdi mdi-home menu-icon"></i>
            <span class="menu-title">Home</span>  
          </a>
        </li>
       
      

            <!--<li class="nav-item">
          <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php?p=channels">
            <i class="mdi mdi-settings menu-icon"></i>
            <span class="menu-title">Channels</span>  
          </a>
        </li>
         
          <li class="nav-item">
          <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php">
            <i class="mdi mdi-video menu-icon"></i>
            <span class="menu-title">Trending Videos</span>  
          </a>
        </li>
            <li class="nav-item">
          <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php?p=startvoting">
            <i class="mdi mdi-vote menu-icon"></i>
            <span class="menu-title">Vote</span>  
          </a>
        </li>-->
      <?php
    if(isset($_COOKIE['userid'])){ ?>
        <li class="nav-item">
     <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php?p=makepayment">
            <i class="mdi mdi-cash menu-icon"></i>
            <span class="menu-title">Fund Wallet </span>
    </a>
        </li>
        <!--<li class="nav-item">
          <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=finals'>
            <i class="mdi mdi-account-multiple-plus menu-icon"></i>
            <span class="menu-title">
            Live Show Vote</span>
          </a>
        </li>
           <li class="nav-item">
          <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=liveresults'>
            <i class="mdi mdi-bookmark menu-icon"></i>
            <span class="menu-title">Live Show Results</span>
          </a>
        </li>-->
        <?php }
        if(base64_decode($_COOKIE['role']) !== ROLE_ADMIN) {
            ?>

            <li class="nav-item">
                <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=blinddate'>
                    <i class="mdi mdi-chart-pie menu-icon"></i>
                    <span class="menu-title">Blind Date</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=episodes'>
                    <i class="mdi mdi-chart-pie menu-icon"></i>
                    <span class="menu-title">View Episodes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=blinddaterequests'>
                    <i class="mdi mdi-chart-pie menu-icon"></i>
                    <span class="menu-title">View Date Requests</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=blinddateunmatch'>
                    <i class="mdi mdi-chart-pie menu-icon"></i>
                    <span class="menu-title">Unmatch</span>
                </a>
            </li>
            <?php
        }else {
       ?>
          <li class="nav-item">
              <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=blinddateunmatchadmin'>
                  <i class="mdi mdi-chart-pie menu-icon"></i>
                  <span class="menu-title">Match and Unmatch Users</span>
              </a>
          </li>
          <?php
        }
?>
          <!--

            <li class="nav-item">
              <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=results'>
                <i class="mdi mdi-chart-pie menu-icon"></i>
                <span class="menu-title">View Live Results</span>
              </a>
            </li>-->
      <!--   <li class="nav-item">
         <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php?p=allshows">
            <i class="mdi mdi-play menu-icon"></i>
            <span class="menu-title">Reality TV Shows</span>  
          </a>
        </li>  -->
          <!--  <li class="nav-item">
         <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php?p=lol">
            <i class="mdi mdi-play menu-icon"></i>
            <span class="menu-title">Love OR Lust</span>  
          </a>
        </li>  -->
         <!--   <li class="nav-item">
         <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php?p=highlights">
            <i class="mdi mdi-replay menu-icon"></i>
            <span class="menu-title">Highlights of Show</span>  
          </a>
        </li>  -->
        <!---
             <li class="nav-item">
         <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php?p=r18highlights">
            <i class="mdi mdi-replay menu-icon"></i>
            <span class="menu-title">R18 Highlights</span>  
          </a>
        </li>
          <li class="nav-item">
          <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=schedule'>
            <i class="mdi mdi-format-list-checks menu-icon"></i>
            <span class="menu-title"> Schedule of Shows</span>
          </a>
        </li> -->
        <!--   <li class="nav-item">
         <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php?p=livestream">
            <i class="mdi mdi-play menu-icon"></i>
            <span class="menu-title">Live Stream</span>  
          </a>
        </li> -->
        <!--
        <li class="nav-item">
          <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=topreferrals'>
            <i class="mdi mdi-account-multiple-plus menu-icon"></i>
            <span class="menu-title">Top Referrals</span>
          </a>
        </li>-->
        <!--    <li class="nav-item">
          <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=commissions'>
            <i class="mdi mdi-account-multiple-plus menu-icon"></i>
            <span class="menu-title">Commissions</span>
          </a>
        </li>
       <li class="nav-item">
          <a class="nav-link" href='<?php echo SITE_URL; ?>/index.php?p=guidelines'>
            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            <span class="menu-title">Roomies Guidelines</span>
          </a>
        </li> -->
    
      
        <?php
        if(isset($_COOKIE['userid'])){ ?>
        <!--  <li  class="nav-item">
           <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php?p=addmyvideos"  > <i class="mdi mdi-upload menu-icon"></i> <span class="menu-title"> Add Video</span></a></li>

         <li  class="nav-item"> <a href="<?php echo SITE_URL; ?>/index.php?p=myvideos" class="nav-link" > <i class="mdi mdi-folder-upload menu-icon"></i>
          <span class="menu-title"> Manage Videos</span></a></li>-->
                   

         <li  class="nav-item"> <a href="<?php echo SITE_URL; ?>/pages/updateprofile.php" class="nav-link" > <i class="mdi mdi-account menu-icon"></i>
          <span class="menu-title"> Update Profile</span></a></li>             
                
 
     
         
        <li class="nav-item">
          <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php?p=logout">
            <i class="mdi mdi-logout menu-icon"></i>
            <span class="menu-title">LogOut</span>
          </a>
        </li> <?php
        }?>

           <li  class="nav-item">
          <a class="nav-link" href="https://wa.me/2348035729461?text=Hi%2C%20I%20would%20love%20to%20make%20an%20enquiry%20about%20shufflestv." target='_blank'>
            <img src='<?php echo SITE_URL; ?>/images/whatsapp.png' width='120px' height='auto'>
             </a>
        </li>
      </ul>
    </nav>