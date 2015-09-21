<?php
	$states = array(
	'Alabama'=>'AL',
	'Alaska'=>'AK',
	'Arizona'=>'AZ',
	'Arkansas'=>'AR',
	'California'=>'CA',
	'Colorado'=>'CO',
	'Connecticut'=>'CT',
	'Delaware'=>'DE',
	'Florida'=>'FL',
	'Georgia'=>'GA',
	'Hawaii'=>'HI',
	'Idaho'=>'ID',
	'Illinois'=>'IL',
	'Indiana'=>'IN',
	'Iowa'=>'IA',
	'Kansas'=>'KS',
	'Kentucky'=>'KY',
	'Louisiana'=>'LA',
	'Maine'=>'ME',
	'Maryland'=>'MD',
	'Massachusetts'=>'MA',
	'Michigan'=>'MI',
	'Minnesota'=>'MN',
	'Mississippi'=>'MS',
	'Missouri'=>'MO',
	'Montana'=>'MT',
	'Nebraska'=>'NE',
	'Nevada'=>'NV',
	'New Hampshire'=>'NH',
	'New Jersey'=>'NJ',
	'New Mexico'=>'NM',
	'New York'=>'NY',
	'North Carolina'=>'NC',
	'North Dakota'=>'ND',
	'Ohio'=>'OH',
	'Oklahoma'=>'OK',
	'Oregon'=>'OR',
	'Pennsylvania'=>'PA',
	'Rhode Island'=>'RI',
	'South Carolina'=>'SC',
	'South Dakota'=>'SD',
	'Tennessee'=>'TN',
	'Texas'=>'TX',
	'Utah'=>'UT',
	'Vermont'=>'VT',
	'Virginia'=>'VA',
	'Washington'=>'WA',
	'West Virginia'=>'WV',
	'Wisconsin'=>'WI',
	'Wyoming'=>'WY'
	);

	


	function GetPropertyFromRealty($StreetAddr,$City,$State,$Zip)
	{
		$StreetAddr = urlencode($StreetAddr);

		 $URL  = "http://dlpapi.realtytrac.com/Reports/Get?ApiKey=a2d3e2aa-9c9b-4aab-af3a-56785ae67e25&Login=accurity&Password=1cyquent!&JobID=&LoanNumber=&PreparedBy=&ResellerID=&PreparedFor=&OwnerFirstName=&OwnerLastName=&AddressType=&PropertyStreetAddress=$StreetAddr&AddressNumber=&StartAddressNumberRange=&EndAddressNumberRange=&StreetDir=&StreetName=&StreetSuffix=&City=$City&StateCode=$State&County=&ZipCode=$Zip&PropertyParcelID=&APN=&ApnRangeStart=&ApnRangeEnd=&GeoCodeX=&GeoCodeY=&GeoCodeRadius=&SearchType=&NumberOfRecords=&Format=XML&ReportID=102";
	
	
		$path = $_SESSION['path'];
		$fp = fopen($path,"a");
		fwrite($fp, "<p>Query To Get Main Property - <b>$URL </b></p>");
		fclose($fp);

		$data = file_get_contents($URL);


		$p = xml_parser_create();
		xml_parse_into_struct($p, $data, $vals, $index);
		xml_parser_free($p);
		
		foreach($vals as $aval)
		{
			
			if($aval['type'] == 'complete' && isset($aval['attributes']))
			{
				foreach($aval['attributes'] as $key=>$val){
					if($key=="PROPERTYPARCELID_EXT")						
					$aProp[$key] = $val;
				}
			}

			if($aval['type'] == 'complete' && isset($aval['attributes']) && $aval['tag']=="PARSED_STREET_ADDRESS")
			{
				foreach($aval['attributes'] as $key=>$val){
					if(array_key_exists($key, $aProp)){
						continue;	
					}

				   $aProp[$key] = $val;				   
				}
			
			}


			
			if($aval['type'] == 'open' && isset($aval['attributes']))
			{
				foreach($aval['attributes'] as $key=>$val){
					if($aval['tag']=="MAILING_ADDRESS_EXT")
						continue;				
				
					$aProp[$key] = $val;
				}

			}
				
		}



		if(!isset($aProp)){
			// get the property id
			$propertyId = getPropertyId($StreetAddr,$City,$State,$Zip);
			$aProp = getByPropertyId($propertyId);
		}	
		return $aProp;
	}

	function getByPropertyId($id){
		$URL = "http://dlpapi.realtytrac.com/Reports/Get?ApiKey=a2d3e2aa-9c9b-4aab-af3a-56785ae67e25&Login=accurity&Password=1cyquent!&JobID=&LoanNumber=&PreparedBy=&ResellerID=&PreparedFor=&OwnerFirstName=&OwnerLastName=&AddressType=&PropertyStreetAddress=&AddressNumber=&StartAddressNumberRange=&EndAddressNumberRange=&StreetDir=&StreetName=&StreetSuffix=&City=&StateCode=&County=&ZipCode=&PropertyParcelID=".$id."&SAPropertyID=&APN=&ApnRangeStart=&ApnRangeEnd=&Latitude=&Longitude=&Radius=&SearchType=&NumberOfRecords=&Sort=&Format=XML&ReportID=102";

		$data = file_get_contents($URL);


		$p = xml_parser_create();
		xml_parse_into_struct($p, $data, $vals, $index);
		xml_parser_free($p);
		

		foreach($vals as $aval)
		{
			
			if($aval['type'] == 'complete' && isset($aval['attributes']))
			{
				foreach($aval['attributes'] as $key=>$val){
					if($key=="PROPERTYPARCELID_EXT")						
					$aProp[$key] = $val;
				}
			}

			if($aval['type'] == 'complete' && isset($aval['attributes']) && $aval['tag']=="PARSED_STREET_ADDRESS")
			{
				foreach($aval['attributes'] as $key=>$val){
				   $aProp[$key] = $val;
				}
			}
			if($aval['type'] == 'open' && isset($aval['attributes']))
			{
				foreach($aval['attributes'] as $key=>$val){
					if($aval['tag']=="MAILING_ADDRESS_EXT")
						continue;
					$aProp[$key] = $val;
				}

			}
				
		}
		return $aProp;
	}


	function getPropertyId($streetName, $city, $state, $zip){


		$streetName= preg_replace("@\+@"," ",$streetName);
		preg_match("@^\s*([0-9]+)\s+(.+?)$@is",$streetName, $address);
		$addressNo = trim($address[1]);
		$street = trim($address[2]);
		
		if(preg_match("@([SW]{2}|{N}1|W{1}|E{1}|S{1})@",$street,$matches)){
			//print_r($matches);exit;
		}

		$street = preg_replace("@(\s+|^)SW(\s+|$)@is", " ",$street);
		$street = preg_replace("@(\s+|^)ave(\s+|$)@is", " ",$street);
		$street = preg_replace("@(\s+|^)ST(\s+|$)@is", " ",$street);
		$street = preg_replace("@(\s+|^)W(\s+|$)@is", " ",$street);
		$street = preg_replace("@(\s+|^)N(\s+|$)@is", " ",$street);
		$street = preg_replace("@(\s+|^)av(\s+|$)@is", " ",$street);
		$street = preg_replace("@^\s+|\s+$@","",$street);
		$street = preg_replace("@\s+@","+",$street);
		$city = preg_replace("@\s+@","+",$city);

		$getURL = "http://dlpapi.realtytrac.com/Reports/Get?ApiKey=a2d3e2aa-9c9b-4aab-af3a-56785ae67e25&Login=accurity&Password=1cyquent!&JobID=&LoanNumber=&PreparedBy=&ResellerID=&PreparedFor=&OwnerFirstName=&OwnerLastName=&AddressType=Both&PropertyStreetAddress=&AddressNumber=".$addressNo."&StartAddressNumberRange=&EndAddressNumberRange=&StreetDir=&StreetName=".$street."&StreetSuffix=&City=".$city."&StateCode=".$state."&County=&ZipCode=".$zip."&PropertyParcelID=&SAPropertyID=&APN=&ApnRangeStart=&ApnRangeEnd=&Latitude=&Longitude=&Radius=&SearchType=ExactAndClose&NumberOfRecords=10&Sort=ASC&Format=XML&ReportID=105";

		$data = file_get_contents($getURL);
	

		$simple = simplexml_load_string($data);
		
		$arr = json_decode( json_encode($simple) , 1);


		$arrs = $arr['RESPONSE']['RESPONSE_DATA']['PROPERTY_INFORMATION_RESPONSE_ext']['SUBJECT_PROPERTY_ext'];


		foreach($arrs as $ar){
			
			if($ar['PARSED_STREET_ADDRESS']['@attributes']['_HouseNumber']==$addressNo){
				$id = $ar['@attributes']['PropertyParcelID_ext'];
				break;
			}
		}
		return $id;	
	
	}


	function ConvertAddress($Address)
	{
		global $states;
		$reverse_states = array_flip($states);
		$StreetAddress = '';
		$City ='';
		$State = '';
		$Zip = '';
		$county = '';
		$Address = str_replace(',',' ',$Address);
		$aData = array_reverse(explode(' ', $Address));
		if(is_numeric($aData[0]))
		{
			$Zip = $aData[0];
			if(isset($states[ucfirst($aData[1])]) )
			{
				$OrigState = ucfirst($aData[1]);
				$State = $states[ucfirst($aData[1])];
				$City = $aData[2];
			}
			else if(isset($reverse_states[strtoupper($aData[1])]))
			{
				$OrigState =$reverse_states[strtoupper($aData[1])];
				$State = $aData[1];
				$City = $aData[2];
			}
			else
			{
				$City = $aData[1];
			}

		}
		else
		{
			if(isset($states[ucfirst($aData[0])]))
			{
				$OrigState = ucfirst($aData[0]);
				$State = $states[ucfirst($aData[0])];
				$City = $aData[1];
			}
			else if(isset($reverse_states[strtoupper($aData[0])]))
			{
				$OrigState =$reverse_states[strtoupper($aData[0])];
				$State = $aData[0];
				$City = $aData[1];
			}
			else
			{
				$City = $aData[0];
			}
		}
		$Address = trim(str_replace($Zip, ' ',$Address));;
		$Address = trim(str_replace($OrigState, ' ',$Address));
		$Address = trim(str_replace($City, ' ',$Address));
		$Address = trim(str_replace(" $State" , ' ',$Address));
		$aRet['StreetAdd'] = $Address;
		$aRet['Zip'] = trim($Zip);
		$aRet['City'] = trim($City);
		$aRet['State'] = trim($State);

		return $aRet;
	}

	function MinMax($percent,$val)
	{
		$Max = $val + (($percent/100)*$val);
		$Min = $val - (($percent/100)*$val);
		$ret['Max'] = $Max;
		$ret['Min'] = $Min;
		return $ret;
	}

	function MinMaxAge($per, $val)
	{
		$Max = $val + $per;
		$Min = $val - $per;
		$ret['Max'] = $Max;
		$ret['Min'] = $Min;
		return $ret;
	}

	function MinMaxAgePer($percent, $val)
	{

		$ageyear = date('Y')-$val;
		$minmax = ceil(($ageyear*$percent)/100);
		$ret['Max'] = $val+$minmax;
		$ret['Min'] = $val-$minmax;
		return $ret;
	}


	function getLatitudeLongitude($ad){
	
			$url = "http://maps.google.com/maps/api/geocode/json?address=$ad&sensor=false";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);
			$lat = $response_a->results[0]->geometry->location->lat;
			$long = $response_a->results[0]->geometry->location->lng;
			$coord = array('latitude'=>$lat, 'longitude'=> $long);
			return $coord;
	}


	function generate_xml($address, $city, $state, $zip, $landUse,$date="2015-06-23"){		
		$address = preg_replace("@\s+@","+",$address);
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'http://www.relar.com/RelarService/RelarReportService.asmx/GetListingsForRelarReport',
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => "login=bjones1&password=relar88&address=$address&city=$city&state=$state&zipCode=$zip&landUse=$landUse&date=$date",
		));


		$path = $_SESSION['path'];
		$fds = fopen($path,"a");
		$dt="<p>Query To Get RELAR Property - <b>http://www.relar.com/RelarService/RelarReportService.asmx/GetListingsForRelarReport?login=bjones1&password=relar88&address=$address&city=$city&state=$state&zipCode=$zip&landUse=$landUse&date=$date </b></p>";
		fwrite($fds,$dt);
		fclose($fds);
		
		$resp = curl_exec($curl);
		curl_close($curl);

		$fs = fopen("data.xml","w");
		fwrite($fs,$resp);
		fclose($fs);
		
		
		$p = xml_parser_create();
		xml_parse_into_struct($p, $resp, $vals, $index);
		xml_parser_free($p);

		$aProp = array();
		foreach($vals as $aval)
		{
			if($aval['tag'] == 'PROP' && $aval['type'] == 'open')
				$aProp[] = $aval['attributes'];
		}

		return $aProp;
	}

	function get_xml_data($arrParam){		
		

		//$url = 'http://dlpapi.realtytrac.com/Reports/Get?ApiKey=a2d3e2aa-9c9b-4aab-af3a-56785ae67e25&Login=accurity&Password=1cyquent!&JobID=&LoanNumber=&PreparedBy=&ResellerID=&PreparedFor=&OwnerFirstName=&OwnerLastName=&AddressType=&PropertyStreetAddress='.$arrParam['street'].'&AddressNumber=&StartAddressNumberRange=&EndAddressNumberRange=&StreetDir=&StreetName=&StreetSuffix=&City='.$arrParam['city'].'&StateCode='.$arrParam['state'].'&County=&ZipCode=&PropertyParcelID=&SAPropertyID=&APN=&ApnRangeStart=&ApnRangeEnd=&GeoCodeX=&GeoCodeY=&GeoCodeRadius=&SearchType=&NumberOfRecords=&Format=XML&ReportID=104&R104_SettingsMode=';

		$url = 'http://dlpapi.realtytrac.com/Reports/Get?ApiKey=a2d3e2aa-9c9b-4aab-af3a-56785ae67e25&Login=accurity&Password=1cyquent!&JobID=&LoanNumber=&PreparedBy=&ResellerID=&PreparedFor=&OwnerFirstName=&OwnerLastName=&AddressType=&PropertyStreetAddress=&AddressNumber=&StartAddressNumberRange=&EndAddressNumberRange=&StreetDir=&StreetName=&StreetSuffix=&City=&StateCode=&County=&ZipCode=&PropertyParcelID='.$arrParam['propertyId'].'&SAPropertyID=&APN=&ApnRangeStart=&ApnRangeEnd=&Latitude=&Longitude=&Radius=&SearchType=&NumberOfRecords=&Sort=&Format=XML&ReportID=104&R104_SettingsMode=';



		$path = $_SESSION['path'];
		$fp = fopen($path,"a");
		fwrite($fp, "<p>Query To Get Comparable Property - <b>$url</b></p>");
		fclose($fp);
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url,
		));
		$resp = curl_exec($curl);
		curl_close($curl);
		
		preg_match_all("@<PROPERTY>(.*?)</PROPERTY>@is",$resp,$aProp,PREG_SET_ORDER);

		$result = array();
	
		foreach($aProp as $arr){
			 preg_match("@_City=\"(.*?)\"\s*_StreetAddress=\"(.*?)\"\s*_State=\"(.*?)\"\s*_PostalCode=\"(.*?)\"@is",$arr[1],$matches);
			 $address = $matches[2]." ".$matches[1]." ".$matches[3]." ".$matches[4];
			 preg_match("@DistanceFromSubjectPropertyMilesCount=\"(.*?)\"@is",$arr[1],$distance);
			 preg_match("@TotalBedroomCount=\"(.*?)\"@is",$arr[1],$beds);
			 preg_match("@TotalBathroomCount=\"(.*?)\"@is",$arr[1],$baths);
			 preg_match("@GrossLivingAreaSquareFeetCount=\"(.*?)\"@is",$arr[1],$size);
			 preg_match("@PropertyStructureBuiltYear=\"(.*?)\"@is",$arr[1],$built);
			 preg_match("@LotSquareFeetCount=\"(.*?)\"@is",$arr[1],$lot);
			 preg_match("@StoriesCount=\"(.*?)\"@is",$arr[1],$story);
			 preg_match("@LatitudeNumber=\"(.*?)\"\s*LongitudeNumber=\"(.*?)\"@is",$arr[1],$coords);
			 if(preg_match("@PropertySalesDate@",$arr[1])){
				 preg_match("@PropertySalesDate=\"(.*?)\"@is",$arr[1],$sale_date);
			 }else{
				 preg_match("@SALES_HISTORY.*?TransferDate_ext=\"(.*?)\"@is",$arr[1],$sale_date);
			 }
			 preg_match("@SALES_HISTORY.*?PropertySalesAmount=\"(.*?)\"@is",$arr[1],$sale_amount);

			 preg_match("@AMENITY _Type=\"Pool\" _ExistsIndicator=\"(.*?)\"@is", $arr[1],$pool);
			 $pool[1] = getPoolType($pool[1]);

			 preg_match("@BASEMENT SquareFeetCount=\"(.*?)\"@is",$arr[1],$basement);
			 if($basement[1]>0){ $basement[1]="Y";}else{ $basement[1]="No"; }

			 if($coords[1]!=""){$latitude=$coords[1];}
			 if($coords[2]!=""){$longitude=$coords[2];}

			 preg_match("@TransferDate_ext=\"(.*?)\"@is",$arr[1],$transfer);
			 $transfer[1] = preg_replace("@T.*?$@is", "", $transfer[1]);
			 preg_match("@StoriesCount=\"(.*?)\"@is",$arr[1],$stories);
			 $stories = $stories[1];
			  preg_match("@StandardUseCode_ext=\"(.*?)\"@",$arr[1],$props);
			 $ptype = trim($props[1]);
			 $ptype = getPropertyTypeDLP($ptype);
			 $result[] = array('address'=>$address,'distance'=>$distance[1], 'beds'=>trim(floor($beds[1])).'/'.floor($baths[1]).'','sq_size'=>$size[1],'year_built'=>$built[1], 'lot_size'=>$lot[1], 'stories'=>$story[1], 'dateSold'=>$sale_date[1], 'amount'=>$sale_amount[1], 'street'=>$matches[2],'city'=>$matches[1],'state'=>$matches[3], 'zip'=>$matches[4],'latitude'=>$latitude, 'longitude'=>$longitude, 'pool'=>$pool[1], 'basement'=>$basement[1], 'transferDate'=>$transfer[1],'stories'=>$stories,"propertyType"=>$ptype);			
		}
			
		return $result;
	}


	function getPropertyTypeDLP($prop){
			$multi = array("RAGA","RAHI","RAP1","RAPG","RAPT","RBOR","RDOR","RFRA","RMFD","RRIN");
			$sfr = array("RBUN","RMAN","RPAT","RPUD","RRES","RRUR","RSEA","RSFR");
			$condo = array("RCLU","RCOM","RCON","RCOO","RROW","RTHO");
			$duplex = array("RDUP");
			$mobile = array("RMOB","RMPM","RMSC");
			$quadraplex = array("RQUA","RRCO");
			$triplex = array("RTRI");

			$ml = preg_grep("@$prop@is", $multi);
			$sr  = preg_grep("@$prop@is", $sfr);
			$cn = preg_grep("@$prop@is", $condo);
			$dl  = preg_grep("@$prop@is", $duplex);
			$mb = preg_grep("@$prop@is", $mobile);
			$qd = preg_grep("@$prop@is", $quadraplex);
			$trp = preg_grep("@$prop@is", $triplex);

			if(count($ml)>0){
					return "MULTI";
			}
			else if(count($sr)>0){
					return "SFR";
			}
			else if(count($cn)>0){
					return "CONDO";
			}
			else if(count($dl)>0){
					return "DUPLEX";
			}
			else if(count($mb)>0){
					return "MOBILE";
			}
			else if(count($qd)>0){
					return "QUADRAPLEX";
			}
			else if(count($trp)>0){
					return "TRIPLEX";
			}
			return "SFR";
	}	


	function getPropertyTypeRELAR($prop){
			$multi = array("Residential Income (General/Multi-Family)","Multi-Family Dwellings (Generic, any combination)");
			$sfr = array("Historical - Private (general)","Historical Residence","Agricultural/Rural (general)","Apartment house (100+ units)","Apartment house (5+ units)","Apartments (generic)","Boarding/Rooming House, Apt Hotel","Bungalow (Residential)","Rural Residence","Residential (General/Single)","Ranch","Planned Unit Development (PUD)","Patio Home","Manufactured, Modular, Pre-Fabricated Homes","Seasonal, Cabin, Vacation Residence","Single Family Residence","Single Family Residential","Zero Lot Line (Residential)");
			$condo = array("Cooperative","Condominium Development (Association Assessment)","Condominium","Common Area (Residential)","Cluster home","Row house","Townhouse");
			$duplex = array("Highrise Apartments","Garden Apt, Court Apt (5+ units)","Duplex (2 units, any combination)");
			$mobile = array("Mobile home");
			$quadraplex = array("Quadruplex (4 units, any combination)");
			$triplex = array("Triplex (3 units, any combination)");

			$ml = preg_grep("@$prop@is", $multi);
			$sr  = preg_grep("@$prop@is", $sfr);
			$cn = preg_grep("@$prop@is", $condo);
			$dl  = preg_grep("@$prop@is", $duplex);
			$mb = preg_grep("@$prop@is", $mobile);
			$qd = preg_grep("@$prop@is", $quadraplex);
			$trp = preg_grep("@$prop@is", $triplex);

			if(count($ml)>0){
					return "MULTI";
			}
			else if(count($sr)>0){
					return "SFR";
			}
			else if(count($cn)>0){
					return "CONDO";
			}
			else if(count($dl)>0){
					return "DUPLEX";
			}
			else if(count($mb)>0){
					return "MOBILE";
			}
			else if(count($qd)>0){
					return "QUADRAPLEX";
			}
			else if(count($trp)>0){
					return "TRIPLEX";
			}
			return "SFR";
	}	
	
	
	function getPoolType($pool){
		
			if(preg_match("@Yes|Y|Gunite|In\s*ground|Above\s*ground@is",$pool)){				
				return "Y";					
			}
			else if (preg_match("@N|No|Association Pool|Neighborhood Pool@is",$pool)){
				return "N";
			}
			return "N";
	}

