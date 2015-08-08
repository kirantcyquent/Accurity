<?php

include_once('Database.php');
include_once('Session.php');

class User {

	public $email;
	public $password;

	public function __construct(){

	}


	public function createLog($address){

		$path = preg_replace("@\s+@","_",$address);
		if(!file_exists ("/tmp/logs/" ))
			mkdir("/tmp/logs/", 777);
		$path = "/tmp/logs/".$path.".html";
		if(file_exists($path)){
			unset($path);
		}
		$fp = fopen($path,"a");
		$data = "<h3 style='color:green;'>Search Address : $address </h3>";
		fwrite($fp, $data);
		fclose($fp);
		return $path;
	}

	public function writeRefineLog($PropData){
		session_start();
		$PropData['TOTALBATHROOMCOUNT']=round($PropData['TOTALBATHROOMCOUNT']);
		$Add =  $PropData['_STREETADDRESS'] .' '.$PropData['_CITY'].' '.$PropData['_STATE'].' '.$PropData['_POSTALCODE'];	
		$sq_footage =  $PropData['GROSSLIVINGAREASQUAREFEETCOUNT'];
		$bedrooms = $PropData['TOTALBEDROOMCOUNT'];
		$bathrooms=$PropData['TOTALBATHROOMCOUNT'];
		$year_built =$PropData['PROPERTYSTRUCTUREBUILTYEAR'];
		$lot_size =  $PropData['LOTSIZESQUAREFEETCOUNT_EXT'];
		$stories = $PropData['STORIESCOUNT'];

		$data = "<h5>Data Returned from DLP API for Search Address</h5>";
		$data = $data .'<table class="table table-bordered">
			<tr>
				<td>Address</td>
				<td>Sq Ft</td>
				<td>Bedrooms</td>
				<td>Bathrooms </td>
				<td>Year Built</td>
				<td>Lot </td>
				<td>Stories</td>
			</tr>
			<tr>
				<td>'.$Add.'</td>
				<td>'.$sq_footage.'</td>
				<td>'.$bedrooms.'</td>
				<td>'.$bathrooms.'</td>
				<td>'.$year_built.'</td>
				<td>'.$lot_size.'</td>
				<td>'.$stories.'</td>
			</tr>
		</table>';
		$sid  = $_SESSION['search_id_s'];
		$path = $_SESSION[$sid]['path'];
		$fp = fopen($path,"a");
		fwrite($fp, $data);
		fclose($fp);
	}

