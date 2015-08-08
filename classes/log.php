<?php

include_once('Database.php');
include_once('Session.php');

class User {

	public $email;
	public $password;

	public function __construct(){

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