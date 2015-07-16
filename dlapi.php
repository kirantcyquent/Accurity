<?php
function get_xml_data($arrParam){
	$url = 'http://dlpapi.realtytrac.com/Reports/Get?ApiKey=a2d3e2aa-9c9b-4aab-af3a-56785ae67e25&Login=accurity&Password=1cyquent!&JobID=&LoanNumber=&PreparedBy=&ResellerID=&PreparedFor=&OwnerFirstName=&OwnerLastName=&AddressType=&PropertyStreetAddress='.$arrParam['street'].'&AddressNumber=&StartAddressNumberRange=&EndAddressNumberRange=&StreetDir=&StreetName=&StreetSuffix=&City='.$arrParam['city'].'&StateCode='.$arrParam['state'].'&County=&ZipCode='.$arrParam['zip'].'&PropertyParcelID=&APN=&ApnRangeStart=&ApnRangeEnd=&GeoCodeX=&GeoCodeY=&GeoCodeRadius=&SearchType=&NumberOfRecords=&Format=XML&ReportID=104&R104_SettingsMode=Merge&PropertyCharacteristics_BedroomsRange='.$arrParam['beds'].'&PropertyCharacteristics_BathroomsRange='.$arrParam['baths'].'&PropertyCharacteristics_SquareFeetRange='.$arrParam['square_footage'].'&PropertyCharacteristics_LotSizeRange='.$arrParam['lot_size'].'&PropertyCharacteristics_SaleDateRange='.$arrParam['sale_date'].'&PropertyCharacteristics_SaleAmountRangeFrom='.$arrParam['amount_min'].'&PropertyCharacteristics_SaleAmountRangeTo='.$arrParam['amount_max'].'&PropertyCharacteristics_YearBuiltRange='.$arrParam['built_year'];

	$curl = curl_init();
	curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
  	));
	$resp = curl_exec($curl);
	curl_close($curl);
	
	preg_match_all("@<PROPERTY>(.+?)</PROPERTY>@is",$resp,$aProp,PREG_SET_ORDER);
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

		 if(preg_match("@PropertySalesDate@",$arr[1])){
			 preg_match("@PropertySalesDate=\"(.*?)\"@is",$arr[1],$sale_date);
		 }else{
			 preg_match("@SALES_HISTORY.*?TransferDate_ext=\"(.*?)\"@is",$arr[1],$sale_date);
		 }
		 preg_match("@SALES_HISTORY.*?PropertySalesAmount=\"(.*?)\"@is",$arr[1],$sale_amount);

		 $result[] = array('address'=>$address, 'distance'=>$distance[1], 'beds'=>$beds[1].' Bd /'.$baths[1].' Ba','sq_size'=>$size[1],'year_built'=>$built[1], 'lot_size'=>$lot[1], 'stories'=>$story[1], 'dateSold'=>$sale_date[1], 'amount'=>$sale_amount[1], 'street'=>$matches[2],'city'=>$matches[1],'state'=>$matches[3], 'zip'=>$matches[4]);			
	}
	return $result;
}

	$arr  = array ('street'=>'415+31ST+AVE+N','city'=>'NASHVILLE', 'state'=>'TN', 'zip'=>'37215','beds'=>'2', 'baths'=>'2','square_footage'=>'1000','lot_size'=>'249', 'sale_date'=>'2013','amount_min'=>'2500','amount_max'=>'250000', 'built_year'=>'1950');
	$res = get_xml_data($arr);
	echo "<pre>";
	print_r($res);
?>