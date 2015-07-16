<?php
session_start();
include('db/db.php');
$id = $_GET['id'];
$result = mysql_fetch_array(mysql_query("select * from savesearch where SearchID='$id'"));
$set = unserialize($result['Param']);
echo "<pre>";

$_SESSION = $set;

if(isset($_SESSION['refineSearch']) && count($_SESSION['refineSearch'])>0){
	$_SESSION['resumeSearch']='refineSearch';
}else if(isset($_SESSION['search']) && count($_SESSION['search'])>0){
	$_SESSION['resumeSearch']='search';
}
header('Location: index.php');
?>