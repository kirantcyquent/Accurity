<?php session_start();$sessiondata = $_SESSION['email'];?>
<html lang="en">
	<head>
		<title>Accurity Valuation</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href='http://fonts.googleapis.com/css?family=Fjord+One' rel='stylesheet' type='text/css'>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">		
		<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" media="all and (device-width: 768px) and (device-height: 1024px) and (orientation:portrait)" href="ipad-portrait.css" />
		<link rel="stylesheet" media="all and (device-width: 768px) and (device-height: 1024px) and (orientation:landscape)" href="ipad-landscape.css" />
		<link rel="stylesheet" href="css/accurity.css">		
		<script src="js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.js"></script>	
		<script id="loader" src="js/script.js" type="text/javascript"></script>
		<link rel="icon" type="image/png" sizes="16x16" href="css/images/favicon-32x32.png">
	</head>
	<body>
	<div class="box3" id="box3">


	<!--- Header Section-->
	<div class="container-fluid logo-section">
		<div class="row">		
			<div class="pull-left header-left"> 
				<a href="index.php"><img class="img-responsive logo" src="css/images/main-logo.jpg" /></a>
			</div>
			<div class="pull-right header-right"> 
				<div class="pull-right welcome-block">
					<h6>Welcome <a href="profile.php"><?php echo $sessiondata; ?></a> | 			
					<?php if (!(isset($_SESSION['email']) && $_SESSION['email'] == true)) { ?>
						<a href="index.php" target="_blank">Login</a>
					<?php }else if (isset($_SESSION['email']) && $_SESSION['email'] == true) { ?>
					<a href="logout_test.php">Logout</a>
					<?php }  ?>
					</h6>
					<p>Call Us: <span class="support-call">913.261.1800</span></p>
					<span class="label label-info" id="member-badge">Accurity Membership Presentation</span>
				</div>
			</div>
		</div>	
	</div>
	<!-- Header Ends -->
	
	<!-- Header Menus -->
	<div class="container-fluid">
		<div class="clearfix"></div>
		<div class="row navigation-row">
			<div class="col-sm-12 col-md-2 col-lg-2">
			</div>
			<div class="col-sm-12 col-md-10 col-lg-10">
				<nav class="navbar navbar-default">
				  <div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">					  
					  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>		
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					  <ul class="nav navbar-nav">
							<li><a href="#">Home</a></li>
							<li><a href="#">About Us</a></li>
							<li><a href="#">Client-Appraiser Access</a></li>
							<li><a href="#">Specialty Practices</a></li>
							<li><a href="#">Appraisal Services</a></li>
							<li><a href="#">Join Us</a></li>
							<li style="border-right:0px;"><a href="#">Contact Us</a></li>
						</ul>	 
					</div><!-- /.navbar-collapse -->
				  </div><!-- /.container-fluid -->
				</nav>
			</div>
  		</div>
	</div>
	<!-- Header Menus End -->