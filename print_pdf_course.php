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

	$query = $elc_db->prepare("Select *, Levels.level_name from Courses inner join Levels on Courses.level_id=Levels.level_id where course_id = ? ");
	$query->bind_param("s", $print_id);
	$query->execute();
	$result = $query->get_result();

		while($course = $result->fetch_assoc()){



			//Style information for the PDF
			$content='
			<style>

			h2 {
				background-color: #dadada;
				font-family: "dejavusansextralight";
				font-size: 13pt;
				line-height: 150%;


			}

			p, a, li{
				font-family: "times";
				font-size: 12pt;
				font-weight: normal;
				line-height: 18pt;

			}

			h4 {
				font-family: "dejavusansextralight";
				font-size: 10pt;
				font-weight: bold;

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
			<h2>Assessments and Learning Experiences</h2><ol>';
			
			// Get learning experiences
			
			$queryRequiredLearningExperiences = $elc_db->prepare("select *, Learning_experiences.name, Learning_experiences.learning_experience_id 
			from `LE_courses`
					natural left join
						Learning_experiences 
					where LE_courses.course_id=? order by Learning_experiences.assessment DESC, Learning_experiences.required DESC");
			$queryRequiredLearningExperiences->bind_param('s', $course['course_id']);
			$queryRequiredLearningExperiences->execute();
			$resultLe = $queryRequiredLearningExperiences->get_result();
			$ar = TRUE; //assessment, required counter
			$anr =TRUE; //assessment, not required counter
			$ler = TRUE; //learning experience, required counter
			$lenr = TRUE; //learning experience, not required counter
			
			while($le = $resultLe->fetch_assoc()){
				if ($le['assessment'] == 1 && $le['required'] == 1 && $ar) {$content .='</ol><h4>Required Assessments</h4><ol>';$ar=FALSE;}
				if ($le['assessment'] == 1 && $le['required'] == 0 && $anr) {$content .='</ol><br /><h4>Optional Assessments</h4><ol>';$anr=FALSE;}
				if ($le['assessment'] == 0 && $le['required'] == 1 && $ler) {$content .='</ol><br /><h4>Required Learning Experiences</h4><ol>';$ler=FALSE;}
				if ($le['assessment'] == 0 && $le['required'] == 0 && $lenr) {$content .='</ol><br /><h4>Optional Learning Experiences</h4><ol>';$lenr=FALSE;}
				
				
				$content .='<li><a href="http://elc.byu.edu/curriculum/learning_experience.php?id='.$le["id"].'">'.$le["name"].'</a>. '.$le["short_description"].'</li><br />';
			}
			$content .="</ol>";
			// end getting learning Experiences

			$content .= '

			<h2> Assessment OLD</h2>
			<p>'.$course['assessment'].'</p>

			<h2> Learning Experiences OLD</h2>
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
			$pdf->writeHTML($content, true, false, true, false, "");
			$filename=$course["level_name"]." ".$course['course_name'];
		}
	$result->free(); //Free MYSQL request


$pdf->Output($filename); //Create PDF
?>
