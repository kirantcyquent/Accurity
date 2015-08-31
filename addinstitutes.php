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
			<br/>
			<?php
			if(isset($_SESSION['status_success'])){
				echo $_SESSION['status_success'];
				unset($_SESSION['status_success']);
			}
			?>
			<br/>
			<form action="addinstitute.php" method="post" onsubmit="return validateForm();">
				<fieldset>

						<legend><h4>Add New User</h4></legend>
				</fieldset>	
			<div class="row">
			<div class="col-sm-12" >
			<div style="margin-left:3%;">
				 <div class="form-group">
    <label for="exampleInputEmail1">Company Name</label>
    <input type="text" class="form-control input-sm" name="company_name" id="company_name" placeholder="Company Name" value="<?php if(isset($_SESSION['add']['company_name'])){ echo $_SESSION['add']['company_name']; unset($_SESSION['add']['company_name']);}?>" required>
    
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control input-sm" name="email" id="email" placeholder="Email" value="<?php if(isset($_SESSION['add']['email'])){ echo $_SESSION['add']['email']; }?>" <?php if(isset($_SESSION['add']['email'])){ echo "autofocus";}?>  onblur="return check_email(this.value);" required>
    <br><span id="mail"><?php 
    if(isset($_SESSION['add']['email'])){
    	echo "E-mail already exists.";
    	unset($_SESSION['add']['email']);
    }
    ?></span>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="text" class="form-control input-sm" name="password" id="exampleInputPassword1" value="<?php echo rand(1111,9999);?>" pattern="[a-zA-Z0-9\.\@\_]+" value="<?php if(isset($_SESSION['add']['password'])){ echo $_SESSION['add']['password']; unset($_SESSION['add']['password']);}?>" placeholder="Password" minlength="4" required>
  </div>
<div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control input-sm" id="" name="name" value="<?php if(isset($_SESSION['add']['name'])){ echo $_SESSION['add']['name']; unset($_SESSION['add']['name']);}?>" placeholder="User Name" required>
  </div>  
  
 

	<div class="form-group">
		<label for="exampleInputEmail1">Address</label>
		<textarea class="form-control" id="" name="address" placeholder="Address" required><?php if(isset($_SESSION['add']['address'])){ echo $_SESSION['add']['address']; unset($_SESSION['add']['company_name']);}?></textarea>
	</div>  
  	
  	<div class="form-group">
		<label for="exampleInputEmail1">City / State / Zip</label>
		<input type="text" class="input-sm" id="" name="city" value="<?php if(isset($_SESSION['add']['city'])){ echo $_SESSION['add']['city']; unset($_SESSION['add']['city']);}?>" placeholder="City" required>

		<input type="text" class="input-sm" id="" name="state" placeholder="State" value="<?php if(isset($_SESSION['add']['state'])){ echo $_SESSION['add']['state']; unset($_SESSION['add']['state']);}?>" required>

		<input type="text" class="input-sm" id="" name="zip" placeholder="Zip" value="<?php if(isset($_SESSION['add']['zip'])){ echo $_SESSION['add']['zip']; unset($_SESSION['add']['zip']);}?>" pattern="^[0-9]+" required>
	</div>  
	
	<div class="form-group">
		<label for="exampleInputEmail1">Status</label>
		<select class="form-control input-sm" name="status">
			<option value="1">Active</option>
			<option value="0">Inactive</option>
		</select>
	</div>  

	
	<div style="margin-left:1%;">
		<button type="submit" id="bt" class="btn btn-success" onclick="checkForm();"> Add User </button>
	</div>

</div>
</div>
</div>
  </form>

  	</div>	
  	<br><br>
	</div>

</div>
<script type="text/javascript">

function checkForm(){
	
	if(validateForm()=="true"){
		document.getElementById('bt').disabled=true; 
		form.submit();
	}
}
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