<div class="main">

	<?php

$i=0;
		$query = $elc_db->prepare("Select Levels.level_id, Levels.level_name from Levels order by level_order ASC");
		$query->execute();
		$result = $query->get_result();
		//echo "<div style='text-align:center' class='content'>";
		while($levels = $result->fetch_assoc()){
			echo "<div class='content-background'><div class='content'>";

			echo "<h1>".$levels['level_name']."</h1>";
			echo "<div class='course_list'>";
				$course_query = $elc_db->prepare("Select Courses.course_id, Courses.course_name, Courses.level_id, Courses.course_short_name from Courses where Courses.level_id = ? order by course_order ASC");
				$course_query->bind_param('s', $levels['level_id']);
				$course_query->execute();
				$course_result=$course_query->get_result();
				

			while($courses = $course_result->fetch_assoc()){

				$courses['course_name'] = str_replace('Fluency', '', $courses['course_name']);
				
				echo "<a title='".$courses['course_name']."' class='course_icon' href='course.php?course_id=".$courses['course_id']."'><span align='center'>".$courses['course_name']."</a>";






			}
			echo "</div>";
		echo "</div></div>";
		}
		$result->free();
?>
</div>
