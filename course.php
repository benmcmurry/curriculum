<?php
session_start();
    include_once("../../connectFiles/connect_cis.php");
    $course_id = $_GET['course_id'];
    $title_query = "Select Courses.course_name, Levels.level_name from Courses inner join Levels on Courses.level_id=Levels.level_id where course_id=$course_id";
        if (!$title_query_result = $db->query($title_query)) {
            die('There was an error running the query [' . $db->error . ']');
        }
        while ($title = $title_query_result->fetch_assoc()) {
            $course_name = $title['course_name'];
            $level_name = $title['level_name'];
        }
?>
<!DOCTYPE html>
<html lang="">
<head>
	<title><?php echo $level_name." - ".$course_name; ?></title>

<!-- 	Meta Information -->
	<meta charset="utf-8">
	<meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
	<meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">


<?php include("content/styles_and_scripts.html"); ?>
</head>
<body>
	<header>
		<?php include("content/header.php"); ?>
	</header>
	<nav>
		<?php include("content/nav-bar.php"); ?>
	</nav>
	<article>
		<?php include("content/course_information.php"); ?>
		</article>
	<footer>
		<?php include("content/footer.html"); ?>
	</footer>
			<?php include("content/other.php"); ?>
</body>
</html>
