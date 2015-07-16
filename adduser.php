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
			<h4>Add New User</h4>
			<form action="addusers.php" method="post">
			<div class="row">
			<div class="col-sm-6" >
			<div style="margin-left:3%;">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="text" class="form-control" name="password" id="exampleInputPassword1" value="<?php echo rand(1111,9999);?>" placeholder="Password">
  </div>
<div class="form-group">
    <label for="exampleInputEmail1">User's Name</label>
    <input type="text" class="form-control" id="" name="name" placeholder="User Name" required>
  </div>  
  </div>
  </div>
<div class="col-sm-6" >	<div class="form-group">
		<label for="exampleInputEmail1">Address</label>
		<input type="text" class="form-control" id="" name="address" placeholder="Address" required>
	</div>  
  
	<div class="form-group">
		<label for="exampleInputEmail1">Type of User</label>
		<select class="form-control" name="type_user">
			<option value="1">Appraiser</option>
			<option value="2">Loan Officer</option>
		</select>
	</div>  
	
	<div class="form-group">
		<label for="exampleInputEmail1">Status</label>
		<select class="form-control" name="status">
			<option value="1">Active</option>
			<option value="0">Inactive</option>
		</select>
	</div>  
	</div>
	<div style="margin-left:3%;"><button type="submit" class="btn btn-default">Add User</button></div>
  </form>
  <br/><br/>
		</div>	
	</div>
</div>
<?php  include('includes/footer.php'); ?>