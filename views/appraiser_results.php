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
					
						<div class="pull-left indicate blue">
						
						</div>
						<div class="pull-left indicate-text">
							Comparable Properties
						</div>
					
						
		
	</div>
	</div>
	<div class="clearfix"></div>

	<div class="row">
		<div class="col-lg-8 col-sm-8 col-xs-12 col-md-8 repaddress">
			<div>
				<div id="map_wrapper">
				<div id="map_canvas" class="mapping">loading</div>
				</div>	
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
<form id="resultForm" action="" method="post">
		<div class="row">
			<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
					<h4 class="resultHeading">Potential Comparable Sales Used </h4>
					<table class="table " id="compTable">
					 <thead>
					 <?php if($user==1){?>
						<tr rowspan="2">
							<th colspan="11" style="border:none;"></th>
							<th colspan="2" style="border:none;">Public Record Match</th>
							<th style="border:none;"></th>
						</tr>					
						<?php } ?>
						<tr>					 
							<th>Address</th>
							<th>Distance</th>
							<th>Bd/Ba</th>
							<th  style="text-align:center;">SF</th>
							<th  style="text-align:center;">Yr</th>
							<th  style="text-align:center;">Lot</th>
							<th  style="text-align:center;">STY</th>
							<th  style="text-align:center;">Pool</th>
							<th  style="text-align:center;">BSMT</th>
							<th  style="text-align:center;">Date Sold</th>
							<th  style="text-align:center;">Amount</th>
							<?php if($user==1){?>
							<th  style="text-align:center;">Sales $</th>
							<th  style="text-align:center;">Sales Date</th>
							
							<th  style="text-align:center;">Use?</th>
							<?php }?>
					  </tr>
					 </thead>
					<tbody>
					<?php
						$i=1;
						$seq=1;
						$aMatchData = array();
						
						$storeData = '<h3 style="color:green;">Final Results </h3><table class="table table-bordered"> 
		<tr>
			<td>SL</td><td>Address </td><td>Distance </td><td>Bed/baths </td><td>Sqft</td><td>Year Built</td><td>Lot Size</td><td>Stories</td><td>Pool</td><td>Basement</td><td>List Date</td><td>Price</td>
		</tr>';
						foreach($aSearchProp as $row){					

							if($i>$maxRecords){
								break;
							}
							$i++;
						
							$latitude = $row['latitude'];
							$longitude = $row['longitude'];
						
							$markers[]=array('id'=>$seq, 'address'=>$row['address'], 'latitude'=>$latitude, 'longitude'=>$longitude);
						
							$row['ay']="N";
							$row['dy']="N";

							list($m,$d,$y)= preg_split("@\/@",$row['dateSold']);
							if(preg_match("@^[0-9]{1}$@",$m))
									$m= "0".$m;
							$dateSold = $y."-".$m."-".$d;
							foreach($compare as $rs){
								//echo "<pre>"; print_r($rs);
								//print $rs['address']; print "----- ".$row['address'];


							/*	preg_match("@^([0-9]+)\s+@",$row['address'],$addno);
								preg_match("@^([0-9]+)\s+@",$rs['address'],$maddno);


								$mls_address = trim($maddno[1]). " ".trim($rs['city'])." ".trim($rs['state'])." ".trim($rs['zip']);
								$mls_address = strtolower($mls_address);

								$relar_address =  trim($addno[1]). " ".trim($row['city'])." ".trim($row['state'])." ".trim($row['zip']);
								$relar_address = strtolower($relar_address);
						*/

								if($rs['address']==$row['address']){

									if($rs['transferDate']==$dateSold){
										$row['dy'] = "Y";
									}else{
										$row['dy'] = "N";
									}

									if($rs['amount']==$row['amount']){
										$row['ay'] = "Y";
									}else{
										$row['ay'] = "N";
									}
								}
							}	
							$address = ucwords(strtolower($row['address']));
							$state = $row['state'];

							$address = preg_replace("@$state@is",$state, $address);
							$row['address'] = $address;

							if(strtolower($row['pool'])=="no" || strtolower($row['pool'])=="none"){
								$row['pool']="N";
							}else{
								$row['pool']="Y";
							}

							
							echo '<tr>';
							echo '<td>'.$seq.'. '.$address.'</td>';
							echo '<td>';
							echo sprintf('%0.2f', $row['distance']);
							echo ' mi</td>';
							echo '<td>'.$row['bedsBaths'].'</td>';
							echo '<td  style="text-align:center;">'.number_format($row['sq_size']).'</td>';
							echo '<td  style="text-align:center;">'.$row['year_built'].'</td>';
							echo '<td  style="text-align:center;">'.number_format($row['lot_size']).'</td>';
							echo '<td  style="text-align:center;">'.$row['stories'].'</td>';
							echo '<td  style="text-align:center;">'.$row['pool'].'</td>';
							echo '<td  style="text-align:center;">'.$row['basement'].'</td>';							
							echo '<td  style="text-align:center;">'.$row['dateSold'].'</td>';
							echo '<td  style="text-align:center;">$'.number_format($row['amount']).'</td>';
							if($user==1){ 
								echo '<td  style="text-align:center;">'.$row['ay'].'</td>';
								echo '<td  style="text-align:center;">'.$row['dy'].'</td>';


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
							$storeData = $storeData.'<tr><td>'.$seq.'</td><td>'.$row['address'].'</td><td>'.sprintf('%0.2f', $row['distance']).'miles</td><td>'.$row['bedsBaths'].'</td><td>'.number_format($row['sq_size']).'</td><td>'.$row['year_built'].'</td><td>'.number_format($row['lot_size']).'</td><td>'.$row['stories'].'</td><td>'.$row['pool'].'</td><td>'.$row['basement'].'</td><td>'.$row['dateSold'].'</td><td>$'.number_format($row['amount']).'</td></tr>';			
							$seq++;
						}
						$storeData = $storeData.'</table>';
						fwrite($fd,$storeData);
						fclose($fd);

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
		$_SESSION['markers'] = $markers;
		
		//echo "<pre>"; print_r($markers);
?>
			</div>
		</div>
		
		
		
		<div class="row">
			<div class="col-sm-12">
				<h5 class="resultHeading">I used the following parameters for my comparable selection in the appraisal report:</h5>
		

				<table class="table table-borderless">
						<tr>
				<td class="paramTd">Square Footage </td>
				<td class="paramDt"><select name="compSq" class="input-medium"><option value="<?php echo $finalParameters['square_footage'];?>"> <?php echo $finalParameters['square_footage'];?></option></td>
			</tr>

			<tr>
				<td class="paramTd">Radius </td>
				<td class="paramDt"><select name="compRadius" class="input-medium"><option value="<?php echo $finalParameters['radius'];?>"><?php echo $finalParameters['radius'];?></option></td>
			</tr>

			<tr>
				<td class="paramTd">Age </td>
				<td class="paramDt"><select name="compAge" class="input-medium"><option value="<?php echo $finalParameters['age'];?>"> <?php echo $finalParameters['age'];?></option></td>
			</tr>

			<tr>
				<td class="paramTd">Lot Size </td>
				<td class="paramDt"><select name="compLot" class="input-medium"><option value="<?php echo $finalParameters['lotSize'];?>"> <?php echo $finalParameters['lotSize'];?></option></td>
			</tr>

			<tr>
				<td class="paramTd">Stories</td>
				<td class="paramDt"><select class="input-medium" name="compStories"><option value="<?php echo $finalParameters['stories'];?>"> <?php echo $finalParameters['stories'];?></option></td>
			</tr>

			<tr>
				<td class="paramTd">Date of Sale</td>
				<td class="paramDt"><select name="compSale" class="input-medium"><option value="<?php echo $finalParameters['dateSale'];?>"> <?php echo $finalParameters['dateSale'];?></option></td>
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
	
						
						
