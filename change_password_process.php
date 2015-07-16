<?php 
	session_start();
	include('db/db.php');
if(isset($_POST['change-password'])){
	$password1 = $_POST['pwd1'];
	$password2 = $_POST['pwd2'];
	$userid = $_SESSION['userid'];
	$query = "UPDATE userdetail SET Password='$password1' WHERE UserId='$userid'";
	$sql = mysql_query($query);
	if($sql){
		header("Location: login.php?password_change='you have successfully changed password. Please login with new credentials'");
	}else{
		header("Location: login.php?password_change_failure='something went wrong. Please retry'");
	}
}
?>