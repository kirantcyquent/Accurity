<?php
		session_start();
		$id = $_SESSION['sessionId'];
		if(isset($_SESSION['results']['map'])){
		$mp = $_SESSION['results']['map'];
		}else{
		$mp = $_SESSION['map'];
		}		

		$map = file_get_contents($mp);
		$fp = fopen("/tmp/$id.jpg",'w');
		fwrite($fp,$map);
		fclose($fp);
		
		$doc_path = $_SERVER["DOCUMENT_ROOT"];
		
		// Include the main TCPDF library (search for installation path).
		include($doc_path.'/tcpdf/examples/tcpdf_include.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		

		// set document information
		//$pdf->SetCreator(PDF_CREATOR);
		//$pdf->SetAuthor('Nicola Asuni');
		//$pdf->SetTitle(false);
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, 55, false, false);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', 10);

		// add a page
		$pdf->AddPage();
		
		// set JPEG quality
		$pdf->setJPEGQuality(75);

		/* NOTE:
		 * *********************************************************
		 * You can load external XHTML using :
		 *
		 * $html = file_get_contents('/path/to/your/file.html');
		 *
		 * External CSS files will be automatically loaded.
		 * Sometimes you need to fix the path of the external CSS.
		 * *********************************************************
		 */

		// define some HTML content with style
		$html = $_POST['cc'];

		$pdf->Image('/tmp/'.$id.'.jpg', '15', '60', 100, 60, '', '', '', false, 400, '', false, false, 0, false, false, false);
		preg_match("@downloadReport\s*<br>(.*?)downloadReport@is",$html,$matches);
		$html = $matches[1];
		//echo $html;exit;
		$html = preg_replace("@src=\"http.*?\".*?>@","src='$id.jpg' width='400'>", $html);
		
		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		// reset pointer to the last page
		$pdf->lastPage();

		//Close and output PDF document
		$pdf->Output($id.'.pdf', 'D');

		//============================================================+
		// END OF FILE
		//============================================================+
?>