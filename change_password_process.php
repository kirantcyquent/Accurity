<?php 
	session_start();
	include('db/db.php');
    if(isset($_POST['pwd1']) && isset($_POST['pwd2']) && isset($_POST['userid'])){
		$password1 = $_POST['pwd1'];
		$password2 = $_POST['pwd2'];
		$userid = $_SESSION['userid'];

		$query = "UPDATE userdetail SET Password='$password1' WHERE UserId='$userid'";
		$sql = mysql_query($query);
		if($sql){
			//mail
$_SESSION['login-error'] = '<div class="success message">
 <h3>Your Password is Changed Successfully.</h3>
 <p> Please login with new password.</p>
</div>';
			header("Location: login.php");
		}else{
			//
			header("Location: login.php");
		}
	}
?>