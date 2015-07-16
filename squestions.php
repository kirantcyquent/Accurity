	<?php
	$userid = $_GET['user_id'];
	session_start();
	$_SESSION['userid'] =$userid;
	/*if (!(isset($_SESSION['email']) && $_SESSION['email'] == true)) {
    header ("location: login.php");
} else {*/
	include('db/db.php');
	$userid = $_GET['user_id'];
	//$query = "SELECT Question FROM securityquestion WHERE userID = (SELECT UserID FROM userdetail where UserName = '$useremail')";
	$query = "SELECT Question FROM securityquestion WHERE userID = $userid";
	$query2 = "SELECT Question FROM securityquestion WHERE userID = $userid ORDER BY QuestionID DESC LIMIT 1, 1";
	$query3 = "SELECT Question FROM securityquestion WHERE userID = $userid ORDER BY QuestionID DESC LIMIT 1";
	$sql = mysql_query($query);
	$result = mysql_fetch_array($sql);
	$sql2 = mysql_query($query2);
	$result2 = mysql_fetch_array($sql2);
	$sql3 = mysql_query($query3);
	$result3 = mysql_fetch_array($sql3);
?>
	<?php  //include('includes/header.php'); ?>	
	<?php  //include('includes/topBarMain.php'); ?>
	<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Accurity Questions</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<style>
body{
	backgroud:#ccc;
}
#login-form{
	margin:auto;
}
#login-form fieldset{
	box-shadow:0 0 2px #ccc;
}
</style>
<body>
<div class="container">

  <div id="login-form">

    <h3>Questions</h3>
				<div class="row" style="">
				<div class="col-md-2"></div>
					<div class="col-md-8">
						<div id="questions_div" style="padding:25px 10px 10px 180px; color:#000;">
							<div class="row">
								<div class="col-sm-12" style="padding:0px 0px 10px 0px;">
								<b>You can recover your account by answering below questions</b>
								<form method="post" action="forgot_password_questions.php">
	   <div class="form-group">
		<label for="question1">1) <?php echo $result[0]; ?></label>
		<input type="text" class="form-control" name="answer1" id="answer1" placeholder="Your Answer...">
	  </div>
	  <div class="form-group">
		<label for="question1">2) <?php echo $result2[0]; ?></label>
		<input type="text" class="form-control" name="answer2" id="answer2" placeholder="Your Answer...">
	  </div>
	  <div class="form-group">
		<label for="question1">3) <?php echo $result3[0]; ?></label>
		<input type="text" class="form-control" name="answer3" id="answer3" placeholder="Your Answer...">
	  </div>
	  <div class="form-group">
		<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>" />
	  </div>
	  <input type="submit" name="forgotpasswordsubmit" class="btn btn-default" value="submit"/>
	   </form>
								</div>
							</div>
						</div>
					</div>
				<div class="col-md-2"></div>
				</div>
			</div>
		</div>
	</body>
</html>	
		<?php  //include('includes/footer.php'); ?>
<?php //} ?>