<?php
if($_GET['page']=='listUsers') {
include('listUsers.php');
}
if($_GET['page']=='createUser') {
include('usersForm.php');
}
if($_GET['page']=='viewUser') {
include('viewUsers.php');
}
?>