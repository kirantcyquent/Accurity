<?php 
	session_start();
	if(!isset($_SESSION['forgot-user'])){
		header('Location: login.php');
	}
	$userid = $_SESSION['forgot-user'];
	$_SESSION['userid'] =$userid;

	include('db/db.php');
	
	$query = "SELECT Question FROM securityquestion WHERE userID = $userid";
	$query2 = "SELECT Question FROM securityquestion WHERE userID = $userid ORDER BY QuestionID DESC LIMIT 1, 1";
	$query3 = "SELECT Question FROM securityquestion WHERE userID = $userid ORDER BY QuestionID DESC LIMIT 1";
	$sql = mysql_query($query);
	$result = mysql_fetch_array($sql)or die(mysql_error());
	$sql2 = mysql_query($query2);
	$result2 = mysql_fetch_array($sql2);
	$sql3 = mysql_query($query3);
	$result3 = mysql_fetch_array($sql3);

?>
<!DOCTYPE html>
<html lang="en-us">
<meta charset="utf-8" />
<head>
<title>Accurity Valuation</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" sizes="16x16" href="css/images/favicon-32x32.png">
<link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="form">
<div class="header"><h2><img class="img-responsive logo" src="css/images/main-logo.jpg" width="200" /></h2></div>
<div class="login">
<div  id="login" style="height:auto; min-height:400px;">
<h4>Recover your account by answering questions below</h4> 
<br>
<?php if(isset($_SESSION['recover-error'])){ echo $_SESSION['recover-error'];  unset($_SESSION['recover-error']);} ?>
<form method="post" action="forgot_password_questions.php" autocomplete="off">
<ul>
<li><p>1. <?php echo $result[0]; ?></p>
<span class="un"><i class="fa fa-edit"></i></span><input type="text" name="answer1" id="answer1" required class="text" placeholder="Your Answer" autofocus/>
</li>

<li><br/><p>2. <?php echo $result2[0]; ?></p>
<span class="un"><i class="fa fa-edit"></i></span><input type="text" name="answer2" id="answer2" required class="text" placeholder="Your Answer"></li>


<li><br/><br/><p>3. <?php echo $result3[0]; ?></p>
<span class="un"><i class="fa fa-edit"></i></span><input type="text" name="answer3" id="answer3" required class="text" placeholder="Your Answer"></li>
<br/><br/><br/>
<li>
		<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>" />
<input type="submit" name="forgotpasswordsubmit" value="Send" class="btn-small-p"> 
<input type="button" onclick="revert();" value="Cancel" class="btn-small-p">
</li>
	   </form>

</div>

</div>

<div class="sign">
<div class="need">@ 2013 Accurity </div>
<div class="up">Absolute Web Services</div>
</div>
</div>
<br/><br/>
<script src="http://code.jquery.com/jquery-latest.js"></script>  
<script>

function revert(){
location = "login.php";
}

</script>
</body>
</html>