	public function storeXMLResultLog($xml_result){
		session_start();
		$sid  = $_SESSION['search_id_s'];
		$path = $_SESSION[$sid]['path'];
		
		$fp = fopen($path,"a");
		$count = count($xml_result);
		fwrite($fp, "<p>Number of Records in Relar Database</p>");
		$data = '<table class="table table-bordered"> 
		<tr>
			<td>SL</td><td>Address </td><td>Distance </td><td>Bed/baths </td><td>Sqft</td><td>Year Built</td><td>Lot Size</td><td>Stories</td><td>List Date</td><td>Price</td><td>Pool</td>
		</tr>
		';

		$count = 1;
		foreach($xml_result as $rows)
		{

			$rows['LOTSIZEACRES'] = $rows['LOTSIZEACRES'] * 43560;
			$tr = '<tr><td>'.$count.'</td><td>'.$rows['ADDRESS'].'</td><td>'.$rows['DIST'].'</td><td>'.$rows['BEDS'].' Bd /'.$rows['BATHS'].' Ba </td><td>'.$rows['SQ_FT'].' </td><td>'.$rows['YEARBUILT'].'</td><td>'.$rows['LOTSIZEACRES'].'</td><td>'.$rows['STRUCTURESTORIES'].'</td><td>'.$rows['LISTDATE'].'</td><td>'.$rows['LISTPRICE'].'</td><td>'.$rows['POOL'].'</td></tr>';
			$count++;


			$listdate = $rows['LISTDATE'];
			list($m,$d,$y) = preg_split("@\/@",$listdate);
			$ydate = strtotime("$y-$m-$d");
			$cn1 = time() - (180*24*60*60);
			$cn2 = time() - (365*24*60*60);

			if($rows['POOL']==""){ $rows['POOL']="No";}
			if(($rows['SQ_FT'] > $C1Rangesqrft['Min'] && $rows['SQ_FT'] < $C1Rangesqrft['Max'] ) && ($rows['LOTSIZEACRES'] > $C1Rangelot['Min'] && $rows['LOTSIZEACRES'] < $C1Rangelot['Max']) && ($rows['YEARBUILT'] > $C1RangeAge['Min'] && $rows['YEARBUILT'] < $C1RangeAge['Max']) && ($ydate> $cn1) && $rows['DIST']<$C1Proximity)
			{
				$c1[] = array('address'=>$rows['ADDRESS'], 'distance'=>$rows['DIST'],'bedsBaths'=>$rows['BEDS'].' Bd /'.$rows['BATHS'].' Ba','sq_size'=>$rows['SQ_FT'],'year_built'=>$rows['YEARBUILT'],'lot_size'=>$rows['LOTSIZEACRES'],'stories'=>$rows['STRUCTURESTORIES'],'dateSold'=>$rows['LISTDATE'], 'amount'=>$rows['LISTPRICE'], 'latitude'=>$rows['LAT'], 'longitude'=>$rows['LON'],'pool'=>$rows['POOL'], 'basement'=>"No");
			}
			else 
			if(($rows['SQ_FT'] > $C2Rangesqrft['Min'] && $rows['SQ_FT'] < $C2Rangesqrft['Max'] ) && ($rows['LOTSIZEACRES'] > $C2Rangelot['Min'] && $rows['LOTSIZEACRES'] < $C2Rangelot['Max']) && ($rows['YEARBUILT'] > $C2RangeAge['Min'] && $rows['YEARBUILT'] < $C2RangeAge['Max']) && ($ydate> $cn2) && $rows['DIST']<$C2Proximity)
			{
				$c2[] = array('address'=>$rows['ADDRESS'], 'distance'=>$rows['DIST'],'bedsBaths'=>$rows['BEDS'].' Bd /'.$rows['BATHS'].' Ba','sq_size'=>$rows['SQ_FT'],'year_built'=>$rows['YEARBUILT'],'lot_size'=>$rows['LOTSIZEACRES'],'stories'=>$rows['STRUCTURESTORIES'],'dateSold'=>$rows['LISTDATE'], 'amount'=>$rows['LISTPRICE'],'latitude'=>$rows['LAT'], 'longitude'=>$rows['LON'],'pool'=>$rows['POOL'], 'basement'=>"No");
			}else 
			if(($rows['SQ_FT'] > $C3Rangesqrft['Min'] && $rows['SQ_FT'] < $C3Rangesqrft['Max'] ) && ($rows['LOTSIZEACRES'] > $C3Rangelot['Min'] && $rows['LOTSIZEACRES'] < $C3Rangelot['Max']) && ($rows['YEARBUILT'] > $C3RangeAge['Min'] && $rows['YEARBUILT'] < $C3RangeAge['Max']) && ($ydate> $cn2) && $rows['DIST']<$C3Proximity)
			{
				$c3[] = array('address'=>$rows['ADDRESS'], 'distance'=>$rows['DIST'],'bedsBaths'=>$rows['BEDS'].' Bd /'.$rows['BATHS'].' Ba','sq_size'=>$rows['SQ_FT'],'year_built'=>$rows['YEARBUILT'],'lot_size'=>$rows['LOTSIZEACRES'],'stories'=>$rows['STRUCTURESTORIES'],'dateSold'=>$rows['LISTDATE'], 'amount'=>$rows['LISTPRICE'],'latitude'=>$rows['LAT'], 'longitude'=>$rows['LON'], 'pool'=>$rows['POOL'], 'basement'=>"No");
			}
			$data  = $data."".$tr;
		}

		$data = $data ."</table>";

		fwrite($fp,$data);
		fclose($fp);

		$c1data = "<h5>Properties matching criteria 1 </h5>";
		$fp = fopen($path,"a");
		$c1data = $c1data.'<table class="table table-bordered"> 
		<tr>
			<td>SL</td><td>Address </td><td>Distance </td><td>Bed/baths </td><td>Sqft</td><td>Year Built</td><td>Lot Size</td><td>Stories</td><td>List Date</td><td>Price</td><td>Pool</td>
		</tr>
		';
		$count=1;
		foreach($c1 as $rows){
			$tr = '<tr><td>'.$count.'</td><td>'.$rows['address'].'</td><td>'.$rows['distance'].'</td><td>'.$rows['bedsBaths'].' </td><td>'.$rows['sq_size'].' </td><td>'.$rows['year_built'].'</td><td>'.$rows['lot_size'].'</td><td>'.$rows['Sstories'].'</td><td>'.$rows['dateSold'].'</td><td>'.$rows['amount'].'</td><td>'.$rows['pool'].'</td></tr>';
			$count++;
			$c1data = $c1data .''.$tr;
		}	
		fwrite($fp, $c1data);
		fclose($fp);


		$c1data = "<h5>Properties matching criteria 2 </h5>";
		$fp = fopen($path,"a");
		$c1data = $c1data.'<table class="table table-bordered"> 
		<tr>
			<td>SL</td><td>Address </td><td>Distance </td><td>Bed/baths </td><td>Sqft</td><td>Year Built</td><td>Lot Size</td><td>Stories</td><td>List Date</td><td>Price</td><td>Pool</td>
		</tr>
		';
		$count=1;
		foreach($c2 as $rows){
			$tr = '<tr><td>'.$count.'</td><td>'.$rows['address'].'</td><td>'.$rows['distance'].'</td><td>'.$rows['bedsBaths'].' </td><td>'.$rows['sq_size'].' </td><td>'.$rows['year_built'].'</td><td>'.$rows['lot_size'].'</td><td>'.$rows['Sstories'].'</td><td>'.$rows['dateSold'].'</td><td>'.$rows['amount'].'</td><td>'.$rows['pool'].'</td></tr>';
			$count++;
			$c1data = $c1data .''.$tr;
		}	
		fwrite($fp, $c1data);
		fclose($fp);


		$c1data = "<h5>Properties matching criteria 3 </h5>";
		$fp = fopen($path,"a");
		$c1data = $c1data.'<table class="table table-bordered"> 
		<tr>
			<td>SL</td><td>Address </td><td>Distance </td><td>Bed/baths </td><td>Sqft</td><td>Year Built</td><td>Lot Size</td><td>Stories</td><td>List Date</td><td>Price</td><td>Pool</td>
		</tr>
		';
		$count=1;
		foreach($c3 as $rows){
			$tr = '<tr><td>'.$count.'</td><td>'.$rows['address'].'</td><td>'.$rows['distance'].'</td><td>'.$rows['bedsBaths'].' </td><td>'.$rows['sq_size'].' </td><td>'.$rows['year_built'].'</td><td>'.$rows['lot_size'].'</td><td>'.$rows['Sstories'].'</td><td>'.$rows['dateSold'].'</td><td>'.$rows['amount'].'</td><td>'.$rows['pool'].'</td></tr>';
			$count++;
			$c1data = $c1data .''.$tr;
		}	
		fwrite($fp, $c1data);
		fclose($fp);
	}




