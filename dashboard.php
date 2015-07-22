<?php
	session_start();
	$user_type=$_SESSION['user_type'];
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid']) || $user_type!=0){
		header('Location: login.php');
	}
	
?>
<?php  include('includes/header.php'); ?>	
<?php  include('includes/topBar.php'); ?>
	<div class="row" id="sideMenuDiv">
		<?php  include('includes/adminMenu.php'); ?>	
		<div class="col-sm-10" id="pageContent">
			
		</div>	
	</div>
</div>
<?php  include('includes/footer.php'); ?>
