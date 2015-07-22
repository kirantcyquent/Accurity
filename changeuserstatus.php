<?php
	session_start();
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}
	include('db/db.php');
	$id  = $_GET['id'];
	$status = $_GET['status'];
	mysql_query("update userdetail set Active='$status' where UserID='$id'");
	if($status==0){
	$_SESSION['status_success']='<div class="alert alert-danger">
		 	 <strong> User has been suspended successfully.</strong>
			</div>';
		}else{
			$_SESSION['status_success']='<div class="alert alert-success">
		 	 <strong> User has been re-activated successfully.</strong>
			</div>';
		}
	header('Location: viewuser.php?id='.$id);
?>