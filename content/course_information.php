<?php
// $correct = $_GET['correct'];

?>

<?php
	echo "<div class='main'><div class='content-background'><div class='content'>";
	$query = $elc_db->prepare("Select *, Levels.level_name from Courses inner join Levels on Courses.level_id=Levels.level_id where course_id=?");
	$query->bind_param('s', $course_id);
	$query->execute();
	$result = $query->get_result();
	$course = $result->fetch_assoc();
	
echo "<a class='pdf_icon' title='Save Course information' href='print_pdf_course.php?print_id=".$course['course_id']."'></a>";
echo "<h1>".$course['level_name']." - ".$course['course_name']."</h1><br />";





		echo "<h3 class='course_data'>Course Description</h3>";
		echo "<p>".$course['course_description']."</p>";

		echo "<h3 class='course_data'>Course Emphasis</h3>";
		echo "<p>".$course['course_emphasis']."</p>";

		echo "<h3 class='course_data'>Course Books and Materials</h3>";
		echo "<p>".$course['course_materials']."</p>";


		echo "<h3 class='course_data'>Course Learning Outcomes</h3>";
		echo $course['learning_outcomes'];

		echo "<h3 class='course_data'>Course Assessment</h3>";
		echo $course['assessment'];

		echo "<h3 class='course_data'>Course Learning Experiences</h3>";
		echo $course['learning_experiences'];

		// Get required learning experiences
		$queryRequiredLearningExperiences = $elc_db->prepare("select *, Learning_experiences.name, Learning_experiences.learning_experience_id 
		from `LE_Courses`
				natural left join
					Learning_experiences 
				where LE_Courses.course_id=? order by Learning_experiences.assessment DESC, Learning_experiences.required DESC");
		$queryRequiredLearningExperiences->bind_param('s', $course['course_id']);
		$queryRequiredLearningExperiences->execute();
		$resultLe = $queryRequiredLearningExperiences->get_result();
		while($le = $resultLe->fetch_assoc()){
			echo "<a href='learning_experience.php?id=".$le['id']."'>".$le['name']."</a><br />";
		}
		// end getting Required learning Experiences

		if ($auth && $access){
		echo "<h3 class='course_data'>Teacher Resources</h3>";
		echo "<p>".$course['teacher_resources']."</p>";
		echo "<iframe class='google_folder' src='https://drive.google.com/embeddedfolderview?id=".$course['google_drive_folder_id']."#list' width='100%' height='500px' frameborder='0'></iframe>";
		}
		else {echo "Teachers can login to see additional resources.";}

	echo "</div></div></div>";
 ?>
