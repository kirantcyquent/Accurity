<?php
	session_start();

	include('classes/User.php');
	$us = new User();
	if(isset($_REQUEST['searchAddress'])){
		$parameters = 'searchAddress='.$_REQUEST['searchAddress'];
		$action = 'Home Page Search';	
		$actionId = 'search';	
		$us->saveAction($actionId, $action, $parameters);
	}

	include_once('includes/process.php') ;
	$Add = 	isset($_REQUEST['searchAddress']) ? $_REQUEST['searchAddress']: $_SESSION['refineSearch']['address'];
	$Add = strip_tags($Add);
	$Add = mysql_real_escape_string(@$Add);
    $_SESSION['search']['searchAddress']=$Add;

	if(isset($_REQUEST['searchAddress']))
	{
		unset($_SESSION['refineSearch']); unset($_SESSION['results']);
		$aRet = ConvertAddress($Add);
		$PropData = GetPropertyFromRealty($aRet['StreetAdd'],$aRet['City'],$aRet['State'],$aRet['Zip']);
		
		if(!isset($PropData['_STREETADDRESS'])){
	?>
	<script>
		var currentPage="index";
		$.ajax({
				type: "GET",
				data: "error=1",
				url: "home.php?page="+currentPage+"&set_page=index",
				success: function(data){	
					$("#pageContent").html(data);
					$('.nav-stacked li').removeClass('active')
					$(".nav-stacked li:first").addClass("active");
				}
		});

	</script>
	<?php
			exit;
		}
			
		$PropData['TOTALBATHROOMCOUNT']=round($PropData['TOTALBATHROOMCOUNT']);
		$Add =  $PropData['_STREETADDRESS'] .' '.$PropData['_CITY'].' '.$PropData['_STATE'].' '.$PropData['_POSTALCODE'];	
		$sq_footage =  $PropData['GROSSLIVINGAREASQUAREFEETCOUNT'];
		$bedrooms = $PropData['TOTALBEDROOMCOUNT'];
		$bathrooms=$PropData['TOTALBATHROOMCOUNT'];
		$year_built =$PropData['PROPERTYSTRUCTUREBUILTYEAR'];
		$lot_size =  $PropData['LOTSIZESQUAREFEETCOUNT_EXT'];
		$stories = $PropData['STORIESCOUNT'];
		$sq_f  =  "+/- 20%";
		$radius  =  "0.5 Mile";
		$age  =  "+/- 5 years";
		$l_size  ="+/- 50%";
		$story  = "3";
		$pool =  "No";
		$basement =  "No";
		$beds_from = "2";
		$beds_to =  "3";
		$baths_from = "2";
		$baths_to = "3";
		$sale_range = "0.3 Months";
		$sale_type = "Full Value";

		$searchId = $us->saveSearch($Add, 0, $_SESSION);

		unset($_SESSION['refineSearch']);
	}
	else if(isset($_SESSION['refineSearch']['address'])) {
		$sq_footage = isset($_SESSION['refineSearch']['square_footage']) ? $_SESSION['refineSearch']['square_footage'] : $PropData['GROSSLIVINGAREASQUAREFEETCOUNT'];

		$bedrooms = isset($_SESSION['refineSearch']['bedrooms']) ? $_SESSION['refineSearch']['bedrooms'] : $PropData['TOTALBEDROOMCOUNT'];
		$bathrooms=isset($_SESSION['refineSearch']['bathrooms']) ? $_SESSION['refineSearch']['bathrooms'] :$PropData['TOTALBATHROOMCOUNT'];
		$year_built =isset($_SESSION['refineSearch']['year_built']) ? $_SESSION['refineSearch']['year_built'] : $PropData['PROPERTYSTRUCTUREBUILTYEAR'];
		$lot_size = isset($_SESSION['refineSearch']['lot_size']) ? $_SESSION['refineSearch']['lot_size'] :  $PropData['LOTSIZESQUAREFEETCOUNT_EXT'];
		$stories = isset($_SESSION['refineSearch']['stories']) ? $_SESSION['refineSearch']['stories'] :$PropData['STORIESCOUNT'];


		$sq_f  = isset($_SESSION['refineSearch']['sq_f']) ? $_SESSION['refineSearch']['sq_f'] : "+/- 20%";
		$radius  = isset($_SESSION['refineSearch']['radius']) ? $_SESSION['refineSearch']['radius'] : "0.5 Mile";
		$age  = isset($_SESSION['refineSearch']['age']) ? $_SESSION['refineSearch']['age'] : "+/- 5 years";
		$l_size  = isset($_SESSION['refineSearch']['l_size']) ? $_SESSION['refineSearch']['l_size'] : "+/- 50%";
		$story  = isset($_SESSION['refineSearch']['story']) ? $_SESSION['refineSearch']['story'] : "3";
		$pool = isset($_SESSION['refineSearch']['pool']) ? $_SESSION['refineSearch']['pool'] : "No";
		$basement = isset($_SESSION['refineSearch']['basement']) ? $_SESSION['refineSearch']['basement'] : "No";
		$beds_from = isset($_SESSION['refineSearch']['beds_from']) ? $_SESSION['refineSearch']['beds_from'] : "2";
		$beds_to = isset($_SESSION['refineSearch']['beds_to']) ? $_SESSION['refineSearch']['beds_to'] : "3";
		$baths_from = isset($_SESSION['refineSearch']['baths_from']) ? $_SESSION['refineSearch']['baths_from'] :"2";
		$baths_to = isset($_SESSION['refineSearch']['baths_to']) ? $_SESSION['refineSearch']['baths_to'] :"3";
		$sale_range = isset($_SESSION['refineSearch']['sale_range']) ? $_SESSION['refineSearch']['sale_range'] :"0.3 Months";
		$sale_type = isset($_SESSION['refineSearch']['sale_type']) ? $_SESSION['refineSearch']['sale_type'] :"Full Value";
	} 
	else{
	
	?>
	<script>

			var currentPage="index";			
			$.ajax({
				type: "GET",
				url: "home.php?page="+currentPage+"&set_page=index",
				success: function(data){	
				$("#pageContent").html(data);
				$('.nav-stacked li').removeClass('active')
				$(".nav-stacked li:first").addClass("active");
				}
				});
	</script>
		<?php
			exit;
	}
	?>




		<div class="row">
		<div class="col-sm-6 textDiv">
		<span style="font-size:16px; font-weight:bold; color:#6a6a6a;"><?php echo $Add;
		?></span>
		</div>

		<div class="col-sm-6 textDiv">
		<button type="button" id="backBtn" class="btn btn-success">&lArr;Back</button>
		</div>
		</div>

		<div class="row">
		<div class="col-sm-6 textDiv">
			<?php if(isset($_REQUEST['referror'])){ echo "please adjust the square footage to the possible nearest value."; unset($_REQUEST['referror']); }?>
		</div>
		</div>

		<div class="row">
		<div class="col-sm-3">
		<ul class="textDiv">
		<li><b>Attribute</b></li>
		<li>Measured Square Footage <span style="color:red; font-weight:bold;">*</span></li>
		<li>Bedrooms</li>
		<li>Bathrooms</li>
		<li>Year Built</li>
		<li>Lot Size</li>
		<li>Stories</li>
		</ul>
		</div>
		<div class="col-sm-3">
		<ul class="textDiv">
		<li><b>Public Record Results</b></li>
		<li>
		<span id="sfcount">
		<?php echo $sq_footage; ?>
		</span></li>	
		<li><?php echo $bedrooms; ?></li>
		<li><?php echo $bathrooms; ?></li>
		<li><?php echo $year_built; ?></li>
		<li><?php echo $lot_size; ?></li>
		<li><?php echo $stories; ?></li>
		</ul>
		</div>
		<div class="col-sm-6">
		<form action="" method="post" id="measure_form">
		<ul class="textDiv">
		<li><b>Adjustments</b></li>
		<li><input type="text"  name="square_footage" class="small" onkeypress="return isNumber(event)"  value="<?php echo $sq_footage; ?>" id="adjustments" pattern="^[0-9\.]+$" maxlength="8" required>
				<span id="sq_error" style="font-weight:bold; color:red;"></span>
		</li>
		<input type="hidden" name="bedrooms" value="<?php echo $bedrooms; ?>"/>
		<input type="hidden" name="bathrooms" value="<?php echo $bathrooms; ?>"/>
		<input type="hidden" name="year_built" value="<?php echo $year_built; ?>"/>
		<input type="hidden" name="lot_size" value="<?php echo $lot_size; ?>"/>
		<input type="hidden" name="stories" value="<?php echo $stories; ?>"/>
		<input type="hidden" name="sq_f" id="sq_f" value="<?php echo $sq_f;?>" />
		<input type="hidden" name="radius" id="radius" value="<?php echo $radius;?>" />
		<input type="hidden" name="age" id="age" value="<?php echo $age;?>" />
		<input type="hidden" name="l_size" id="l_size" value="<?php echo $l_size;?>" />
		<input type="hidden" name="story" id="story" value="<?php echo $story;?>" />
		<input type="hidden" name="pool" id="pool" value="<?php echo $pool;?>" />	
		<input type="hidden" name="basement" id="basement" value="<?php echo $basement;?>" />	
		<input type="hidden" name="beds_from" id="beds_from" value="<?php echo $beds_from;?>" />	
		<input type="hidden" name="beds_to" id="beds_to" value="<?php echo $beds_to;?>" />	
		<input type="hidden" name="baths_from" id="baths_from" value="<?php echo $baths_from;?>" />	
		<input type="hidden" name="baths_to" id="baths_to" value="<?php echo $baths_to;?>" />	
		<input type="hidden" name="sale_range" id="sale_range" value="<?php echo $sale_range;?>" />	
		<input type="hidden" name="sale_type" id="sale_type" value="<?php echo $sale_type;?>" />	
		
	

		<input type="hidden" name="address" value="<?php echo $Add; ?>" />
		<li>&nbsp; </li>
		<li>&nbsp; </li>
		<li>&nbsp; </li>
		<li>&nbsp; </li>
		<li>&nbsp; </li>
		<li><button type="button" class="btn btn-success" id="searchBtn">Save & Search</button></li>
		</ul>
		</form>
		</div>
		</div>

		<script type="text/javascript">
		function isNumber(evt) {
		    var charCode = (evt.which) ? evt.which : event.keyCode

        	if ((charCode != 45 || $('#adjustments').val().indexOf('-') != -1) &&  (charCode != 46 || $('#adjustments').val().indexOf('.') != -1) &&  (charCode < 48 || charCode > 57))
            return false;

        	return true;
		}

		$(document).ready(function(){
		
			$('#adjustments').keyup(function() {
				var adj = $('#adjustments').val();
				$('#sfcount').html(adj);
			});

			$("#backBtn").css("display","none");
			$('#backBtn').click(function() { 

				var currentPage="index";
				$.ajax({
					type: "GET",
					url: "home.php?page="+currentPage+"&set_page=index",
					success: function(data){	
						$("#pageContent").html(data);
						$('.nav-stacked li').removeClass('active')
						$(".nav-stacked li:first").addClass("active");
					}
				});
				return false;
			});
			
			$('#saveBtn').click(function() { 
				var adj=$('#adjustments').val();

				
				var currentPage="refineSearch";
				var dataString = '&street=<?php echo $a = isset($PropData["_STREETADDRESS"]) ? urlencode($PropData["_STREETADDRESS"]) : $_SESSION["refineSearch"]["street"]; ?>&state=<?php echo $b = isset($PropData["_STATE"]) ? $PropData["_STATE"] :  $_SESSION["refineSearch"]["state"];?>&city=<?php echo $c = isset($PropData["_CITY"]) ? $PropData["_CITY"] :  $_SESSION["refineSearch"]["city"];?>&zip=<?php echo $c = isset($PropData["_POSTALCODE"]) ? $PropData["_POSTALCODE"] :  $_SESSION["refineSearch"]["zip"];?>';

				$.ajax({
					type: "POST",
					data: $('#measure_form').serialize()+dataString,
					url: "home.php?page="+currentPage+"&set_page=refineSearch",
					success: function(data){	
						$("#pageContent").html(data);
						$('.nav-stacked li').removeClass('active')
						$(".nav-stacked li:nth-child(2)").addClass("active");
					}
				});
			});
				
			$('#searchBtn').click(function() {
				
				var square_footage = $("#adjustments").val();
				if(square_footage==""){
					document.getElementById('sq_error').innerHTML = 'please enter square footage';
					return false;
				}else{
					document.getElementById('sq_error').innerHTML = '';
				}
				if(isNaN(square_footage)){ 
					document.getElementById('sq_error').innerHTML = 'please enter square footage';
					$("#adjustments").val("");
					return false;
				}
				var box3 = new ajaxLoader('#box3', {classOveride: 'blue-loader', bgColor: '#000'});
				var sq_f = $("#sq_f").val();
				var radius = $("#radius").val();
				var age = $("#age").val();
				var l_size = $("#l_size").val();
				var story = $('#story').val();
				var pool = $('#pool').val();
				var basement = $('#basement').val();
				var beds_from = $('#beds_from').val();
				var beds_to = $('#beds_to').val();
				var baths_from = $('#baths_from').val();
				var baths_to = $('#baths_to').val();
				var sale_range = $('#sale_range').val();
				var sale_type = $('#sale_type').val();

				var dataString = 'sq_f='+sq_f+'&radius='+radius+'&age='+age+'&l_size='+l_size+'&story='+story +'&pool='+pool+'&basement='+basement+'&beds_from='+beds_from+'&beds_to='+ beds_to+'&baths_from='+baths_from+'&baths_to='+baths_to+'&sale_range='+ sale_range+'&sale_type='+sale_type+'&square_footage='+square_footage+'&bedrooms=<?php echo $bedrooms;?>&bathrooms=<?php echo $bathrooms;?>&stories=<?php echo $stories;?>&lot_size=<?php echo $lot_size;?>&year_built=<?php echo $year_built;?>&address=<?php echo $Add;?>&street=<?php echo $a = isset($PropData["_STREETADDRESS"]) ? urlencode($PropData["_STREETADDRESS"]) : $_SESSION["refineSearch"]["street"]; ?>&state=<?php echo $b = isset($PropData["_STATE"]) ? $PropData["_STATE"] :  $_SESSION["refineSearch"]["state"];?>&city=<?php echo $c = isset($PropData["_CITY"]) ? $PropData["_CITY"] :  $_SESSION["refineSearch"]["city"];?>&zip=<?php echo $c = isset($PropData["_POSTALCODE"]) ? $PropData["_POSTALCODE"] :  $_SESSION["refineSearch"]["zip"];?>';

				var currentPage="results";
				$.ajax({
					type: "POST",
					data: dataString,
					url: "home.php?page="+currentPage+"&set_page=refineSearch",		
					success: function(data){
						
						box3.remove();
						$("#pageContent").html(data);	   
						$('.nav-stacked li').removeClass('active')
						$(".nav-stacked li:nth-child(3)").addClass("active");
					}
				});
				return false;
				});
		});
		</script>