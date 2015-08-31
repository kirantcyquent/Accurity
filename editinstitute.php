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
		$address = mysql_real_escape_string(nl2br(@$_POST['address']));
		$add = preg_replace("@<br\s*\/>@","",$address);
		if($add != strip_tags($add)) {
 	   		$errors[] = 'Address';
		}
		$usertype = 3;
		$status = mysql_real_escape_string(@$_POST['status']);
		$company_name =mysql_real_escape_string(@$_POST['company_name']);
    	$city = mysql_real_escape_string(@$_POST['city']);
    	$state = mysql_real_escape_string(@$_POST['state']);
	    $zip = mysql_real_escape_string(@$_POST['zip']);


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
			$update = mysql_query("update userdetail set Name='$usname', Address='$address', TypeOfUser='$usertype', Active='$status', company_name='$company_name', city='$city', state='$state', zip='$zip' where UserID='$id'");
			if($update){
				header('Location:viewinstitute.php?id='.$id);
			}else{
				$_SESSION['status_success']='<div class="alert alert-danger">
		 	 <strong>Error in updating User </strong>.
			</div>';
			}
		}
	}

	$udetail = mysql_fetch_array(mysql_query("select * from userdetail where UserID='$id'"));
	$usertype = $udetail['TypeOfUser'];
	//if($usertype==1){ $usertype="Appraiser";}elseif($usertype==2){$usertype="Loan Officer"; }
	$status = $udetail['Active'];// if($status==1){ //$status="Active";} else{ $status = "Inactive"; }
	$x="institutes";
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
		<?php  include('includes/adminMenu.php'); ?>	
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

			<form action="editinstitute.php?id=<?php echo $_GET['id'];?>" method="post">
			<table class="table table-bordered"> 
				<tbody>
					<tr>
						<td>Company Name</td>
						<td><input type="text" class="form-control  input-sm"  value="<?php echo trim($udetail['company_name']);?>" required name="company_name"/></td>
					</tr>	
					<tr>
						<td>UserName</td>
						<td><input type="text" class="form-control  input-sm"  value="<?php echo trim($udetail['UserName']);?>" required readonly/></td>
					</tr>					
					<tr>
						<td>Name</td>
						<td><input type="text" class="form-control  input-sm" name="username" value="<?php echo trim($udetail['Name']);?>" required></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><textarea class="form-control input-sm" name="address"  required> <?php echo trim(preg_replace("@<br\s*\/>@","",$udetail['Address']));?></textarea></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input type="text" class="form-control input-sm" name="city"  value="<?php echo trim($udetail['city']);?>" required></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input type="text" class="form-control input-sm" name="state"  value="<?php echo trim($udetail['state']);?>" required></td>
					</tr>
					<tr>
						<td>Zip</td>
						<td><input type="text" class="form-control input-sm" name="zip"  value="<?php echo trim($udetail['zip']);?>"pattern="^[0-9]+" required></td>
					</tr>													
					<tr>
						<td>Status</td>
						<td><select class="form-control input-sm" name="status">
			<option value="1" <?php if($status==1){echo " selected"; } ?>>Active</option>
			<option value="0" <?php if($status==0){echo " selected"; } ?>>Inactive</option>
		</select></td>
					</tr>	

					<tr>
						<td colspan="2">
								<button type="submit" id="bt" class="btn btn-success" onclick=""> Update </button>
						</td>
					</tr>									
				</tbody>			
			</table>
		</form>
  <br/>
 
		</div>	
	</div>
</div>
<?php  include('includes/footer.php'); ?>