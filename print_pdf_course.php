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

	$query = $db->prepare("Select *, Levels.level_name from Courses inner join Levels on Courses.level_id=Levels.level_id where course_id = ? ";
	$query->bind_param("s", $print_id);
	$query->execute();
	$result = $query->get_result();

		while($course = $result->fetch_assoc()){



			//Style information for the PDF
			$style='
			<style>

			h2 {
				background-color: #dadada;
				font-family: "dejavusansextralight";
				font-size: 13pt;
				line-height: 150%;


			}

			p {
				font-family: "freeserif";
				font-size: 12pt;
				font-weight: normal;

			}

			h4 {
				font-family: "dejavusansextralight";
				font-size: 10pt;
				font-weight: normal;

			}
			OL {
				counter-reset: item;
				position: relative;
				left: -20px;
				z-index: 8;
			}
			OL LI { display: block;  }
			OL LI:before { content: counters(item, ".") ". "; counter-increment: item;  }

			table { width: 600px; }
			</style>
			<h2> Description</h2>
			<p>'.$course['course_description'].'</p>

			<h2> Emphasis</h2>
			<p>'.$course['course_emphasis'].'</p>

			<h2> Books and Materials</h2>
			<p>'.$course['course_materials'].'</p>

			<h2> Learning Outcomes</h2>
			<p>'.$course['learning_outcomes'].'</p>

			<h2> Assessment</h2>
			<p>'.$course['assessment'].'</p>

			<h2> Learning Experiences</h2>
			<p>'.$course['learning_experiences'].'</p>'
			;

			// PDF Settings

				$pdf->SetTitle($course["level_name"]." - ".$course['course_name']);
				$pdf->SetSubject($course["level_name"]." - ".$course['course_name']);
				$pdf->SetKeywords('ELC, BYU, Learning Outcomes');

			//Margins

			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			//Header and Footer
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $course["level_name"]." - ".$course['course_name'], "Course Information", array(0,34,85), array(0,34,85));
			$pdf->setFooterData(array(0,34,85), array(0,34,85));

			//Fonts and Spacing
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, "", "18"));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, "", PDF_FONT_SIZE_DATA));
			$pdf->SetFont("dejavusans","",8);
			$pdf->setCellHeightRatio(1); //this is the spacing between lines

			// this takes care of margins and padding for html elements
			$tagvs = array("p" => array(0 => array("h" => 1, "n" => 1), 1 => array("h" => 1, "n" => 1)), "ol" => array(0 => array("h" => 0, "n" => 0), 1 => array("h" => 0, "n" => 0)),"ul" => array(0 => array("h" => 0, "n" => 0), 1 => array("h" => 0, "n" => 0)), "h2" => array(0 => array("h" => 0, "n" => 0), 1 => array("h" => 0, "n" => 0)), "h4" => array(0 => array("h" => 0, "n" => 0), 1 => array("h" => 0, "n" => 0)), "hr" => array(1 => array("h" => 0, "n" => 0), 1 => array("h" => 1, "n" => 2)));
			$pdf->setHtmlVSpace($tagvs);

			$pdf->AddPage();
			$pdf->writeHTML($style, true, false, true, false, "");
			$filename=$course["level_name"]." ".$course['course_name'];
		}
	$result->free(); //Free MYSQL request


$pdf->Output($filename); //Create PDF
?>
