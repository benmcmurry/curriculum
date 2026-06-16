<?php
require_once __DIR__ . '/bootstrap.php';
include_once("../../connectFiles/connect_cis.php");
include_once("auth.php");
include_once("teachers.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Curriculum Courses - English Language Center</title>

    <meta charset="utf-8">
    <meta name="description" content="Browse curriculum courses by level for the English Language Center." />
    <meta name="keywords" content="ELC, BYU, ESL, Curriculum, Courses, Levels, Learning, Outcomes" />
    <meta name="robots" content="ELC, BYU, ESL, Curriculum, Courses, Levels, Learning, Outcomes" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include("content/styles_and_scripts.html"); ?>
</head>
<body>
    <?php include("content/header.php"); ?>

    <div id="title" class="container-fluid">
        Courses
    </div>

    <main class="container-md portfolio-main">
        <?php
        $levelsQuery = $elc_db->prepare("SELECT level_id, level_name, level_short_name FROM Levels WHERE active = 1 ORDER BY level_order ASC");
        $levelsQuery->execute();
        $levelsResult = $levelsQuery->get_result();
        $levels = array();
        while ($level = $levelsResult->fetch_assoc()) {
            $levels[] = $level;
        }
        $levelsResult->free();
        ?>

        <section class="portfolio-card mb-4">
            <div class="portfolio-card-header-course">
                <h2 class="h4 mb-0">Browse Courses by Level</h2>
            </div>
            <div class="portfolio-card-body">
                <p>Choose a level to jump to its courses, or open any course directly from the grouped lists below.</p>
                <div class="portfolio-course-links">
                    <?php foreach ($levels as $level) { ?>
                        <a
                            class="btn btn-outline-primary btn-sm"
                            href="#<?php echo htmlspecialchars($level['level_short_name'], ENT_QUOTES, 'UTF-8'); ?>"
                        >
                            <?php echo htmlspecialchars($level['level_name'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </section>

        <?php
        $coursesQuery = $elc_db->prepare("SELECT course_id, course_name, course_short_name FROM Courses WHERE level_id = ? ORDER BY course_order ASC");
        foreach ($levels as $level) {
            $levelId = (string) $level['level_id'];
            $coursesQuery->bind_param('s', $levelId);
            $coursesQuery->execute();
            $coursesResult = $coursesQuery->get_result();
            ?>
            <a class="anchor" id="<?php echo htmlspecialchars($level['level_short_name'], ENT_QUOTES, 'UTF-8'); ?>"></a>
            <section class="portfolio-card mb-4">
                <div class="portfolio-card-header-level">
                    <h2 class="h4 mb-0"><?php echo htmlspecialchars($level['level_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                </div>
                <div class="portfolio-card-body">
                    <div class="portfolio-course-links">
                        <?php
                        $hasCourses = false;
                        while ($course = $coursesResult->fetch_assoc()) {
                            $hasCourses = true;
                            $courseLabel = trim((string) $course['course_name']);
                            if (!empty($course['course_short_name'])) {
                                $courseLabel = trim((string) $course['course_short_name']) . ' ' . $courseLabel;
                            }
                            ?>
                            <a
                                class="courses btn btn-outline-primary btn-sm"
                                role="button"
                                title="<?php echo htmlspecialchars((string) $course['course_name'], ENT_QUOTES, 'UTF-8'); ?>"
                                href="course.php?course_id=<?php echo urlencode((string) $course['course_id']); ?>"
                            >
                                <?php echo htmlspecialchars($courseLabel, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        <?php } ?>
                        <?php if (!$hasCourses) { ?>
                            <p class="mb-0">No courses are currently listed for this level.</p>
                        <?php } ?>
                    </div>
                </div>
            </section>
            <?php
            $coursesResult->free();
        }
        ?>
    </main>

    <footer>
        <?php include("content/footer.html"); ?>
    </footer>
</body>
</html>
