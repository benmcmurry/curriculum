<?php
require_once __DIR__ . '/bootstrap.php';
include_once("../../connectFiles/connect_cis.php");
if (isset($_GET['course_id'])) {$course_id = $_GET['course_id'];} else {header("Location: index.php");}
$title_query = $elc_db->prepare("Select Courses.course_name, Levels.level_name from Courses inner join Levels on Courses.level_id=Levels.level_id where course_id= ?");
$title_query->bind_param('s', $course_id);
$title_query->execute();
$result = $title_query->get_result();

while ($title = $result->fetch_assoc()) {
    $course_name = $title['course_name'];
    $level_name = $title['level_name'];
}
include_once("auth.php");
require_once("teachers.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $level_name." - ".$course_name; ?></title>

<!--     Meta Information -->
    <meta charset="utf-8">
    <meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
    <meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="viewport" content="width=device-width, initial-scale=1">


<?php include("content/styles_and_scripts.html"); ?>
</head>
<body>
    <?php require_once __DIR__ . "/content/shared-shell.php"; curriculum_render_site_header(); ?>

    <?php
    $query = $elc_db->prepare("Select *, Levels.level_name, Skill_areas.skill_area_philosophy from Courses inner join Levels on Courses.level_id=Levels.level_id inner join Skill_areas on Courses.skill_area=Skill_areas.id where course_id=?");
    $query->bind_param('s', $course_id);
    $query->execute();
    $result = $query->get_result();
    $course = $result->fetch_assoc();
    ?>

    <main class="container portfolio-main">
        <section class="hero-card portfolio-hero content-card-spotlight">
            <p class="portfolio-eyebrow"><?php echo htmlspecialchars($course['level_name'], ENT_QUOTES, 'UTF-8'); ?></p>
            <h1 class="portfolio-title"><?php echo htmlspecialchars($course['course_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <p class="portfolio-subtitle">Review the course description, emphasis, materials, learning outcomes, and connected learning experiences for this part of the curriculum.</p>
            <div class="portfolio-chip-group mt-4">
                <a class="portfolio-chip-link" href="courses.php">All Courses</a>
                <a class="portfolio-chip-link" href="levels.php#<?php echo htmlspecialchars((string) $course['level_short_name'], ENT_QUOTES, 'UTF-8'); ?>">Back to Level</a>
                <?php if ($auth && $teacher_access > 0) { ?>
                    <a class="portfolio-chip-link" href="https://byu.box.com/s/3sp7037dloc3ponmddtxk9hhd42po6wb">Teacher Resources</a>
                <?php } ?>
            </div>
        </section>

        <section class="content-card content-card-compact content-card-nav mb-4">
            <nav class="section-jump-nav" aria-label="Course sections">
                <p class="section-jump-label">On this page</p>
                <ul>
                    <li><a href="#course-overview">Overview</a></li>
                    <?php if ($course['active'] == 1) { ?>
                        <li><a href="#course-outcomes">Learning Outcomes</a></li>
                        <li><a href="#course-experiences">Assessments and Learning Experiences</a></li>
                        <li><a href="#course-resources">Teacher Resources</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </section>

        <section class="portfolio-card mb-4" id="course-overview">
            <div class="portfolio-card-header-course d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">Course Overview</h2>
            </div>
            <div class="portfolio-card-body">
                <?php if ($course['active'] == 0) { ?>
                    <div class="alert alert-warning mb-4" role="alert">This course is currently inactive.</div>
                <?php } ?>
                <div class="portfolio-kv">
                    <article class="portfolio-kv-card">
                        <dt>Level</dt>
                        <dd><?php echo htmlspecialchars($course['level_name'], ENT_QUOTES, 'UTF-8'); ?></dd>
                    </article>
                    <article class="portfolio-kv-card">
                        <dt>Course Code</dt>
                        <dd><?php echo htmlspecialchars((string) $course['course_short_name'], ENT_QUOTES, 'UTF-8'); ?></dd>
                    </article>
                    <article class="portfolio-kv-card">
                        <dt>Status</dt>
                        <dd><?php echo $course['active'] == 1 ? 'Active' : 'Inactive'; ?></dd>
                    </article>
                </div>

                <h3 class="h6 mt-4 mb-2">Course Description</h3>
                <p><?php echo $course['course_description']; ?></p>

                <h3 class="h6 mb-2">Course Emphasis</h3>
                <p><?php echo $course['course_emphasis']; ?></p>

                <h3 class="h6 mb-2">Course Books and Materials</h3>
                <p><?php echo $course['course_materials']; ?></p>
            </div>
        </section>

        <?php if ($course['active'] == 1) { ?>
        <section class="portfolio-card mb-4" id="course-outcomes">
            <div class="portfolio-card-header-course">
                <h2 class="h5 mb-0">Course Learning Outcomes</h2>
            </div>
            <div class="portfolio-card-body portfolio-rich-text">
                <?php echo $course['learning_outcomes']; ?>
            </div>
        </section>

        <section class="portfolio-card mb-4" id="course-experiences">
            <div class="portfolio-card-header-course">
                <h2 class="h5 mb-0">Assessments and Learning Experiences</h2>
            </div>
            <div class="portfolio-card-body">
                <?php
                $queryRequiredLearningExperiences = $elc_db->prepare(
                    "select *, Learning_experiences.name, Learning_experiences.learning_experience_id 
                    from `LE_courses`
                        natural left join
                            Learning_experiences 
                    where LE_courses.course_id=? order by emphasis, Learning_experiences.name ASC"
                );
                $queryRequiredLearningExperiences->bind_param('s', $course['course_id']);
                $queryRequiredLearningExperiences->execute();
                $resultLe = $queryRequiredLearningExperiences->get_result();
                $hasLearningExperiences = false;
                $currentEmphasis = null;
                while($le = $resultLe->fetch_assoc()){
                    $hasLearningExperiences = true;
                    if ($currentEmphasis !== $le['emphasis']) {
                        if ($currentEmphasis !== null) {
                            echo "</ul></div>";
                        }
                        $currentEmphasis = $le['emphasis'];
                        echo "<div class='portfolio-emphasis-group'><h3>" . htmlspecialchars($currentEmphasis, ENT_QUOTES, 'UTF-8') . "</h3><ul class='portfolio-list-clean'>";
                    }

                    $le['short_description'] = strip_tags($le['short_description']);
                    $nameSplit = explode(". ", $le['name']);
                    if (isset($nameSplit[1])) {
                        $le['name'] = $nameSplit[1];
                    }
                    echo "<li><a class='le_link' href='learning_experience.php?id=".$le['learning_experience_id']."'>".$le['name']."</a>. ".$le['short_description']."</li>";
                }
                if ($hasLearningExperiences) {
                    echo "</ul></div>";
                } else {
                    echo "<p class='mb-0'>No learning experiences are currently connected to this course.</p>";
                }
                ?>
            </div>
        </section>

        <section class="portfolio-card mb-4" id="course-resources">
            <div class="portfolio-card-header-course">
                <h2 class="h5 mb-0">Teacher Resources</h2>
            </div>
            <div class="portfolio-card-body">
                <?php if ($auth && $teacher_access > 0) { ?>
                    <a type="button" class="btn btn-outline-primary" href="https://byu.box.com/s/3sp7037dloc3ponmddtxk9hhd42po6wb">Box Resources</a>
                <?php } else { ?>
                    <p class="mb-0">Teachers can login to see additional resources.</p>
                <?php } ?>
            </div>
        </section>
        <?php } ?>
    </main>

    <?php curriculum_render_footer(); ?>
</body>
</html>
