<?php

require_once 'config.php';

class Database
{
    
    public function __construct()
    {
       
    }

    // host:port
    private static $dbHost = DB_HOST;
    private static $dbName = DB_NAME;
    private static $dbUser = DB_USER;
    private static $dbPass = DB_PASS;
    public static $dbConn = null;


	public function getDBConnection(){
			self::$dbConn = mysql_connect(self::$dbHost, self::$dbUser, self::$dbPass);
			if (!self::$dbConn) {
				echo "Error in connecting database";
				die;
			}else{
				mysql_select_db(self::$dbName)or die("Couldnot connect connect to the database " . self::$dbName . " " . mysql_error());
			}
			return self::$dbConn;
	}


	public function saveRecords($insertArray, $table){

		 foreach ($insertArray as $fieldName => $fieldValue) {
            $insertArray[$fieldName] =  sprintf("`%s%s` = '%s'", '', $fieldName, mysql_real_escape_string($fieldValue, self::getDBConnection()));
        }

        $subsql = implode(", ", $insertArray);
        $sql = "INSERT INTO " . $table . " SET " . $subsql;
        $result = mysql_query($sql, self::getDBConnection())or die(mysql_error());
        return $result;
	}

	public function updateRecords($insertArray, $table, $where){

		 foreach ($insertArray as $fieldName => $fieldValue) {
            $insertArray[$fieldName] =  sprintf("`%s%s` = '%s'", '', $fieldName, mysql_real_escape_string($fieldValue, self::getDBConnection()));
        }

        $subsql = implode(", ", $insertArray);
        $sql = "UPDATE " . $table . " SET " . $subsql. " WHERE $where";

        $result = mysql_query($sql, self::getDBConnection())or die(mysql_error());
        return $result;
	}

	public function deleteRecords($stateInitial, $table){

   	    if ($stateInitial == "all") {
            $delSql = "DELETE FROM " . $table;
        }
        else {
            $delSql = "DELETE FROM " . $table . " WHERE id='$stateInitial'";
        }

		if (mysql_query($delSql, self::getDBConnection())) {
			return true;
		}else{
			return false;
		}
	}

	public function runQuery($query){
		$result = mysql_query($query, self::getDBConnection());
		return $result;
	}

	public function fetchArray($result){
		self::getDBConnection();
		$rs = @mysql_fetch_array($result)or die(mysql_error());
		return $rs;
	}

	public function checkRows($rs){
		self::getDBConnection();
		$rows = mysql_num_rows($rs);
		return $rows;
	}
} 
