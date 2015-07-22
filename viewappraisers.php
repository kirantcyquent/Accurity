<?php
	session_start();
	$user_type=$_SESSION['user_type'];
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid']) || $user_type!=0){
		header('Location: login.php');
	}
	include('classes/User.php');	
	$x = "institutes";
?>
<?php  include('includes/header.php'); ?>	
<?php  include('includes/topBar.php'); ?>
	<div class="row" id="sideMenuDiv">
		<?php  include('includes/adminMenu.php'); ?>	
		<div class="col-sm-10" id="pageContent">
			<br/><br/>
			<?php
			if(isset($_SESSION['add_success'])){
				echo $_SESSION['add_success'];
				unset($_SESSION['add_success']);
			}
			?>
			<h3>List of Appraisers </h3>
			<table class="table table-bordered">
				<thead>
					<th>SL </th>
					<th>User Name</th>
					<th>Name </th>
					<th>Address</th>
					<th>Completed Searches</th>
					<th>Incomplete Searches</th>
								
					<th>Status </th>
				</thead>
				<tbody>
					<?php
						$count = 1;
						$us = new User();
						$results = $us->getAppraiserList($_GET['id']);
						foreach($results as $res){
							$completed = $us->getNbCompletedSearches($res['UserID']);
							$incomplete = $us->getNbIncompleteSearches($res['UserID']);
							//if($res['TypeOfUser']==1){ $usertype = 'Appraiser';} else if($res['TypeOfUser']==2){ $usertype="Loan Officer"; }else{continue;}
							if($res['Active']==1){ $status = "<span class='btn btn-info'>&nbsp;Active&nbsp;</span>";} else if($res['Active']==0) { $status = "<span class='btn btn-danger'>Inactive</span>"; } 
							echo '<tr><td>'.$count.'</td><td><a href="viewuser.php?id='.$res['UserID'].'">'.$res['UserName'].'</a></a></td><td>'.$res['Name'].'</td><td>'.$res['Address'].'</td>';
							if($completed>0){
								echo '<td>'.$completed.'</td>';
							}else{
								echo '<td>'.$completed.'</td>';
							}
							echo '<td>'.$incomplete.'</td><td>'.$status.'</td></tr>';
							$count++;
						}
					?>
				</tbody>
			</table>
		</div>	
	</div>
</div>
<?php  include('includes/footer.php'); ?>
