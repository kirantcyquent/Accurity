<?php 
session_start();
//$result[0] = $_SESSION['email'];
$sessiondata = $_SESSION['email'];
echo 'Welcome, '.$sessiondata;
/*if (isset($_SESSION['email'])) {
   echo 'Welcome, '.$_SESSION['email']; 
} else {
echo 'Sorry, You are not logged in.';
}*/

?>
<style>
.logout{
	float:right;
	margin:20px;
}
</style>
<div class="logout">
<a href="logout_test.php">Logout</a>
</div>