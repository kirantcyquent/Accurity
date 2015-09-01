<!-- downloadReport<br>
<br><br>
		<table width="100%" style="border-bottom:1px solid #ccc;font-size:14px;">
			<tr>
				<td valign="top" width="60%">	
					<h5 class="report-header"><?php echo $address; ?></h5>
					<h6><?php echo $bedrooms; ?> Bd | <?php echo $bathrooms; ?> Ba | <?php echo number_format($square_footage);?> Sq Ft</h6>
					<h6><?php echo $stories; ?> Stories | Lot Size <?php echo number_format($lot_size); ?></h6>
					<h6><?php echo "Pool ".$pool; ?> |  <?php echo "Basement ".$basement; ?></h6>
					<h6>Built <?php echo $year_built;?>
					</h6>
				</td>
				<td valign="top" width="40%">
					<h5 class="mapSearch"> Final Search Parameters</h5>
					<?php
						if(!isset($finalParameters)){
							$finalParameters = $_SESSION['finalParameters'];
						}
					?>
					<table style="font-size:10px !important;"  width="100%">
						<tr style="height:30px !important;"><td>Square Footage</td><td> <?php echo $finalParameters['square_footage'];?></td></tr>
						<tr style="height:25px !important;"><td>Radius</td><td> <?php echo $finalParameters['radius'];?> </td></tr>
						<tr style="height:25px !important;"><td>Age</td><td> <?php echo $finalParameters['age'];?></td></tr>
						<tr style="height:25px !important;"><td>Lot Size</td><td> <?php echo $finalParameters['lotSize'];?></td></tr>
						<tr style="height:25px !important;"><td>Stories</td><td> <?php echo $finalParameters['stories'];?></td></tr>
						<tr style="height:25px !important;"><td>Date of Sale</td><td>  <?php echo $finalParameters['dateSale'];?> </td></tr>
					</table>
				</td>
			</tr>	
			<tr style="height:25px;border-bottom:1px solid #ccc;"><td colspan=2>&nbsp;</td></tr>
		</table>
<br><br>
		<?php

	if(count($comps)>0){
		?>
		<h4 class="resultHeading">Potential Comparable Sales</h4>
		<br>
		<table id="compTable" width="100%" style="font-size:9px;">
			<thead>
				<tr bgcolor="#ccc" style="font-size:7px !important;">
					<th width="24%" style="border-right:1px solid #ccc;"><strong>Address</strong></th>
					<th width="9%" style="border-right:1px solid #ccc;"><strong>Distance</strong></th>
					<th width="11%" style="border-right:1px solid #ccc;"><strong>Bd/Ba</strong></th>
					<th width="7%" style="border-right:1px solid #ccc;"><strong>SF</strong></th>
					<th width="5%" style="border-right:1px solid #ccc;"><strong>Yr</strong></th>
					<th width="7%" style="border-right:1px solid #ccc;"><strong>Lot</strong></th>
					<th width="6%" style="border-right:1px solid #ccc;"><strong>Stories</strong></th>
					<th width="5%" style="border-right:1px solid #ccc;"><strong>Pool</strong></th>
					<th width="6%" style="border-right:1px solid #ccc;"><strong>Bsmnt</strong></th>
					<th width="10%" style="border-right:1px solid #ccc;"><strong>Date Sold</strong></th>
					<th width="10%" style="border-right:1px solid #ccc;"><strong>Amount</strong></th>
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
			  <tr bgcolor="#f6f6f6">
			  <td width="24%" style="border-right:1px solid #ccc;"><?php echo $key+1 .") ".$detail['address'];?></td>
				<td width="9%" style="border-right:1px solid #ccc;"><?php echo  sprintf('%0.2f', $detail['distance']);?>miles</td>
				<td width="11%" style="border-right:1px solid #ccc;"><?php echo $detail['bedsBaths'];?></td>
				<td width="7%" style="border-right:1px solid #ccc;"><?php echo number_format($detail['sq_size']);?></td>
				<td width="5%" style="border-right:1px solid #ccc;"><?php echo $detail['year_built'];?></td>
				<td width="7%" style="3px;border-right:1px solid #ccc;"><?php echo number_format($detail['lot_size']);?></td>
				<td width="6%" style="3px;border-right:1px solid #ccc;"><?php echo $detail['stories'];?></td>
				<td width="5%" style="3px;border-right:1px solid #ccc;"><?php echo $detail['pool'];?></td>
				<td width="6%" style="border-right:1px solid #ccc;"><?php echo $detail['basement'];?></td>
				<td width="10%" style="border-right:1px solid #ccc;"><?php echo $detail['dateSold'];?></td>
				<td width="10%" style="border-right:1px solid #ccc;">$<?php echo number_format($detail['amount']);?></td>	
			  </tr>
			  <?php
				}
			  ?>
			  
			</tbody>
  </table>
  
