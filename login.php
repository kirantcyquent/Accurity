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
	if(isset($_SESSION['login-error'])){
		echo $_SESSION['login-error'];
		unset($_SESSION['login-error']);
    }
?>

</div>
<div class="form">
<div class="header"><h2><img class="img-responsive logo" src="css/images/main-logo.jpg" width="200" /></h2></div>
<div class="login">
<div  id="login">
<form action="login_check.php" method="post" autocomplete="off">
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
<div class="need">@ 2015 Accurity </div>
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
		var data = '<h4>Recover Password</h4><form action="forgot_password.php" method="post" onsubmit="return validate();" autocomplete="off"><ul><li><span class="un"><i class="fa fa-key"></i></span><input id="forgot_email" type="email" name="email" required class="text" placeholder="Enter your registered email to recover password" onblur="check_email(this.value);" autofocus/></li><div id="fmail"></div><input type="submit" value="Recover" class="btn-small"> &nbsp; &nbsp;<input type="button" onclick="revert();" value="Cancel" class="btn-small"></ul></form><br/><br/>';
		$('#forgot').html(data);
		$('#login').html('');
	});


});  

function revert(){
location = "login.php";
}


	function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
	}
	
	function check_email(email) {		
		var strURL = "check_forgot_mail.php?mail="+email;

		var req = getXMLHTTP();
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('fmail').innerHTML=req.responseText;	
					} else {
						//alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					} 
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}				
	}
 
	function validate(){
		var fmail = $('#fmail').html();
		if(fmail.length>0){
			return false;
		}
		return true;
	}
</script>  

</body>
</html>