<?php
session_start();
    include_once("../../connectFiles/connect_cis.php");
    if (isset($_GET['id'])) {$learningExperienceId = $_GET['id'];} else {header("Location: index.php");}
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

<!--    Meta Information -->
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
            <?php echo $le_name."</div><div class='container-md pt-4'>";
            
            echo $description;
            echo "<h3>Connected Courses</h3>";
            $query = $elc_db->prepare("Select LE_courses.course_id, Courses.course_name, Courses.course_short_name, Levels.level_id, Levels.level_short_name, LE_courses.id 
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
                echo "<a class='courses m-1 btn btn-primary' title='$levelShortName $courseName' id='$courseId' href='course.php?course_id=$courseId'>$levelShortName $courseName</a>";
                array_push($courses, $selectedCourse['course_id']);
            }
    
    

            ?>
        </div></div></div></div>
    </div>
    <footer>
        <?php include("content/footer.html"); ?>
    </footer>
    <div id="faded-background"></div>


</body>
</html>