	public function check_user(){
		$db = new Database();
		$session = new Session();

		$this->email = mysql_real_escape_string($this->email, $db->getDBConnection());
		$this->password = mysql_real_escape_string($this->password, $db->getDBConnection());
		$result = $db->runQuery("SELECT * FROM userdetail WHERE username='{$this->email}' and password='{$this->password}' and Active=1");
		if($db->checkRows($result)>0){
			$session->set_session('email',$this->email);			
			$details = $db->fetchArray($result);
			$session->set_session('user_type',$details['TypeOfUser']);
			$randomsession = uniqid(ssn);
			$session->set_session('sessionid',$randomsession);
			$insertArray['SessionID'] = $randomsession;
			$insertArray['UserID'] = $details['UserID'];
			$session->set_session('userid',$details['UserID']);
			$rs = $db->saveRecords($insertArray, "session");
			return true;
		}
		else{
			return false;
		}
	}

	public function get_user_type(){
		$db = new Database();
		$session = new Session();
		$result = $db->runQuery("SELECT TypeOfUser FROM userdetail WHERE username='{$_SESSION['email']}'");
		$row = $db->fetchArray($result);
		return $row['TypeOfUser'];
	}

	public function saveAction($actionId, $action, $parameters){
		$db = new Database();
		$session = new Session();
		$params['SessionID'] = $session->get_session('sessionid');
		$params['ActionID'] = $actionId;
		$params['Action'] = $action;
		$params['Parameters'] = $parameters;
		$db->saveRecords($params, 'action');
	}

