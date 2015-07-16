<?php

class User{
	//if you want to access data variables from login_test_check.php, use this 2 variables
	public $emailidvalue;
	public function checkUser($email,$password){
		include('db/db.php');
		$sql = "select email,password from login_details where email='$email' and password='$password'";
		$query = mysql_query($sql);
		$result=mysql_fetch_array($query);
		$emailvalue = $result[0];
		$this->emailidvalue = $emailvalue;
		$count = mysql_num_rows($query);
		if($count > 0){
			return true;
		}
		else{
			return false;
		}
	}
}

?>