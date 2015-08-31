<?php 
	session_start();
		include('db/db.php');
	if(isset($_POST['update'])){
	$company_name = mysql_real_escape_string(@$_POST['company_name']);
	$city = mysql_real_escape_string(@$_POST['city']);
    $state = mysql_real_escape_string(@$_POST['state']);
    $zip = mysql_real_escape_string(@$_POST['zip']);

	$name = trim(strip_tags($_POST['name']));
	$question1 = strip_tags($_POST['question1']);
	$question2 = strip_tags($_POST['question2']);
	$question3 = strip_tags($_POST['question3']);
	$answer1 = strip_tags($_POST['answer1']);
	$answer2 = strip_tags($_POST['answer2']);
	$answer3 = strip_tags($_POST['answer3']);
	$userid = $_POST['userid'];
	$address = mysql_real_escape_string(nl2br(@$_POST['address']));
	$questionid1 = $_POST['questionid1'];
	$questionid2 = $_POST['questionid2'];
	$questionid3 = $_POST['questionid3'];

	
	$check1 = mysql_query("SELECT * FROM securityquestion WHERE UserID =$userid ")or die(mysql_error());
	//echo mysql_num_rows($check1);exit;

	if( mysql_num_rows($check1) >= 3) {
    mysql_query("UPDATE securityquestion SET Question='$question1', Answer='$answer1' WHERE UserID='$userid' and QuestionID='$questionid1'")or die(mysql_error());
	mysql_query("UPDATE securityquestion SET Question='$question2', Answer='$answer2' WHERE UserID='$userid' and QuestionID='$questionid2'");
	mysql_query("UPDATE securityquestion SET Question='$question3', Answer='$answer3' WHERE UserID='$userid' and QuestionID='$questionid3'");
	}
	else
	{
    mysql_query("INSERT INTO securityquestion (UserID,Question,Answer) VALUES ('$userid','$question1','$answer1') ")or die(mysql_error());
	mysql_query("INSERT INTO securityquestion (UserID,Question,Answer) VALUES ('$userid','$question2','$answer2') ");
	mysql_query("INSERT INTO securityquestion (UserID,Question,Answer) VALUES ('$userid','$question3','$answer3') ");
	}
	$check2 = mysql_query("SELECT Name FROM userdetail WHERE UserID =$userid ");
	if( mysql_num_rows($check2) > 0) {
		mysql_query("UPDATE userdetail SET company_name='$company_name', city='$city', state='$state', zip='$zip', Name = '$name',Address = '$address' where UserID = $userid");
	}else{
		mysql_query("INSERT INTO userdetail (Name,Address, company_name,city,state,zip) VALUES ('$name','$address','$company_name','$city','$state','$zip')");
	}
	header("Location: profile.php?success_meassage=profile update successfully");
	}else{
	header("Location: edit_profile.php?error_message=Something went wrong. Please retry");	
	}
?>