function get_xml_data_address($arrParam){		
		$url = 'http://dlpapi.realtytrac.com/Reports/Get?ApiKey=a2d3e2aa-9c9b-4aab-af3a-56785ae67e25&Login=accurity&Password=1cyquent!&JobID=&LoanNumber=&PreparedBy=&ResellerID=&PreparedFor=&OwnerFirstName=&OwnerLastName=&AddressType=&PropertyStreetAddress='.$arrParam['street'].'&AddressNumber=&StartAddressNumberRange=&EndAddressNumberRange=&StreetDir=&StreetName=&StreetSuffix=&City='.$arrParam['city'].'&StateCode='.$arrParam['state'].'&County=&ZipCode=&PropertyParcelID=&SAPropertyID=&APN=&ApnRangeStart=&ApnRangeEnd=&GeoCodeX=&GeoCodeY=&GeoCodeRadius=&SearchType=&NumberOfRecords=&Format=XML&ReportID=104&R104_SettingsMode=';

		$path = $_SESSION['path'];
		$fp = fopen($path,"a");
		fwrite($fp, "<p>Query To Get Comparable Property - <b> ".$url."</b></p>");
		fclose($fp);

		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url,
		));
		$resp = curl_exec($curl);
		curl_close($curl);
		
		preg_match_all("@<PROPERTY>(.*?)</PROPERTY>@is",$resp,$aProp,PREG_SET_ORDER);

		$result = array();

		foreach($aProp as $arr){
			 preg_match("@_City=\"(.*?)\"\s*_StreetAddress=\"(.*?)\"\s*_State=\"(.*?)\"\s*_PostalCode=\"(.*?)\"@is",$arr[1],$matches);
			 $address = $matches[2]." ".$matches[1]." ".$matches[3]." ".$matches[4];
			 preg_match("@DistanceFromSubjectPropertyMilesCount=\"(.*?)\"@is",$arr[1],$distance);
			 preg_match("@TotalBedroomCount=\"(.*?)\"@is",$arr[1],$beds);
			 preg_match("@TotalBathroomCount=\"(.*?)\"@is",$arr[1],$baths);
			 preg_match("@GrossLivingAreaSquareFeetCount=\"(.*?)\"@is",$arr[1],$size);
			 preg_match("@PropertyStructureBuiltYear=\"(.*?)\"@is",$arr[1],$built);
			 preg_match("@LotSquareFeetCount=\"(.*?)\"@is",$arr[1],$lot);
			 preg_match("@StoriesCount=\"(.*?)\"@is",$arr[1],$story);
			 preg_match("@LatitudeNumber=\"(.*?)\"\s*LongitudeNumber=\"(.*?)\"@is",$arr[1],$coords);
			 if(preg_match("@PropertySalesDate@",$arr[1])){
				 preg_match("@PropertySalesDate=\"(.*?)\"@is",$arr[1],$sale_date);
			 }else{
				 preg_match("@SALES_HISTORY.*?TransferDate_ext=\"(.*?)\"@is",$arr[1],$sale_date);
			 }
			 preg_match("@SALES_HISTORY.*?PropertySalesAmount=\"(.*?)\"@is",$arr[1],$sale_amount);

			 preg_match("@AMENITY _Type=\"Pool\" _ExistsIndicator=\"(.*?)\"@is", $arr[1],$pool);
			 if($pool[1]==""){ $pool[1]="N";}

			 preg_match("@BASEMENT SquareFeetCount=\"(.*?)\"@is",$arr[1],$basement);
			 if($basement[1]>0){ $basement[1]="Y";}else{ $basement[1]="No"; }

			 if($coords[1]!=""){$latitude=$coords[1];}
			 if($coords[2]!=""){$longitude=$coords[2];}

			 preg_match("@TransferDate_ext=\"(.*?)\"@is",$arr[1],$transfer);
			 $transfer[1] = preg_replace("@T.*?$@is", "", $transfer[1]);
			 preg_match("@StoriesCount=\"(.*?)\"@is",$arr[1],$stories);
			 $stories = $stories[1];
			 preg_match("@StandardUseCode_ext=\"(.*?)\"@",$arr[1],$props);
			 $ptype = trim($props[1]);
			 $ptype = getPropertyTypeDLP($ptype);
			 if($basement[1]=="Yes"){		 
				 $basement[1] = "Y";
			 }else if($basement[1]=="No"){
				 $basement[1] = "N";				 
			 }
			 $result[] = array('address'=>$address,'distance'=>$distance[1], 'beds'=>floor($beds[1]).' /'.floor($baths[1]).' ','sq_size'=>$size[1],'year_built'=>$built[1], 'lot_size'=>$lot[1], 'stories'=>$story[1], 'dateSold'=>$sale_date[1], 'amount'=>$sale_amount[1], 'street'=>$matches[2],'city'=>$matches[1],'state'=>$matches[3], 'zip'=>$matches[4],'latitude'=>$latitude, 'longitude'=>$longitude, 'pool'=>$pool[1], 'basement'=>$basement[1], 'transferDate'=>$transfer[1],'stories'=>$stories,'propertyType'=>$ptype);			
		}
			
		return $result;
	}



?>