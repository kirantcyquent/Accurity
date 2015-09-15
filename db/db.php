<?php
    $host = 'Db1-hf.realtytrac.com'; 
    $db_name = 'loan';
    $db_username = 'loan_user';
    $db_password = 'l0@n';
    mysql_connect($host, $db_username, $db_password)or die(mysql_error());
	$db = mysql_select_db($db_name)or die(mysql_error());
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
