<?php 
session_start();
	include('db/db.php');
if(isset($_POST['forgotpasswordsubmit'])){
	$answer1 = $_POST['answer1'];
	$answer2 = $_POST['answer2'];
	$answer3 = $_POST['answer3'];
	$userid = $_SESSION['userid'];
	//$query = "SELECT Answer FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$emailid')";
	$query = "SELECT Answer FROM securityquestion WHERE userID = $userid";
	//echo $query;
	$query2 = "SELECT Answer FROM securityquestion WHERE userID = $userid ORDER BY QuestionID DESC LIMIT 1, 1";
	//echo $query2;
	$query3 = "SELECT Answer FROM securityquestion WHERE userID = $userid ORDER BY QuestionID DESC LIMIT 1";
	//echo $query3;exit;
	$sql = mysql_query($query);
	$result = mysql_fetch_array($sql);
	$sql2 = mysql_query($query2);
	$result2 = mysql_fetch_array($sql2);
	$sql3 = mysql_query($query3);
	$result3 = mysql_fetch_array($sql3);
	if($result[0] == $answer1 && $result2[0] == $answer2 && $result3[0] == $answer3){
		$_SESSION['success'] =1;
		header("Location: change_password.php?user_id=$userid");
	}else{
		header("Location: login.php?error_message='You did not answered all security questions correctly. Please Retry'");
	}
}
?>