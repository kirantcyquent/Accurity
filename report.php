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
	$prepared_by = $us->getUserDetails();        
		

	
	$paramAdd = serialize($_REQUEST['paramAdd']);
	$paramCom = serialize($_REQUEST['paramComments']);
	$paramCom = preg_replace("@matchResult.*?\}\}@","",$paramCom);

	$us->storeAddress($_SESSION['searchId'], $paramAdd, $paramCom);

    if($user==2){
	$address = 	isset($_SESSION['search']['address']) ? $_SESSION['search']['address']: "3101 West End Ave, Nashvelle TN 37203" ;
	$bedrooms = isset($_SESSION['search']['bedrooms']) ? $_SESSION['search']['bedrooms'] : "3";
	$bathrooms = isset($_SESSION['search']['bathrooms'])? $_SESSION['search']['bathrooms'] : "4";
	$square_footage = isset($_SESSION['search']['square_footage']) ? $_SESSION['search']['square_footage'] : "2,455";
	$stories  = isset($_SESSION['search']['stories'])? $_SESSION['search']['stories'] : "1";
	$lot_size = isset($_SESSION['search']['lot_size'])? $_SESSION['search']['lot_size']: "5,260";
	$year_built = isset($_SESSION['search']['year_built'])? $_SESSION['search']['year_built']: "1991";
	$pool = isset($_SESSION['search']['pool'])? $_SESSION['search']['pool']: "No";
	$basement = isset($_SESSION['search']['basement'])? $_SESSION['search']['basement']: "No";
	}else{
	$address = 	isset($_SESSION['refineSearch']['address']) ? $_SESSION['refineSearch']['address']: "3101 West End Ave, Nashvelle TN 37203" ;
	$bedrooms = isset($_SESSION['refineSearch']['bedrooms']) ? $_SESSION['refineSearch']['bedrooms'] : "3";
	$bathrooms = isset($_SESSION['refineSearch']['bathrooms'])? $_SESSION['refineSearch']['bathrooms'] : "4";
	$square_footage = isset($_SESSION['refineSearch']['square_footage']) ? $_SESSION['refineSearch']['square_footage'] : "2,455";
	$stories  = isset($_SESSION['refineSearch']['stories'])? $_SESSION['refineSearch']['stories'] : "1";
	$lot_size = isset($_SESSION['refineSearch']['lot_size'])? $_SESSION['refineSearch']['lot_size']: "5,260";
	$year_built = isset($_SESSION['refineSearch']['year_built'])? $_SESSION['refineSearch']['year_built']: "1991";
	$pool = isset($_SESSION['refineSearch']['pool'])? $_SESSION['refineSearch']['pool']: "No";
	$basement = isset($_SESSION['refineSearch']['basement'])? $_SESSION['refineSearch']['basement']: "No";

	$addRisk = isset($_POST['addRisk']) ? $_POST['addRisk'] : "814 31ST AVE N,3312 CLIFTON AVE,3508 PARK AVE,711 32ND AVE N,513 31ST AVE N";
	$addRisk  = explode(',',$addRisk);
	$riskCount = count($addRisk);
	$utilRisk = isset($_POST['utilRisk']) ? $_POST['utilRisk'] : "Yes,No,Yes,Yes,No";
	$utilRisk = explode(',',$utilRisk);
	$reasonRisk = isset($_POST['reasonRisk']) ? $_POST['reasonRisk'] : "1,1,1,1,1";
	$reasonRisk = explode(',',$reasonRisk);
	$noteRisk = isset($_POST['noteRisk']) ? $_POST['noteRisk'] : "1,1,1,1,1";
	$noteRisk = explode(',',$noteRisk);
}



