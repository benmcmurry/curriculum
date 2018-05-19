<?php
session_start();
    include_once("../../connectFiles/connect_cis.php");
    include_once("cas-go.php");
    include_once("teachers.php");
?>
<!DOCTYPE html>
<html lang="">
<head>
	<title>Curriculum Portfolio - English Language Center</title>

<!-- 	Meta Information -->
	<meta charset="utf-8">
	<meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
	<meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">


<?php include_once("content/styles_and_scripts.html"); ?>
</head>
<body>
	<header>
		<?php include("content/header.php"); ?>
	</header>
	<nav>
		<?php include("content/nav-bar.php"); ?>
	</nav>
	<article>
    <div class='content-background'><div class='content'>
        <h2> Who has taught my class before? </h2>
		<?php
        $query = $evaluations_db->prepare("Select t.teacher_first_name, t.teacher_last_name, t.teacher_email_address, c.modern_level_name, c.modern_course_name, s.semester_name, s.semester_year from Teacher_Enrollments te natural join Teachers t natural join Courses c natural join Semesters s order by c.level_number, c.skill_area_code, s.semester_year, s.semester_name ASC");
        echo $evaluations_db->error;
        $query->execute();
        $results = $query->get_result();
        echo "<table class='whohas'>";
        $level = "";
        $course = "";
        $teacher_email_address = "";
        $semester_year = "";
        $semester_name = "";
        while($list = $results->fetch_assoc()){
            if ($course != $list['modern_course_name']){
                echo "</table><h3>".$list['modern_level_name']." - ".$list['modern_course_name']."</h3><table class='whohas'>";
            } 
            // if ($teacher_email_address !==$list['teacher_email_address'] && $semester_name !==$list['semester_name'] && $semester_year !== $list['semester_year']){
            echo "<tr>";
            echo "<td>".$list['teacher_first_name'];
            if (strstr($list['teacher_first_name'],'/')) {
                echo "</td>";
            } else {
                echo " ".$list['teacher_last_name']."</td>";
            }
            echo "<td>".$list['teacher_email_address']."</td>";
            echo "<td>".$list['semester_name']." ".$list['semester_year']."</td>";
            echo "<td>".$list['modern_level_name']." - ".$list['modern_course_name']."</td>";
            echo "</tr>";
       // }
            $level = $list['modern_level_name'];
            $course = $list['modern_course_name'];
            // echo $level." ".$course;
    
        }
        ?>
        </table>
        </div></div>
	</article>
	<footer>
		<?php include("content/footer.html"); ?>
	</footer>

</body>
</html>
