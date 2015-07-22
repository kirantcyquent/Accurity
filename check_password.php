<?php
	include('db/db.php');
	$password = $_REQUEST['pass'];

	session_start();

	include('classes/User.php');
	$us = new User();

	$check = $us->check_password($password);
	if($check==0){
		echo '<span style="color:red;">Incorrect Current Password.</span>';
	}else{
		echo '';
	}
?>