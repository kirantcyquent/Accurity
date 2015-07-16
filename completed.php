<?php 
session_start();
if (!(isset($_SESSION['email']) && $_SESSION['email'] == true)) {
    header ("location: login.php");
} else {
	include('db/db.php'); 
	include('classes/User.php');
	$us = new User();
?>
	
<?php include('includes/header.php'); ?>
<?php  include('includes/topBar.php'); ?>

<div class="row" style="width:80%;margin:0 auto;">
<div class="col-lg-2 col-md-2">
<?php  include('includes/profile-sideMenu.php'); ?>
</div>
<div class="col-lg-10 col-md-10" style="margin-top:33px;">
	<h4>Completed Searches</h4>
<table class="table table-bordered">
<thead>
	<th>SL</th>
	<th>Name </th>
	<th>Date</th>
	<th>Action</th>
</thead>
<tbody>

<?php
	$count=1;
	$results = $us->getCompletedSearches();
	foreach($results as $row){
		if($row['date']=="0000-00-00 00:00:00"){ $date = date("d-m-Y H:i:s");}else{
			$date = strtotime($row['date']);
			$date = date('d-m-Y H:i:s',$date);
		}
		echo '<tr><td>'.$count.'</td><td>'.$row['Name'].'</td><td>'.$date.'</td><td><a href="download.php?id='.$row['SearchID'].'">Download Report</a></td></tr>';
		$count++;
	}
?>
</tbody>
</table>
</div>
</div>
<?php include('includes/footer.php'); ?>
<?php } ?>