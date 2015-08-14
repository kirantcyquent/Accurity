<?php  session_start();?>
<!-- Search Page-->
<div id="search_form">
	<span class="heading-text">Begin your search here</span>
	<form role="form">
		<div class="form-group" style="padding:5px 0px 0px 0px;">
			<input type="text" style="width:50%; height:30px;" id="searchAddress" name="searchAddress" value="<?php if($_SESSION['search']['searchAddress']!='') { echo $_SESSION['search']['searchAddress']; }
		else {  } ?>" placeholder=" Search Address or Assessor Parcel " autofocus required/>	
											
			<button type="button" value="search" class="btn btn-success" id="searchBtn" name="searchdata" style="margin-bottom:3px;">Search</button>
			<br/><span >(* provide address in STREET CITY STATE ZIP format)</span>
		</div>

		<div id="error" class="form-group" style="padding:5px 0px 0px 0px;">
			<?php  if(isset($_REQUEST['error']) && $_REQUEST['error']==1){ 
				echo "<br/><strong><span style='color:red;'>No corresponding property found.</span></strong>";
			}?>
		</div>	
	</form>		
</div>
<!-- Search Page Ends -->
<script type="text/javascript">

		$(document).ready(function(){

		$('input[name=searchAddress]').focus();

		$(document).on("keypress",function(event) {
			
			var keyCode = event.which || event.keyCode;
			if (keyCode == 13) {
				$("#searchBtn").click();
				return false;
			}
		});

		$('#searchBtn').click(function() { 
			var sdata = $('#searchAddress').val();
			
			if(sdata=="" || sdata.length<=2){
				return false;
			}
			var userrole = <?php echo $_SESSION['user_type'];?>;
			
			if(sdata==""){
				return false;
			}
			
			if(userrole == 2){
				var currentPage="results";
			}else{
				var currentPage="refineSearch";
			}
			var address=$("#searchAddress").val();
			var box3 = new ajaxLoader('#box3', {classOveride: 'blue-loader', bgColor: '#000'});
				$.ajax({
					type: "GET",
					url: "home.php?page="+currentPage+"&searchAddress="+address+"&set_page=search",
					success: function(data){	
						box3.remove();
						$("#pageContent").html(data);
						$("#backBtn").css("display","");
						
						
						$('.nav-stacked li').removeClass('active')
						$(".nav-stacked li:eq(1)").addClass("active");

					}
				});
				return false;
			});
		});
</script>