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
			$userdt = mysql_fetch_array(mysql_query("select UserName, Password, Name from userdetail where UserID='$userid'"));

			$to =$userdt['UserName'];
			$subject = "Your Accurity Valuation password has been changed";
			$txt = "Dear ".$userdt['Name'].",<br/><br/>
			Your Password has been changed successfully. <br/><br/>
			To login use below credentials.<br/>

			Username : ".$userdt['UserName']." <br/>
			Password : ".$userdt['Password']."<br/>

			<br/>
			Regards,
			<br/>
			Accurity 
			";
			
			//get from address from main_settings table
			$main_settings_qry = "SELECT * FROM main_settings LIMIT 1";
			$main_settings_exe_qry = mysql_query($main_settings_qry);
			$main_settings_result = mysql_fetch_assoc($main_settings_exe_qry);

			$headers = "From: ".$main_settings_result['from_email'];

			$res = mail($to,$subject,$txt,$headers);
			//echo '<br>Subject : '.$subject;
			//echo '<br>From :'.$main_settings_result['from_email'];
			//echo '<br>To :'.$to;
			//echo '<br>Body :'.'<br>'.$txt;exit;
			$_SESSION['login-error'] = '<div class="success message">
			 <h3>Your Password is Changed Successfully</h3>
			 <p>Password is sent to your e-mail id </p>
			 <p>Please login with new password.</p>
			</div>';

			header("Location: login.php");
		}else{
			//
			header("Location: login.php");
		}
	}
?>