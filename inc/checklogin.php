<?php
///// uncomment this to allow ip address checks
/*
$userip=$_SERVER['REMOTE_ADDR'];
$sql=mysqli_query($db,"SELECT * FROM tbl_checklogin  where  userip='$userip'"); 
$num=mysqli_num_rows($sql);
if($num>0){

while($row=mysqli_fetch_array($sql))
  {
$usercount=$row['usercount'];

  	}
  	if($usercount>4){
  	?>

<script type="text/javascript">alert("OOPS! \n Kindly login / Register (FREE) to continue watching videos.");
window.location.replace("<?php echo SITE_URL; ?>/login.php");</script>	 <?php
}else{
	$upsql=mysqli_query($db,"UPDATE tbl_checklogin set usercount=usercount+1  where  userip='$userip'"); 
}



}else{

	$insql=mysqli_query($db,"INSERT into tbl_checklogin set  userip='$userip'"); 
}
*/
?>
