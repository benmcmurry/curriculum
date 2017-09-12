<?php
// $correct = $_GET['correct'];

?>

<?php
	echo "<div class='main'><div class='content-background'><div class='content'>";
	$query = $db->prepare("Select *, Levels.level_name from Courses inner join Levels on Courses.level_id=Levels.level_id where course_id=?");
	$query->bind_param('s', $course_id);
	$query->execute();
	$result = $query->get_result();
	while($course = $result->fetch_assoc()){
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

		if(isset($_SESSION['password'])){
		echo "<h3 class='course_data'>Teacher Resources</h3>";
		echo "<p>".$course['teacher_resources']."</p>";
		echo "<iframe class='google_folder' src='https://drive.google.com/embeddedfolderview?id=".$course['google_drive_folder_id']."#list' width='100%' height='500px' frameborder='0'></iframe>";
		}
		else {echo "<h1><a id='login-link'>Login</a> to see additional resources available to teachers.</h1>";}
		}
	echo "</div></div></div>";
 ?>
