<?php

function generate_xml($address, $city, $state, $zip, $landUse,$date="2015-06-23"){

	$curl = curl_init();
	curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://www.relar.com/RelarService/RelarReportService.asmx/GetListingsForRelarReport',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => "login=bjones1&password=relar88&address=$address&city=$city&state=$state&zipCode=$zip&landUse=$landUse&date=$date",
	));
	$resp = curl_exec($curl);
	curl_close($curl);

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
	

?>

