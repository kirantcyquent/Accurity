<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Accurity Valuation</title>
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="css/bootstrap.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
	
</head>

<body>
		<!-- start: Header -->
<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				
				<img src="../css/images/main_logo.jpg" class="img-responsive" alt="Logo" id="main_logo" style="padding-left:0px;"> 
		
		<div style="padding:50px 0px 10px 0px; float:right;">
		<span style="font-size:14px;">Call Us:</span> <span style="font-size:18px; font-weight:bold;">913.261.1800</span>
		<br/><span class="label label-info" style="padding:5px 5px 5px 5px;">Accurity Membership Presentation</span>
		</div>						
				<!-- start: Header Menu -->
			<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">									
						<!-- start: User Dropdown -->
						<li class="dropdown" style="background:#60226b;">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="halflings-icon white user"></i> Ganavi J
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li class="dropdown-menu-title">
 									<span>Account Settings</span>
								</li>
								<li><a href="#" id="viewUser"><i class="halflings-icon user"></i> Profile</a></li>
								<li><a href="index.php"><i class="halflings-icon off"></i> Logout</a></li>
							</ul>
						</li>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
	<!-- start: Header -->
		<div class="container-fluid-full">
		<div class="row-fluid">
				
			<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2">
				<div class="nav-collapse sidebar-nav" style="color:#fff;">
					<ul class="nav nav-tabs nav-stacked main-menu">		
						<li class="active"><a href="path.php?page=listUsers" id="listUsers"><i class="icon-edit"></i><span class="hidden-tablet"> Users</span></a></li>
						<li><a href="path.php?page=createUser" id="createUser"><i class="icon-align-justify"></i><span class="hidden-tablet"> Create User</span></a></li>
						</ul>
				</div>
			</div>
			<!-- end: Main Menu -->		
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="#" id="listUsers">Users</a> 
				</li>				
			</ul>

			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Users</h2>
					
					</div>
					<div class="box-content" id="pageContent">
					<?php include('listUsers.php'); ?>         
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

		
			

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
	<footer>

		<p>
			<span style="text-align:left;float:left">&copy; 2013 
			<a href="#">Accurity Valuation</a>
			</span>
			
		</p>

	</footer>
	
	<!-- start: JavaScript-->

		<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
		
		<script src="js/bootstrap.min.js"></script>
	
	
		<script src='js/fullcalendar.min.js'></script>
	
		<script src='js/jquery.dataTables.min.js'></script>

	
		<script src="js/jquery.chosen.min.js"></script>
	
		<script src="js/jquery.uniform.min.js"></script>
		
		<script src="js/jquery.cleditor.min.js"></script>
	
	
		<script src="js/jquery.elfinder.min.js"></script>
	
		<script src="js/jquery.raty.min.js"></script>
	
		
		<script src="js/jquery.uploadify-3.1.min.js"></script>
	
	
		<script src="js/jquery.masonry.min.js"></script>
	
		<script src="js/jquery.knob.modified.js"></script>
	
		<script src="js/jquery.sparkline.min.js"></script>
	
		

		<script src="js/custom.js"></script>
	<!-- end: JavaScript-->
	
</body>
</html>
<script type="text/javascript">
		$(document).ready(function(){
		$('.nav-stacked li a').click(function() { 
		var currentPage=this.id;		
		$.ajax({
		type: "GET",
		url: "path.php?page="+currentPage,
		success: function(data){	
		$("#pageContent").html(data);
		}
		});
		return false;
		});
		$("#viewUser").click(function(){
		var currentPage=this.id;		
		$.ajax({
		type: "GET",
		url: "path.php?page="+currentPage,
		success: function(data){	
		$("#pageContent").html(data);
		}
		});
		return false;
		});
		$(".nav-stacked li a").click(function() {
			$(".nav-stacked li a").css('color','#fff');
			$(".nav-stacked li a").css('border','none');
    $(this).parent().addClass('active').siblings().removeClass('active');

    });
		});
		</script>