<br><br><br>
	<div width="50%" align="center" style="text-align:center !important;">
		<table width="80%" style="font-size:10px;" align="center">
			<tr>
				<td width="%4"><div style="width:10px; height:10px;background-color:#A689B6;"></div></td>
				<td width="25%">&nbsp;<strong>Subject Property</strong></td>
				<td width="4%"><div style="width:13px; height:10px;background-color:#99BEFD;"></div></td>
				<td width="35%">&nbsp;<strong>Potential Comparable Used</strong></td>
			</tr>
			<tr style="height:25px;"><td colspan=2>&nbsp;</td></tr>
		</table>
	</div>
	<div width="90%">
		
	</div>
		
		<?php } ?>

downloadReport-->

	<!-- report header -->
		<div class="row">
		<div class="col-lg-8 col-sm-8 col-xs-12 col-md-8 repaddress">
				<h5 class="report-header"><?php echo $address; ?></h5>
				<h6><?php echo $bedrooms; ?> Bd | <?php echo $bathrooms; ?> Ba | <?php echo number_format($square_footage);?> Sq Ft</h6>
				<h6><?php echo $stories; ?> Stories | Lot Size <?php echo number_format($lot_size); ?></h6>
				<h6><?php echo "Pool ".$pool; ?> |  <?php echo "Basement ".$basement; ?></h6>
				<h6>Built <?php echo $year_built;?>
				</h6>
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
		<!-- report header -->
	
		<div class="clearfix"></div>		
		
		<?php

		$count=1;
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
	  <td><?php echo $count.". ".$detail['address'];?></td>
        <td><?php echo  sprintf('%0.2f', $detail['distance']);?>miles</td>
        <td><?php echo $detail['bedsBaths'];?></td>
		<td><?php echo number_format($detail['sq_size']);?></td>
        <td><?php echo $detail['year_built'];?></td>
        <td><?php echo number_format($detail['lot_size']);?></td>
		<td><?php echo $detail['stories'];?></td>
		<td><?php echo $detail['pool'];?></td>
		<td><?php echo $detail['basement'];?></td>
        <td><?php echo $detail['dateSold'];?></td>
        <td>$<?php echo number_format($detail['amount']);?></td>
		

		<?php
			if($user==2){

			}else{
		?>
		<td><?php echo $detail['dy'] ?></td>
		<td><?php echo $detail['ay'] ?></td>
		<?php } ?>
      </tr>
	  <?php
	  $count++;
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
				
			if($detail['reason']==1){$reason = "Poor Condition of Subject/Good Condition of Comp &nbsp;&nbsp;&nbsp;"; } else{ $reason="None"; }
			if($detail['note']==1){ $note = "I didn't use this property because"; } else{ $note="None"; }


			
			if($odd%2==0){ $color= "#ffffff;";}else{ $color= "#f6f6f6;";}
			$odd++;
			//$detail['pool']=$pool;
			//$detail['basement']=$basement;
	?>
      <tr style="background:<?php  echo $color;?>">
        <td><?php echo $count.". ";?><?php echo $detail['address'];?></td>
        <td><?php echo  sprintf('%0.2f', $detail['distance']); ?>miles</td>
        <td><?php echo $detail['bedsBaths'];?></td>
		<td><?php echo number_format($detail['sq_size']);?></td>
        <td><?php echo $detail['year_built'];?></td>
        <td><?php echo number_format($detail['lot_size']);?></td>
		<td><?php echo $detail['stories'];?></td>
		<td><?php echo $detail['pool'];?></td>
		<td><?php echo $detail['basement'];?></td>
        <td><?php echo $detail['dateSold'];?></td>
        <td>$<?php echo number_format($detail['amount']);?></td>
		
		<td><?php echo $detail['dy'] ?></td>
		<td><?php echo $detail['ay'] ?></td>
		<td></td>
      </tr>
	   <tr style="background:<?php  echo $color;?>">
	  <td colspan="15"><span style="color:red;"><?php echo $reason;?></span>  &nbsp; <span style="color:red;">Notes: <?php echo $note;?></span></td>
	  </tr>
	  <?php
	  $count++;
		}
		
	  ?>	
	 
    </tbody>
  </table>

		</div>
		</div>		
		</div>
		<?php } ?>
		
		<div class="clearfix"></div>
		<div class="row">
		<div class="col-lg-9 col-sm-9 col-xs-12 col-md-9">
				
						<div class="pull-left indicate purple">
						
						</div>
						<div class="pull-left indicate-text">
							Subject Property
						</div>
					<?php if(count($comps)>0){?>
						<div class="pull-left indicate blue">
						
						</div>


						<div class="pull-left indicate-text">
							 Potential Comparable Used
						</div>
					<?php } ?>

					<?php if(count($not_comps)>0){?>
						<div class="pull-left indicate pink">
						
						</div>
						<div class="pull-left indicate-text">
							Potential Comparable Sales Not Used 
						</div>
						<?php } ?>
					
		
		</div>
		</div>

		<div class="clearfix"></div>

		<div class="row">
		<div>
		<div id="mp">
		

		<img src="<?php if(isset($_SESSION['results']['map']) || isset($_SESSION['map'])){ $map = isset($_SESSION['results']['map']) ? $_SESSION['results']['map'] : $_SESSION['map']; echo $map; } ?>" width="100%;" height="400px;"/>
		</div>
		
		</div>
		</div>	