<?php
date_default_timezone_set("America/Denver");
	include_once("../../connectFiles/connect_cis.php");
	require("tcpdf/tcpdf.php");

	$print_id=$_GET['print_id'];

	class MYPDF extends TCPDF {
	    // Page footer
	    public function Footer() {
	        // Position at 15 mm from bottom
	        $this->SetY(-15);
	        // Set font
	        $this->SetFont("times", "", 10);
	        // Page number
	        // $this->Cell(0, 10,"English Language Center", 0, false, "C", 0, "", 0, false, "T", "M");
			$year = date("Y");
			$download_date = date("F\ j\,\ Y");

			$footerHTML = '<table><tr><td align="left"><a style="color: blue;text-decoration: underline;" href="http://elc.byu.edu/curriculum/">http://elc.byu.edu/curriculum/</a></td><td align="center">&copy; '.$year.'. English Language Center</td><td align="right">Downloaded: '.$download_date.'</td></tr></table>';

	        $this->writeHTMLCell(0, 10, 13, 265, " ".$footerHTML. " ", 0, 0, false, false, "C", true);
	        $this->Line(13,265,205,265);

	    }
	}

	$pdf=new myPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, "UTF-8", false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor(PDF_AUTHOR);

	$query = $database_curriculum->prepare("Select * from Levels where level_id = ? order by level_order ASC");
	$query->bind_param("s", $print_id);
$query->execute();
$result = $query->get_result();

		while($levels = $result->fetch_assoc()){
			//This splits the descriptor content into two separate strings to cross two pages.
			$spaces = str_replace("<h3>", "<h3>&nbsp;", $levels["level_descriptor"]); //adds a space to the h3 heading

			//This gest the proficiency info from the first page so it can be used int he second page.
			$proficiency = explode("</h4>", $spaces);

			$cleanup = array("<h4>", "(", ")");

			$proficiency[0] = str_replace($cleanup, "", $proficiency[0]);


			//Style information for the PDF
			$style='
			<style>

			h3 {
				background-color: #dadada;
				font-family: "dejavusansextralight";
				font-size: 12pt;
				line-height: 150%;


			}

			p {
				font-family: "Times";
				font-size: 11pt;
				font-weight: normal;


			}

			h4 {
				font-family: "dejavusansextralight";
				font-size: 10pt;
				font-weight: normal;

			}
			</style>

			';

			// PDF Settings

				$pdf->SetTitle($levels["level_name"]." Level Descriptors");
				$pdf->SetSubject($levels["level_name"]." Level Descriptors");
				$pdf->SetKeywords('ELC, BYU, Level Descriptor, Proficiency, Listening, Speaking, Reading, Writing');

			//Margins

			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			//Header and Footer
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $levels["level_name"]." Level Descriptors", $proficiency[0], array(0,34,85), array(0,34,85));
			$pdf->setFooterData(array(0,34,85), array(0,34,85));

			//Fonts and Spacing
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, "", "18"));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, "", PDF_FONT_SIZE_DATA));
			$pdf->SetFont("dejavusans","",8);
			$pdf->setCellHeightRatio(1); //this is the spacing between lines

			// this takes care of margins and padding for html elements
			$tagvs = array("p" => array(0 => array("h" => 0, "n" => 0), 1 => array("h" => 1.5, "n" => 2)), "h1" => array(0 => array("h" => 0, "n" => 0), 1 => array("h" => 0, "n" => 0)), "h3" => array(0 => array("h" => 0, "n" => 0), 1 => array("h" => 0, "n" => 0)), "h4" => array(0 => array("h" => 0, "n" => 0), 1 => array("h" => 0, "n" => 0)));
			$pdf->setHtmlVSpace($tagvs);

			$pdf->AddPage();
			$pdf->writeHTML($style.$proficiency[1], true, false, true, false, "");
			$filename=$levels['level_name']." Level Descriptors";
		}
	$result->free(); //Free MYSQL request


$pdf->Output($filename); //Create PDF
?>
