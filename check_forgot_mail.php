<?php
include('db/db.php');
$mail = $_REQUEST['mail'];

$check = mysql_query("select * from userdetail where UserName='$mail'");
if(mysql_num_rows($check)>0){
}else{
	echo 'This e-mail id is not registered.<br/><br/>';
}
?>
