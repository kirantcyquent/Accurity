<?php
$dir    = '/tmp/logs1/';
$files1 = scandir($dir);
echo "<table><tr><td>";
foreach($files1 as $file)
echo "<a href='dispfile.php?filename=$file'>Visit our HTML tutorial</a></td>";
echo "</tr></table>";


?>