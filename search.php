<?php  session_start();?>
<style>
#popup { 
display:none;
position:fixed;
margin-left:40%;
top:25%;
background-color:#000;
color:#fff; font-size:11px;
padding:5px;
}
#popup h3{ font-size:11px;}
#popup li{font-size:11px;}
</style>
<!-- Search Page-->
<div id="search_form">
	<span class="heading-text">Begin your search here</span>
	<form role="form">
		<div class="form-group" style="padding:5px 0px 0px 0px;">
			<input type="text" style="width:50%; height:30px;" id="searchAddress" name="searchAddress" value="<?php if($_SESSION['search']['searchAddress']!='') { echo $_SESSION['search']['searchAddress']; }
		else {  } ?>" placeholder=" Search Address or Assessor Parcel " autofocus required/>	
											
			<button type="button" value="search" class="btn btn-success" id="searchBtn" name="searchdata" style="margin-bottom:3px;">Search</button>
			<br/><span >(* provide address in STREET CITY STATE ZIP format) <img src="icon.png" width="25" height="25" onmouseover="displayAddress();" onmouseout="removeAddress();" /></span>
		</div>

		<div id="error" class="form-group" style="padding:5px 0px 0px 0px;">
			<?php  
			if(isset($_SESSION['trackerror']) && $_SESSION['trackerror']==1){
				echo "<br/><strong><span style='color:red;'>Address not found, please check entry for errors.</span></strong>";
			}
			else if(isset($_SESSION['trackerror']) && $_SESSION['trackerror']==2){
				echo "<br/><strong><span style='color:red;'>Property not found</span></strong>";
			} 
		
			else if(isset($_REQUEST['error']) && $_REQUEST['error']==1){ 
				echo "<br/><strong><span style='color:red;'>No corresponding property found.</span></strong>";
			}

			else if(isset($_REQUEST['verror']) && $_REQUEST['verror']==1){
				echo "<br/><strong><span style='color:red;'>Address not found, please check entry for errors.</span></strong>";
			}
			else if(isset($_REQUEST['vreferror']) && $_REQUEST['vreferror']==1){
				echo "<br/><strong><span style='color:red;'>Your search did not return any comparable properties.</span></strong>";
			}
			?>
		</div>	
	</form>		


	<div id="popup">
		    <h3> Suggestions for better Search </h3>
		<h3> Spelling counts!</h3>
<ul>
	<li> Misspelled street names or cities may result in a failed query or with incorrect results- even a missing “s” at the end of a street may create a failed entry</li>
	<li> If entering an apartment or unit number, use unit or apt; # is not accepted </li>
</ul>


<h3>  Address formats:</h3>
Input address can be in following formats:
<ul>
	<li>   &lt;Street Number&gt; &lt;Street Name&gt;, &lt;City&gt;, &lt;State&gt; &lt;Zip&gt; 
<br/>  Example: 1 Venture, Irvine, CA 92618</li>
<li>  &lt;Street Number&gt; &lt;Street Name&gt;, &lt;City&gt;, &lt;State&gt;
<br/>   Example: 1 Venture, Irvine, CA</li>
<li>   &lt;Street Number&gt; &lt;Street Name&gt;, &lt;Zip&gt;<br/>
  Example: 1 Venture, 92618</li>
<li> Unit number can be passed after &lt;Street Name&gt; </li>
<li>   Unit number must start with:	
		<br/>1.  “unit” word
		<br/>2.  “apt.” word
	</li>
<li>   Example: 1 Venture apt. 25C, Irvine, CA 92618</li>
<li>   Example: 1 Venture unit 25C, Irvine, CA 92618</li>
</ul>
	</div>
</div>
<br/><br/>
<!-- Search Page Ends -->
<script type="text/javascript">

		function displayAddress(){			
			document.getElementById('popup').style.display = "block";
		}

		function removeAddress(){			
			document.getElementById('popup').style.display = "none";
		}

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