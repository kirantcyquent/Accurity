<?php 
session_start();
if (!(isset($_SESSION['email']) && $_SESSION['email'] == true)) {
    header ("location: login.php");
} else {
	include('db/db.php'); 
		include('classes/User.php');
	$us = new User();
	$x="incomplete";
	$user_type=$_SESSION['user_type'];
?>
<?php  include('includes/header.php'); ?>	
<?php  include('includes/topBar.php'); ?>
	<div class="row" id="sideMenuDiv">
		<?php  include('includes/profile-sideMenu.php'); ?>	
		<div class="col-sm-10" id="pageContent">

	<h4>Incomplete Searches</h4>
<table class="table table-bordered">
<thead>
	<th>SL</th>
	<th>Name </th>
	<th>Date</th>
	<th>Action </th>
</thead>
<tbody>

<?php
	$count=1;
	$results = $us->getInCompleteSearches();
	foreach($results as $row){
		if($row['date']=="0000-00-00 00:00:00"){ $date = date("d-m-Y H:i:s");}else{
			$date = strtotime($row['date']);
			$date = date('d-m-Y H:i:s',$date);
		}
		$row["Name"] = preg_replace("@\_@", " ", $row['Name']);
		echo '<tr><td>'.$count.'</td><td>'.$row['Name'].'</td><td>'.$date.'</td><td><a href="resume-search.php?id='.$row['SearchID'].'">Resume Search</a></td></tr>';
		$count++;
	}
?>
</tbody>
</table>
</div>
</div>
</div>
<?php include('includes/footer.php'); ?>
<?php } ?>