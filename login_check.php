<?php 
if(isset($_POST['email']) && isset($_POST['password']))
{
	session_start();
	include('classes/User.php');
	include_once('classes/Session.php');

	$user = new User();
	$session = new Session();

	$user->email = strip_tags($_POST['email']);
	$user->password = strip_tags($_POST['password']);


	if($user->check_user()){		
		$user_type = $session->get_session('user_type');
		if($user_type==3){
			header("Location: users.php");
			exit;
		}else if($user_type==0){
			header("Location: institutes.php");
			exit;
		}
		
	header ("Location: index.php");	
		exit;
	}else{
		header ("Location: login.php?error_message=login failed.Please Retry");			
		exit;
	}

}

header('Location: login.php');
?>