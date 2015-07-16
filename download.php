<?php
	session_start();
	include('db/db.php');
	include('classes/User.php');
	$us = new User();
	$prepared_by = $us->getUserDetails();

	$id = $_GET['id'];
	$result = mysql_fetch_array(mysql_query("select * from savesearch where SearchID='$id'"))or die(mysql_error());
	$set = unserialize($result['Param']);
	$download = $set;

	if(isset($download['results']['map']) || isset($download['map'])){ 
		$map = isset($download['results']['map']) ? $download['results']['map'] : $download['map']; } 	

	$map = file_get_contents($map);
	$fp = fopen("$id.jpg",'w');
	fwrite($fp,$map);
	fclose($fp);

	if($download['user_type']==2){ 
		$address = 	isset($download['search']['address']) ? $download['search']['address']: "3101 West End Ave, Nashvelle TN 37203" ;
	$bedrooms = isset($download['search']['bedrooms']) ? $download['search']['bedrooms'] : "3";
	$bathrooms = isset($download['search']['bathrooms'])? $download['search']['bathrooms'] : "4";
	$square_footage = isset($download['search']['square_footage']) ? $download['search']['square_footage'] : "2,455";
	$stories  = isset($download['search']['stories'])? $download['search']['stories'] : "1";
	$lot_size = isset($download['search']['lot_size'])? $download['search']['lot_size']: "5,260";
	$year_built = isset($download['search']['year_built'])? $download['search']['year_built']: "1991";
	$pool = isset($download['search']['pool'])? $download['search']['pool']: "No";
	$basement = isset($download['search']['basement'])? $download['search']['basement']: "No";

	}else{
	$address = 	isset($download['refineSearch']['address']) ? $download['refineSearch']['address']: "3101 West End Ave, Nashvelle TN 37203" ;
	$bedrooms = isset($download['refineSearch']['bedrooms']) ? $download['refineSearch']['bedrooms'] : "3";
	$bathrooms = isset($download['refineSearch']['bathrooms'])? $download['refineSearch']['bathrooms'] : "4";
	$square_footage = isset($download['refineSearch']['square_footage']) ? $download['refineSearch']['square_footage'] : "2,455";
	$stories  = isset($download['refineSearch']['stories'])? $download['refineSearch']['stories'] : "1";
	$lot_size = isset($download['refineSearch']['lot_size'])? $download['refineSearch']['lot_size']: "5,260";
	$year_built = isset($download['refineSearch']['year_built'])? $download['refineSearch']['year_built']: "1991";
	$pool = isset($download['refineSearch']['pool'])? $download['refineSearch']['pool']: "No";
	$basement = isset($download['refineSearch']['basement'])? $download['refineSearch']['basement']: "No";
}
	if(isset($download['results']['matchResult'])){

		 $match  = $download['results']['matchResult'];	
		 $matchResult = unserialize(urldecode($match));

		 $comps = array();
		 $not_comps = array();


		 foreach($matchResult as $key=>$detail){
			if($download['results']['utilizes'][$key]=="Yes" ){
				$comps[$key]=$detail;
				$matchResult[$key]['utility'] = "Yes";
				if(isset($download['results']['map']))
					$download['results']['map'] = preg_replace("@color:$key\%@","color:blue%",$download['results']['map']);
				if(isset($download['map']))
					$download['map'] = preg_replace("@color:$key\%@","color:blue%",$download['map']);
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
				if(isset($download['results']['map']))
					$download['results']['map'] = preg_replace("@color:$key\%@","color:pink%",$download['results']['map']);
				if(isset($download['map']))
					$download['map'] = preg_replace("@color:$key\%@","color:pink%",$download['map']);
			}
		 }
		
		$download['results']['matchResult'] = urlencode(serialize($matchResult));
		//$us->updateSearch($address, 1, $download, $download['searchId']);
	}			

$download['sessionId'] = session_id();

$html = $html.'<style>.btn-success { padding:6px 5px 6px 5px; }
#reportDiv { background-color:#60226b; width:156px; border-right:2px solid #fff; 
border-left:2px solid #fff; }
#sideMenu { margin-left:9%; }
input,textarea,select { border:1px solid #cfcfcf;}
#pageContent { overflow-x:hidden;}
#backBtn { font-size:11px; padding:2px 2px 2px 2px; }
.box-3 {
	position:relative;overflow:hidden;
	width:400px;height:200px;border:1px dashed #0C0;text-align:center;margin:5px;float:left;
}


.borderless td, .borderless th {
    border: none;
}

#map_wrapper {
    height: 400px;
}

