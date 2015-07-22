<?php
	session_start();
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}
	include('classes/User.php');
	$user_type=$_SESSION['user_type'];
	$x = "addins";
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
		<?php  include('includes/adminMenu.php'); ?>	
		<div class="col-sm-10">
			<br><br>
			<div id="wrapper">
			<h4>Add New User</h4>
			<form action="addinstitute.php" method="post" onsubmit="return validateForm();">
			<div class="row">
			<div class="col-sm-12" >
			<div style="margin-left:3%;">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" name="email" id="email" placeholder="Email" onblur="return check_email(this.value);" required>
    <br><span id="mail"></span>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="text" class="form-control" name="password" id="exampleInputPassword1" value="<?php echo rand(1111,9999);?>" pattern="[a-zA-Z0-9\.\@\_]+" placeholder="Password" minlength="4" required>
  </div>
<div class="form-group">
    <label for="exampleInputEmail1">User's Name</label>
    <input type="text" class="form-control" id="" name="name" placeholder="User Name" required>
  </div>  
  
 

<div class="form-group">
		<label for="exampleInputEmail1">Address</label>
		<input type="text" class="form-control" id="" name="address" placeholder="Address" required>
	</div>  
  
		
	<div class="form-group">
		<label for="exampleInputEmail1">Status</label>
		<select class="form-control" name="status">
			<option value="1">Active</option>
			<option value="0">Inactive</option>
		</select>
	</div>  

	
	<div style="margin-left:1%;"><button type="submit" class="btn btn-success"> Add User </button></div>

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

function check_email(mail){
	var mail = $("#email").val();
	if(mail.length > 2){
		$('#Loading').show();
		$.post("check_email.php", {
			mail: $('#email').val(),
		}, function(response){
			$('#mail').fadeOut();
			 $('#Loading').hide();
			setTimeout("finishAjax('mail', '"+escape(response)+"')", 450);
		});
		return false;
	}
}

function finishAjax(id, response){
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn(1000);
} 


function validateForm(){
	var mail = $("#mail").html();
	if(mail!=""){
		return false;
	}
	return true;
}
</script>
<?php  include('includes/footer.php'); ?>