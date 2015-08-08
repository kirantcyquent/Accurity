<?php
$dir    = '/tmp/logs1/';
$files1 = scandir($dir);
echo "<pre>"; print_r($files1);
echo "<table><tr><td>";
foreach($files1 as $file)
echo "<a href='dispfile.php?filename=$file'>$file</a></td>";
echo "</tr></table>";


?>