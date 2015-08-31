<?php
	session_start();
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}
	include('db/db.php');

	if(isset($_POST['company_name']) && isset($_POST['email']) && isset($_POST['email']) && isset($_POST['name'])){
		
		$company_name = mysql_real_escape_string(@$_POST['company_name']);
		$city = mysql_real_escape_string(@$_POST['city']);
	    $state = mysql_real_escape_string(@$_POST['state']);
    	$zip = mysql_real_escape_string(@$_POST['zip']);
		$email = mysql_real_escape_string(@$_POST['email']);
		$password = mysql_real_escape_string(@$_POST['password']);
		$name  = mysql_real_escape_string(@$_POST['name']);
		$address = mysql_real_escape_string(nl2br(@$_POST['address']));
		$type_user = 3;
		$status = mysql_real_escape_string(@$_POST['status']);

		$check = mysql_query("select * from userdetail where UserName='$email'");
		if(mysql_num_rows($check)>0){
			$_SESSION['status_success']='<div class="alert alert-danger">
				 	 <strong>E-mail already exists!!</strong>.
					</div>';
					$_SESSION['add']['company_name'] = $company_name;
					$_SESSION['add']['city'] = $city;
					$_SESSION['add']['state'] = $state;
					$_SESSION['add']['zip'] = $zip;
					$_SESSION['add']['email'] = $email;
					$_SESSION['add']['password'] = $password;
					$_SESSION['add']['name'] = $name;
					$_SESSION['add']['address'] = $address;
					$_SESSION['add']['status'] = $status;
			header('Location:addinstitutes.php');
			$_SESSION['add']['company_name'] = $company_name;
			$_SESSION['add']['company_name'] = $company_name;
			$_SESSION['add']['company_name'] = $company_name;
			$_SESSION['add']['company_name'] = $company_name;
			$_SESSION['add']['company_name'] = $company_name;
			$_SESSION['add']['company_name'] = $company_name;
			$_SESSION['add']['company_name'] = $company_name;
			exit;
		}else{
			
		}


		$password = mysql_real_escape_string(@$_POST['password']);
		$name  = mysql_real_escape_string(@$_POST['name']);
		$address = mysql_real_escape_string(nl2br(@$_POST['address']));
		$type_user = 3;
		$status = mysql_real_escape_string(@$_POST['status']);
		$sponsor_code = mysql_fetch_row(mysql_query("select max(SponserCode) from userdetail"));
		$sponsor_code = $sponsor_code[0]+1;
		$insert = mysql_query("insert into userdetail values ('','$email','$password','$name','$address','$sponsor_code','$status','','','','$type_user','','$company_name','$city','$state','$zip') ")or die(mysql_error());
		if($insert){
			$_SESSION['add_success']='<div class="alert alert-success">
		 	 <strong>Success!</strong> User has been added successfully.
			</div>';
		}
	}
	header('Location: institutes.php');
	exit;
?>