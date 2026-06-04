<?php
require_once __DIR__ . '/bootstrap.php';
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

$backCourseId = null;
$backCourseName = null;
$backLevelShortName = null;
$backLevelName = null;
$backQuery = $elc_db->prepare("Select Courses.course_id, Courses.course_name, Levels.level_name, Levels.level_short_name
    from LE_courses
    inner join Courses on LE_courses.course_id = Courses.course_id
    inner join Levels on Courses.level_id = Levels.level_id
    where LE_courses.learning_experience_id = ?
    order by Levels.level_order ASC, Courses.course_order ASC
    limit 1");
$backQuery->bind_param('s', $learningExperienceId);
$backQuery->execute();
$backResult = $backQuery->get_result();
if ($backRow = $backResult->fetch_assoc()) {
    $backCourseId = (int) $backRow['course_id'];
    $backCourseName = $backRow['course_name'];
    $backLevelName = $backRow['level_name'];
    $backLevelShortName = $backRow['level_short_name'];
}
include_once("cas-go.php");
include_once("teachers.php");
?>
<!DOCTYPE html>
<html lang="en">
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

        <div id="title" class="container-fluid"><?php echo $le_name; ?></div>
        <main class="container-md portfolio-main">
            <?php if ($backCourseId !== null || $backLevelShortName !== null) { ?>
            <section class="portfolio-card mb-4">
                <div class="portfolio-card-body">
                    <div class="portfolio-course-links">
                        <?php if ($backCourseId !== null) { ?>
                        <a class="btn btn-outline-primary btn-sm" href="course.php?course_id=<?php echo $backCourseId; ?>">
                            <i class="bi bi-arrow-left"></i> Back to <?php echo htmlspecialchars($backCourseName); ?>
                        </a>
                        <?php } ?>
                        <?php if ($backLevelShortName !== null) { ?>
                        <a class="btn btn-outline-primary btn-sm" href="levels.php#<?php echo htmlspecialchars($backLevelShortName); ?>">
                            <i class="bi bi-arrow-left-circle"></i> Back to <?php echo htmlspecialchars($backLevelName); ?>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </section>
            <?php } ?>

            <section class="portfolio-card mb-4">
                <div class="portfolio-card-header-course">
                    <h2 class="h4 mb-0">Learning Experience Overview</h2>
                </div>
                <div class="portfolio-card-body">
                    <?php echo $description; ?>
                </div>
            </section>

            <section class="portfolio-card mb-4">
                <div class="portfolio-card-header-course">
                    <h2 class="h5 mb-0">Connected Courses</h2>
                </div>
                <div class="portfolio-card-body">
                    <div class="portfolio-course-links">
                    <?php
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
                    while ($selectedCourse = $result->fetch_assoc()) {
                        $courseName = $selectedCourse['course_name'];
                        $levelShortName = $selectedCourse['level_short_name'];
                        $courseId = $selectedCourse['course_id'];
                        echo "<a class='courses btn btn-outline-primary btn-sm' title='$levelShortName $courseName' id='$courseId' href='course.php?course_id=$courseId'>$levelShortName $courseName</a>";
                    }
                    ?>
                    </div>
                </div>
            </section>
        </main>

    <footer>
        <?php include("content/footer.html"); ?>
    </footer>
</body>
</html>
