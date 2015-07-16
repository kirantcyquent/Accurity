<?php
session_start();
$id = $_SESSION['sessionId'];
if(isset($_SESSION['results']['map'])){
$mp = $_SESSION['results']['map'];
}else{
$mp = $_SESSION['map'];
}

$map = file_get_contents($mp);
$fp = fopen("$id.jpg",'w');
fwrite($fp,$map);
fclose($fp);
$html = '<style>.btn-success { padding:6px 5px 6px 5px; }
#reportDiv { background-color:#60226b; width:156px; border-right:2px solid #fff; 
border-left:2px solid #fff; }
#sideMenu { margin-left:9%; }
input,textarea,select { border:1px solid #cfcfcf;}
#pageContent { overflow-x:hidden;}
#backBtn { font-size:11px; padding:2px 2px 2px 2px; }
.box-3 {
	position:relative;overflow:hidden;
	width:400px;height:200px;border:1px dashed #0C0;text-align:center;margin:5px;float:left;
}


.borderless td, .borderless th {
    border: none;
}

#map_wrapper {
    height: 400px;
}

#map_canvas {
    width: 90%;
    height: 100%;
}
th{ font-size:14px; height:30px;}
td{ font-size:16px; height:30px;}
#comps{ border:1px solid;}
#comps td{ font-size:16px; height:30px; border-top:1px solid;}

#ucomps{ border:1px solid;}
#ucomps td{ font-size:16px; height:30px; border-top:1px solid; }
</style>'.$_POST['cc'];
$html = preg_replace("@id=\"aclogo\">.*?</div>@is", 'id="aclogo"><img src="css/images/main_logo.jpg" width="200" class="img-responsive" alt="Logo" id="main_logo" style="padding-left:0px;"></div>',$html);
$html = preg_replace("@id=\"ad1\s*class.*?\"\s*style.*?\"@is",'',$html);
$html = str_replace('style="padding:20px 80px 0px 30px;"',"",$html);
$html = preg_replace("@repAddress\">@is",'id="repAddress"><table style="width:100%;"><tr><td>',$html);
$html = preg_replace("@</div>\s*<div id=\"repBy\".*?>@is",'</div></td><td>',$html);
$html = preg_replace("@<span id=\"repClose\"></span>@","</td></tr></table>",$html);
$html = preg_replace("@id=\"mp\">.*?</div>@is","><img src='".$id.".jpg'></div>",$html);
$html = preg_replace("@<div id=\"break\"></div>@is","<div><br/><br/><br/></div>",$html);
include("dompdf/dompdf_config.inc.php");
$html = $css.$html;
$dompdf = new DOMPDF();
$dompdf->set_base_path(realpath(APPLICATION_PATH . 'css/bootstrap.css'));
$dompdf->set_base_path(realpath(APPLICATION_PATH . 'css/bootstrap-theme.css'));
$dompdf->set_base_path(realpath(APPLICATION_PATH . 'css/style.css'));
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("$id.pdf");

?>