<?php
include_once("../CASauthinator.php");
include_once("../../../connectFiles/connect_cis.php");
$net_id = Authenticator::getUser();
?>

<!DOCTYPE html>
<html lang="">
<head>
	<title>Curriculum Editor</title>

<!-- 	Meta Information -->
	<meta charset="utf-8">
	<meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
	<meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">


<?php include("styles_and_scripts.html"); ?>

<!-- 	Javascript -->
	<script>
	$(document).ready(function() {



});


</script>
</head>
<body>
	<header>
			<h1>Curriculum Editor</h1>
			<div id="user"><?php echo $net_id; ?></div>
			<a class="button" id="go_back" href="https://elc.byu.edu/curriculum/">View the Curriculum Portfolio</a>
				</header>
<article>
			<hr />
			<div class="main">
			<h2> Levels and Courses </h2>
			<?php
                $query = "Select Levels.level_id, Levels.level_name from Levels order by level_order ASC";
        if (!$result = $db->query($query)) {
            die('There was an error running the query [' . $db->error . ']');
        }
        while ($levels = $result->fetch_assoc()) {
            echo "<div class='course_list'>";
            echo "<h2><a href='level-edit.php?level_id=".$levels['level_id']."'>".$levels['level_name']."</a></h2>";
            $course_query = "Select Courses.course_id, Courses.course_name, Courses.level_id from Courses where Courses.level_id=".$levels['level_id']." order by course_order ASC";
            if (!$course_result = $db->query($course_query)) {
                die('There was an error running the query [' . $db->error . ']');
            }

            while ($courses = $course_result->fetch_assoc()) {
                echo "<a class='course-icon ".$courses['course_id']."' href='course-edit.php?course_id=".$courses['course_id']."'>".$courses['course_name']."</a>";
            }
            echo "</div>";
        }
        $result->free();

if ($net_id == "blm39") {
    ?>
		<h2> Review Submitted Changes </h2>
		<?php



		$review_query = "Select * from Courses_review where needs_review = 1";
  	if (!$review_query_results = $db->query($review_query)) {
    	die('There was an error running the query [' . $db->error . ']');
  	}
  	while ($Courses_review = $review_query_results->fetch_assoc()) {
      echo "<a href='review-edits.php?course_id=".$Courses_review['course_id']."'>".$Courses_review['course_name']."</a><br />";
  	}

		$review_level_query = "Select * from Levels_review where needs_review = 1";
  	if (!$review_level_query_results = $db->query($review_level_query)) {
    	die('There was an error running the query [' . $db->error . ']');
  	}
  	while ($Level_review = $review_level_query_results->fetch_assoc()) {
      echo "<a href='review-level-edits.php?level_id=".$Level_review['level_id']."'>".$Level_review['level_name']."</a><br />";
  	}

}

?>
			</div>
	<hr />

	</article>
</body>
</html>
