<?php 
session_start();
if(!isset($_SESSION['userid'])){
	header('Location: login.php');
}
$userid = $_SESSION['userid'];
$_SESSION['user_id'] =$userid;

if(!(isset($_SESSION['success']) && $_SESSION['user_id'])){
	header ("location: login.php");
}
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
<div  id="login">
<form action="change_password_process.php" method="post" onsubmit="return checkForm(this);" autocomplete="off">
<ul>
<li>
<span class="un"><i class="fa fa-lock"></i></span><input type="password"  required class="text" placeholder="New Password" name="pwd1" autofocus/></li>
<li>
<span class="un"><i class="fa fa-lock"></i></span><input type="password" name="pwd2" required class="text" placeholder="Confirm Password"/>
<div id="passErr"></div>
</li>
<br/>		
<li>
 <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
<input type="submit" value="Change Password" class="btn">
</li>
</ul>
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
$(document).ready(function(){  
setTimeout(function() {  
$('.message').fadeOut('fast');  
}, 6000); // <-- time in milliseconds  



});  

function revert(){
location = "login.php";
}


  function checkForm(form)
  {

	        $('#passErr').html("");
    if(form.pwd1.value != "" && form.pwd1.value == form.pwd2.value) {
      if(form.pwd1.value.length < 6) {
        $('#passErr').html("Error: Password must contain at least six characters!");
        form.pwd1.focus();
        return false;
      }
      if(form.pwd1.value == form.username.value) {
         $('#passErr').html("Error: Password must be different from Username!");
        form.pwd1.focus();
        return false;
      }
      re = /[0-9]/;
      if(!re.test(form.pwd1.value)) {
         $('#passErr').html("Error: password must contain at least one number (0-9)!");
        form.pwd1.focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(form.pwd1.value)) {
         $('#passErr').html("Error: password must contain at least one lowercase letter (a-z)!");
        form.pwd1.focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(form.pwd1.value)) {
         $('#passErr').html("Error: password must contain at least one uppercase letter (A-Z)!");
        form.pwd1.focus();
        return false;
      }
    } else {
       $('#passErr').html("Error: Please check that you've entered and confirmed your password!");
      form.pwd1.focus();
      return false;
    }

//    alert("You entered a valid password: " + form.pwd1.value);
    return true;
  }
</script>

</body>
</html>
