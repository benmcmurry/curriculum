<?php
include_once("../../connectFiles/connect_cis.php");
$course_id=$_GET['print_id'];

$year = date("Y");
$download_date = date("F\ j\,\ Y");
            

function convertLinks($inputString) {
    if (strpos($_SERVER["SERVER_NAME"], 'elc.byu.edu')) {$server = 'href="https://'.$_SERVER["SERVER_NAME"].'/curriculum/';}
    else {$server = 'href="http://'.$_SERVER["SERVER_NAME"].'/';}
    
    return str_replace('href="', $server, $inputString);
}

// Include autoloader
require_once 'dompdf/autoload.inc.php';

// Reference the Dompdf namespace
use Dompdf\Dompdf;

// Instantiate and use the dompdf class
$dompdf = new Dompdf();
$query = $elc_db->prepare("Select *, Levels.level_name, Levels.level_short_name from Courses inner join Levels on Courses.level_id=Levels.level_id where course_id=?");
$query->bind_param('s', $course_id);
$query->execute();
$result = $query->get_result();
$course = $result->fetch_assoc();

$html = "<!DOCTYPE html>
<html lang=''>
<head>
	<title>".$course['level_short_name']." ".$course['course_name']."</title>

<!-- 	Meta Information -->
	<meta charset='utf-8'>
	<meta name='description' content='This section of the ELC website outlines the ELC curriculum.' />
	<meta name='keywords' content='ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes' />
	<meta name='robots' content='ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes' />
    <link href='pdfStyle.css' rel='stylesheet' type='text/css' />


</head>
<body>

<footer>
<table>
    <tr>
        <td align='left' width='33%'>
            <a href='https://elc.byu.edu/curriculum/'>https://elc.byu.edu/curriculum/</a>
        </td>
        <td align='center' width='33%'>
            &copy; $year. English Language Center
        </td>
        <td align='right' width='33%'>
            Downloaded: $download_date
        </td>
    </tr>
</table>
</footer>
<header>
<table>
    <tr>
        
        <td>
        <h1>".$course['level_name']."</h1>
        <h1>".$course['course_name']."</h1>
            
        </td>
        <td style=';width:200px'>
            <img width='200px' src='https://elc.byu.edu/curriculum/images/box-logo.jpg' />
        </td>
    </tr>

<table>
    


</header>
<article>
    <h3 class='course_data'>Course Description</h3>
    <p>".$course['course_description']."</p>
    <h3 class='course_data'>Course Emphasis</h3>
    <p>".$course['course_emphasis']."</p>
    <h3 class='course_data'>Course Books and Materials</h3>
    <p>".$course['course_materials']."</p>
    <h3 class='course_data'>Course Learning Outcomes</h3>
    <p>".convertLinks($course['learning_outcomes'])."</p>
    <h3 class='course_data'>Assessments and Learning Experiences</h3>";

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
		$html .="<ol class='le'>";
		while($le = $resultLe->fetch_assoc()){
			if ($le['assessment'] == 1 && $le['required'] == 1 && $ar) {$html .="</ol><h4>Required Assessments</h4><ol class='le'>";$ar=FALSE;}
			if ($le['assessment'] == 1 && $le['required'] == 0 && $anr) {$html .="</ol><h4>Optional Assessments</h4><ol class='le'>";$anr=FALSE;}
			if ($le['assessment'] == 0 && $le['required'] == 1 && $ler) {$html .="</ol><h4>Required Learning Experiences</h4><ol class='le'>";$ler=FALSE;}
			if ($le['assessment'] == 0 && $le['required'] == 0 && $lenr) {$html .="</ol><h4>Optional Learning Experiences</h4><ol class='le'>";$lenr=FALSE;}
			
			
			$html .="<li><a class='le_link' href='https://elc.byu.edu/curriculum/learning_experience.php?id=".$le['learning_experience_id']."'>".$le['name']."</a>. ".$le['short_description']."</li>";
		}            
        $html .="</ol>   
            
    </article>
</body>
</html>";

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream($course['level_short_name']." ".$course['course_name']);
exit;
?>