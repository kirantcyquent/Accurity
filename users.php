<?php
	session_start();
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}
	include('classes/User.php');
	$user_type=$_SESSION['user_type'];
?>
<?php  include('includes/header.php'); ?>	
<?php  include('includes/topBar.php'); ?>
	<div class="row" id="sideMenuDiv">
		<?php  include('includes/lendingMenu.php'); ?>	
		<div class="col-sm-10" id="pageContent">
			<br/><br/>
			<table class="table table-bordered">
				<thead>
					<th>SL </th>
					<th>User Name</th>
					<th>Name </th>
					<th>Address</th>
					<th>Completed Searches</th>
					<th>Incomplete Searches</th>
					<th>Type of User</th>					
					<th>Status </th>
				</thead>
				<tbody>
					<?php
						$count = 1;
						$us = new User();
						$results = $us->getUserList();
						foreach($results as $res){
							$completed = $us->getNbCompletedSearches($res['UserID']);
							$incomplete = $us->getNbIncompleteSearches($res['UserID']);
							if($res['TypeOfUser']==1){ $usertype = 'Appraiser';} else if($res['TypeOfUser']==2){ $usertype="Loan Officer"; }else{continue;}
							if($res['Active']==1){ $status = "<span class='badge success'>Active</span>";} else if($res['Active']==0) { $status = "<span class='badge warning'>Inactive</span>"; } 
							echo '<tr><td>'.$count.'</td><td><a href="viewuser.php?id='.$res['UserID'].'">'.$res['UserName'].'</a></a></td><td>'.$res['Name'].'</td><td>'.$res['Address'].'</td>';
							if($completed>0){
								echo '<td><a href="viewcompleted.php?id='.$res['UserID'].'" style="text-decoration:underline;">'.$completed.'</a></td>';
							}else{
								echo '<td>'.$completed.'</td>';
							}
							echo '<td>'.$incomplete.'</td><td>'.$usertype.'</td><td>'.$status.'</td></tr>';
							$count++;
						}
					?>
				</tbody>
			</table>
		</div>	
	</div>
</div>
<?php  include('includes/footer.php'); ?>
