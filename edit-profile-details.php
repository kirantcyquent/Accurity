<?php 
session_start();
	include('db/db.php');
if(isset($_POST['update'])){
	$name = $_POST['name'];
	$question1 = $_POST['question1'];
	$question2 = $_POST['question2'];
	$question3 = $_POST['question3'];
	$answer1 = $_POST['answer1'];
	$answer2 = $_POST['answer2'];
	$answer3 = $_POST['answer3'];
	$userid = $_POST['userid'];
	$address = $_POST['address'];
	$questionid1 = $_POST['questionid1'];
	$questionid2 = $_POST['questionid2'];
	$questionid3 = $_POST['questionid3'];
	$check1 = mysql_query("SELECT * FROM securityquestion WHERE UserID =$userid ");
	//echo mysql_num_rows($check1);exit;
	if( mysql_num_rows($check1) >= 3) {
    mysql_query("UPDATE securityquestion SET Question='$question1', Answer='$answer1' WHERE UserID=$userid and QuestionID=$questionid1");
	mysql_query("UPDATE securityquestion SET Question='$question2', Answer='$answer2' WHERE UserID=$userid and QuestionID=$questionid2");
	mysql_query("UPDATE securityquestion SET Question='$question3', Answer='$answer3' WHERE UserID=$userid and QuestionID=$questionid3");
	}
	else
	{
    mysql_query("INSERT INTO securityquestion (UserID,Question,Answer) VALUES ($userid,'$question1','$answer1') ");
	mysql_query("INSERT INTO securityquestion (UserID,Question,Answer) VALUES ($userid,'$question2','$answer2') ");
	mysql_query("INSERT INTO securityquestion (UserID,Question,Answer) VALUES ($userid,'$question3','$answer3') ");
	}
	$check2 = mysql_query("SELECT Name FROM userdetail WHERE UserID =$userid ");
	if( mysql_num_rows($check2) > 0) {
		mysql_query("UPDATE userdetail SET Name = '$name',Address = '$address' where UserID = $userid");
	}else{
		mysql_query("INSERT INTO userdetail (Name,Address) VALUES ('$name','$address')");
	}
	header("Location: profile.php?success_meassage=profile update successfully");
	}else{
	header("Location: edit_profile.php?error_message=Something went wrong. Please retry");	
	}
?>