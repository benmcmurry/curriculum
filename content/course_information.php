<?php
// $correct = $_GET['correct'];

?>

<?php
	echo "<div class='main'><div class='content-background'><div class='content'>";
	echo "<a id='editorPopup' href='editors/course-edit.php?course_id=$course_id'>Edit</a>";
	$query = $elc_db->prepare("Select *, Levels.level_name, Skill_areas.skill_area_philosophy from Courses inner join Levels on Courses.level_id=Levels.level_id inner join Skill_areas on Courses.skill_area=Skill_areas.id where course_id=?");
	$query->bind_param('s', $course_id);
	$query->execute();
	$result = $query->get_result();
	$course = $result->fetch_assoc();
	
echo "<a class='pdf_icon' title='Save Course information' href='print_pdf_course.php?print_id=".$course['course_id']."'></a>";
echo "<h1>".$course['level_name']." - ".$course['course_name']."</h1><br />";


echo "<h3 class='course_data'>Skill Area Philosophy</h3>";
echo "<p>".$course['skill_area_philosophy']."</p>";


		echo "<h3 class='course_data'>Course Description</h3>";
		echo "<p>".$course['course_description']."</p>";

		echo "<h3 class='course_data'>Course Emphasis</h3>";
		echo "<p>".$course['course_emphasis']."</p>";

		echo "<h3 class='course_data'>Course Books and Materials</h3>";
		echo "<p>".$course['course_materials']."</p>";


		echo "<h3 class='course_data'>Course Learning Outcomes</h3>";
		echo $course['learning_outcomes'];

	
		echo "<h3 class='course_data'>Assessments and Learning Experiences</h3>";
		// Get learning experiences
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
		// echo "<ol>";
		while($le = $resultLe->fetch_assoc()){
			if ($le['emphasis'] == "Speaking" && $speaking) {echo "</ol><h4>Speaking</h4><ol>";$speaking=FALSE;}
			if ($le['emphasis'] == "Listening" && $listening) {echo "</ol><h4>Listening</h4><ol>";$listening=FALSE;}
			if ($le['emphasis'] == "Pronunciation" && $pronunciation) {echo "</ol><h4>Pronunciation</h4><ol>";$pronunciation=FALSE;}
			if ($le['emphasis'] == "Grammar" && $grammar) {echo "</ol><h4>Grammar</h4><ol>";$grammar=FALSE;}
			if ($le['emphasis'] == "Reading" && $reading) {echo "</ol><h4>Reading</h4><ol>";$reading=FALSE;}
			if ($le['emphasis'] == "Writing" && $writing) {echo "</ol><h4>Writing</h4><ol>";$writing=FALSE;}
			if ($le['emphasis'] == "Vocabulary" && $vocabulary) {echo "</ol><h4>Vocabulary</h4><ol>";$vocabulary=FALSE;}
			if ($le['emphasis'] == "None Specified" && $none) {echo "</ol><h4>None Specified</h4><ol>";$none=FALSE;}

			// if ($le['assessment'] == 1 && $le['required'] == 0 && $anr) {echo "</ol><h4>Optional Assessments</h4><ol>";$anr=FALSE;}
			// if ($le['assessment'] == 0 && $le['required'] == 1 && $ler) {echo "</ol><h4>Required Learning Experiences</h4><ol>";$ler=FALSE;}
			// if ($le['assessment'] == 0 && $le['required'] == 0 && $lenr) {echo "</ol><h4>Optional Learning Experiences</h4><ol>";$lenr=FALSE;}
			
			$le['short_description'] = $le['short_description'];
			echo "<p><a class='le_link' href='learning_experience.php?id=".$le['learning_experience_id']."'>".$le['name']."</a>. ".$le['short_description']."</p><br />";
		}
		// echo "</ol>";
		// end getting learning Experiences

		if ($auth && $access){
		echo "<h3 class='course_data'>Teacher Resources</h3>";
		echo "<p>".$course['teacher_resources']."</p>";
		echo "<iframe class='google_folder' src='https://drive.google.com/embeddedfolderview?id=".$course['google_drive_folder_id']."#list' width='100%' height='500px' frameborder='0'></iframe>";
		}
		else {echo "Teachers can login to see additional resources.";}

	echo "</div></div></div>";
 ?>
 
