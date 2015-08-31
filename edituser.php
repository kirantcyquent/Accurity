<?php
	session_start();
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}
	if(!isset($_GET['id'])){
		header('Location: users.php');
	}
		include('db/db.php');
	include('classes/User.php');
	$user_type=$_SESSION['user_type'];
	$id = $_GET['id'];
	if(isset($_POST['username']) && isset($_POST['address'])){
		$usname = mysql_real_escape_string(@$_POST['username']);
		$errors = array();
		if($usname != strip_tags($usname)) {
 	   		$errors[] = 'Username ';
		}
		$address = mysql_real_escape_string(@$_POST['address']);
		if($address != strip_tags($address)) {
 	   		$errors[] = 'Address';
		}
		$usertype = mysql_real_escape_string(@$_POST['type_user']);
		$status = mysql_real_escape_string(@$_POST['status']);

		if(count($errors)>0){
			$string= '';
			foreach($errors as $err){
					$string = $string ." , ". $err;
			}
			$string = $string . " contains invalid characters.";
			$string = preg_replace("@^\s*\,@","",$string);
			$_SESSION['status_success']='<div class="alert alert-danger">
		 	 <strong>'.$string.'</strong></div>';
		}else{
			$update = mysql_query("update userdetail set Name='$usname', Address='$address', TypeOfUser='$usertype', Active='$status' where UserID='$id'");
			if($update){
				$_SESSION['status_success']='<div class="alert alert-success">
		 	 <strong>User Information Updated Successfully.</strong></div>';
			}
		}
	}

	$udetail = mysql_fetch_array(mysql_query("select * from userdetail where UserID='$id'"));
	$usertype = $udetail['TypeOfUser'];
	//if($usertype==1){ $usertype="Appraiser";}elseif($usertype==2){$usertype="Loan Officer"; }
	$status = $udetail['Active'];// if($status==1){ //$status="Active";} else{ $status = "Inactive"; }
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
		<?php  include('includes/lendingMenu.php'); ?>	
		<div class="col-sm-8" id="pageContent">
			<br/><br/>
			<?php
			if(isset($_SESSION['status_success'])){
				echo $_SESSION['status_success'];
				unset($_SESSION['status_success']);
			}
			?>
			
			<div class="pull-right"></div>
			<div class="pull-left"><h4>User Details of <?php echo trim($udetail['UserName']);?></h4></div>

			<form action="edituser.php?id=<?php echo $_GET['id'];?>" method="post">
			<table class="table table-bordered"> 
				<tbody>
					<tr>
						<td>UserName</td>
						<td><input type="text" class="form-control input-sm"  value="<?php echo trim($udetail['UserName']);?>" required readonly/></td>
					</tr>					
					<tr>
						<td>Name</td>
						<td><input type="text" class="form-control input-sm" name="username" value="<?php echo trim($udetail['Name']);?>" required></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><textarea class="form-control input-sm" name="address"   required><?php echo trim($udetail['Address']);?></textarea></td>
					</tr>
					<tr>
						<td>Type of User</td>
						<td><select class="form-control  input-sm" name="type_user">
			<option value="1" <?php if($usertype==1){ echo " selected";}?>>Appraiser</option>
			<option value="2" <?php if($usertype==2){ echo " selected";}?>>Loan Officer</option>
		</select></td>
					</tr>															
					<tr>
						<td>Status</td>
						<td><select class="form-control  input-sm" name="status">
			<option value="1" <?php if($status==1){echo " selected"; } ?>>Active</option>
			<option value="0" <?php if($status==0){echo " selected"; } ?>>Inactive</option>
		</select></td>
					</tr>	

					<tr>
						<td colspan="2"><input type="submit" class="btn btn-primary" name="submit" value="Update" /></td>
					</tr>									
				</tbody>			
			</table>
		</form>
  <br/>
 
		</div>	
	</div>
</div>
<?php  include('includes/footer.php'); ?>