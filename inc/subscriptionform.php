<p style='color:red; padding:10px; text-align:left'>Kindly note that your subscription strictly allows you access to watch the livestream.<br> If you wish to view other content, you may be required to make a payment. </p><form method="post" action="">
<div style="padding: 10px">	
	<select name="subscribe" class="form-control" required>
<option value=''>-Choose a Subscription -</option>
<?php
$sq = mysqli_query($db,"SELECT * FROM tbl_subscription order by sub_value asc");
while($r=mysqli_fetch_array($sq))
  {

  	$sub_name=$r['sub_name'];
  	$sub_value=$r['sub_value'];
  	$sub_duration=$r['sub_duration'];
?>
<option value="<?php echo $sub_value; ?>~<?php echo $sub_duration; ?>"><?php echo $sub_name; ?></option>


<?php
  }


?>
</select>
</div><div style="padding: 10px">
<input type="submit" name="subscribenow" value="Submit" class="btn btn-primary form-control">
</div>
</form>