#map_canvas {
    width: 90%;
    height: 100%;
}
th{ font-size:14px; height:30px;}
td{ font-size:16px; height:30px;}
#comps{ border:1px solid;}
#comps td{ font-size:16px; height:30px; border-top:1px solid;}

#ucomps{ border:1px solid;}
#ucomps td{ font-size:16px; height:30px; border-top:1px solid; }
</style>
		<form action="convert2.php" method="post" id="conv" name="conv">
		<div id="content">
		<div id="aclogo"></div>
		<div class="row" id="repAddress">

		<div class="col-sm-7"  style="padding:20px 0px 20px 30px;">
		<span style="font-size:12px; font-weight:bold; color:#6a6a6a;">'.$address.'</span>
		<span style="font-size:12px; color:#6a6a6a;"><br/>
		'.$bedrooms.' Bd | '.$bathrooms.' Ba | '.$square_footage.' Sq Ft<br/>
		'. $stories.' Stories | Lot Size '.$lot_size.'<br/>
		'. 'Pool '.$pool.' |  Basement '.$basement.'<br/>
		Built '.$year_built.'
		</span>
		</div>

		<div id="repBy" class="col-sm-5" style="padding:20px 0px 20px 30px;">
		<span style="font-size:12px; font-weight:bold; color:#6a6a6a;">Report Prepared By</span>
		<span style="font-size:12px; color:#6a6a6a;"><br/>
		'.$prepared_by['Name'].'<br/>
		'.$prepared_by['Address'].'<br/>
		<a href="">'.$prepared_by['UserName'].'</a>
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
		<div class="row">
		<div class="col-sm-7" style="padding:0px 0px 20px 30px;">
		<table>
		<tr>
		<td style="width:20px; height:20px;background-color:#A689B6;">&nbsp;</td><td>&nbsp;Subject Property&nbsp;</td>
		<td style="width:20px; height:20px;background-color:#99BEFD;">&nbsp;</td><td>&nbsp;Potential Comparable Sales Used &nbsp;</td>
		<td style="width:20px; height:20px;background-color:#F5635B;">&nbsp;</td><td>&nbsp;Potential Comparable Sales Not Used &nbsp;</td>
		</tr></table>
		<br/>
		<span id="mp">
		<img src="'.$id.'.jpg" width="550"/>
		</div>
		
		<div class="col-sm-5" style="padding:0px 0px 20px 30px;">
		<h3>Final Search Parameters</h3>
		<table>
		<tr><td> Square Footage</td><td> +/- 10%</td></tr>
		<tr><td>Radius</td><td> &lt; 1 Mile </td></tr>
		<tr><td>Age</td><td>+/- 5 Years</td></tr>
		<tr><td>Lot Size</td><td>+/- 100%</td></tr>
		<tr><td>Stories</td><td>2</td></tr>
		<tr><td> Date of Sale</td><td>  &lt; 1 Year </td></tr>
		</table>
		</div>
		</div>
		<div id="break"><br/><br/></div>';
		
	if(count($comps)>0){
		
		$html = $html.'<div class="row">
		<div class="col-sm-12" style="padding:20px 0px 0px 30px;">
		<span style="font-size:16px; font-weight:bold; color:#6a6a6a;">R3 Comps Used</span>
		</div>
		</div>
		
		<div class="row">
		<div class="col-sm-12" style="padding:20px 80px 0px 30px;">
		<table class="table table-striped" id="comps">
    <thead>
      <tr>
	  <th></th>
        <th>Address</th>
        <th>Distance</th>
        <th>Beds/Baths</th>
		<th>Size</th>
        <th>Built</th>
        <th>Lot</th>
		<th>Stories</th>
        <th>Date Sold</th>
        <th>Amount</th>
		<th>Sale Type</th>
		<th>DS</th>
		<th>AM</th>
      </tr>
    </thead>
    <tbody>
	';
			foreach($comps as $key=>$detail){
			
				$html = $html.'
      <tr style="background:#f6f6f6;">
	  <td>'.$key.'</td>
        <td>'.$detail['address'].'</td>
        <td>'.$detail['distance'].'Miles</td>
        <td>'.$detail['bedsBaths'].'</td>
		<td>'.$detail['sq_size'].' sqft</td>
        <td>'.$detail['year_built'].'</td>
        <td>'.$detail['lot_size'].'</td>
		<td>'.$detail['stories'].'</td>
        <td>'.$detail['dateSold'].'</td>
        <td>$'.$detail['amount'].'</td>
		<td>Full Value</td>
		<td>'.$detail['dy'].'</td>
		<td>'.$detail['ay'].'</td>
      </tr>';
		}

	  $html = $html.'
    </tbody>
  </table>
		</div>
		</div>';

		 }
		$html = $html.'<div id="break"></div>';
		
	if(count($not_comps)>0){
		$html = $html.'
		<div class="row">
		<div class="col-sm-12" style="padding:30px 0px 0px 30px;">
		<span style="font-size:16px; font-weight:bold; color:#6a6a6a;">R3 Comps Not Used</span>
		</div>
		</div>
		<div class="row">
		<div class="col-sm-12" style="padding:20px 80px 0px 30px;">
		<table class="table table-striped" id="ucomps">
    <thead>
      <tr>
	  <th></th>
        <th>Address</th>
        <th>Distance</th>
        <th>Beds/Baths</th>
		<th>Size</th>
        <th>Built</th>
        <th>Lot</th>
		<th>Stories</th>
        <th>Date Sold</th>
        <th>Amount</th>
		<th>Sale Type</th>
		<th>DS</th>
		<th>AM</th>
      </tr>
    </thead>
    <tbody>';
	
		foreach($not_comps as $key=>$detail){
			if($detail['reason']==1){ $detail['reason'] = "Poor Condition of Subject/Good Condition of Comp"; } else{ $detail['reason']="None"; }
			if($detail['note']==1){ $detail['note'] = "I didn't use this property because"; } else{ $detail['note']="None"; }
	
    $html = $html.'  <tr style="background:#f6f6f6;">
        <td>'.$key.'</td>
        <td>'.$detail['address'].'</td>
        <td>'.$detail['distance'].' Miles</td>
        <td>'.$detail['bedsBaths'].'</td>
		<td>'.$detail['sq_size'].' sqft</td>
        <td>'.$detail['year_built'].'</td>
        <td>'.$detail['lot_size'].'</td>
		<td>'.$detail['stories'].'</td>
        <td>'.$detail['dateSold'].'</td>
        <td>$ '.$detail['amount'].'</td>
		<td>Full Value</td>
		<td>'.$detail['dy'].'</td>
		<td>'.$detail['ay'].'</td>
      </tr>
	   <tr style="background:#f6f6f6;">
	  <td colspan="13">'.$detail['reason'].'  &nbsp; Notes: '.$detail['note'].'</td>
	  </tr>';
	  
		}
		
	  $html = $html.'
	 
    </tbody>
  </table>

		</div>
		</div>		
		</div>';
		 } 
		$html = $html.'
		
</form>';

include("dompdf/dompdf_config.inc.php");
$html = preg_replace("@id=\"aclogo\">.*?</div>@is", 'id="aclogo"><img src="css/images/main_logo.jpg" width="200" class="img-responsive" alt="Logo" id="main_logo" style="padding-left:0px;"></div>',$html);
$html = preg_replace("@id=\"ad1\s*class.*?\"\s*style.*?\"@is",'',$html);
$html = str_replace('style="padding:20px 80px 0px 30px;"',"",$html);
$html = preg_replace("@repAddress\">@is",'id="repAddress"><table style="width:100%;"><tr><td>',$html);
$html = preg_replace("@</div>\s*<div id=\"repBy\".*?>@is",'</div></td><td>',$html);
$html = preg_replace("@<span id=\"repClose\"></span>@","</td></tr></table>",$html);
$html = $html;
$dompdf = new DOMPDF();
$dompdf->set_base_path(realpath(APPLICATION_PATH . 'css/bootstrap.css'));
$dompdf->set_base_path(realpath(APPLICATION_PATH . 'css/bootstrap-theme.css'));
$dompdf->set_base_path(realpath(APPLICATION_PATH . 'css/style.css'));
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("$id.pdf");
?>