	public function saveSearch($Name, $isDone, $param){
		$db = new Database();
		$session = new Session();
		$Name = trim(preg_replace("@\s+@","_",$Name));
		$param  = serialize($param);
		$params['Name'] = $Name;
		$params['UserID'] = $session->get_session('userid');
		$params['IsDone'] = $isDone;
		$params['Param'] = $param;
		$db->saveRecords($params, 'savesearch');
		$searchId = mysql_insert_id();
		$pms['SessionID'] = $session->get_session('sessionid');
		$pms['SearchID'] = $searchId;
		$db->saveRecords($pms, 'sessionsavelink');
		$session->set_session('searchId',$searchId);
		return $searchId;
	}

	public function updateSearch($Name, $isDone, $param,$searchId){
		$db = new Database();
		$session = new Session();
		$Name = trim(preg_replace("@\s+@","_",$Name));
		$param  = serialize($param);
		$params['Name'] = $Name;
		$params['UserID'] = $session->get_session('userid');
		$params['IsDone'] = $isDone;
		$params['Param'] = $param;
		$db->updateRecords($params, 'savesearch','SearchID='.$searchId);
	}

	public function getCompletedSearches(){
		$db = new Database();
		$session = new Session();
		$id = $session->get_session('userid');
		$isDone = 1;
		$query = "SELECT * FROM savesearch s, sessionsavelink l WHERE s.SearchID=l.SearchID and s.UserID='$id' and s.IsDone='$isDone' ORDER BY s.date DESC";
		$result = $db->runQuery($query);
		$rows = array();
		while($rs = mysql_fetch_array($result)){
			$rows[]=$rs;
		}		
		return $rows;
	}

	public function getInCompleteSearches(){
		$db = new Database();
		$session = new Session();
		$id = $session->get_session('userid');
		$isDone = 0;
		$query = "SELECT * FROM savesearch s, sessionsavelink l WHERE s.SearchID=l.SearchID and s.UserID='$id' and s.IsDone='$isDone' ORDER BY s.date DESC";
		$result = $db->runQuery($query);
		$rows = array();
		while($rs = mysql_fetch_array($result)){
			$rows[]=$rs;
		}		
		return $rows;
	}

	public function getUserDetails(){
		$db = new Database();
		$session = new Session();
		$id = $session->get_session('userid');
		$query = "SELECT * FROM userdetail WHERE UserID='$id'";
		$result = $db->runQuery($query);
		$row = $db->fetchArray($result);
		return $row;
	}
	
	public function getUserList(){
		$db  = new Database();
		$session = new Session();
		$id = $session->get_session('userid');
		$query = "select * from userdetail where lendingId='$id' ORDER BY UserID DESC";
		$result = $db->runQuery($query);
		$users = array();
		while($row = mysql_fetch_array($result)){
			$users[] = $row;
		}
		return $users;
	}

	public function getAppraiserList($id){
		$db  = new Database();
		$query = "select * from userdetail where TypeOfUser=1 and lendingId='$id' ORDER BY UserID";
		$result = $db->runQuery($query);
		$users = array();
		while($row = mysql_fetch_array($result)){
			$users[] = $row;
		}
		return $users;
	}

	public function getOfficerList($id){
		$db  = new Database();
		$query = "select * from userdetail where TypeOfUser=2 and lendingId='$id' ORDER BY UserID";
		$result = $db->runQuery($query);
		$users = array();
		while($row = mysql_fetch_array($result)){
			$users[] = $row;
		}
		return $users;
	}

