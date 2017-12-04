<?php

$current_page = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

	

	<!-- <div id="nav-bar"> -->

		<a href="index.php">Mission</a>
		<div id="nav-container">	
		<a href="levels.php">Level Descriptors</a>
		<div>
			<?php
			$query = $elc_db->prepare("Select  level_name, level_id from Levels order by level_order ASC");
			$query->execute();
			$result = $query->get_result();
	while ($levels = $result->fetch_assoc()) {
		echo "<a href='levels.php?level_id=".$levels['level_id']."'>".$levels['level_name']."</a>";
	}
	?>
		</div>
		<a href="courses.php">Courses</a></h3>
		<div><p>C</p></div>
		<a href="profile.php">Profile </a>
		<div><p>D</p></div>
	<!-- </div> -->
</div>
