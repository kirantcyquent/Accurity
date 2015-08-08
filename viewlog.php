<?php
$dir    = '/tmp/logs1/';
$files1 = scandir($dir);
echo "<table border='1'><tr><td>SeqNo</td><td>FileName</td></tr>";
$count = 0;
foreach($files1 as $file)
{
	 if (!in_array($file,array(".","..")))
	 {
		$count++;
		echo "<tr><td>$count</td><td><a href='dispfile.php?filename=$file'>$file</a></td></tr>";
	 }
}
echo "</table>";


?>