	public function getLendingList(){
		$db  = new Database();
		$query = "select * from userdetail WHERE TypeOfUser=3 ORDER BY UserID";
		$result = $db->runQuery($query);
		$users = array();
		while($row = mysql_fetch_array($result)){
			$users[] = $row;
		}
		return $users;
	}

	public function getNbCompletedSearches($userid){
		$db  = new Database();
		$isDone = 1;
		$query = "SELECT count(s.SearchID) FROM savesearch s, sessionsavelink l WHERE s.SearchID=l.SearchID and s.UserID='$userid' and s.IsDone='$isDone' ORDER BY s.date DESC";
		$result = $db->runQuery($query);
		$row = mysql_fetch_row($result);
		return $row[0];
	}
	
	public function getNbIncompleteSearches($userid){
		$db  = new Database();
			$isDone = 0;
		$query = "SELECT count(s.SearchID) FROM savesearch s, sessionsavelink l WHERE s.SearchID=l.SearchID and s.UserID='$userid' and s.IsDone='$isDone' ORDER BY s.date DESC";
		$result = $db->runQuery($query);
		$row = mysql_fetch_row($result);
		return $row[0];
	}
	
	public function getUserCompletedSearches($id){
		$db = new Database();
		$isDone = 1;
		$query = "SELECT * FROM savesearch s, sessionsavelink l WHERE s.SearchID=l.SearchID and s.UserID='$id' and s.IsDone='$isDone' ORDER BY s.date DESC";
		$result = $db->runQuery($query);
		$rows = array();
		while($rs = mysql_fetch_array($result)){
			$rows[]=$rs;
		}		
		return $rows;
	}

	public function check_password($pass){
		$db = new Database();
		$session = new Session();
		$id = $session->get_session('userid');

		$query = "SELECT * FROM userdetail WHERE UserID='$id' and Password='$pass'";
		$result = $db->runQuery($query);
		$check = mysql_num_rows($result);
		if($check>0){
			return 1;
		}else{
			return 0;
		}
	}


	public function change_password($pass){
		print $pass;exit;
		$db = new Database();
		$session = new Session();
		$id = $session->get_session('userid');

		$query = "UPDATE userdetail SET Password='$pass' WHERE UserID='$id'";
		$result = $db->runQuery($query);
		if($result){
			return 1;
		}else{
			return 0;
		}
	}


	public function lendingAppraisers($lendingid){
		$db = new Database();
		$query = "SELECT count(UserID) FROM userdetail WHERE TypeOfUser=1 and lendingId='$lendingid'";			
		$row = $db->runQuery($query);
		$row = mysql_fetch_row($row);
		return $row[0];
	}

	public function lendingOfficers($lendingid){
		$db = new Database();
		$query = "SELECT count(UserID) FROM userdetail WHERE TypeOfUser=2 and lendingId='$lendingid'";			
		$row = $db->runQuery($query);
		$row = mysql_fetch_row($row);
		return $row[0];
	}

	public function lendingSearches($userid, $isDone){
		$db  = new Database();
		$query = "SELECT count(s.SearchID) FROM savesearch s, sessionsavelink l, userdetail u WHERE s.SearchID=l.SearchID and s.UserID=u.UserID and u.lendingId='$userid' and s.IsDone='$isDone'  ORDER BY s.date DESC";
		$result = $db->runQuery($query);
		$row = mysql_fetch_row($result);
		return $row[0];
	}

	public function storeAddress($searchId, $paramAdd, $paramCom){		
		$db = new Database();
		$query = "select * from searchAddresses where searchId='$searchId'";		
		$result = mysql_query($query)or die(mysql_error());
		$row = mysql_num_rows($result);
		

		if($row>0){
			$rw = mysql_fetch_array(mysql_query($query));
			$id = $rw['id'];
			$query ="update searchAddresses set paramAddress='$paramAdd', paramComments='$paramCom' where id='$id'";
			$result = $db->runQuery($query);
		}else{
			$db->runQuery("insert into searchAddresses (searchId, paramAddress, paramComments) values ('$searchId','$paramAdd','$paramCom')");
		}		
	}
}
?>