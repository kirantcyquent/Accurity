<?php
	session_start();
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}
	include('db/db.php');
	$id  = $_GET['id'];
	$status = $_GET['status'];
	mysql_query("update userdetail set Active='$status' where UserID='$id'");
	header('Location: viewuser.php?id='.$id);
?>