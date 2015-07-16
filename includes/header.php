<!DOCTYPE html>
<?php session_start(); 
$sessiondata = $_SESSION['email'];
//echo 'Welcome, '.$sessiondata;
?>
<html lang="en">
	<head>
		<title>Accurity Valuation</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="./css/bootstrap.css">
		<!--<link rel="stylesheet" href="./css/bootstrap.min.css">-->
		<!-- Optional theme -->
		<link rel="stylesheet" href="css/bootstrap-theme.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" media="all and (device-width: 768px) and (device-height: 1024px) and (orientation:portrait)" href="ipad-portrait.css" />
<link rel="stylesheet" media="all and (device-width: 768px) and (device-height: 1024px) and (orientation:landscape)" href="ipad-landscape.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>	
		<style type="text/css">
		.textDiv li,.acc_list li { padding:12px 0px 0px 0px; color:#272727; }
		.small { padding-left:5px; }
		.table { color:#000; font-size:11px; }
		.select { width:108px; }
		label{
    display: block;
    padding-left: 15px;
    text-indent: -15px;
}
.input-checkbox {
    width: 13px;
    height: 13px;
    padding: 0;
    margin:0;
    vertical-align: bottom;
    position: relative;
    top: -1px;
    *overflow: hidden;
}
		footer { background-image:url('css/images/footer-bg.jpg'); }
		</style>
		<script id="loader" src="./js/script.js" type="text/javascript"></script>
	</head>
	<body>
	<div class="box3" id="box3">
	<div class="container" style="width:100%;">
		<div class="row" id="header_logo">
			<div class="col-lg-4 col-md-4">
				<a href="index.php"><img src="./css/images/main_logo.jpg" class="img-responsive" alt="Logo" id="main_logo" style="padding-left:0px;"> 		</a>
			</div>
			<div class="col-lg-8 col-md-8" style="text-align:right; padding:5% 10% 0% 0%;">	
				<span class="pull-right" style="">
					<?php if (!(isset($_SESSION['email']) && $_SESSION['email'] == true)) { ?>
					<a href="admin/index.php" target="_blank">Login</a>
					<?php } ?>
					</span>
					<span style="padding-right:3px; font-weight:bold;">Welcome 
					<a href="profile.php"><?php echo $sessiondata; ?></a> | <?php if (isset($_SESSION['email']) && $_SESSION['email'] == true) { ?><a href="logout_test.php">Logout</a><?php } ?></span>
				<div style="padding:5px 0px 5px 5px; color:#000;">
					<span style="font-size:14px;">Call Us:</span>
					<span style="font-size:18px; font-weight:bold;">913.261.1800</span>
				</div>
					<span class="label label-info" style="padding:5px 5px 5px 5px;">Accurity Membership Presentation</span>		
			</div>
		</div>
		<div class="row" style="margin-bottom:10px;">
			<div class="col-lg-2 col-md-2"></div>
			<div class="col-lg-10 col-md-10" id="topMenu">
				<ul class="nav navbar-nav" style="font-weight:bold; font-size:12px;">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#">About Us</a></li>
					<li><a href="#">Client-Appraiser Access</a></li>
					<li><a href="#">Specialty Practices</a></li>
					<li><a href="#">Appraisal Services</a></li>
					<li><a href="#">Join Us</a></li>
					<li style="border-right:0px;"><a href="#">Contact Us</a></li>
				</ul>
			</div>
		</div>
		<div class="content">
		