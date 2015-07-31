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
	if($usertype==1){ $usertype="Appraiser";}elseif($usertype==2){$usertype="Loan Officer"; }
	$status = $udetail['Active']; if($status==1){ $status="Active";} else{ $status = "Inactive"; }
	$x="users";
?>
<?php  include('includes/header.php'); ?>	
<?php  include('includes/topBar.php'); ?>
<script>
	function suspend(id){
		var y = confirm("Do you really want to suspend this user?");
		if(y){
			location = "changeuserstatus.php?id="+id+"&status=0";
		}else{
		}
	}
	function unsuspend(id){
		var y = confirm("Do you want to reactivate this user?");
		if(y){
			location = "changeuserstatus.php?id="+id+"&status=1";
		}else{
		}
	}
</script>
	<div class="row" id="sideMenuDiv">
		<?php  
if($usertype==0){
include('includes/adminMenu.php');
}else{
		include('includes/lendingMenu.php');

		} ?>	
		<div class="col-sm-8" id="pageContent">
			<br/><br/>
			<?php
			if(isset($_SESSION['status_success'])){
				echo $_SESSION['status_success'];
				unset($_SESSION['status_success']);
			}
			?>
			
			<div class="pull-right"><a class="btn btn-primary" href="edituser.php?id=<?php echo $_GET['id'];?>">Edit User</a></div>
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
  <?php if($udetail['Active']==1){ ?><a onclick="suspend(<?php echo $_GET['id'];?>)" class="btn btn-warning">Suspend User</a> <?php } ?>
  <?php if($udetail['Active']==0){ ?><a onclick="unsuspend(<?php echo $_GET['id'];?>)" class="btn btn-success">Reactivate User</a> <?php } ?>
  <br/><br/>
		</div>	
	</div>
</div>
<?php  include('includes/footer.php'); ?>