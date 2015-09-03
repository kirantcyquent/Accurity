<?php
	session_start();
	$user_type=$_SESSION['user_type'];
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}	
    else {
		include('db/db.php');
	$user_type=$_SESSION['user_type'];

	$x="profile";
?>
<?php  include('includes/header.php'); ?>	
<?php  include('includes/topBar.php'); ?>
	<div class="row" id="sideMenuDiv">
		<?php  include('includes/profile-sideMenu.php'); ?>	
		<div class="col-sm-10" id="pageContent">

			<div style="padding:20px;">


<?php 
//SELECT Answer FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$emailid')
	 $query = "SELECT Question, Answer FROM securityquestion WHERE UserID='{$_SESSION['userid']}'";
  $query2 = "SELECT Question, Answer FROM securityquestion WHERE UserID='{$_SESSION['userid']}' ORDER BY QuestionID DESC LIMIT 1,1";
   $query3 = "SELECT Question, Answer FROM securityquestion WHERE UserID='{$_SESSION['userid']}' ORDER BY QuestionID DESC LIMIT 1";
$query4 = "select Name,Address,company_name,city, state,zip from userdetail where UserName = '$sessiondata' ";
	$sql = mysql_query($query);
	$result = mysql_fetch_array($sql);
	$sql2 = mysql_query($query2);
	$result2 = mysql_fetch_array($sql2);
	$sql3 = mysql_query($query3);
	$result3 = mysql_fetch_array($sql3);
	$sql4 = mysql_query($query4);
	$result4 = mysql_fetch_array($sql4);
?>

<?php $errormsg = $_GET['error_message']; ?>
<?php $successmsg = $_GET['success_meassage']; ?>
 <?php if($errormsg){ ?>
		   <div class="alert alert-danger">
		  <strong>Error!</strong> <?php echo $errormsg; ?>
		</div>
	   <?php 
	   }else if($successmsg){ ?>
		<div class="alert alert-success">
		  <strong>Success!</strong> <?php echo $successmsg; ?>
		</div>   
	   <?php } else{} ?>

	   <h3>Profile Information </h3>
<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
        <tr>
          <th width="50%"><h4>Info</h4></th>
          <th width="50%"><h4>Details</h4></th>
        </tr>
      </thead>
	  <tbody>
	  	<?php
	  		if($user_type==3){
	  			
	  			?>
	  			<tr>
		          <th scope="row">Company Name</th>
		          <td><?php if($result4['company_name']){echo $result4['company_name'];}
		          else{echo "Company not Filled.Please Update.";} ?></td>
		        </tr>
	  			<?php
	  		}
	  	?>
        <tr>
          <th scope="row">Name</th>
          <td><?php if($result4[0]){echo $result4[0];}else{echo "Name Not Filled.Please Update.";} ?></td>
        </tr>
        <tr>
          <th scope="row">Email</th>
          <td><?php echo $sessiondata; ?></td>
        </tr>
		<tr>
          <th scope="row">Address</th>
          <td><?php if($result4[1]){echo $result4[1];}else{echo "Address Not Filled.Please Update.";} ?></td>
        </tr>
        <?php
	  		if($user_type==3){
	  			
	  			?>
	  			<tr>
		          <th scope="row">City</th>
		          <td><?php if($result4['city']){echo $result4['city'];}
		          else{echo "City not Filled.Please Update.";} ?></td>
		        </tr>
		        <tr>
		          <th scope="row">State</th>
		          <td><?php if($result4['state']){echo $result4['state'];}
		          else{echo "State not Filled.Please Update.";} ?></td>
		        </tr>
		        <tr>
		          <th scope="row">Zip</th>
		          <td><?php if($result4['zip']){echo $result4['zip'];}
		          else{echo "Zip not Filled.Please Update.";} ?></td>
		        </tr>
	  			<?php
	  		}
	  	?>
	</tbody>
	</table>
</div>

<div class="table-responsive">
	<table class="table table-bordered" style="border:1px solid #dddddd !important;">
			<thead>
				<tr>
				  <th width="50%"><h4>Security Questions</h4></th>
				  <th width="50%"><h4>Security Answers</h4></th>
				</tr>
		    </thead>
			<tr>
			  <th scope="row">Q1) <span style="padding-left:10px;"><?php if($result[0]){echo $result[0];}else{echo "Question Not Filled.Please Update.";} ?></span></th>
			  <th>A1) <span style="padding-left:10px;"><?php if($result[1]){echo $result[1];}else{echo "Answer Not Filled.Please Update.";} ?></span></th>
			</tr>
			<tr>
			  <th scope="row">Q2) <span style="padding-left:10px;"><?php if($result2[0]){echo $result2[0];}else{echo "Question Not Filled.Please Update.";} ?></span></th>
			  <th>A2) <span style="padding-left:10px;"><?php if($result2[1]){echo $result2[1];}else{echo "Answer Not Filled.Please Update.";} ?></span></th>
			</tr>
			<tr>
			  <th scope="row">Q3) <span style="padding-left:10px;"><?php if($result3[0]){echo $result3[0];}else{echo "Question Not Filled.Please Update.";} ?></span></th>
			  <th>A3) <span style="padding-left:10px;"><?php if($result3[1]){echo $result3[1];}else{echo "Answer Not Filled.Please Update.";} ?></span></th>
			</tr>
  </table>
</div>
<a style="margin-bottom:20px;" href="edit-profile.php" class="btn btn-success">Edit Profile</a>

</div>
</div>	
	</div>
</div>
<?php  include('includes/footer.php'); ?>
<?php } ?>