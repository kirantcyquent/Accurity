<?php
    $host = 'localhost'; 
    $db_name = 'preetisa_sample';
    $db_username = 'preetisa_admin';
    $db_password = 'T&NZR[,b%a_A';
    mysql_connect("localhost","preetisa_admin","T&NZR[,b%a_A");
	$db = mysql_select_db("preetisa_sample");
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