if(isset($_SESSION['results']['matchResult'])){

	 $match  = $_SESSION['results']['matchResult'];	
	 $matchResult = unserialize(urldecode($match));

	 $comps = array();
	 $not_comps = array();

	 foreach($matchResult as $key=>$detail){

	 	if($user==2){
	 			$comps[$key]=$detail;
				$matchResult[$key]['utility'] = "Yes";
				if(isset($_SESSION['results']['map']))
					$_SESSION['results']['map'] = preg_replace("@color:$key\%@","color:blue%",$_SESSION['results']['map']);
				if(isset($_SESSION['map']))
					$_SESSION['map'] = preg_replace("@color:$key\%@","color:blue%",$_SESSION['map']);

	 	}else{
			
		 	if($_SESSION['results']['utilizes'][$key]=="Yes" ){
				$comps[$key]=$detail;
				$matchResult[$key]['utility'] = "Yes";
				if(isset($_SESSION['results']['map']))
					$_SESSION['results']['map'] = preg_replace("@color:$key\%@","color:blue%",$_SESSION['results']['map']);
				if(isset($_SESSION['map']))
					$_SESSION['map'] = preg_replace("@color:$key\%@","color:blue%",$_SESSION['map']);
			}
			else{
			
				 
				$reason = $_REQUEST['reasonRisk_'.$key.''];
				$note  = $_REQUEST['noteRisk_'.$key.''];
				$detail['reason']=$reason;
				$detail['note']=$note;
				$not_comps[$key]=$detail; 
				$matchResult[$key]['utility'] = "No";
				$matchResult[$key]['reason'] = $reason;
				$matchResult[$key]['note'] = $note;

	

				if(isset($_SESSION['results']['map']))
					$_SESSION['results']['map'] = preg_replace("@color:$key\%@","color:pink%",$_SESSION['results']['map']);
				if(isset($_SESSION['map']))
					$_SESSION['map'] = preg_replace("@color:$key\%@","color:pink%",$_SESSION['map']);
			}
	 	}
		
	 }
	
	$_SESSION['results']['matchResult'] = urlencode(serialize($matchResult));
	$us->updateSearch($address, 1, $_SESSION, $_SESSION['searchId']);
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


$_SESSION['sessionId'] = session_id();


?>
		<form action="convert.php" method="post" id="conv" name="conv">
		<div id="content">
		<div id="aclogo"></div>


		<!-- downloadReport<br>

		<table>
			<tr>
				<td valign="top">	
					<h5 class="report-header"><?php echo $address; ?></h5>
					<h6><?php echo $bedrooms; ?> Bd | <?php echo $bathrooms; ?> Ba | <?php echo $square_footage;?> Sq Ft</h6>
					<h6><?php echo $stories; ?> Stories | Lot Size <?php echo $lot_size; ?></h6>
					<h6><?php echo "Pool ".$pool; ?> |  <?php echo "Basement ".$basement; ?></h6>
					<h6>Built <?php echo $year_built;?>
					</h6>
				</td>
				<td valign="top">
				<h5 class="report-by">Report Prepared By</h5>
				<h6><?php echo $prepared_by['Name']; ?></h6>
				<h6><?php echo $prepared_by['Address']; ?></h6>
				<h6  class="linkColor"><a href="mailto:<?php echo $prepared_by['UserName']; ?>"><?php echo $prepared_by['UserName']; ?></a>		
				</h6>
			</td>
			</tr>	
		</table>

		<br>

		<table style="width:100%;">
			<tr>
				<td style="width:5%; height:10px;background-color:#A689B6;"></td>
				<td>Subject Property</td>
				<td style="width:5%; height:10px;background-color:#99BEFD;"></td>
				<td>Potential Comparable Sales Used</td>
				<td style="width:5%; height:10px;background-color:#F5635B;"></td>
				<td>Potential Comparable Sales Not Used </td>
			</tr>
		</table>


		<br>

		<table>
		<tr>
			<td valign="top" id="mp">
				
				<img src="<?php if(isset($_SESSION['results']['map']) || isset($_SESSION['map'])){ $map = isset($_SESSION['results']['map']) ? $_SESSION['results']['map'] : $_SESSION['map']; echo $map; } ?>" width="100%;"/>
				
			</td>
		    <td valign="top">
			<h5 class="mapSearch">Final Search Parameters</h5>
				<?php
				if(!isset($finalParameters)){
					$finalParameters = $_SESSION['finalParameters'];
				}
			?>
				<table class="table table-borderless">
					<tr><td> Square Footage</td><td> <?php echo $finalParameters['square_footage'];?></td></tr>
					<tr><td>Radius</td><td> <?php echo $finalParameters['radius'];?> </td></tr>
					<tr><td>Age</td><td> <?php echo $finalParameters['age'];?></td></tr>
					<tr><td>Lot Size</td><td> <?php echo $finalParameters['lotSize'];?></td></tr>
					<tr><td>Stories</td><td> <?php echo $finalParameters['stories'];?></td></tr>
					<tr><td> Date of Sale</td><td>  <?php echo $finalParameters['dateSale'];?> </td></tr>
				</table>
		</td>
		</tr>	
		</table>

		<br>

		<?php

	if(count($comps)>0){
		?>
		
		<h4 class="resultHeading">Potential Comparable Sales</h4>
		<br>
		<table class="table table-striped" id="compTable">
   <thead>
   	 <?php
			if($user==2){

			}else{?>
     <tr rowspan="2">
    <th colspan="11" style="border:none;"></th>
    <th colspan="2" style="border:none;">Public Record Match</th>
    <th style="border:none;"></th>
    </tr>
    <?php }?>
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
        <?php
			if($user==2){

			}else{
		?>
		<th>Sales $</th>
		<th>Sales Date</th>
		<?php
	}
		?>
		
		<th>Concessions</th>
      </tr>
    </thead>
    <tbody>
		
      </tr>
    </thead>
    <tbody>
	<?php
	
		//for($i=0;$i<$riskCount;$i++){
	$odd=1;
			foreach($comps as $key=>$detail){
				if($odd%2==0){ $color= "#ffffff;";}else{ $color= "#f6f6f6;";}
			$odd++;
		//	$detail['pool']=$pool;
		//	$detail['basement']=$basement;
			
	?>
      <tr >
	  <td><?php echo $key.". ".$detail['address'];?></td>
        <td><?php echo  sprintf('%0.2f', $detail['distance']);?>miles</td>
        <td><?php echo $detail['bedsBaths'];?></td>
		<td><?php echo $detail['sq_size'];?></td>
        <td><?php echo $detail['year_built'];?></td>
        <td><?php echo $detail['lot_size'];?></td>
		<td><?php echo $detail['stories'];?></td>
		<td><?php echo $detail['pool'];?></td>
		<td><?php echo $detail['basement'];?></td>
        <td><?php echo $detail['dateSold'];?></td>
        <td>$<?php echo $detail['amount'];?></td>
		

		<?php
			if($user==2){

			}else{
		?>
		<td><?php echo $detail['dy'] ?></td>
		<td><?php echo $detail['ay'] ?></td>
		<?php } ?>
		<td></td>
      </tr>
	  <?php
		}
	  ?>
	  
    </tbody>
  </table>
		
		<?php } ?>
		
		<?php
	if(count($not_comps)>0){
		?>
		<h4 class="resultHeading">Potential Comparable Sales Not Used</h4>

		<table class="table table-striped" id="compTable">
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
		<th>Concessions</th>
      </tr>
    </thead>
    <tbody>
	<?php
	$odd=1;
		foreach($not_comps as $key=>$detail){
				
			if($detail['reason']==1){$reason = "Poor Condition of Subject/Good Condition of Comp"; } else{ $reason="None"; }
			if($detail['note']==1){ $note = "I didn't use this property because"; } else{ $note="None"; }


			
			if($odd%2==0){ $color= "#ffffff;";}else{ $color= "#f6f6f6;";}
			$odd++;
			//$detail['pool']=$pool;
			//$detail['basement']=$basement;
	?>
      <tr style="background:<?php  echo $color;?>">
        <td><?php echo $key.". ";?><?php echo $detail['address'];?></td>
        <td><?php echo  sprintf('%0.2f', $detail['distance']);?>miles</td>
        <td><?php echo $detail['bedsBaths'];?></td>
		<td><?php echo $detail['sq_size'];?></td>
        <td><?php echo $detail['year_built'];?></td>
        <td><?php echo $detail['lot_size'];?></td>
		<td><?php echo $detail['stories'];?></td>
		<td><?php echo $detail['pool'];?></td>
		<td><?php echo $detail['basement'];?></td>
        <td><?php echo $detail['dateSold'];?></td>
        <td>$<?php echo $detail['amount'];?></td>
		
		<td><?php echo $detail['dy'] ?></td>
		<td><?php echo $detail['ay'] ?></td>
		<td></td>
      </tr>
	   <tr style="background:<?php  echo $color;?>">
	  <td colspan="15"><span style="color:red;"><?php echo $reason;?></span>  &nbsp; <span style="color:red;">Notes: <?php echo $note;?></span></td>
	  </tr>
	  <?php
		}
		
	  ?>	
	 
    </tbody>
  </table>

		<?php } ?>

		<br>
		<h5 style="color:black;font-weight:bold;">I used the following parameters for my comparable selection in the appraisal report:
		
<?php echo $_SESSION['results']['compSq'];?> square footage , date of sale <?php echo $_SESSION['results']['compSale'];?>, <?php echo $_SESSION['results']['compRadius'];?>. 
Please list any other sales that should be addressed that weren't used in appraisal:
</h5>


<table style="width:100%;">
	<tr>
		<td valign="top">
			<?php
			if(count($_SESSION['results']['paramAdd'])>0){
			?>
			<p style="font-weight:bold;color:black;">Address:</p>
				<table class="table table-striped">
					<?php 	$count=1; foreach($_SESSION['results']['paramAdd'] as $res): ?>
					<tr><td><?php echo $count; $count++;?>. <?php echo $res;?></td></tr>
					<?php endforeach; ?>
				</table>				
				<?php } ?>
		</td>
		
		<td>
			<?php
			if(count($_SESSION['results']['paramComments'])>0){
			?>
			<p style="font-weight:bold;color:black;">Comments:</p>
			<table class="table table-striped">
					<?php 	$count=1; foreach($_SESSION['results']['paramComments'] as $res): ?>
					<tr><td><?php echo $count; $count++;?>. <?php echo $res;?></td></tr>
					<?php endforeach; ?>
				</table>
				<?php } ?>
				
		</td>
	</tr>
</table>

		
		downloadReport-->

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
		<div id="mp">
		<img src="<?php if(isset($_SESSION['results']['map']) || isset($_SESSION['map'])){ $map = isset($_SESSION['results']['map']) ? $_SESSION['results']['map'] : $_SESSION['map']; echo $map; } ?>" width="100%;"/>
		</div>
		
		</div>
		<div class="col-lg-4 col-sm-4 col-xs-12 col-md-4 repaddress">
			<h5 class="mapSearch">Final Search Parameters</h5>
				<?php
				if(!isset($finalParameters)){
					$finalParameters = $_SESSION['finalParameters'];
				}
			?>
				<table class="table table-borderless">
					<tr><td> Square Footage</td><td> <?php echo $finalParameters['square_footage'];?></td></tr>
					<tr><td>Radius</td><td> <?php echo $finalParameters['radius'];?> </td></tr>
					<tr><td>Age</td><td> <?php echo $finalParameters['age'];?></td></tr>
					<tr><td>Lot Size</td><td> <?php echo $finalParameters['lotSize'];?></td></tr>
					<tr><td>Stories</td><td> <?php echo $finalParameters['stories'];?></td></tr>
					<tr><td> Date of Sale</td><td>  <?php echo $finalParameters['dateSale'];?> </td></tr>
				</table>
		</div>
		</div>	
	

		<div class="clearfix"></div>

		
		
		<?php

	if(count($comps)>0){
		?>
		<div class="row">
			<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
					<h4 class="resultHeading">Potential Comparable Sales</h4>

			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
		<table class="table table-striped" id="compTable">
   <thead>
   	 <?php
			if($user==2){

			}else{?>
     <tr rowspan="2">
    <th colspan="11" style="border:none;"></th>
    <th colspan="2" style="border:none;">Public Record Match</th>
    <th style="border:none;"></th>
    </tr>
    <?php }?>
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
        <?php
			if($user==2){

			}else{
		?>
		<th>Sales $</th>
		<th>Sales Date</th>
		<?php
	}
		?>
		
		<th>Concessions</th>
      </tr>
    </thead>
    <tbody>
		
      </tr>
    </thead>
    <tbody>
	<?php
	
		//for($i=0;$i<$riskCount;$i++){
	$odd=1;
			foreach($comps as $key=>$detail){
				if($odd%2==0){ $color= "#ffffff;";}else{ $color= "#f6f6f6;";}
			$odd++;
		//	$detail['pool']=$pool;
		//	$detail['basement']=$basement;
			
	?>
      <tr >
	  <td><?php echo $key.". ".$detail['address'];?></td>
        <td><?php echo  sprintf('%0.2f', $detail['distance']);?>miles</td>
        <td><?php echo $detail['bedsBaths'];?></td>
		<td><?php echo $detail['sq_size'];?></td>
        <td><?php echo $detail['year_built'];?></td>
        <td><?php echo $detail['lot_size'];?></td>
		<td><?php echo $detail['stories'];?></td>
		<td><?php echo $detail['pool'];?></td>
		<td><?php echo $detail['basement'];?></td>
        <td><?php echo $detail['dateSold'];?></td>
        <td>$<?php echo $detail['amount'];?></td>
		

		<?php
			if($user==2){

			}else{
		?>
		<td><?php echo $detail['dy'] ?></td>
		<td><?php echo $detail['ay'] ?></td>
		<?php } ?>
		<td></td>
      </tr>
	  <?php
		}
	  ?>
	  
    </tbody>
  </table>
		</div>
		</div>
		<?php } ?>
		<div id="break"></div>
		<?php
	if(count($not_comps)>0){
		?>
		<div class="row">
			<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
					<h4 class="resultHeading">Potential Comparable Sales Not Used</h4>

			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
		<table class="table table-striped" id="compTable">
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
		<th>Concessions</th>
      </tr>
    </thead>
    <tbody>
	<?php
	$odd=1;
		foreach($not_comps as $key=>$detail){
				
			if($detail['reason']==1){$reason = "Poor Condition of Subject/Good Condition of Comp"; } else{ $reason="None"; }
			if($detail['note']==1){ $note = "I didn't use this property because"; } else{ $note="None"; }


			
			if($odd%2==0){ $color= "#ffffff;";}else{ $color= "#f6f6f6;";}
			$odd++;
			//$detail['pool']=$pool;
			//$detail['basement']=$basement;
	?>
      <tr style="background:<?php  echo $color;?>">
        <td><?php echo $key.". ";?><?php echo $detail['address'];?></td>
        <td><?php echo  sprintf('%0.2f', $detail['distance']); ?>miles</td>
        <td><?php echo $detail['bedsBaths'];?></td>
		<td><?php echo $detail['sq_size'];?></td>
        <td><?php echo $detail['year_built'];?></td>
        <td><?php echo $detail['lot_size'];?></td>
		<td><?php echo $detail['stories'];?></td>
		<td><?php echo $detail['pool'];?></td>
		<td><?php echo $detail['basement'];?></td>
        <td><?php echo $detail['dateSold'];?></td>
        <td>$<?php echo $detail['amount'];?></td>
		
		<td><?php echo $detail['dy'] ?></td>
		<td><?php echo $detail['ay'] ?></td>
		<td></td>
      </tr>
	   <tr style="background:<?php  echo $color;?>">
	  <td colspan="15"><span style="color:red;"><?php echo $reason;?></span>  &nbsp; <span style="color:red;">Notes: <?php echo $note;?></span></td>
	  </tr>
	  <?php
		}
		
	  ?>	
	 
    </tbody>
  </table>

		</div>
		</div>		
		</div>
		<?php } ?>

		<div class="row">
		<div class="col-sm-12" style="padding:20px 0px 20px 20px;">
		<h5 style="color:black;font-weight:bold;">I used the following parameters for my comparable selection in the appraisal report:
		<br>
<?php echo $_SESSION['results']['compSq'];?> square footage , date of sale <?php echo $_SESSION['results']['compSale'];?>, <?php echo $_SESSION['results']['compRadius'];?>. 
Please list any other sales that should be addressed that weren't used in appraisal:
</h5>
<div class="row" style="padding:20px 0px 20px 20px;">
			<div class="col-sm-6">
			<?php
			if(count($_SESSION['results']['paramAdd'])>0){
			?>
			<p style="font-weight:bold;color:black;">Address:</p>
				<table class="table table-striped">
					<?php 	$count=1; foreach($_SESSION['results']['paramAdd'] as $res): ?>
					<tr><td><?php echo $count; $count++;?>. <?php echo $res;?></td></tr>
					<?php endforeach; ?>
				</table>				
				<?php } ?>
			</div>
		
			<div class="col-sm-6">
			<?php
			if(count($_SESSION['results']['paramComments'])>0){
			?>
			<p style="font-weight:bold;color:black;">Comments:</p>
			<table class="table table-striped">
					<?php 	$count=1; foreach($_SESSION['results']['paramComments'] as $res): ?>
					<tr><td><?php echo $count; $count++;?>. <?php echo $res;?></td></tr>
					<?php endforeach; ?>
				</table>
				<?php } ?>
				
			</div>
		</div>

		
		

		
		

	<div class="row">
        <div class="col-sm-12" >
		<div class="pull-right">
		<button type="button" class="btn btn-success " style="margin:3px;" onclick="convert_pdf();">Create Report</button>
		</div>	
	</div>
		


		<input type="hidden" name="cc" value="" id="cc"/>
</form>
		<script>
		function convert_pdf(){
			var data = document.getElementById('content').innerHTML;
			var dataString = data;
			document.getElementById('cc').value = dataString;
			conv.submit();
		}
		</script>
		
		