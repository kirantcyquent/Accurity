<?php 
	session_start();
	include('db/db.php');
	if(isset($_POST['email'])){
		$emailid = $_POST['email'];
		//$query = "SELECT Answer FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$emailid')";
		$query = "SELECT UserID FROM userdetail WHERE UserName = '$emailid'";
		$sql = mysql_query($query);
		$result = mysql_num_rows($sql);
		$userid = mysql_fetch_array($sql);
		$user = $userid[0];
		if($result > 0){
			$_SESSION['forgot-user'] = $user;
			header("Location: recover.php");
		}else{
			header("Location: login.php");
		}
	}
?>