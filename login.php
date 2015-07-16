<?php 
	include('classes/Session.php');
	$session = new Session();

	$session->destroySession();
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

    <h3>Login</h3>

    <fieldset>
	<?php $errormsg = $_GET['error_message']; ?>
	<?php $passwordsuccess = $_GET['password_change']; ?>
	<?php $passwordfailure = $_GET['password_change_success']; ?>
	   <?php if($errormsg){ ?>
		   <div class="alert alert-danger">
		  <strong>Error!</strong> <?php echo $errormsg; ?>
		</div>
	   <?php 
	   }else if($passwordsuccess){ ?>
		<div class="alert alert-success">
		  <strong>Success!</strong> <?php echo $passwordsuccess; ?>
		</div>   
	   <?php }else if($passwordfailure) {?>
		<div class="alert alert-warning">
		  <strong>Warning!</strong> <?php echo $passwordfailure; ?>
		</div>
		<?php }else{} ?>
		
      <form action="login_check.php" method="post">
		
        <input type="email" required value="Email" name="email" onBlur="if(this.value=='')this.value='Email'" onFocus="if(this.value=='Email')this.value='' "> <!-- JS because of IE support; better: placeholder="Email" -->

        <input type="password" required value="Password" name="password" onBlur="if(this.value=='')this.value='Password'" onFocus="if(this.value=='Password')this.value='' "> <!-- JS because of IE support; better: placeholder="Password" -->

        <input type="submit" name="signin" value="Login">

        <footer class="clearfix">

          <p><span class="info">?</span> <a href="#" data-modal-id="popup1">Forgot Password</a></p>
 

        </footer>

      </form>

    </fieldset>

  </div> <!-- end login-form -->

</div>
   
	<div id="popup1" class="modal-box">
	  <header> <a href="#" class="js-modal-close close">×</a>
		<h3>Forgot Password</h3>
	  </header>
	  <div class="modal-body">
	   <div id="questions_div" style="">
	   <form method="post" action="forgot_password.php">
	  <div class="form-group">
		<label for="question1">Your Email</label>
		<input type="email" class="form-control" name="youremail" id="emailid" placeholder="Your Email...">
	  </div>
	  <input type="submit" name="forgotpasswordsubmit" class="btn btn-default" value="submit"/>
	   </form>
			</div>
  <footer> <a href="#" class="btn btn-small js-modal-close">Close</a> </footer>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/modal.js"></script>
</body>
</html>
