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
		<div class="row" id="repAddress">

		<div class="col-sm-7"  style="padding:20px 0px 20px 30px;">
		<span style="font-size:12px; font-weight:bold; color:#6a6a6a;" class="headAddress"><?php echo $address; ?></span>
		<span style="font-size:12px; color:#6a6a6a;" class="headAdd"><br/>
		<?php echo $bedrooms; ?> Bd | <?php echo $bathrooms; ?> Ba | <?php echo $square_footage;?> Sq Ft<br/>
		<?php echo $stories; ?> Stories | Lot Size <?php echo $lot_size; ?><br/>
		<?php echo "Pool ".$pool; ?> |  <?php echo "Basement ".$basement; ?><br/>
		Built <?php echo $year_built;?>
		</span>
		</div>

		<div id="repBy" class="col-sm-5" style="padding:20px 0px 20px 30px;">
		<span style="font-size:12px; font-weight:bold; color:#6a6a6a;" class="headAddress">Report Prepared By</span>
		<span style="font-size:12px; color:#6a6a6a;"><br/>
		<?php echo $prepared_by['Name']; ?><br/>
		<?php echo $prepared_by['Address']; ?><br/>
		<a href=""><?php echo $prepared_by['UserName']; ?></a>		
		</span>
		</div>
		</div>
	
	    <span id="repClose"></span>
		<div class="row">
		<div class="col-sm-6">
		</div>
		<div class="col-sm-6">
		<span style="font-size:12px; font-weight:bold; color:#6a6a6a; padding-left:30px;"></span>
		</div>
		</div>
		<br><br>

		<div class="row">
		<div class="col-sm-7">
		<table id="graph">
		<tr>
		<td style="width:25px; height:5px;background-color:#A689B6;">&nbsp;</td><td>&nbsp;Subject Property&nbsp;</td>
		<td style="width:25px; height:5px;background-color:#99BEFD;">&nbsp;</td><td>&nbsp;Potential Comparable Sales Used &nbsp;</td>
		<td style="width:25px; height:5px;background-color:#F5635B;">&nbsp;</td><td>&nbsp;Potential Comparable Sales Not Used &nbsp;</td>
		</tr></table>
		<br/>
		</div>
		</div>

		<div class="row">
		<div class="col-sm-12" >
		<table><tr><td style="width:40%;">
		<div>
		<span id="mp">
		<img src="<?php if(isset($_SESSION['results']['map']) || isset($_SESSION['map'])){ $map = isset($_SESSION['results']['map']) ? $_SESSION['results']['map'] : $_SESSION['map']; echo $map; } ?>" width="400"/>
		</div>
		
		</td>

		<td style="width:40%;" valign="top">
		<h3>Final Search Parameters</h3>
		<table>
		<tr><td> Square Footage</td><td> +/- 10%</td></tr>
		<tr><td>Radius</td><td> &lt; 1 Mile </td></tr>
		<tr><td>Age</td><td>+/- 5 Years</td></tr>
		<tr><td>Lot Size</td><td>+/- 100%</td></tr>
		<tr><td>Stories</td><td>2</td></tr>
		<tr><td> Date of Sale</td><td>  &lt; 1 Year </td></tr>
		</table>
		</td></tr></table>
		</div></div>
		<div id="break"><br/><br/></div>


		<?php

	if(count($comps)>0){
		?>
		<div class="row">
		<div class="col-sm-12" style="padding:20px 0px 0px 30px;">
		<span style="font-size:16px; font-weight:bold; color:#6a6a6a;">Potential Comparable Sales Used</span>
		</div>
		</div>
		
		<div class="row">
		<div class="col-sm-12" style="padding:20px 80px 0px 30px;">
		<table class="table table-striped" id="comps">
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
      <tr <tr style="background:<?php echo $color; ?>">
	  <td><?php echo $key.". ".$detail['address'];?></td>
        <td><?php echo $detail['distance'];?>miles</td>
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
		<div class="col-sm-12" style="padding:30px 0px 0px 30px;">
		<span style="font-size:16px; font-weight:bold; color:#6a6a6a;">Potential Comparable Sales Not Used</span>
		</div>
		</div>
		<div class="row">
		<div class="col-sm-12" style="padding:20px 80px 0px 30px;">
		<table class="table table-striped" id="ucomps">
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
			if($detail['reason']==1){ $detail['reason'] = "Poor Condition of Subject/Good Condition of Comp"; } else{ $detail['reason']="None"; }
			if($detail['note']==1){ $detail['note'] = "I didn't use this property because"; } else{ $detail['note']="None"; }
			if($odd%2==0){ $color= "#ffffff;";}else{ $color= "#f6f6f6;";}
			$odd++;
			//$detail['pool']=$pool;
			//$detail['basement']=$basement;
	?>
      <tr style="background:<?php  echo $color;?>">
        <td><?php echo $key.". ";?><?php echo $detail['address'];?></td>
        <td><?php echo $detail['distance'];?>miles</td>
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
	  <td colspan="15"><?php echo $detail['reason'];?>  &nbsp; Notes: <?php echo $detail['note'];?></td>
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
		<div id="repbtn" class="row" style="padding:0px 0px 30px 30px;" >
		<div class="col-sm-6">
		<!--<button type="button" class="btn btn-success" style="margin-bottom:3px;">Go Back</button>
		<button type="button" class="btn btn-success" style="margin-bottom:3px;">Save</button>
		<button type="button" class="btn btn-success" style="margin-bottom:3px;">Print</button>-->
		</div>
        <div class="col-sm-6" style="padding-left:215px;">
		<button type="button" class="btn btn-success" style="margin:3px;" onclick="convert_pdf();">Create Report</button>
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
		
		