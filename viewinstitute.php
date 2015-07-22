<?php
	session_start();
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}
	include('db/db.php');
	include('classes/User.php');
	$user_type=$_SESSION['user_type'];
	
	$id = $_GET['id'];
	$udetail = mysql_fetch_array(mysql_query("select * from userdetail where UserID='$id'"));
	$usertype = $udetail['TypeOfUser'];
	
	$status = $udetail['Active']; if($status==1){ $status="Active";} else{ $status = "Inactive"; }
	$x="institutes";
?>
<?php  include('includes/header.php'); ?>	
<?php  include('includes/topBar.php'); ?>

	<div class="row" id="sideMenuDiv">
		<?php  include('includes/adminMenu.php'); ?>	
		<div class="col-sm-8" id="pageContent">
			<br/><br/>
			<?php
			if(isset($_SESSION['status_success'])){
				echo $_SESSION['status_success'];
				unset($_SESSION['status_success']);
			}
			?>
			
			<div class="pull-right"><a href="editinstitute.php?id=<?php echo $udetail['UserID'];?>" class="btn btn-primary">Edit User</a></div>
			<div class="pull-left"><h4>User Details of <?php echo $udetail['UserName'];?></h4></div>
			<table class="table table-bordered"> 
				<tbody>
					<tr>
						<td>UserName</td>
						<td><?php echo $udetail['UserName'];?></td>
					</tr>					
					<tr>
						<td>Name</td>
						<td><?php echo $udetail['Name'];?></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><?php echo $udetail['Address'];?></td>
					</tr>
					<tr>
						<td>Type of User</td>
						<td><?php echo $usertype;?></td>
					</tr>															
					<tr>
						<td>Status</td>
						<td><?php echo $status;?></td>
					</tr>										
				</tbody>			
			</table>
  <br/>
  
		</div>	
	</div>
</div>
<?php  include('includes/footer.php'); ?>