<?php session_start(); ?>
<!DOCTYPE html>
<?php session_start(); 
$sessiondata = $_SESSION['email'];
?>
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

	<!--- Header Section-->
	<div class="container-fluid logo-section">
		<div class="row">		
			<div class="pull-left header-left"> 
				<img class="img-responsive logo" src="css/images/main-logo.jpg" />
			</div>
			<div class="pull-right header-right"> 
				<div class="pull-right welcome-block">
					<h6>Welcome demo@cyquent.com | <a href="">Login</a></h6>
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

	<!-- R3 Report -->
	<div class="container-fluid">
		<div class="row report-r3">
			<div class="col-lg-1 col-sm-1 col-xs-1">
			</div>
			<div class="col-lg-10 col-sm-10 col-xs-10">			
				<div class="row">
					<div class="col-sm-3 col-xs-12 col-lg-2" id="reportSubDiv">
						<div id="report" class="report">
							R3 Report
						</div>	
					</div>
					<div class="col-sm-9 col-xs-12 col-lg-9">					
					</div>
				</div>
			</div>
			<div class="col-lg-1 col-sm-1 col-xs-1">
			</div>
		</div>
	</div>
	<!-- R3 Report -->

	<div class="clearfix"></div>

	<!-- Page Content -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-1 col-sm-1 col-xs-1">
			</div>
			<div class="col-lg-10 col-sm-10 col-xs-10">			
				<div class="row">
					<div class="col-sm-3 col-xs-12 col-lg-2">
						<ul class="nav nav-pills nav-stacked" style="line-height:5px; list-style-type:circle; font-weight:bold; width:100%;">
							<li class="active"><a href="#" id="index">Homepage</a></li>
							<li><a href="#" id="refineSearch">Refine Search</a></li>
							<li><a href="#" id="results">Results</a></li>
							<li><a href="#" id="report">Report</a></li>
							<li><a href="#" id="appraiselReview">Review</a></li>
						</ul>	
					</div>
					<div class="col-sm-9 col-xs-12 col-lg-9">
					
							<!-- Search Page-->
							<div id="search_form">
								<span class="heading-text">Begin your search here</span>
									<form role="form">
										<div class="form-group" style="padding:5px 0px 0px 0px;">
											<input type="text" style="width:50%; height:30px;" id="searchAddress" name="searchAddress" value="" placeholder="Search Address or Assessor Parcel " autofocus required/>	
											
											<button type="button" value="search" class="btn btn-success" id="searchBtn" name="searchdata" style="margin-bottom:3px;">Search</button>
											<br/><span >(* provide address in STREET CITY STATE ZIP format)</span>
										</div>

										<div id="error" class="form-group" style="padding:5px 0px 0px 0px;">									
										</div>	
									</form>		
							</div>
							<!-- Search Page Ends -->


							<!-- RefineSearch -->
							<a href="javascript: return false;" class="button back black"><span></span>Back</a>
							<h4>121 MARIE ST NASHVILLE TN 37207</h4>
							<div class="row">
								<table class="table table-borderless">
									<thead>
										<th>Attribute</th>
										<th>Public Record Results</th>
										<th>Adjustments</th>
									</thead>
									<tbody>
										<tr>
											<td>Measured Square Footage *</td>
											<td>1763</td>
											<td class="style-4"> <input type="text" placeholder="" value="1763" class="focus"></td>
										</tr>
										<tr>
											<td>Bedrooms</td>
											<td>3</td>
											<td></td>
										</tr>
										<tr>
											<td>Bathrooms</td>
											<td>2</td>
											<td></td>
										</tr>
										<tr>
											<td>Year Built</td>
											<td>1989</td>
											<td></td>
										</tr>
										<tr>
											<td>Lot Size</td>
											<td>16988.00</td>
											<td></td>
										</tr>
										<tr>
											<td>Stories</td>
											<td>1</td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>	
							<!-- RefineSearch -->
						</div>
					</div>
				</div>
				<div class="col-lg-1 col-sm-1 col-xs-1">
				</div>
		</div>
	</div>
	<!-- Page Content -->


	<div class="clearfix"></div>

	<!-- Valuation Strip -->
	<div class="container-fluid">
		<div class="row" id="valuation-logo">
			<div class="pull-right" style="margin-right:4%;"><img class="img-responsive logo" src="css/images/accurity.jpg" /></div>
		</div>
	</div>
	<!-- Valuation Strip -->


	<footer class="footer">
		<div style="margin-left:4%; margin-right:4%;">
			<div class="container-fluid" >
				<div class="row footer-row">
					<div class="col-sm-3 col-md-6 col-lg-2">
						<h5>ABOUT US</h5>
						<ul class="footer-list">
							<li>Regulatory Compliance
								<ul class="subfooter-list">
									<li>FHA/Dodd-Frank</li>
									<li>Compliance</li>
									<li>UAD Compliances</li>
								</ul>
							</li>
							<li>Press Releases</li>
							<li>In the News</li>
							<li>Events</li>
						</ul>
					</div>
					<div class="col-sm-3 col-md-6 col-lg-2">
						<h5>SPECIALTY PRACTICES</h5>
						<ul class="footer-list">
							<li>Forensic Reviews</li>
							<li>Litigation Assistance</li>
							<li>Consulting Services</li>
							<li>Light Commercial</li>
						</ul>
					</div>
					<div class="col-sm-3 col-md-6 col-lg-2">
						<h5>APPRAISAL SERVICES</h5>
						<ul class="footer-list">
							<li>Mortgage Origination</li>
							<li>Appraisals</li>
							<li>REO Appraisals/Default</li>
							<li>Valuation</li>
							<li>Relocation Appraisals</li>
							<li>Alternative Valuations</li>
						</ul>
					</div>
					<div class="col-sm-3 col-md-6 col-lg-2">
						<h5>JOIN US</h5>
						<ul class="footer-list">
						<li>Frachies &amp; Membership</li>
							<li>Opportunities</li>
							<li>Frachies Opportunities</li>
							<li>Individual Membership</li>
							<li>Opportunities</li>
							<li>Opportunity Inquiry Form</li>
							<li>Accurity Presentation</li>
						</ul>
					</div>
					<div class="col-sm-3 col-md-6 col-lg-2">
						<h5>RESOURCES</h5>
						<ul class="footer-list">
							<li>Member Discount Benifits</li>
							<li>Valuation Tools</li>
							<li>Webinars</li>
						</ul>
					</div>
					<div class="col-sm-3 col-md-6 col-lg-2">
						<h5>CONTACT US</h5>
						<ul class="footer-list">
							<li>Employment Opportunities</li>
							<li>Cancellation and Refund</li>
							<li>Policy</li>
							<li>Membership Application</li>
						</ul>
					</div>
				</div>	
			</div>
		</div>
		
		<div class="clearfix"></div>
			
		<div class="row" style="padding-bottom:10px;">
			<div class="pull-left" style="margin-left:4%; color:#E8E8E8;">@ 2013 Accurity </div>
			<div class="pull-right" style="margin-right:4%;color:#E8E8E8;">Web Design by Absolute Web Services</div>
		</div>
	</footer>	
	</body>
</html>
