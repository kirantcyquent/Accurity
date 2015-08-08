<?php
$filename = $_REQUEST['filename'];
echo $a = file_get_contents("/tmp/logs/$filename");

?>