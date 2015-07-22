<?php
    $host = 'localhost'; 
    $db_name = 'login';
    $db_username = 'root';
    $db_password = 'secret';
    mysql_connect("localhost","root","secret");
	$db = mysql_select_db("loan");
	/*if($db){
		echo "conected";
	}else{
		die(mysql_error());
	}*/
	/*try
    {
        $pdo = new PDO('mysql:host='. $host .';dbname='.$db_name, $db_username, $db_password);
		//echo "connectred";
    }
    catch (PDOException $e)
    {
        exit('Error Connecting To DataBase');
    }*/
?>
