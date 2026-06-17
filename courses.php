<?php
require_once __DIR__ . '/bootstrap.php';
include_once("../../connectFiles/connect_cis.php");
include_once("auth.php");
include_once("teachers.php");
require_once __DIR__ . '/content/page_helpers.php';
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
    <?php require_once __DIR__ . "/content/shared-shell.php"; curriculum_render_site_header(); ?>

    <main class="container portfolio-main">
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

        <?php
        curriculum_render_portfolio_hero(array(
            'eyebrow' => 'Curriculum',
            'title' => 'Courses',
            'subtitle' => 'Browse courses by level, jump to a section quickly, or open an individual course page for descriptions, outcomes, and connected learning experiences.',
            'stats' => array(
                array('label' => 'Active Levels', 'value' => (string) count($levels), 'description' => 'All currently published instructional levels.'),
                array('label' => 'Course Access', 'value' => 'Grouped', 'description' => 'Each level section contains direct links to its courses.'),
            ),
        ));
        $courseJumpItems = array();
        foreach ($levels as $level) {
            $courseJumpItems[] = array(
                'label' => $level['level_name'],
                'href' => '#' . $level['level_short_name'],
            );
        }
        curriculum_render_section_jump_nav('Jump to level', $courseJumpItems, 'Course levels');
        ?>

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
                    <div class="portfolio-item-grid">
                        <?php
                        $hasCourses = false;
                        while ($course = $coursesResult->fetch_assoc()) {
                            $hasCourses = true;
                            $courseLabel = trim((string) $course['course_name']);
                            if (!empty($course['course_short_name'])) {
                                $courseLabel = trim((string) $course['course_short_name']) . ' ' . $courseLabel;
                            }
                            ?>
                            <article class="portfolio-item-card">
                                <p class="portfolio-stat-label">Course</p>
                                <h3><?php echo htmlspecialchars($courseLabel, ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="portfolio-item-meta">Open the course page for descriptions, materials, outcomes, and linked learning experiences.</p>
                                <a
                                    class="portfolio-chip-link"
                                    title="<?php echo htmlspecialchars((string) $course['course_name'], ENT_QUOTES, 'UTF-8'); ?>"
                                    href="course.php?course_id=<?php echo urlencode((string) $course['course_id']); ?>"
                                >
                                    View Course
                                </a>
                            </article>
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

    <?php curriculum_render_footer(); ?>
</body>
</html>
