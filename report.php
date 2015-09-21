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
		

		function subval_sort($a,$subkey) {
			foreach($a as $k=>$v) {
				$b[$k] = strtolower($v[$subkey]);
			}
			asort($b);
			foreach($b as $key=>$val) {
				$c[] = $a[$key];
			}
			return $c;
		}
		
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
			
			if($_SESSION['results']['utilizes'][$key]=="No" ){		
				 
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
		 	else 
		 	{
				$comps[$key]=$detail;
				$matchResult[$key]['utility'] = "Yes";
				if(isset($_SESSION['results']['map']))
					$_SESSION['results']['map'] = preg_replace("@color:$key\%@","color:blue%",$_SESSION['results']['map']);
				if(isset($_SESSION['map']))
					$_SESSION['map'] = preg_replace("@color:$key\%@","color:blue%",$_SESSION['map']);
			}			
	 	}		
	 }

	 	//$comps = subval_sort($comps,'distance'); 
	 	//$not_comps = subval_sort($not_comps,'distance'); 
	
	 	$markers = $_SESSION['markers'];
		$count = 1;

		foreach($comps as $key=>$value){
			foreach($markers as $k=>$m)
			{			
				if(strtolower($m['address'])==strtolower($value['address'])){
					$markers[$k]['id']=$count;
					$markers[$k]['color']="0x003F7F";
				}
			}
			$count++;
		}	
		
		foreach($not_comps as $key=>$value){
			foreach($markers as $k=>$m)
			{
				if(strtolower($m['address'])==strtolower($value['address'])){
					$markers[$k]['id']=$count;
					$markers[$k]['color']= "red";
				}
			}
			$count++;
		}

		foreach($markers as $m){
        	if($m['id']=="C"){
        		$color = "purple";
        	}
        	else { $color = $m['color'];}
	        $locstring=$locstring.'&markers=color:'.$color.'%7Clabel:'.$m['id'].'%7C'.$m['latitude'].','.$m['longitude'];
        }
        $url="http://maps.googleapis.com/maps/api/staticmap?zoom=13&size=800x400&maptype=ROADMAP&".urlencode("center")."=".$locstring."&sensor=false";
		$_SESSION['results']['map'] = $url;
		
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
		<form action="createpdf.php" method="post" id="conv" name="conv">
		<div id="content">
		<div id="aclogo"></div>
		<!-- Includeing report file -->
		<?php if($user!=2)
			  {
				include_once("views/appraiser_report.php");  
			  }
			  else
			  { 
				include_once("views/loanofficer_report.php");
			  }		
		?>

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

		
		