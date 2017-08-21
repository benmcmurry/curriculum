<div class="main">

	<div id="introduction" class="content-background">
		<div class="content">

		<h1>Level Descriptors</h1>
		<p>This document describes the language ability of our students according to proficiency level and skill area. As we continue to revise and improve our existing curriculum, these descriptors will serve as a guide to administrators, teachers, and students. Objectives will aim toward helping students reach these proficiency descriptors.</p>
		<p>The two proficiency levels next to each ELC level name roughly correspond to ACTFL proficiency levels. The first label is the entry point for students in that level and the second label is for students exiting that level. For example, students entering Academic B will be at the Advanced Low proficiency level. Students who successfully complete Academic B are at the Advanced Mid proficiency level. The descriptors describe what language functions students who are exiting the level are capable of performing.<p>
		<p>Each skill area is divided into three groups—function, text, and fluency/comprehensibility:</p>
		<ul>
			<li>Function refers to what a student can do. </li>
			<li>For receptive skills, text refers to the language samples students listen to or read. For productive skills, text refers to the language produced by the learner.  </li>
			<li>Fluency applies to receptive skills and includes information regarding comprehension levels and rate. </li>
			<li>Comprehensibility is used in productive skills to indicate to which degree the students’ language is understood in the presence of errors.</li>
		</ul>
		<p>Another important aspect of these descriptors is the adverbs of frequency that are used to mark difference in ability among various levels. Rarely, usually, often, sometimes, frequently and other similar words are used throughout the document to discriminate among proficiency levels. </p>

	</div>
		</div>
	<?php
        $query = $db->prepare("Select * from Levels order by level_order ASC");
				$query->execute();
				$result = $query->get_result();
        while ($levels = $result->fetch_assoc()) {
            echo "<div class='content-background' id='".$levels['level_short_name']."'><div class='content'>";
						echo "<a class='pdf_icon' target='_new' title='Save PDF' href='print_pdf.php?print_id=".$levels['level_id']."'></a>";

            echo "<h1>".$levels['level_name']."</h1>";





            echo $levels['level_descriptor'];
            echo "<h3>Courses</h3>";
                echo "<div class='course_list'>";
                $course_query = $db->prepare("Select * from Courses where level_id = ? order by course_order");
								$course_query->bind_param("s",$levels['level_id']);
								$course_query->execute();
            		$courses_result = $course_query->get_result();
            while ($courses = $courses_result->fetch_assoc()) {
                echo "<a class='course_icon' style='margin-left:8px' href='course.php?course_id=".$courses['course_id']."'>".$courses['course_name']."</a> ";
            }
                echo "</div>";
            echo "</div></div>";
        }
            echo "</div>";
        $result->free();

?>
