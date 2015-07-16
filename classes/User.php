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
		$query = "select * from userdetail ORDER BY UserID";
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


}
?>