<?php
	session_start();
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}
	include('db/db.php');
	if(isset($_POST['email']) && isset($_POST['name'])){
		$email = mysql_real_escape_string(@$_POST['email']);
		$password = mysql_real_escape_string(@$_POST['password']);
		$name  = mysql_real_escape_string(@$_POST['name']);
		$address = mysql_real_escape_string(@$_POST['address']);
		$type_user = mysql_real_escape_string(@$_POST['type_user']);
		$status = mysql_real_escape_string(@$_POST['status']);
		$sponsor_code = mysql_fetch_row(mysql_query("select max(SponserCode) from userdetail"));
		$sponsor_code = $sponsor_code[0]+1;
		$insert = mysql_query("insert into userdetail values ('','$email','$password','$name','$address','$sponsor_code','$status','','','','$type_user') ")or die(mysql_error());
	}
	header('LOcation: users.php');
	exit;
?>