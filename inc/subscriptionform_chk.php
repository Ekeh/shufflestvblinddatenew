<?php
if(isset($_POST['subscribenow'])){
	 $subscribe=mysqli_real_escape_string($db,$_POST['subscribe']);
$subscribe=explode('~',$subscribe);
$amount=$subscribe[0];
$duration=$subscribe[1];



$sql4 = mysqli_query($db,"SELECT * FROM tbl_users where userid='$userid'");
$rows = mysqli_fetch_array($sql4,MYSQLI_ASSOC); 
  $credit=$rows['credit'];
 $ref=$rows['ref'];

   if($credit<$amount){
   	///stop the action
echo "<div class='alert alert-block alert-danger'> Insufficient Funds</div>";
   }else{
////$officialstart='1605466800';
$start=time();
$stop=$start+(3600*24*$duration);
$update_stop=(3600*24*$duration);

/*if($officialstart>$start){
	/////means we should not yet start charging them
	$start=$officialstart;
	$stop=$start+(3600*24*$duration);

}*/

$sql = mysqli_query($db,"SELECT * FROM tbl_livestreaming where client_id='$userid'");
$nums=mysqli_num_rows($sql);

$comm=0.2*$amount;
if($nums=='0'){
	////client does have an entry so insert
$sp = mysqli_query($db,"INSERT into  tbl_livestreaming set client_id='$userid',start_time='$start',stop_time='$stop'");
$sq = mysqli_query($db,"INSERT into  tbl_sub_record set client_id='$userid',amount='$amount'");
$so = mysqli_query($db,"UPDATE  tbl_users set credit=credit-$amount WHERE userid='$userid'");
if($ref==''){$ref='23120';}
//////give commission to the person that referred user
$s = mysqli_query($db,"UPDATE  tbl_users set commission=commission+$comm WHERE userid='$ref'");
////// record the commission
$d = mysqli_query($db,"INSERT into  tbl_commission set refid='$ref', userid='$userid',amount='$comm'");

}else{
	////Client has an entry so update
	$sp = mysqli_query($db,"UPDATE  tbl_livestreaming set start_time='$start',stop_time =stop_time + $update_stop WHERE client_id='$userid'");
		$sq = mysqli_query($db,"INSERT into  tbl_sub_record set client_id='$userid',amount='$amount'");
			$so = mysqli_query($db,"UPDATE  tbl_users set credit=credit-$amount WHERE userid='$userid'");
}

if($sp){
 
      echo "<div class='alert alert-block alert-success'>".$duration ."-day subscription -  Successful </div>";
      ?>
<script type="text/javascript">
    
        setTimeout(function(){
            window.location.href = 'index.php?p=livestream';
         }, 500);
    
</script>

      <?php
}else{
 echo "<div class='alert alert-block alert-danger'> Failed</div>";
}
}
}

?>