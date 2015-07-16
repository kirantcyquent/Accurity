<?php
if(session_id() == '' && !session_start()) {
session_start();
}
include('db/db.php');
//if(isset($_REQUEST['page']) && isset($_REQUEST['searchAddress']) )
//$_SESSION[$_REQUEST['page']] = $_REQUEST['val'];
$_SESSION[$_REQUEST['set_page']] =$_REQUEST;


//echo "<pre>*************************************";
//print_r($_REQUEST);

//echo "*********************************<br>";


if($_GET['page']=='index') {	
include("search.php");
}
 
if($_GET['page']=='refineSearch') {
include('refineSearch.php');
}

if($_GET['page']=='results') {	
include('results.php');
}
if($_GET['page']=='riskReview') {
include('riskReview.php');
}
if($_GET['page']=='dataQuality') {
include('dataQuality.php');
}
if($_GET['page']=='adjustments') {
include('adjustments.php');
}
if($_GET['page']=='report') {
include('report.php');
}
if($_GET['page']=='litigationDefense') {
include('litigationDefense.php');
}
if($_GET['page']=='appraiselReview') {
include('appraiselReview.php');
}
?>

