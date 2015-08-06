<?php
	session_start();
	$user_type=$_SESSION['user_type'];
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid'])){
		header('Location: login.php');
	}	
	if($user_type==3){
		header('Location: users.php');
	}

	if($user_type==0){
		header('Location: institutes.php');
	}
?>
<?php include('views/header.php'); ?>
<?php include('views/r3report.php'); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-1 col-sm-1 col-xs-1">
			</div>
			<div class="col-lg-11 col-sm-11 col-xs-11">			
				<div class="row">
					<div class="col-sm-3 col-xs-12 col-lg-2">
						<?php include('views/sidebar.php'); ?>
					</div>
					<div class="col-sm-9 col-xs-12 col-lg-9" id="pageContent">
					<?php 
					if($_SESSION['resumeSearch']=="refineSearch"){
						
						?>
						<script>
						var currentPage="refineSearch";
						$.ajax({
							type: "GET",
							url: "home.php?page="+currentPage+"",
							success: function(data){	
							
								$("#pageContent").html(data);
								$('.nav-stacked li').removeClass('active')
								$(".nav-stacked li:first").addClass("active");
							}
						});
						
					</script>
						<?php
					}
					else{			
						include('search.php');
					}
						 ?>	
					</div>
					</div>
				</div>
				<div class="col-lg-1 col-sm-1 col-xs-1">
				</div>
		</div>
	</div>
<?php  include('includes/footer.php'); ?>
<script type="text/javascript">
		$(document).ready(function(){
			$('.search_bar').css('display','none');	
			$('.nav-stacked li a').click(function() { 
			var currentPage=this.id;
			if(currentPage=='index') {
			$('.search_bar').css('display','none');	
			}
			else {
			$('.search_bar').css('display','');		
			}
			$.ajax({
			type: "GET",
			url: "home.php?page="+currentPage,
			success: function(data){	
			$("#pageContent").html(data);
			}
			});
			return false;
			});
		});
</script>