<?php
session_start();
    include_once("../../connectFiles/connect_cis.php");
    $learningExperienceId = $_GET['id'];
    $query = $elc_db->prepare("Select * from Learning_experiences where learning_experience_id= ?");
    $query->bind_param('s', $learningExperienceId);
    $query->execute();
    $result = $query->get_result();

        while ($learningExperience = $result->fetch_assoc()) {
            $le_name = $learningExperience['name'];
            $short_description = $learningExperience['short_description'];
            $description = $learningExperience['description'];
        }
        include_once("cas-go.php");
        include_once("teachers.php");
?>
<!DOCTYPE html>
<html lang="">
<head>
	<title><?php echo $le_name; ?></title>

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
    <div class='main'><div class='content-background'><div class='content'>
        <?php
        echo "<h2>$le_name</h2>";
        echo $short_description;
        echo $description;
        echo "<h3>Connected Courses</h3><div class='course_list'>";
        $query = $elc_db->prepare("Select 
        LE_courses.course_id,
        Courses.course_name, 
        Courses.course_short_name,
        Levels.level_id, 
        Levels.level_short_name,
        LE_courses.id 
    from LE_courses 
    natural join 
        Courses 
    natural join 
        Levels
    where learning_experience_id=?");
        $query->bind_param("s", $learningExperienceId);
        $query->execute();
        $result = $query->get_result();
        $courses = array();
        while ($selectedCourse = $result->fetch_assoc()) {
            $courseName = $selectedCourse['course_name'];
            $courseShortName = $selectedCourse['course_short_name'];
            $levelShortName = $selectedCourse['level_short_name'];
            $courseId = $selectedCourse['course_id'];
            echo "<a class='courses' style='min-width:75px;' title='$levelShortName $courseName' class='course_icon' id='$courseId' href='course.php?course_id=$courseId'>$levelShortName $courseShortName</a>";
            array_push($courses,$selectedCourse['course_id']);
        }
    
    

        ?>
        </div></div></div></div>
		</article>
	<footer>
		<?php include("content/footer.html"); ?>
	</footer>

</body>
</html>
