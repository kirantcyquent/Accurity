<?php
	session_start();
	include('db/db.php');
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}
	include('classes/User.php');
	$user_type=$_SESSION['user_type'];
	$x = "cpassword";
	$us = new User();
	if(isset($_POST['currentpass']) && isset($_POST['newpass']) && isset($_POST['confirmpass'])){
		$current = mysql_real_escape_string(@$_POST['currentpass']);
		$newpassword = mysql_real_escape_string(@$_POST['newpass']);
		$confirm = mysql_real_escape_string(@$_POST['confirmpass']);
		$userid = $_SESSION['userid'];
		$query = "UPDATE userdetail SET password='$confirm' WHERE UserID='$userid'";
		$update = mysql_query($query)or die(mysql_error());
		if($update){
			$_SESSION['change_success']='<div class="alert alert-success">
		 	 <strong>Password Changed Successfully.</strong>
			</div>';
		}
	}
?>

<style>
#wrapper {
	width:60%;
  border: 1px #e4e4e4 solid;
  padding: 20px;
  border-radius: 4px;
  box-shadow: 0 0 6px #ccc;
  background-color: #fff;
  padding-top:5px;
  padding-bottom:5px;
}
</style>
<?php  include('includes/header.php'); ?>	
<?php  include('includes/topBar.php'); ?>
	<div class="row" id="sideMenuDiv">
		<?php  
		if($user_type==3)
			include('includes/lendingMenu.php'); 
		else
			include('includes/adminMenu.php');
	?>	
		<div class="col-sm-10">
			<br><br>
			<div id="wrapper">
			<h4>Change Password</h4>
			<?php
			if(isset($_SESSION['change_success'])){
				echo $_SESSION['change_success'];
				unset($_SESSION['change_success']);
			}
			?>
			<form action="changepassword.php" method="post" onsubmit="return validateForm();">
			<div class="row">
			<div class="col-sm-12" >
			<div style="margin-left:3%;">
  <div class="form-group">
    <label for="exampleInputEmail1">Current Password *</label>
    <input type="password" class="form-control" name="currentpass" id="currentpass" pattern="[a-zA-Z0-9\.\@\_]+" placeholder="Current Password" minlength="4" onblur="return check_password(this.value);" required>
    <br><span id="pass"></span>
  </div>
  
  <div class="form-group">
    <label for="exampleInputEmail1">New Password *</label>
    <input type="password" class="form-control" name="newpass" id="newpass" pattern="[a-zA-Z0-9\.\@\_]+" placeholder="New Password" minlength="4" required>    
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Confirm Password *</label>
    <input type="password" class="form-control" name="confirmpass" id="confirmpass" pattern="[a-zA-Z0-9\.\@\_]+" placeholder="Repeat Password" minlength="4" onblur="match_password(this.value);" required>    
    <br><span id="match" style="color:red;"></span>
  </div>

  	<div style="margin-left:1%;"><button type="submit" class="btn btn-success"> Change Password </button></div>

</div>
</div>
</div>
  </form>

  	</div>	
  	<br><br>
	</div>

</div>
<script type="text/javascript">
$(document).ready(function() {
  
});


function match_password(confirm){
	var newpass = $('#newpass').val();
	var confirmpass = $('#confirmpass').val();

	if(newpass!=confirmpass){
		$('#match').html("Please match new password and confirm password");
	}else{
		$('#match').html("");		
	}
}
function check_password(password){
	var pass = $("#currentpass").val();
	if(pass.length > 2){
		$('#Loading').show();
		$.post("check_password.php", {
			pass: $('#currentpass').val(),
		}, function(response){
			$('#pass').fadeOut();
			 $('#Loading').hide();
			setTimeout("finishAjax('pass', '"+escape(response)+"')", 450);
		});
		return false;
	}
}

function finishAjax(id, response){
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn(1000);
} 


function validateForm(){
	var pass = $("#pass").html();
	if(pass!=""){
		return false;
	}
	var match = $("#match").html();
	if(match!=""){
		return false;
	}
	return true;
}
</script>
<?php  include('includes/footer.php'); ?>