<?php 
session_start();
$userid = $_GET['user_id'];
	$_SESSION['user_id'] =$userid;
if(!(isset($_SESSION['success']) && $_SESSION['user_id'])){
	header ("location: login.php");
 /*$_GET['user_id'] = $session;
session_start();*/
/*if (!(isset($_SESSION['email']) && $_SESSION['email'] == true)) {
    header ("location: login.php");*/
} else { 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Accurity Login</title>
 <link rel="stylesheet" href="css/login/style.css">
 <link rel="stylesheet" href="css/login/modal.css"> 
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

    <h3>Change Password</h3>

    <fieldset>
	<?php //$errormsg = $_GET['error_message']; ?>
		<!--<div class="alert alert-danger" role="alert">
	  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  <span class="sr-only">Error:</span>
	   <?php //echo $errormsg; } ?>
	   </div>-->
	  
      <form action="change_password_process.php" method="post" onsubmit="return checkForm(this);">
		
        <input type="password" required value="" placeholder="Enter New Password" name="pwd1" onBlur="if(this.value=='')this.value='Password'" onFocus="if(this.value=='Password')this.value='' "> <!-- JS because of IE support; better: placeholder="Password" -->

		<input type="password" required value="" placeholder="ReEnter New Password" name="pwd2" onBlur="if(this.value=='')this.value='Password'" onFocus="if(this.value=='Password')this.value='' "> <!-- JS because of IE support; better: placeholder="Password" -->
        
		<input type="hidden" name="userid" value="<?php echo $userid; ?>" />
		
		<input type="submit" name="change-password" value="Change Password">

        <footer class="clearfix">
		
        </footer>

      </form>

    </fieldset>

  </div> <!-- end login-form -->

</div>
<?php } ?>
<script type="text/javascript">

  function checkForm(form)
  {

    if(form.pwd1.value != "" && form.pwd1.value == form.pwd2.value) {
      if(form.pwd1.value.length < 6) {
        alert("Error: Password must contain at least six characters!");
        form.pwd1.focus();
        return false;
      }
      if(form.pwd1.value == form.username.value) {
        alert("Error: Password must be different from Username!");
        form.pwd1.focus();
        return false;
      }
      re = /[0-9]/;
      if(!re.test(form.pwd1.value)) {
        alert("Error: password must contain at least one number (0-9)!");
        form.pwd1.focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(form.pwd1.value)) {
        alert("Error: password must contain at least one lowercase letter (a-z)!");
        form.pwd1.focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(form.pwd1.value)) {
        alert("Error: password must contain at least one uppercase letter (A-Z)!");
        form.pwd1.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.pwd1.focus();
      return false;
    }

    alert("You entered a valid password: " + form.pwd1.value);
    return true;
  }
</script>
</body>
</html>
