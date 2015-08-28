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
					<th width="26%" style="border-right:1px solid #ccc;"><strong>Address</strong></th>
					<th width="8%" style="border-right:1px solid #ccc;"><strong>Distance</strong></th>
					<th width="11%" style="border-right:1px solid #ccc;"><strong>Bd/Ba</strong></th>
					<th width="7%" style="border-right:1px solid #ccc;"><strong>SF</strong></th>
					<th width="5%" style="border-right:1px solid #ccc;"><strong>Yr</strong></th>
					<th width="7%" style="border-right:1px solid #ccc;"><strong>Lot</strong></th>
					<th width="5%" style="border-right:1px solid #ccc;"><strong>Stories</strong></th>
					<th width="5%" style="border-right:1px solid #ccc;"><strong>Pool</strong></th>
					<th width="5%" style="border-right:1px solid #ccc;"><strong>Bsmnt</strong></th>
					<th width="9%" style="border-right:1px solid #ccc;"><strong>Date Sold</strong></th>
					<th width="12%" style="border-right:1px solid #ccc;"><strong>Amount</strong></th>
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
			  <td width="26%" style="border-right:1px solid #ccc;"><?php echo $key+1 .") ".$detail['address'];?></td>
				<td width="8%" style="border-right:1px solid #ccc;"><?php echo  sprintf('%0.2f', $detail['distance']);?>miles</td>
				<td width="11%" style="border-right:1px solid #ccc;"><?php echo $detail['bedsBaths'];?></td>
				<td width="7%" style="border-right:1px solid #ccc;"><?php echo number_format($detail['sq_size']);?></td>
				<td width="5%" style="border-right:1px solid #ccc;"><?php echo $detail['year_built'];?></td>
				<td width="7%" style="3px;border-right:1px solid #ccc;"><?php echo number_format($detail['lot_size']);?></td>
				<td width="5%" style="3px;border-right:1px solid #ccc;"><?php echo $detail['stories'];?></td>
				<td width="5%" style="3px;border-right:1px solid #ccc;"><?php echo $detail['pool'];?></td>
				<td width="5%" style="border-right:1px solid #ccc;"><?php echo $detail['basement'];?></td>
				<td width="9%" style="border-right:1px solid #ccc;"><?php echo $detail['dateSold'];?></td>
				<td width="12%" style="border-right:1px solid #ccc;">$<?php echo number_format($detail['amount']);?></td>	
			  </tr>
			  <?php
				}
			  ?>
			  
			</tbody>
  </table>
  
<br><br><br>
	<div width="50%" align="center" style="text-align:center;">
		<table width="80%" style="font-size:10px;" align="center">
			<tr>
				<td width="%4"><div style="width:10px; height:10px;background-color:#A689B6;"></div></td>
				<td width="20%">&nbsp;<strong>Subject Property</strong></td>
				<td width="4%"><div style="width:13px; height:10px;background-color:#99BEFD;"></div></td>
				<td width="35%">&nbsp;<strong>Potential Comparable Sales Used</strong></td>
			</tr>
			<tr style="height:25px;"><td colspan=2>&nbsp;</td></tr>
		</table>
	</div>
	<div width="90%">
		
	</div>
		
		<?php } ?>

downloadReport-->