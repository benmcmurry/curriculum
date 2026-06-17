<?php
require_once __DIR__ . '/bootstrap.php';
include_once("../../connectFiles/connect_cis.php");
if (isset($_GET['id'])) {$learningExperienceId = $_GET['id'];} else {header("Location: index.php");}
$le_name = 'Learning Experience';
$short_description = '';
$description = '';
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
include_once("auth.php");
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
    
        <?php require_once __DIR__ . "/content/shared-shell.php"; curriculum_render_site_header(); ?>

        <main class="container portfolio-main">
            <section class="hero-card portfolio-hero content-card-spotlight">
                <p class="portfolio-eyebrow">Learning Experience</p>
                <h1 class="portfolio-title"><?php echo htmlspecialchars($le_name, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="portfolio-subtitle">Review the activity overview and see which courses currently connect to this learning experience.</p>
                <div class="portfolio-chip-group mt-4">
                    <?php if ($backCourseId !== null) { ?>
                    <a class="portfolio-chip-link" href="course.php?course_id=<?php echo $backCourseId; ?>">
                        Back to <?php echo htmlspecialchars($backCourseName); ?>
                    </a>
                    <?php } ?>
                    <?php if ($backLevelShortName !== null) { ?>
                    <a class="portfolio-chip-link" href="levels.php#<?php echo htmlspecialchars($backLevelShortName); ?>">
                        Back to <?php echo htmlspecialchars($backLevelName); ?>
                    </a>
                    <?php } ?>
                </div>
            </section>

            <?php if ($backCourseId !== null || $backLevelShortName !== null) { ?>
            <section class="content-card content-card-compact content-card-nav mb-4">
                <nav class="section-jump-nav" aria-label="Learning experience navigation">
                    <p class="section-jump-label">Quick links</p>
                    <ul>
                        <?php if ($backCourseId !== null) { ?>
                        <li><a href="course.php?course_id=<?php echo $backCourseId; ?>">Back to <?php echo htmlspecialchars($backCourseName); ?></a></li>
                        <?php } ?>
                        <?php if ($backLevelShortName !== null) { ?>
                        <li><a href="levels.php#<?php echo htmlspecialchars($backLevelShortName); ?>">Back to <?php echo htmlspecialchars($backLevelName); ?></a></li>
                        <?php } ?>
                    </ul>
                </nav>
            </section>
            <?php } ?>

            <section class="portfolio-card mb-4">
                <div class="portfolio-card-header-course">
                    <h2 class="h4 mb-0">Learning Experience Overview</h2>
                </div>
                <div class="portfolio-card-body portfolio-rich-text">
                    <?php echo $description; ?>
                </div>
            </section>

            <section class="portfolio-card mb-4">
                <div class="portfolio-card-header-course">
                    <h2 class="h5 mb-0">Connected Courses</h2>
                </div>
                <div class="portfolio-card-body">
                    <div class="portfolio-item-grid">
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
                        echo "<article class='portfolio-item-card'>";
                        echo "<p class='portfolio-stat-label'>Connected Course</p>";
                        echo "<h3>" . htmlspecialchars($levelShortName . " " . $courseName, ENT_QUOTES, 'UTF-8') . "</h3>";
                        echo "<p class='portfolio-item-meta'>Open the course page to see where this learning experience fits into the broader sequence.</p>";
                        echo "<a class='portfolio-chip-link' title='" . htmlspecialchars($levelShortName . " " . $courseName, ENT_QUOTES, 'UTF-8') . "' id='" . (int) $courseId . "' href='course.php?course_id=$courseId'>View Course</a>";
                        echo "</article>";
                    }
                    ?>
                    </div>
                </div>
            </section>
        </main>

    <?php curriculum_render_footer(); ?>
</body>
</html>
