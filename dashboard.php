<?php
	session_start();
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}
	
	$user_type=$_SESSION['user_type'];
?>
<?php  include('includes/header.php'); ?>	
<?php  include('includes/topBar.php'); ?>
	<div class="row" id="sideMenuDiv">
		<?php  include('includes/lendingMenu.php'); ?>	
		<div class="col-sm-10" id="pageContent">
			<?php  echo "welcome ".$_SESSION['email'];?>
		</div>	
	</div>
</div>
<?php  include('includes/footer.php'); ?>
