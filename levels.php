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


<?php include("content/styles_and_scripts.html"); ?>
</head>
<body>


		<?php include("content/header.php"); ?>


		<div id="title" class="container-fluid">
	Level Descriptors
</div>
<div class="container-md pt-4">
	<p>This document describes the language ability of our students according to proficiency level and skill area. As we
		continue to revise and improve our existing curriculum, these descriptors will serve as a guide to
		administrators, teachers, and students. Objectives will aim toward helping students reach these proficiency
		descriptors.</p>
	<p>The two proficiency levels next to each ELC level name roughly correspond to ACTFL proficiency levels. The first
		label is the entry point for students in that level and the second label is for students exiting that level. For
		example, students entering Academic B will be at the Advanced Low proficiency level. Students who successfully
		complete Academic B are at the Advanced Mid proficiency level. The descriptors describe what language functions
		students who are exiting the level are capable of performing.
	<p>
	<p>Each skill area is divided into three groups—function, text, and fluency/comprehensibility:</p>
	<ul>
		<li>Function refers to what a student can do. </li>
		<li>For receptive skills, text refers to the language samples students listen to or read. For productive skills,
			text refers to the language produced by the learner.  </li>
		<li>Fluency applies to receptive skills and includes information regarding comprehension levels and rate. </li>
		<li>Comprehensibility is used in productive skills to indicate to which degree the students’ language is
			understood in the presence of errors.</li>
	</ul>
	<p>Another important aspect of these descriptors is the adverbs of frequency that are used to mark difference in
		ability among various levels. Rarely, usually, often, sometimes, frequently and other similar words are used
		throughout the document to discriminate among proficiency levels. </p>

</div>
<div class="container-md pt-4">
	<?php
        $query = $elc_db->prepare("Select * from Levels where active=1 order by level_order ASC");
				$query->execute();
				$result = $query->get_result();
        while ($levels = $result->fetch_assoc()) {
            echo "<a class='anchor' id='".$levels['level_short_name']."'></a>";
						// echo "<a class='pdf_icon' target='_new' title='Save PDF' href='print_pdf.php?print_id=".$levels['level_id']."'></a>";

            echo "<h2>".$levels['level_name']."</h2>";





            echo $levels['level_descriptor'];
            echo "<h3>Courses</h3>";
                echo "<div class='course_list container'>";
                $course_query = $elc_db->prepare("Select * from Courses where level_id = ? order by course_order");
								$course_query->bind_param("s",$levels['level_id']);
								$course_query->execute();
            		$courses_result = $course_query->get_result();
					
            while ($courses = $courses_result->fetch_assoc()) {
				echo "<a class='courses m-1 btn btn-primary' role='button' data-shortName='".$courses['course_short_name']."' data-name='".$courses['course_name']."' title='".$courses['course_name']."' href='course.php?course_id=".$courses['course_id']."'>".$courses['course_name']."</a>";
            }
                
			echo "</div>";
        }
            echo "</div>";
        $result->free();

?>
</div>
	
	<footer>
		<?php include("content/footer.html"); ?>
	</footer>

</body>
</html>
