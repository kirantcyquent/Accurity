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
		
		class MYPDF extends TCPDF 
		{
			public function Header() {
				// get the current page break margin
				$bMargin = $this->getBreakMargin();
				// get current auto-page-break mode
				$auto_page_break = $this->AutoPageBreak;
				// disable auto-page-break
				$this->SetAutoPageBreak(false, 0);
				$headerData = $this->getHeaderData();
				$this->SetFont('helvetica', 'B', 10);
				$this->writeHTML($headerData['string']);
				 // restore auto-page-break status
				$this->SetAutoPageBreak($auto_page_break, $bMargin);
				// set the starting point for the page content
				$this->setPageMark();
			}
		}

		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		

		// set document information
		//$pdf->SetCreator(PDF_CREATOR);
		//$pdf->SetAuthor('Nicola Asuni');
		//$pdf->SetTitle(false);
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		if($_SESSION['user_type']!=2)
		{
			$head_descr = false;
			$head_title = false;
			$pdf_creator_name = '';
			$designation = '';
			$qualification = '';
		}
		else
		{
			$head_title = "Accurity Valuation";
			$head1 = "“I developed R3 because the future became clear:";
			$head_descr = " Loan officers and \n their REALTOR® business partners needed a search engine to identify \n potential appraisal issues and “red flag” sales BEFORE the transaction.”";
			$pdf_creator_name = "BRENT JONES &nbsp;&nbsp;|";
			$designation = 'CEO &nbsp;&nbsp;|';
			$qualification = 'FORMER FANNIE MAE SENIOR ANALYST';
		}
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, 60, false, $head_descr);
		$logo = K_PATH_IMAGES.PDF_HEADER_LOGO;
		$hedader_data = '<table cellspacing="0" cellpadding="1" border="0" width="100%" style="font-size:11px; font-weight:normal !important;">
							<tr>
								<td rowspan="3" width="40%">
									<img src="'.$logo.'" width="235" height:"180"/>
								</td>
								<td width="60%" align="justify">
									<span color="#60226B"><b>'.$head1.'</b></span>'.$head_descr.'	
									<br/><br/>
									<table>
										<tr>
											<td width="100px" color="#60226B"><b>'.$pdf_creator_name.' </b></td>
											<td width="50px" color="#60226B"><b>'.$designation.' </b></td>
											<td width="350px" color="#60226B"><b>'.$qualification.'</b></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>';
		$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs=$hedader_data, $tc=array(0,0,0), $lc=array(0,0,0));

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
		$pdf->SetFont('dejavusans', '', 10);

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
		if($_SESSION['user_type']!=2)
		$pdf->Image('/tmp/'.$id.'.jpg', '15', '70', 100, 60, '', '', '', false, 400, '', false, false, 0, false, false, false);
		else
		$pdf->Image('/tmp/'.$id.'.jpg', '15', '160', 180, 90, '', '', '', false, 400, '', false, false, 0, false, false, false);
	
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