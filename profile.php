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
	$query = "SELECT Question,Answer FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$sessiondata')";
	//echo "The value ".$query;exit;
	$query2 = "SELECT Question,Answer FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$sessiondata') ORDER BY QuestionID DESC LIMIT 1, 1";
	$query3 = "SELECT Question,Answer FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$sessiondata') ORDER BY QuestionID DESC LIMIT 1";
	$query4 = "select Name,Address from userdetail where UserName = '$sessiondata' ";
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
          <th>Info</th>
          <th>Details</th>
        </tr>
      </thead>
	  <tbody>
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
		<tr>
          <th scope="row"><?php if($result[0]){echo $result[0];}else{echo "Question Not Filled.Please Update.";} ?></th>
          <td><?php if($result[1]){echo $result[1];}else{echo "Answer Not Filled.Please Update.";} ?></td>
        </tr>
		<tr>
          <th scope="row"><?php if($result2[0]){echo $result2[0];}else{echo "Question Not Filled.Please Update.";} ?></th>
          <td><?php if($result2[1]){echo $result2[1];}else{echo "Answer Not Filled.Please Update.";} ?></td>
        </tr>
		<tr>
          <th scope="row"><?php if($result3[0]){echo $result3[0];}else{echo "Question Not Filled.Please Update.";} ?></th>
          <td><?php if($result3[1]){echo $result3[1];}else{echo "Answer Not Filled.Please Update.";} ?></td>
        </tr>
      </tbody>
  </table>
</div>
<a style="margin-bottom:20px;" href="edit-profile.php" class="btn btn-success">Edit Profile</a>

</div>
</div>	
	</div>
</div>
<?php  include('includes/footer.php'); ?>
<?php } ?>