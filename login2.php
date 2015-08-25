<?php 
	include('classes/Session.php');
	$session = new Session();
	$session->destroySession();
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

<div class="msg">
<?php 
	if(isset($_SESSION['login_message'])){
?>
<div class="info message">
 <h3>FYI, something just happened!</h3>
 <p>This is just an info notification message.</p>
</div>
<?php  }?>

</div>
<div class="form">
<div class="header"><h2><img class="img-responsive logo" src="css/images/main-logo.jpg" width="200" /></h2></div>
<div class="login">
<div  id="login">
<form action="login_check.php" method="post">
<ul>
<li>
<span class="un"><i class="fa fa-user"></i></span><input type="email" name="email" required class="text" placeholder="User Name Or Email" autofocus/></li>
<li>
<span class="un"><i class="fa fa-lock"></i></span><input type="password" name="password" required class="text" placeholder="User Password"/></li>
<li>
<input type="submit" value="LOGIN" class="btn">
</li>
<li><div class="span"><span class="ch"><input type="checkbox" id="r"> <label for="r">Remember Me</label> </span> <span class="ch"><a id="fpass">Forgot Password?</a></span></div></li>
</ul>
</form>
</div>

<div id="forgot"></div>

</div>
<div class="sign">
<div class="need">@ 2013 Accurity </div>
<div class="up">Absolute Web Services</div>
</div>
</div>
<br/><br/>
<script src="http://code.jquery.com/jquery-latest.js"></script>  
<script>  
$(document).ready(function(){  
setTimeout(function() {  
$('.message').fadeOut('fast');  
}, 6000); // <-- time in milliseconds  

	$('#fpass').click(function() { 
		var data = '<h4>Recover Password</h4><form action="forgot.php" method="post"><ul><li><span class="un"><i class="fa fa-key"></i></span><input type="email" name="email" required class="text" placeholder="Enter your registered email to recover password" autofocus/></li><input type="submit" value="Recover" class="btn-small"> &nbsp; &nbsp;<input type="button" onclick="revert();" value="Cancel" class="btn-small"></ul></form><br/>';
		$('#forgot').html(data);
		$('#login').html('');
	});
			

});  

function revert(){
location = "login2.php";
}
</script>  

</body>
</html>