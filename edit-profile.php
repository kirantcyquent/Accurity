<?php session_start();
		include('db/db.php');
	if (!(isset($_SESSION['email']) && $_SESSION['email'] == true)) {
    header ("location: login.php");
} else {
  $x="profile";
  $user_type=$_SESSION['user_type'];
	?>
	


<?php  include('includes/header.php'); ?> 
<?php  include('includes/topBar.php'); ?>
  <div class="row" id="sideMenuDiv">
    <?php  include('includes/profile-sideMenu.php');?> 
    <div class="col-sm-10" id="pageContent">
      <div style="padding:20px; padding-left:0;">

<?php 

//SELECT Answer FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$emailid')
	//$query = "SELECT QuestionID,Question,Answer FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$sessiondata')";
	//echo "The value ".$query;exit;
	//$query2 = "SELECT QuestionID,Question,Answer FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$sessiondata') ORDER BY QuestionID DESC LIMIT 1, 1";
	//$query3 = "SELECT QuestionID,Question,Answer FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$sessiondata') ORDER BY QuestionID DESC LIMIT 1";

  $query = "SELECT * FROM securityquestion WHERE UserID='{$_SESSION['userid']}'";
  $query2 = "SELECT * FROM securityquestion WHERE UserID='{$_SESSION['userid']}' ORDER BY QuestionID DESC LIMIT 1,1";
   $query3 = "SELECT * FROM securityquestion WHERE UserID='{$_SESSION['userid']}' ORDER BY QuestionID DESC LIMIT 1";
  //while($row = mysq)
	$query4 = "select UserID,Name,Address,company_name,city,state,zip from userdetail where UserName = '$sessiondata' ";
	$sql = mysql_query($query);
	$result = mysql_fetch_array($sql);
	$sql2 = mysql_query($query2);
	$result2 = mysql_fetch_array($sql2);
	$sql3 = mysql_query($query3);
	$result3 = mysql_fetch_array($sql3);
	$sql4 = mysql_query($query4);
	$result4 = mysql_fetch_array($sql4);
?>

<form method="post" action="edit-profile-details.php" autocomplete="off">
<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
        <tr>
          <th><h4>Info</h4></th>
          <th><h4>Details</h4></th>
        </tr>
      </thead>
	  <tbody>
      <?php
        if($user_type==3){
          
          ?>
          <tr>
              <th scope="row">Company Name</th>
              <td><input type="text" class="form-control input-sm" placeholder="Company Name" name="company_name" required value="<?php echo $result4['company_name']; ?>" /></td>
            </tr>
          <?php
        }
      ?>
        <tr>
          <th scope="row">Name</th>
          <td><input type="text" class="form-control input-sm" placeholder="Name.." name="name" value="<?php echo $result4[1];?>" required /><input type="hidden" name="userid" value="<?php echo $result4[0]; ?>" /></td>
        </tr>
        <tr>
          <th scope="row">Email</th>
          <td><?php echo $sessiondata; ?></td>
        </tr>
		    <tr>
          <th scope="row">Address</th>
          <td><textarea class="form-control input-sm" placeholder="Address.." name="address" required ><?php echo preg_replace("@<br\s*\/>@", "", $result4[2]); ?></textarea></td>
        </tr>
         <?php
        if($user_type==3){
          
          ?>
          <tr>
              <th scope="row">City</th>
              <td><input type="text" class="form-control input-sm" placeholder="City" name="city" required value="<?php echo $result4['city']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">State</th>
              <td><input type="text" class="form-control input-sm" placeholder="State" name="state" required value="<?php echo $result4['state']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Zip</th>
                           <td><input type="text" class="form-control input-sm" placeholder="Zip" name="zip" required value="<?php echo $result4['zip']; ?>" /></td>
            </tr>
          <?php
        }
      ?>
	     	<tr>
          <th scope="row"><input type="hidden" name="questionid1" value="<?php echo $result[0]; ?>" /><input type="text" required class="form-control input-sm" placeholder="Question1.." name="question1" value="<?php echo $result['Question']; ?>" /></th>
          <td><input type="text" class="form-control input-sm" required placeholder="Answer1.." name="answer1" value="<?php echo $result['Answer']; ?>" /></td>
        </tr>
		    <tr>
          <th scope="row"><input type="hidden" name="questionid2" value="<?php echo $result2[0]; ?>" /><input type="text" class="form-control input-sm" required placeholder="Question2.." name="question2" value="<?php echo $result2['Question']; ?>" /></th>
          <td><input type="text" name="answer2" placeholder="Answer2.." class="form-control input-sm" required value="<?php echo $result2['Answer']; ?>" /></td>
        </tr>
		<tr>
          <th scope="row"><input type="hidden" name="questionid3" value="<?php echo $result3[0]; ?>" /><input type="text" required class="form-control input-sm" placeholder="Question3.." name="question3" value="<?php echo $result3['Question']; ?>" /></th>
          <td><input type="text" class="form-control input-sm" placeholder="Answer3.." required name="answer3" value="<?php echo $result3['Answer']; ?>" /></td>
        </tr>
		<tr>
          <th scope="row"><a style="" href="profile.php" class="btn btn-danger">Cancel</a></th>
          <td><input type="submit" name="update" class="btn btn-success" value="Update" /></td>
        </tr>
      </tbody>
  </table>
</div>
</form>
</div>
</div></div</div><?php include('includes/footer.php'); ?>
<?php } ?>