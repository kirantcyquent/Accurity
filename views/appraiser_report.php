<!-- downloadReport<br>

		<table width="100%">
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
					<h5 class="report-by">Report Prepared By</h5>
					<h6><?php echo $prepared_by['Name']; ?></h6>
					<h6 style="line-height:150%"><?php echo $prepared_by['Address']; ?></h6>
					<h6  class="linkColor"><a href="mailto:<?php echo $prepared_by['UserName']; ?>"><?php echo $prepared_by['UserName']; ?></a>		
					</h6>
				</td>
			</tr>	
			<tr style="height:25px;"><td colspan=2>&nbsp;</td></tr>
		</table>

		<table width="60%" style="font-size:6px;">
			<tr>
				<td width="4%"><div style="width:10px; height:10px;background-color:#A689B6;"></div></td>
				<td width="16%">&nbsp;<strong>Subject Property</strong></td>
				<td width="4%"><div style="width:13px; height:10px;background-color:#003F7F;"></div></td>
				<td width="33%">&nbsp;<strong>Potential Comparable Sales Used</strong></td>
				<td width="4%"><div style="width:13px; height:10px;background-color:#F5635B;"></div></td>
				<td width="35%">&nbsp;<strong>Potential Comparable Sales Not Used</strong> </td>
			</tr>
			<tr style="height:25px;"><td colspan=2>&nbsp;</td></tr>
		</table>

		<table width="100%" valign="top">
			<tr>
				<td valign="top" id="mp" width="60%">
					
					<img src="<?php if(isset($_SESSION['results']['map']) || isset($_SESSION['map'])){ $map = isset($_SESSION['results']['map']) ? $_SESSION['results']['map'] : $_SESSION['map']; echo $map; } ?>" width="100%;"/>
					
				</td>
				<td valign="top" width="40%" valign="top">
				<h5 class="mapSearch">Final Search Parameters</h5>
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
						<tr style="height:25px !important;"><td>STY</td><td> <?php echo $finalParameters['stories'];?></td></tr>
						<tr style="height:25px !important;"><td>Date of Sale</td><td>  <?php echo $finalParameters['dateSale'];?> </td></tr>
					</table>
				</td>
			</tr>	
			<tr style="height:25px;"><td colspan=2>&nbsp;</td></tr>
		</table>

		<?php

	if(count($comps)>0){
		?>
		<br><br><br><br><br><br><br><br>
		<h4 class="resultHeading">Potential Comparable Sales</h4>
		<br>
		<table id="compTable" width="100%" style="font-size:9px;">
			<thead>
				<?php
					if($user==2){

					}else{?>
				<tr bgcolor="#ccc" style="font-size:7px !important;">
					<th colspan="11" width="85%">&nbsp;</th>
					<th colspan="2" width="11%" style="border-right:1px solid #ccc;"><strong>Public Record Match</strong></th>
					<th width="4%">&nbsp;</th>
				</tr>
				<?php }?>
				<tr bgcolor="#ccc" style="font-size:7px !important;">
					<th width="22%" style="border-right:1px solid #ccc;"><strong>Address</strong></th>
					<th width="7%" style="border-right:1px solid #ccc;"><strong>Distance</strong></th>
					<th width="5%" style="border-right:1px solid #ccc;"><strong>Bd/Ba</strong></th>
					<th width="7%" style="border-right:1px solid #ccc;text-align:center;"><strong>SF</strong></th>
					<th width="5%" style="border-right:1px solid #ccc;text-align:center;"><strong>Yr</strong></th>
					<th width="7%" style="border-right:1px solid #ccc;text-align:center;"><strong>Lot</strong></th>
					<th width="4%" style="border-right:1px solid #ccc;text-align:center;"><strong>STY</strong></th>
					<th width="5%" style="border-right:1px solid #ccc;text-align:center;"><strong>Pool</strong></th>
					<th width="5%" style="border-right:1px solid #ccc;text-align:center;"><strong>BSMT</strong></th>
					<th width="10%" style="border-right:1px solid #ccc;text-align:center;"><strong>Date Sold</strong></th>
					<th width="8%" style="border-right:1px solid #ccc;text-align:center;"><strong>Amount</strong></th>
					<th width="6%" style="border-right:1px solid #ccc;text-align:center;"><strong>Sales $</strong></th>
					<th width="5%" style="border-right:1px solid #ccc;text-align:center;"><strong>Sales Date</strong></th>
					<th width="4%" style="border-right:1px solid #ccc;text-align:center;"><strong>Concessions</strong></th>
				</tr>
			</thead>
			<tbody>
			<?php
			
				//for($i=0;$i<$riskCount;$i++){
			$odd=1;
					foreach($comps as $key2=>$detail){
						if($odd%2==0){ $color= "#ffffff;";}else{ $color= "#f6f6f6;";}
					$odd++;
				//	$detail['pool']=$pool;
				//	$detail['basement']=$basement;
					
			?>
			  <tr bgcolor="#f6f6f6">
			  <td width="22%" style="border-right:1px solid #ccc;"><?php echo $key2+1 .") ".$detail['address'];?></td>
				<td width="7%" style="border-right:1px solid #ccc;"><?php echo  sprintf('%0.2f', $detail['distance']);?> mi</td>
				<td width="5%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['bedsBaths'];?></td>
				<td width="7%" style="border-right:1px solid #ccc;text-align:center;"><?php echo number_format($detail['sq_size']);?></td>
				<td width="5%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['year_built'];?></td>
				<td width="7%" style="3px;border-right:1px solid #ccc;text-align:center;"><?php echo number_format($detail['lot_size']);?></td>
				<td width="4%" style="3px;border-right:1px solid #ccc;text-align:center;"><?php echo $detail['stories'];?></td>
				<td width="5%" style="3px;border-right:1px solid #ccc;text-align:center;"><?php echo $detail['pool'];?></td>
				<td width="5%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['basement'];?></td>
				<td width="10%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['dateSold'];?></td>
				<td width="8%" style="border-right:1px solid #ccc;text-align:center;">$<?php echo number_format($detail['amount']);?></td>	
				<td width="6%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['dy'] ?></td>
				<td width="5%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['ay'] ?></td>
				<td width="4%">&nbsp;</td>
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
		
		<?php

	if(count($comps)==0){
		$odd=0;
		?>
		<br><br><br><br><br><br><br><br><br>
	<?php }else{$odd=$key2+1;}?>
		<h4 class="resultHeading">Potential Comparable Sales Not Used</h4>

		<table id="compTable" width="100%" style="font-size:9px;">
    <thead>
        <tr bgcolor="#ccc" style="font-size:7px !important;">
			<th colspan="11" width="85%">&nbsp;</th>
			<th colspan="2" width="11%" style="border-right:1px solid #ccc;"><strong>Public Record Match</strong></th>
			<th width="4%">&nbsp;</th>
		</tr>
      <tr bgcolor="#ccc" style="font-size:7px !important;">	 
        <th width="22%" style="border-right:1px solid #ccc;"><strong>Address</strong></th>
		<th width="7%" style="border-right:1px solid #ccc;"><strong>Distance</strong></th>
		<th width="5%" style="border-right:1px solid #ccc;text-align:center;"><strong>Bd/Ba</strong></th>
		<th width="7%" style="border-right:1px solid #ccc;text-align:center;"><strong>SF</strong></th>
		<th width="5%" style="border-right:1px solid #ccc;text-align:center;"><strong>Yr</strong></th>
		<th width="7%" style="border-right:1px solid #ccc;text-align:center;"><strong>Lot</strong></th>
		<th width="4%" style="border-right:1px solid #ccc;text-align:center;"><strong>STY</strong></th>
		<th width="5%" style="border-right:1px solid #ccc;text-align:center;"><strong>Pool</strong></th>
		<th width="5%" style="border-right:1px solid #ccc;text-align:center;"><strong>BSMT</strong></th>
		<th width="10%" style="border-right:1px solid #ccc;text-align:center;"><strong>Date Sold</strong></th>
		<th width="8%" style="border-right:1px solid #ccc;text-align:center;"><strong>Amount</strong></th>
		<th width="6%" style="border-right:1px solid #ccc;text-align:center;"><strong>Sales $</strong></th>
		<th width="5%" style="border-right:1px solid #ccc;text-align:center;"><strong>Sales Date</strong></th>
		<th width="4%" style="border-right:1px solid #ccc;text-align:center;"><strong>Concessions</strong></th>
      </tr>
    </thead>
    <tbody>
	<?php
		foreach($not_comps as $key=>$detail){
				
			if($detail['reason']==1){$reason = "Poor Condition of Subject/Good Condition of Comp &nbsp;&nbsp;&nbsp;"; } else{ $reason="None"; }
			if($detail['note']==1){ $note = "I didn't use this property because"; } else{ $note="None"; }


			
			//if($odd%2==0){ $color= "#ffffff;";}else{ $color= "#f6f6f6;";}
			//$detail['pool']=$pool;
			//$detail['basement']=$basement;
	?>
      <tr bgcolor="#f6f6f6">
	  <td width="22%" style="border-right:1px solid #ccc;"><?php echo $odd+1 .") ".$detail['address'];?></td>
		<td width="7%" style="border-right:1px solid #ccc;"><?php echo  sprintf('%0.2f', $detail['distance']);?> mi</td>
		<td width="5%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['bedsBaths'];?></td>
		<td width="7%" style="border-right:1px solid #ccc;text-align:center;"><?php echo number_format($detail['sq_size']);?></td>
		<td width="5%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['year_built'];?></td>
		<td width="7%" style="3px;border-right:1px solid #ccc;text-align:center;"><?php echo number_format($detail['lot_size']);?></td>
		<td width="4%" style="3px;border-right:1px solid #ccc;text-align:center;"><?php echo $detail['stories'];?></td>
		<td width="5%" style="3px;border-right:1px solid #ccc;text-align:center;"><?php echo $detail['pool'];?></td>
		<td width="5%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['basement'];?></td>
		<td width="10%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['dateSold'];?></td>
		<td width="8%" style="border-right:1px solid #ccc;text-align:center;">$<?php echo number_format($detail['amount']);?></td>
		
		<td width="6%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['dy'] ?></td>
		<td width="5%" style="border-right:1px solid #ccc;text-align:center;"><?php echo $detail['ay'] ?></td>
		<td width="4%">&nbsp;</td>
      </tr>
	   <tr>
	  <td colspan="15"><span style="color:red;"><?php echo $reason;?></span>  &nbsp; <span style="color:red;">Notes: <?php echo $note;?></span></td>
	  </tr>
	  <?php
		$odd++;}
		
	  ?>	
	 
    </tbody>
  </table>

		<?php } ?>

		<br>
		<h5 style="color:black;font-weight:bold;">I used the following parameters for my comparable selection in the appraisal report:
		<br>
<?php echo $_SESSION['results']['compSq'];?> square footage , date of sale <?php echo str_replace('<',' less than ',$_SESSION['results']['compSale']);?>, <?php echo str_replace('<',' less than ',$_SESSION['results']['compRadius']);?>. Please list any other sales that should be addressed that weren't used in appraisal:
</h5>

<br><br>
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
				<h6><?php echo $bedrooms; ?> Bd | <?php echo $bathrooms; ?> Ba | <?php echo number_format($square_footage);?> Sq Ft</h6>
				<h6><?php echo $stories; ?> Stories | Lot Size <?php echo number_format($lot_size); ?></h6>
				<h6><?php echo "Pool ".$pool; ?> |  <?php echo "Basement ".$basement; ?></h6>
				<h6>Built <?php echo $year_built;?>
				</h6>
		</div>
		<div class="col-lg-4 col-sm-4 col-xs-12 col-md-4 repaddress">
				<h5 class="report-by">Report Prepared By</h5>
				<h6><?php echo $prepared_by['Name']; ?></h6>
				<h6 style="line-height:150%"><?php echo $prepared_by['Address']; ?></h6>
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
					<?php if(count($comps)>0){?>
						<div class="pull-left indicate blue">
						
						</div>


						<div class="pull-left indicate-text">
							 Potential Comparable Sales Used
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
					<tr><td>STY</td><td> <?php echo $finalParameters['stories'];?></td></tr>
					<tr><td> Date of Sale</td><td>  <?php echo $finalParameters['dateSale'];?> </td></tr>
				</table>
		</div>
		</div>	
	

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
		<th style="text-align:center;">SF</th>
        <th style="text-align:center;">Yr</th>
        <th style="text-align:center;">Lot</th>
		<th style="text-align:center;">STY</th>
		<th style="text-align:center;">Pool</th>
		<th style="text-align:center;">BSMT</th>
        <th style="text-align:center;">Date Sold</th>
        <th style="text-align:center;">Amount</th>
        <?php
			if($user==2){

			}else{
		?>
		<th style="text-align:center;">Sales $</th>
		<th style="text-align:center;">Sales Date</th>
		<?php
	}
		?>
		
		<th style="text-align:center;">Concessions</th>
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
	?>
      <tr >
	  <td><?php echo $count.". ".$detail['address'];?></td>
        <td><?php echo  sprintf('%0.2f', $detail['distance']);?> mi</td>
        <td><?php echo $detail['bedsBaths'];?></td>
		<td style="text-align:center;"><?php echo number_format($detail['sq_size']);?></td>
        <td style="text-align:center;"><?php echo $detail['year_built'];?></td>
        <td style="text-align:center;"><?php echo number_format($detail['lot_size']);?></td>
		<td style="text-align:center;"><?php echo $detail['stories'];?></td>
		<td style="text-align:center;"><?php echo $detail['pool'];?></td>
		<td style="text-align:center;"><?php echo $detail['basement'];?></td>
        <td style="text-align:center;"><?php echo $detail['dateSold'];?></td>
        <td style="text-align:center;">$<?php echo number_format($detail['amount']);?></td>
		

		<?php
			if($user==2){

			}else{
		?>
		<td style="text-align:center;"><?php echo $detail['dy'] ?></td>
		<td style="text-align:center;"><?php echo $detail['ay'] ?></td>
		<?php } ?>
		<td style="text-align:center;"></td>
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
		<th>STY</th>
		<th>Pool</th>
		<th>BSMT</th>
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
        <td><?php echo  sprintf('%0.2f', $detail['distance']); ?> mi</td>
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

		<div class="row">
		<div class="col-sm-12" style="padding:20px 0px 20px 20px;">
		<h5 style="color:black;font-weight:bold;">I used the following parameters for my comparable selection in the appraisal report:
		<br>
<?php echo $_SESSION['results']['compSq'];?> square footage , date of sale <?php echo $_SESSION['results']['compSale'];?>, <?php echo $_SESSION['results']['compRadius'];?>. 
Please list any other sales that should be addressed that weren't used in appraisal:
</h5>
<div class="row" style="">
			<div class="col-sm-6">
			<?php
			if(count($_SESSION['results']['paramAdd'])>0){
			?>
			<p style="font-weight:bold;color:black; text-align:left;">Address:</p>
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
			<p style="font-weight:bold;color:black;text-align:left;">Comments:</p>
			<table class="table table-striped">
					<?php 	$count=1; foreach($_SESSION['results']['paramComments'] as $res): ?>
					<tr><td><?php echo $count; $count++;?>. <?php echo $res;?></td></tr>
					<?php endforeach; ?>
				</table>
				<?php } ?>
				
			</div>
		</div>	