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
$query = $elc_db->prepare("Select *, Levels.level_name, Skill_areas.skill_area_philosophy from Courses inner join Levels on Courses.level_id=Levels.level_id inner join Skill_areas on Courses.skill_area=Skill_areas.id where course_id=?");
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
    <h3 class='course_data'>Skill Area Philosophy</h3>
    <p>".$course['skill_area_philosophy']."</p>
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
            where LE_courses.course_id=? order by emphasis, name ASC");
    $queryRequiredLearningExperiences->bind_param('s', $course['course_id']);
    $queryRequiredLearningExperiences->execute();
    $resultLe = $queryRequiredLearningExperiences->get_result();
    $grammar = TRUE; //counter
    $speaking =TRUE; //counter
    $listening = TRUE; //counter
    $reading = TRUE; //counter
    $writing = TRUE; //counter
    $pronunciation = TRUE; //counter
    $vocabulary = TRUE; //counter
    $none = TRUE; //counter
    $listening_and_reading = TRUE; //counter
		$html .="<ol>";
        while($le = $resultLe->fetch_assoc()){
			if ($le['emphasis'] == "Speaking" && $speaking) {$html .=  "</ol><h4>Speaking</h4><ol>";$speaking=FALSE;}
			if ($le['emphasis'] == "Listening" && $listening) {$html .=  "</ol><h4>Listening</h4><ol>";$listening=FALSE;}
			if ($le['emphasis'] == "Pronunciation" && $pronunciation) {$html .=  "</ol><h4>Pronunciation</h4><ol>";$pronunciation=FALSE;}
			if ($le['emphasis'] == "Grammar" && $grammar) {$html .=  "</ol><h4>Grammar</h4><ol>";$grammar=FALSE;}
			if ($le['emphasis'] == "Reading" && $reading) {$html .=  "</ol><h4>Reading</h4><ol>";$reading=FALSE;}
			if ($le['emphasis'] == "Writing" && $writing) {$html .=  "</ol><h4>Writing</h4><ol>";$writing=FALSE;}
			if ($le['emphasis'] == "Vocabulary" && $vocabulary) {$html .=  "</ol><h4>Vocabulary</h4><ol>";$vocabulary=FALSE;}
			if ($le['emphasis'] == "None Specified" && $none) {$html .=  "</ol><h4>None Specified</h4><ol>";$none=FALSE;}
			if ($le['emphasis'] == "Listening and Reading" && $listening_and_reading) {$html .=  "</ol><h4>Listening and Reading</h4><ol>";$listening_and_reading=FALSE;}

			$le['short_description'] = strip_tags($le['short_description']); 
			$nameSplit = explode(". ", $le['name']);
			
			if (isset($nameSplit[1]))
				{
					$le['name'] = $nameSplit[1];
				} 
			$html .= "<li><a class='le_link' href='learning_experience.php?id=".$le['learning_experience_id']."'>".$le['name']."</a>. ".$le['short_description']."</li><br />";
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