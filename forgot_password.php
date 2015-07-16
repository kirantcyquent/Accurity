<?php 
	include('db/db.php');
if(isset($_POST['forgotpasswordsubmit'])){
	$emailid = $_POST['youremail'];
	//$query = "SELECT Answer FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$emailid')";
	$query = "SELECT UserID FROM userdetail WHERE UserName = '$emailid'";
	$sql = mysql_query($query);
	$result = mysql_num_rows($sql);
	$userid = mysql_fetch_array($sql);
	$user = $userid[0];
	if($result > 0){
		//print_r($result);exit;
		header("Location: squestions.php?user_id=$user");
	}else{
		header("Location: login.php?error_message='Entered Email is not found. Please Retry or register'");
	}
}
?>