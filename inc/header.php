<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>ShufflesTV</title>
  <!-- base:css -->
  <link rel="stylesheet" href="<?php echo SITE_URL; ?>/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo SITE_URL; ?>/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/vertical-layout-dark/style.css">
  <!-- endinject -->
   <meta name="description" content="TV that pays">
  <meta name="keywords" content="shufflesTV,Campoutnaija,campout9ja,9jagifted,reality TV , outdoor">

  <link rel="shortcut icon" href="<?php echo SITE_URL; ?>/images/favicon.png" />
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
if(!isset($_REQUEST['JS'])){
?>
    <noscript>
      <meta http-equiv="refresh" content="0; url='<?php echo basename($_SERVER['PHP_SELF']);?>?JS='"/>
    </noscript><?php
  }

?>

</head>
<body  oncontextmenu="return false;" >
 
<?php
  if(isset($_REQUEST['JS'])){ ?> 
  <h4> Kindly Enable Javascript in your browser to continue </h4><a href='<?php echo $_SERVER['REQUEST_URI']; ?>'>Try again</a> <?php
    exit;
     }
?>
