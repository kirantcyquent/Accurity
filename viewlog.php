<?php
$dir    = '/tmp/logs1/';
$files1 = scandir($dir);
echo "<pre>"; print_r($files1);
echo "<table>";
foreach($files1 as $file)
{
	 if (!in_array($file,array(".",".."))) 
		echo "<tr><td><a href='dispfile.php?filename=$file'>$file</a></td></tr>";
}
echo "</table>";


?>