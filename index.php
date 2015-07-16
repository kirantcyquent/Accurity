<?php
	session_start();
	$user_type=$_SESSION['user_type'];
	if(!isset($_SESSION['email']) || !isset($_SESSION['sessionid']) || $user_type==3){
		header('Location: login.php');
	}	
?>
<?php  include('includes/header.php'); ?>	
<?php  include('includes/topBar.php'); ?>
	<div class="row" id="sideMenuDiv">
		<?php  include('includes/sideMenu.php'); ?>	
		<div class="col-sm-10" id="pageContent">
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