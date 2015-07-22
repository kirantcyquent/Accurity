<?php
include('db/db.php');
$mail = $_REQUEST['mail'];

$check = mysql_query("select * from userdetail where UserName='$mail'");
if(mysql_num_rows($check)>0){
	echo '<font color="red">E-mail id already exists!!</font>';
}else{
	echo '';
}
?>