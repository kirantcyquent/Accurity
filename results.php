<?php
	session_start();
	$sessiondata = $_SESSION['email'];

	include('db/db.php');
	$query = "select TypeOfUser from userdetail where UserName = '$sessiondata'";
	$sql = mysql_query($query) or die(mysql_error());
	$result = mysql_fetch_row($sql);	
	$user = $result[0];

	
	include('classes/User.php');
	$us = new User();
  	include_once('includes/process.php') ;
  	
	$prepared_by = $us->getUserDetails();    

	$maxRecords=5;

	if($user==2  && isset($_REQUEST['searchAddress'])){

			include_once('includes/process.php') ;
			$Add = 	isset($_REQUEST['searchAddress']) ? $_REQUEST['searchAddress']: $_SESSION['results']['address'];
			$Add = strip_tags($Add);
			$Add = mysql_real_escape_string(@$Add);



			if(isset($_REQUEST['searchAddress']))
			{
				unset($_SESSION['results']);
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
				$address= $Add;
				
		        $_SESSION['search']['searchAddress']=$address;
				$PropData['TOTALBATHROOMCOUNT']=round($PropData['TOTALBATHROOMCOUNT']);
				$Add =  $PropData['_STREETADDRESS'] .' '.$PropData['_CITY'].' '.$PropData['_STATE'].' '.$PropData['_POSTALCODE'];	
				$street = $aRet['StreetAdd'];
				$city = $PropData['_CITY'];
				$state  = $PropData['_STATE'];
				$zip =$PropData['_POSTALCODE'];

				$sq_footage =  $PropData['GROSSLIVINGAREASQUAREFEETCOUNT'];
				$bedrooms = $PropData['TOTALBEDROOMCOUNT'];
				$bathrooms=$PropData['TOTALBATHROOMCOUNT'];
				$year_built =$PropData['PROPERTYSTRUCTUREBUILTYEAR'];
				$lot_size =  $PropData['LOTSIZESQUAREFEETCOUNT_EXT'];
				$stories = $PropData['STORIESCOUNT'];
				
				$sq_f  =  "+/- 20%";
				$radius  =  "0.5 Mile";
				$age  =  "5";
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

				$_SESSION['search']['address'] = $Add;
				$_SESSION['search']['bedrooms'] = $bedrooms;
				$_SESSION['search']['bathrooms'] = $bathrooms;
				$_SESSION['search']['square_footage'] = $square_footage;
				$_SESSION['search']['stories'] = $stories;												
				$_SESSION['search']['lot_size'] = $lot_size;	
				$_SESSION['search']['year_built'] = $year_built;	
				$_SESSION['search']['pool'] = $pool;									
				$_SESSION['search']['basement'] = $basement;													

				$date = date('Y-m-d');
				
			
				//echo "($street,$city,$state,$zip,'',$date";
			//	$xml_result = generate_xml($street,$city,$state,$zip,'',$date);
				$street = preg_replace("@\s+@","+",$street);
				$arr  = array ('street'=>$street,'city'=>$city, 'state'=>$state, 'zip'=>$zip,'beds'=>$bedrooms, 'baths'=>$bathrooms,'square_footage'=>$square_footage,'lot_size'=>$lot_size, 'sale_date'=> '','amount_min'=>'','amount_max'=>'', 'built_year'=>$year_built);
				$xml_result = get_xml_data($arr);


				$results = array();

				/*criteria- 1   ******** sqft->10+- age 5+-  saledate<180 prox0.5mile lot size 50+-   ***********/
				$C1Rangesqrft = MinMax(10,$sq_footage);
				$C1RangeAge = MinMaxAge(5, $year_built);
				$C1Rangelot = MinMax(50,$lot_size);
				$C1Proximity = "0.5";

				/*criteria- 2   ******** sqft->10+- age 5+-  saledate<180 prox0.5mile lot size 50+-   ***********/
				$C2Rangesqrft = MinMax(15,$sq_footage);
				$C2RangeAge = MinMaxAge(10,$year_built);
				$C2Rangelot = MinMax(50,$lot_size);
				$C2Proximity = "1";

				/*criteria- 3   ******** sqft->10+- age 5+-  saledate<180 prox0.5mile lot size 50+-   ***********/
				$C3Rangesqrft = MinMax(20,$sq_footage);
				$C3RangeAge = MinMaxAge(50,$year_built);
				$C3Rangelot = MinMax(50,$lot_size);
				$C3Proximity = "2.5";


				$aSearchProp = array();
				$c1=array(); 
				$c2=array(); 
				$c3=array();
				print_r($_SESSION);
				$us->storeXMLResultLog($xml_result);
				foreach($xml_result as $rows)
				{
					//print_r($rows);
					//$rows['lot_size'] = $rows['lot_size'] * 43560;
					$listdate = $rows['dateSold'];
					$listdate = preg_replace("@T.*?$@","",$listdate);
					list($m,$d,$y) = preg_split("@-@",$listdate);
					
					
					$ydate = strtotime("$y-$m-$d");

					$cn1 = time() - (180*24*60*60);
					$cn2 = time() - (365*24*60*60);

					$adr = preg_replace("@\s+@","+",$Add);
					$coords = getLatitudeLongitude($adr);

/*
					if(($rows['sq_size'] > $C1Rangesqrft['Min'] && $rows['sq_size'] < $C1Rangesqrft['Max'] ) && ($rows['lot_size]'] > $C1Rangelot['Min'] && $rows['lot_size]'] < $C1Rangelot['Max']) && ($rows['year_built'] > $C1RangeAge['Min'] && $rows['year_built'] < $C1RangeAge['Max']) && ($ydate> $cn1) && $rows['distance']<$C1Proximity)
					{
						$c1[] = array('address'=>$rows['address'], 'distance'=>$rows['distance'],'bedsBaths'=>$rows['beds'] ,'sq_size'=>$rows['sq_size'],'year_built'=>$rows['year_built'],'lot_size'=>$rows['lot_size'],'stories'=>$rows['stories'],'dateSold'=>$rows['dateSold'], 'amount'=>$rows['amount'], 'latitude'=>$coords['latitude'], 'longitude'=>$coords['longitude']);
					}
					else 
					if(($rows['sq_size'] > $C2Rangesqrft['Min'] && $rows['sq_size'] < $C2Rangesqrft['Max'] ) && ($rows['lot_size'] > $C2Rangelot['Min'] && $rows['lot_size'] < $C2Rangelot['Max']) && ($rows['year_built'] > $C2RangeAge['Min'] && $rows['year_built'] < $C2RangeAge['Max']) && ($ydate> $cn2) && $rows['distance']<$C2Proximity)
					{
						$c2[] = array('address'=>$rows['address'], 'distance'=>$rows['distance'],'bedsBaths'=>$rows['beds'] ,'sq_size'=>$rows['sq_size'],'year_built'=>$rows['year_built'],'lot_size'=>$rows['lot_size'],'stories'=>$rows['stories'],'dateSold'=>$rows['dateSold'], 'amount'=>$rows['amount'], 'latitude'=>$coords['latitude'], 'longitude'=>$coords['longitude']);
					}else */


					if(($rows['sq_size'] > $C3Rangesqrft['Min'] && $rows['sq_size'] < $C3Rangesqrft['Max'] ) && ($rows['lot_size'] > $C3Rangelot['Min'] && $rows['lot_size'] < $C3Rangelot['Max']) && ($rows['year_built'] > $C3RangeAge['Min'] && $rows['year_built'] < $C3RangeAge['Max']) && $rows['distance']<$C3Proximity)
					{
						$c3[] = array('address'=>$rows['address'], 'distance'=>$rows['distance'],'bedsBaths'=>$rows['beds'] ,'sq_size'=>$rows['sq_size'],'year_built'=>$rows['year_built'],'lot_size'=>$rows['lot_size'],'stories'=>$rows['stories'],'dateSold'=>$rows['dateSold'], 'amount'=>$rows['amount'], 'latitude'=>$rows['latitude'], 'longitude'=>$rows['longitude'],'pool'=>$rows['pool'], 'basement'=>$rows['basement']);
					}
					
				}
				
			
				$aSearchProp = array_merge($c1, $c2);
				$aSearchProp =array_merge($aSearchProp, $c3);

				


				if(count($aSearchProp)<=0){
					
						?>
						<script>
							var currentPage="refineSearch";
							$.ajax({
									type: "GET",
									data: "referror=1",
									url: "home.php?page="+currentPage+"&set_page=index",
									success: function(data){	
										$("#pageContent").html(data);
										$('.nav-stacked li').removeClass('active')
										$(".nav-stacked li:nth-child(2)").addClass("active");
									}
							});
						</script>
						<?php
						exit;
				}

				$us->updateSearch($address, 0, $_SESSION, $_SESSION['searchId']);
				
					
	
			}
	}

	else if(isset($_POST['sq_f']) || ($user == 2 && isset($_POST['searchdata'])) )
	{
		
		$sq_f = $_POST['sq_f'];
		$radius = $_POST['radius']; 
		$age = $_POST['age'];
		$l_size = $_POST['l_size'];
		$story = $_POST['story'];
		$pool = $_POST['pool'];
		$basement = $_POST['basement']; 
		$beds_from = $_POST['beds_from']; 
		$beds_to = $_POST['beds_to'];
		$baths_from = $_POST['baths_from']; 
		$baths_to = $_POST['baths_to']; 
		$sale_range = $_POST['sale_range'];  
		$sale_type = $_POST['sale_type']; 
		$square_footage = $_POST['square_footage'];
		$bedrooms = $_POST['bedrooms']; 
		$bathrooms = $_POST['bathrooms']; 
		$stories = $_POST['stories']; 
		$lot_size = $_POST['lot_size'];
		$year_built = $_POST['year_built'];
		
		$address= $_POST['address'];
		$street = $_POST['street'];
		$city = $_POST['city'];
		$state  = $_POST['state'];
		$zip =$_POST['zip'];

		$date = date('Y-m-d');

		//echo "($street,$city,$state,$zip,'',$date";
		$xml_result = generate_xml($street,$city,$state,$zip,'',$date);
		$results = array();

		/*criteria- 1   ******** sqft->10+- age 5+-  saledate<180 prox0.5mile lot size 50+-   ***********/
		$C1Rangesqrft = MinMax(10,$square_footage);
		$C1RangeAge = MinMaxAge(5, $year_built);
		$C1Rangelot = MinMax(50,$lot_size);
		$C1Proximity = "0.5";

		
		/*criteria- 2   ******** sqft->10+- age 5+-  saledate<180 prox0.5mile lot size 50+-   ***********/
		$C2Rangesqrft = MinMax(15,$square_footage);
		$C2RangeAge = MinMaxAge(10, $year_built);
		$C2Rangelot = MinMax(50,$lot_size);
		$C2Proximity = "1";

		/*criteria- 3   ******** sqft->10+- age 5+-  saledate<180 prox0.5mile lot size 50+-   ***********/
		$C3Rangesqrft = MinMax(20,$square_footage);
		$C3RangeAge = MinMaxAgePer(50, $year_built);
		$C3Rangelot = MinMax(50,$lot_size);
		$C3Proximity = "2.5";

		$aSearchProp = array();
		$c1=array(); 
		$c2=array(); 
		$c3=array();
		print_r($_SESSION);
		$us->storeXMLResultLog($xml_result);
		foreach($xml_result as $rows)
		{
			$rows['LOTSIZEACRES'] = $rows['LOTSIZEACRES'] * 43560;
			$listdate = $rows['LISTDATE'];
			list($m,$d,$y) = preg_split("@\/@",$listdate);
			$ydate = strtotime("$y-$m-$d");
			$cn1 = time() - (180*24*60*60);
			$cn2 = time() - (365*24*60*60);

			if($rows['POOL']==""){ $rows['POOL']="No";}
			if(($rows['SQ_FT'] > $C1Rangesqrft['Min'] && $rows['SQ_FT'] < $C1Rangesqrft['Max'] ) && ($rows['LOTSIZEACRES'] > $C1Rangelot['Min'] && $rows['LOTSIZEACRES'] < $C1Rangelot['Max']) && ($rows['YEARBUILT'] > $C1RangeAge['Min'] && $rows['YEARBUILT'] < $C1RangeAge['Max']) && ($ydate> $cn1) && $rows['DIST']<$C1Proximity)
			{

				$c1[] = array('address'=>$rows['ADDRESS'], 'distance'=>$rows['DIST'],'bedsBaths'=>$rows['BEDS'].' Bd /'.$rows['BATHS'].' Ba','sq_size'=>$rows['SQ_FT'],'year_built'=>$rows['YEARBUILT'],'lot_size'=>$rows['LOTSIZEACRES'],'stories'=>$rows['STRUCTURESTORIES'],'dateSold'=>$rows['LISTDATE'], 'amount'=>$rows['LISTPRICE'], 'latitude'=>$rows['LAT'], 'longitude'=>$rows['LON'],'pool'=>$rows['POOL'], 'basement'=>"No");
			}
			else 
			if(($rows['SQ_FT'] > $C2Rangesqrft['Min'] && $rows['SQ_FT'] < $C2Rangesqrft['Max'] ) && ($rows['LOTSIZEACRES'] > $C2Rangelot['Min'] && $rows['LOTSIZEACRES'] < $C2Rangelot['Max']) && ($rows['YEARBUILT'] > $C2RangeAge['Min'] && $rows['YEARBUILT'] < $C2RangeAge['Max']) && ($ydate> $cn2) && $rows['DIST']<$C2Proximity)
			{
				$c2[] = array('address'=>$rows['ADDRESS'], 'distance'=>$rows['DIST'],'bedsBaths'=>$rows['BEDS'].' Bd /'.$rows['BATHS'].' Ba','sq_size'=>$rows['SQ_FT'],'year_built'=>$rows['YEARBUILT'],'lot_size'=>$rows['LOTSIZEACRES'],'stories'=>$rows['STRUCTURESTORIES'],'dateSold'=>$rows['LISTDATE'], 'amount'=>$rows['LISTPRICE'],'latitude'=>$rows['LAT'], 'longitude'=>$rows['LON'],'pool'=>$rows['POOL'], 'basement'=>"No");
			}else 
			if(($rows['SQ_FT'] > $C3Rangesqrft['Min'] && $rows['SQ_FT'] < $C3Rangesqrft['Max'] ) && ($rows['LOTSIZEACRES'] > $C3Rangelot['Min'] && $rows['LOTSIZEACRES'] < $C3Rangelot['Max']) && ($rows['YEARBUILT'] > $C3RangeAge['Min'] && $rows['YEARBUILT'] < $C3RangeAge['Max']) && ($ydate> $cn2) && $rows['DIST']<$C3Proximity)
			{
				$c3[] = array('address'=>$rows['ADDRESS'], 'distance'=>$rows['DIST'],'bedsBaths'=>$rows['BEDS'].' Bd /'.$rows['BATHS'].' Ba','sq_size'=>$rows['SQ_FT'],'year_built'=>$rows['YEARBUILT'],'lot_size'=>$rows['LOTSIZEACRES'],'stories'=>$rows['STRUCTURESTORIES'],'dateSold'=>$rows['LISTDATE'], 'amount'=>$rows['LISTPRICE'],'latitude'=>$rows['LAT'], 'longitude'=>$rows['LON'], 'pool'=>$rows['POOL'], 'basement'=>"No");
			}			
		}
		 

		$aSearchProp = array_merge($c1, $c2);
		$aSearchProp =array_merge($aSearchProp, $c3);

	
		if(count($aSearchProp)<=0){
			
				?>
				<script>
		var currentPage="refineSearch";
		$.ajax({
				type: "GET",
				data: "referror=1",
				url: "home.php?page="+currentPage+"&set_page=index",
				success: function(data){	
					$("#pageContent").html(data);
					$('.nav-stacked li').removeClass('active')
					$(".nav-stacked li:nth-child(2)").addClass("active");
				}
		});

	</script>
				<?php
				exit;
		}

		$us->updateSearch($address, 0, $_SESSION, $_SESSION['searchId']);

		$street = preg_replace("@\s+@","+",$street);
		$arr  = array ('street'=>$street,'city'=>$city, 'state'=>$state, 'zip'=>$zip,'beds'=>$bedrooms, 'baths'=>$bathrooms,'square_footage'=>$square_footage,'lot_size'=>$lot_size, 'sale_date'=> '','amount_min'=>'','amount_max'=>'', 'built_year'=>$year_built);
		$res = get_xml_data($arr);		
	}
	else if(isset($_SESSION['results']['matchResult'])){	
		$result=unserialize(urldecode($_SESSION['results']['matchResult']));
		
		$aSearchProp = $result;
		
		if($user==2){
		$address = $_SESSION['search']['address'];
		$bedrooms  = $_SESSION['search']['bedrooms'];
		$bathrooms= $_SESSION['search']['bathrooms'];
		$square_footage= $_SESSION['search']['square_footage'];
		$stories= $_SESSION['search']['stories'];
		$year_built= $_SESSION['search']['year_built'];
		}else{
		$address = $_SESSION['refineSearch']['address'];
		$bedrooms  = $_SESSION['refineSearch']['bedrooms'];
		$bathrooms= $_SESSION['refineSearch']['bathrooms'];
		$square_footage= $_SESSION['refineSearch']['square_footage'];
		$stories= $_SESSION['refineSearch']['stories'];
		$year_built= $_SESSION['refineSearch']['year_built'];
		}
	}else{
		
		
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

	$b = $a = $aSearchProp;
	function cmp($a, $b) {
		if($a['distance'] == $b['distance']) {
			return 0;
		}
		return ($a['distance'] < $b['distance']) ? -1 : 1;
	}

	uasort($a, 'cmp');
	$aSearchProp = $a;
	
?>
<?php
		$adr = preg_replace("@\s+@","+",$address);
		$main = getLatitudeLongitude($adr);
		$markers = array();
		$markers[] = array('id'=>'C','address'=>$address, 'latitude'=>$main['latitude'], 'longitude'=>$main['longitude']);
?>

		<!--tableheader<table class="table table-borderless" id="resultTable">
			<tbody>
			<tr>
				<td class="repAddress">
				<span ><?php echo $address; ?></span>
				<span><br/>
				<?php echo $bedrooms; ?> Bd | <?php echo $bathrooms; ?> Ba | <?php echo $square_footage;?> Sq Ft<br/>
				<?php echo $stories; ?> Stories | Lot Size <?php echo $lot_size; ?><br/>
				<?php echo "Pool ".$pool; ?> |  <?php echo "Basement ".$basement; ?><br/>
				Built <?php echo $year_built;?>
				</span> </td>
				<td class="repBy"><span >Report Prepared By</span>
				<span ><br/>
				<?php echo $prepared_by['Name']; ?><br/>
				<?php echo $prepared_by['Address']; ?><br/>
				<a href=""><?php echo $prepared_by['UserName']; ?></a>		
				</span> </td>
			</tr>
			</tbody>
		</table>
		tableheader-->

		<!-- report header -->
		<div class="row">
		<div class="col-lg-8 col-sm-8 col-xs-12 col-md-8 repaddress">
				<h5 class="report-header"><?php echo $address; ?></h5>
				<h6><?php echo $bedrooms; ?> Bd | <?php echo $bathrooms; ?> Ba | <?php echo $square_footage;?> Sq Ft</h6>
				<h6><?php echo $stories; ?> Stories | Lot Size <?php echo $lot_size; ?></h6>
				<h6><?php echo "Pool ".$pool; ?> |  <?php echo "Basement ".$basement; ?></h6>
				<h6>Built <?php echo $year_built;?>
				</h6>
		</div>
		<div class="col-lg-4 col-sm-4 col-xs-12 col-md-4 repaddress">
				<h5 class="report-by">Report Prepared By</h5>
				<h6><?php echo $prepared_by['Name']; ?></h6>
				<h6><?php echo $prepared_by['Address']; ?></h6>
				<h6  class="linkColor"><a href="mailto:<?php echo $prepared_by['UserName']; ?>"><?php echo $prepared_by['UserName']; ?></a>		
				</h6>
		</div>
		</div>		
		<!-- report header -->

		<div class="clearfix"></div>
		<div class="row">
		<div class="col-lg-9 col-sm-9 col-xs-12 col-md-9">
				
						<div class="pull-left indicate purple">
						
						</div>
						<div class="pull-left indicate-text">
							Subject Property
						</div>
					
						<div class="pull-left indicate blue">
						
						</div>
						<div class="pull-left indicate-text">
							 Potential Comparable Sales Used
						</div>
					
						<div class="pull-left indicate pink">
						
						</div>
						<div class="pull-left indicate-text">
							Potential Comparable Sales Not Used 
						</div>
					
		
	</div>
	</div>
	<div class="clearfix"></div>

	<div class="row">
		<div class="col-lg-8 col-sm-8 col-xs-12 col-md-8 repaddress">
			<div>
				<div id="map_wrapper">
				<div id="map_canvas" class="mapping"></div>
				</div>	
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-xs-12 col-md-4 repaddress">
			<h5 class="mapSearch">Final Search Parameters</h5>
				<table class="table table-borderless">
					<tr><td> Square Footage</td><td> +/- 10%</td></tr>
					<tr><td>Radius</td><td> &lt; 1 Mile </td></tr>
					<tr><td>Age</td><td>+/- 5 Years</td></tr>
					<tr><td>Lot Size</td><td>+/- 100%</td></tr>
					<tr><td>Stories</td><td>2</td></tr>
					<tr><td> Date of Sale</td><td>  &lt; 1 Year </td></tr>
				</table>
		</div>
		</div>		


		<div class="clearfix"></div>
<form id="resultForm" action="" method="post">
		<div class="row">
			<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
					<h4 class="resultHeading">Potential Comparable Sales</h4>
					<table class="table " id="compTable">
					 <thead>
						<tr rowspan="2">
							<th colspan="11" style="border:none;"></th>
							<th colspan="2" style="border:none;">Public Record Match</th>
							<th style="border:none;"></th>
						</tr>					
						<tr>					 
							<th>Address</th>
							<th>Distance</th>
							<th>Bd/Ba</th>
							<th>SF</th>
							<th>Yr</th>
							<th>Lot</th>
							<th>Stories</th>
							<th>Pool</th>
							<th>Bsmnt</th>
							<th>Date Sold</th>
							<th>Amount</th>
							<th>Sales $</th>
							<th>Sales Date</th>						
							<th></th>
					  </tr>
					 </thead>
					<tbody>
					<?php
						$i=1;
						$seq=1;
						$aMatchData = array();
							
						foreach($aSearchProp as $row){
						

							if($i>$maxRecords){
								break;
							}
							$i++;
						
							$latitude = $row['latitude'];
							$longitude = $row['longitude'];
						
							$markers[]=array('id'=>$seq, 'address'=>$row['address'], 'latitude'=>$latitude, 'longitude'=>$longitude);
						
							if(!isset($row['ay']))
							{
								//echo "<pre>"; print_r($res);
								foreach($res as $rs){
									if($row['address']==$rs['address']){
										
										if($row['dateSold']==$rs['dateSold']){
											$dy = "Y";
										}else{ 
											$dy = "N/a";
										}

										if($row['amount']==$rs['amount']){
											$ay = "Y";
										}
										else{
											$ay = "N/a";
										}
										break;
									}else{

										$ay="N/a";
										$dy="N/a";
									}
								}
								$row['ay'] = $ay;
								$row['dy'] = $dy;
							}

							if($row['dy']==""){$row['dy']="N/a";}
							if($row['ay']==""){$row['ay']="N/a";}
							echo '<tr>';
							echo '<td>'.$seq.'. '.$row['address'].'</td>';
							echo '<td>'.$row['distance'].'miles</td>';
							echo '<td>'.$row['bedsBaths'].'</td>';
							echo '<td>'.$row['sq_size'].'</td>';
							echo '<td>'.$row['year_built'].'</td>';
							echo '<td>'.$row['lot_size'].'</td>';
							echo '<td>'.$row['stories'].'</td>';
							echo '<td>'.$row['pool'].'</td>';
							echo '<td>'.$row['basement'].'</td>';							
							echo '<td>'.$row['dateSold'].'</td>';
							echo '<td>$'.$row['amount'].'</td>';
							if($user==1){ 
								echo '<td>'.$row['dy'].'</td>';
								echo '<td>'.$row['ay'].'</td>';

								if(isset($_SESSION['results']['utilizes'][$seq])){
								$util=$_SESSION['results']['utilizes'][$seq];
								?>
								<td>
								<select name="utilizes[<?php echo $seq;?>]" onchange="return checkReason(this.value, <?php echo $seq;?>);">
									<option value="Yes" <?php if($util=="Yes"){ echo " selected"; }?>>Yes</option>
									<option value="No" <?php if($util=="No"){ echo " selected"; }?>>No</option>
								</select>
								</td>
								<?php
								}else{
									echo '<td>
									<select name="utilizes['.$seq.']" onchange="return checkReason(this.value, '.$seq.');">
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									</td>';
								}
							}
							echo '</tr>';
							echo '<tr id="sequence_'.$seq.'">';
							if($util=="No"){
								echo '<td colspan="15">
								<select class="reasonRisk" name="reasonRisk_'.$seq.'">';

								if($_SESSION['results']['reasonRisk_'.$seq]==1){
									echo '<option value="1" selected>Poor Condition of Subject/Good Condition of Comp</option>';
								}else{
									echo '<option value="1" >Poor Condition of Subject/Good Condition of Comp</option>';
								}
								
								if($_SESSION['results']['reasonRisk_'.$seq]==2){
									echo '<option value="2" selected>None</option></select> &nbsp; &nbsp; ';
								}else{
									echo '<option value="2">None</option></select> &nbsp; &nbsp;';
								}
								
								echo '<select class="noteRisk" name="noteRisk_'.$seq.'">';

								if($_SESSION['results']['noteRisk_'.$seq]==1){
									echo '<option value="1" selected>I didnt use this property because</option>';
								}else{
									echo '<option value="1">I didnt use this property because</option>';
								}
								
								if($_SESSION['results']['noteRisk_'.$seq]==2){
									echo '<option value="2" selected>None</option></select></td>';
								}else{
									echo '<option value="2">None</option></select></td>';
								}
							
							}
							echo '</tr>';
							$aMatchData[$seq] = $row;			
							$seq++;
						}
						$strMatchData = urlencode(serialize($aMatchData));
						$_SESSION['results']['matchResult']=$strMatchData;
					?>    
					<input type="hidden" name="matchResult" id="matchResult" value="<?php echo $strMatchData; ?>" />
					</tbody>
				</table>

						
  		<?php
        $locstring='';    
        $c=1;
        foreach($markers as $m){
        	if($c==1){ $color="red";}
        	else if($c%2==0){ $color ="green";}else{$color="blue";}
	        $c++;
			if($m['id']=="C"){
				$color = 'purple';
			}else{
				$color = $m['id'];
			}
	        $locstring=$locstring.'&markers=color:'.$color.'%7Clabel:'.$m['id'].'%7C'.$m['latitude'].','.$m['longitude'];
        }
        $url="http://maps.googleapis.com/maps/api/staticmap?zoom=15&size=800x400&maptype=ROADMAP&".urlencode("center")."=".$locstring."&sensor=false";
		$_SESSION['results']['map'] = $url;
		$_SESSION['map']=$url;
?>
			</div>
		</div>
		
		
		
		<div class="row">
			<div class="col-sm-12">
				<h5 class="resultHeading">I used the following parameters for my comparable selection in the appraisal report:</h5>
		

				<table class="table table-borderless">
						<tr>
				<td class="paramTd">Square Footage </td>
				<td class="paramDt"><select name="compSq" class="input-medium"><option value="+/-10%"> +/-10%</option></td>
			</tr>

			<tr>
				<td class="paramTd">Radius </td>
				<td class="paramDt"><select name="compRadius" class="input-medium"><option value="< Mile">< 1 Mile</option></td>
			</tr>

			<tr>
				<td class="paramTd">Age </td>
				<td class="paramDt"><select name="compAge" class="input-medium"><option value="+/- 5 Years"> +/- 5 Years</option></td>
			</tr>

			<tr>
				<td class="paramTd">Lot Size </td>
				<td class="paramDt"><select name="compLot" class="input-medium"><option value="+/- 100%"> +/- 100%</option></td>
			</tr>

			<tr>
				<td class="paramTd">Stories</td>
				<td class="paramDt"><select class="input-medium" name="compStories"><option value="2"> 2</option></td>
			</tr>

			<tr>
				<td class="paramTd">Date of Sale</td>
				<td class="paramDt"><select name="compSale" class="input-medium"><option value="<1 Year"> < 1 Year</option></td>
			</tr>	
						
				</table>	

			</div>
		</div>

	

	<div class="row">
		<div class="col-sm-12">
		<h5 class="resultHeading">Please list any other sales that should be addressed that weren't used in appraisal:</h5>
		
		<div class="row">
			<div class="col-sm-6">
			<p class="resultSection">Address:</p>
				<table class="table table-striped">
					<tr><td>1. <input type="text" class="input-medium" style="width:80%;" name="paramAdd[]" value="<?php echo $_SESSION['results']['paramAdd'][0];?>" /></td></tr>
					<tr><td>2. <input type="text" class="input-medium" style="width:80%;" name="paramAdd[]" value="<?php echo $_SESSION['results']['paramAdd'][1];?>"/></td></tr>
					<tr><td>3. <input type="text" class="input-medium" style="width:80%;" name="paramAdd[]" value="<?php echo $_SESSION['results']['paramAdd'][2];?>" /></td></tr>
				</table>
			</div>
		
			<div class="col-sm-6">
			<p class="resultSection">Comments:</p>
			<table class="table table-striped">
					<tr><td>&nbsp;<input type="text" class="input-medium pcom" style="width:80%;" name="paramComments[]" value="<?php echo $_SESSION['results']['paramComments'][0];?>"/></td></tr>
					<tr><td>&nbsp;<input type="text" class="input-medium pcom" name="paramComments[]" style="width:80%;" value="<?php echo $_SESSION['results']['paramComments'][1];?>"/></td></tr>
					<tr><td>&nbsp;<input type="text" class="input-medium pcom" name="paramComments[]" style="width:80%;" value="<?php echo $_SESSION['results']['paramComments'][2];?>"/></td></tr>
				</table>
			</div>
		</div>

		</div>
	</div>
</form>
<div class="row">
<div class="col-sm-12">
  <div class="pull-right">
	<button type="button" class="btn btn-success" style="padding:8px 8px 8px 8px;" id="continueBtn">&nbsp; Next &nbsp; </button>
  </div>
</div>
</div>
<?php
        $locstring='';    
        $c=1;
        foreach($markers as $m){
        	if($c==1){ $color="red";}
        	else if($c%2==0){ $color ="green";}else{$color="blue";}
	        $c++;
			if($m['id']=="C"){
				$color = 'purple';
			}else{
				$color = $m['id'];
			}
	        $locstring=$locstring.'&markers=color:'.$color.'%7Clabel:'.$m['id'].'%7C'.$m['latitude'].','.$m['longitude'];
        }
        $url="http://maps.googleapis.com/maps/api/staticmap?zoom=15&size=800x400&maptype=ROADMAP&".urlencode("center")."=".$locstring."&sensor=false";
		$_SESSION['results']['map'] = $url;
		$_SESSION['map']=$url;
?>


		
	
		<div class="row">
		<div class="col-sm-12" style="padding:20px 0px 30px 15px;">
		
		<div style="padding:10px 80px 5px 0px; float:right;">
		<!--<button type="button" class="btn btn-success" style="padding:2px 5px 0px 5px;">Continue Analysis>></button>-->
		</div>
		</div>
		</div>
		
		
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
			<script type="text/javascript">

			function checkReason(util, id){
					if(util=="No"){
						var data = '<td colspan="15"><select class="reasonRisk input-medium" name="reasonRisk_'+id+'"><option value="1">Poor Condition of Subject/Good Condition of Comp</option><option value="2">None</option></select> &nbsp; &nbsp; <select class="noteRisk input-medium" name="noteRisk_'+id+'"><option value="1">I didn\'t use this property because</option><option value="2">None</option></select></td>';
						document.getElementById('sequence_'+id+'').innerHTML = data;
					}else{
						document.getElementById('sequence_'+id+'').innerHTML = '';
					}
			}

			jQuery(function($) {
				// Asynchronously Load the map API 
				var script = document.createElement('script');
				script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
				document.body.appendChild(script);
			});

			function initialize() {
				var map;
				var bounds = new google.maps.LatLngBounds();
				var mapOptions = {
					zoom: 6,
					center: new google.maps.LatLng(<?php echo $main['latitude']; ?>, <?php echo $main['longitude']; ?>),
					mapTypeId: 'roadmap'
				};
								
				// Display a map on the page
				map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
				map.setTilt(45);
					
				// Multiple Markers
				var markers = [
					<?php
						$count = count($markers);
						foreach($markers as $m){
							$count--;
							if($count==0){
								echo "['".$m['address']."',".$m['latitude'].",".$m['longitude']."]";
							}else{
							echo "['".$m['address']."',".$m['latitude'].",".$m['longitude']."],";
							}
						}
					?>
			
				];
									
				// Info Window Content
				/*var infoWindowContent = [
					['<div class="info_content">' +
					'<h3>London Eye</h3>' +
					'<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' +        '</div>'],
					['<div class="info_content">' +
					'<h3>Palace of Westminster</h3>' +
					'<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
					'</div>']
				];*/
					
				// Display multiple markers on a map
				//var infoWindow = new google.maps.InfoWindow(), marker, i;
				// Loop through our array of markers & place each one on the map  
				for( i = 0; i < markers.length; i++ ) {
					var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
					bounds.extend(position);
					marker = new google.maps.Marker({
						position: position,
						map: map,
 						title: markers[i][0],
					});
					
					// Allow each marker to have an info window    
					/*google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infoWindow.setContent(infoWindowContent[i][0]);
							infoWindow.open(map, marker);
						}
					})(marker, i));
					*/
					// Automatically center the map fitting all markers on the screen
					map.fitBounds(bounds);
				}

				// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
				var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
					//this.setZoom(60);
					google.maps.event.removeListener(boundsListener);
				});
				
			}
			 

			$('#continueBtn').click(function() { 
				
				var currentPage="results";
				var matchResult = $("#matchResult").val();

				var dataString = '&matchResult='+matchResult;
				
				$.ajax({
				type: "POST",
				data: $('#resultForm').serialize()+dataString,
				url: "home.php?page=report&set_page=results",
				success: function(data){	
				$("#pageContent").html(data);
				<?php if($user==2){  ?>
					$('.nav-stacked li').removeClass('active')
					$(".nav-stacked li:nth-child(3)").addClass("active");
					<?php } else{ ?>
					$('.nav-stacked li').removeClass('active')
					$(".nav-stacked li:nth-child(4)").addClass("active");
					<?php } ?>
				}
				});
			});	
	

		</script>