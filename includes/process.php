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
		$URL = "http://dlpapi.realtytrac.com/Reports/Get?ApiKey=a2d3e2aa-9c9b-4aab-af3a-56785ae67e25&Login=accurity&Password=1cyquent!&JobID=&LoanNumber=&PreparedBy=&ResellerID=&PreparedFor=&OwnerFirstName=&OwnerLastName=&AddressType=&PropertyStreetAddress=$StreetAddr&AddressNumber=&StartAddressNumberRange=&EndAddressNumberRange=&StreetDir=&StreetName=&StreetSuffix=&City=$City&StateCode=$State&County=&ZipCode=$Zip&PropertyParcelID=&APN=&ApnRangeStart=&ApnRangeEnd=&GeoCodeX=&GeoCodeY=&GeoCodeRadius=&SearchType=&NumberOfRecords=&Format=XML&ReportID=102";

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
		$Address = trim(str_replace($Zip, '',$Address));;
		$Address = trim(str_replace($OrigState, '',$Address));
		$Address = trim(str_replace($City, '',$Address));
		$Address = trim(str_replace(" $State" , '',$Address));
		$aRet['StreetAdd'] = $Address;
		$aRet['Zip'] = $Zip;
		$aRet['City'] = $City;
		$aRet['State'] = $State;

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

		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'http://www.relar.com/RelarService/RelarReportService.asmx/GetListingsForRelarReport',
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => "login=bjones1&password=relar88&address=$address&city=$city&state=$state&zipCode=$zip&landUse=$landUse&date=$date",
		));

		$path = $_SESSION['path'];
		$fp = fopen($path,"a");
		fwrite($fp, "<p>Query To Get RELAR Property - <b>http://www.relar.com/RelarService/RelarReportService.asmx/GetListingsForRelarReport?login=bjones1&password=relar88&address=$address&city=$city&state=$state&zipCode=$zip&landUse=$landUse&date=$date </b></p>");
		fclose($fp);
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
		$url = 'http://dlpapi.realtytrac.com/Reports/Get?ApiKey=a2d3e2aa-9c9b-4aab-af3a-56785ae67e25&Login=accurity&Password=1cyquent!&JobID=&LoanNumber=&PreparedBy=&ResellerID=&PreparedFor=&OwnerFirstName=&OwnerLastName=&AddressType=&PropertyStreetAddress='.$arrParam['street'].'&AddressNumber=&StartAddressNumberRange=&EndAddressNumberRange=&StreetDir=&StreetName=&StreetSuffix=&City='.$arrParam['city'].'&StateCode='.$arrParam['state'].'&County=&ZipCode=&PropertyParcelID=&SAPropertyID=&APN=&ApnRangeStart=&ApnRangeEnd=&GeoCodeX=&GeoCodeY=&GeoCodeRadius=&SearchType=&NumberOfRecords=&Format=XML&ReportID=104&R104_SettingsMode=';

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
			 if($pool[1]==""){ $pool[1]="No";}

			 preg_match("@BASEMENT SquareFeetCount=\"(.*?)\"@is",$arr[1],$basement);
			 if($basement[1]>0){ $basement[1]="Y";}else{ $basement[1]="No"; }

			 if($coords[1]!=""){$latitude=$coords[1];}
			 if($coords[2]!=""){$longitude=$coords[2];}


			 $result[] = array('address'=>$address, 'distance'=>$distance[1], 'beds'=>$beds[1].' Bd /'.$baths[1].' Ba','sq_size'=>$size[1],'year_built'=>$built[1], 'lot_size'=>$lot[1], 'stories'=>$story[1], 'dateSold'=>$sale_date[1], 'amount'=>$sale_amount[1], 'street'=>$matches[2],'city'=>$matches[1],'state'=>$matches[3], 'zip'=>$matches[4],'latitude'=>$latitude, 'longitude'=>$longitude, 'pool'=>$pool[1], 'basement'=>$basement[1]);			
		}
			
		return $result;
	}


?>