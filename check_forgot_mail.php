<?php
include('classes/Database.php');
	$db = new Database();
	$db->getDBConnection();
$mail = $_REQUEST['mail'];

$check = mysql_query("select * from userdetail where UserName='$mail'");

if(mysql_num_rows($check)>0){
	
	$check_res = mysql_fetch_assoc($check);
	$sec_qust_res = mysql_query("select * from securityquestion where UserID ='$check_res[UserID]'");
	if(mysql_num_rows($sec_qust_res) < 3)
	{
		//get from address from main_settings table
		$main_settings_qry = "SELECT * FROM main_settings LIMIT 1";
		$main_settings_exe_qry = mysql_query($main_settings_qry);
		$main_settings_result = mysql_fetch_assoc($main_settings_exe_qry);
		
		
		$to =$check_res['UserName'];
		$subject = "Your Accurity Valuation login credentials.";
		$txt = "Dear ".$check_res['Name'].",<br/><br/>

		To login use below credentials.<br/><br/>

		Username : ".$check_res['UserName']." <br/>
		Password : ".$check_res['Password']."<br/>

		<br/>
		Regards,
		<br/>
		Accurity 
		";
		
		$headers = "From: ".$main_settings_result['from_email'];

		$res = mail($to,$subject,$txt,$headers);
		echo "noquestions";
		//echo '<br>Subject : '.$subject;
		//echo '<br>From :'.$main_settings_result['from_email'];
		//echo '<br>To :'.$to;
		//echo '<br>Body :'.'<br>'.$txt;exit;
	}
	
}else{
	echo 'This e-mail id is not registered.<br/><br/>';
}
?>
