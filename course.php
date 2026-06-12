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
    <?php include("content/header.php"); ?>

    <?php
    $query = $elc_db->prepare("Select *, Levels.level_name, Skill_areas.skill_area_philosophy from Courses inner join Levels on Courses.level_id=Levels.level_id inner join Skill_areas on Courses.skill_area=Skill_areas.id where course_id=?");
    $query->bind_param('s', $course_id);
    $query->execute();
    $result = $query->get_result();
    $course = $result->fetch_assoc();
    ?>

    <div id="title" class="container-fluid"><?php echo $course['level_name']." - ".$course['course_name']; ?></div>

    <main class="container-md portfolio-main">
        <section class="portfolio-card mb-4">
            <div class="portfolio-card-header-course d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">Course Overview</h2>
                <a class="pdf_icon" title="Save Course information" href="print_pdf_course.php?print_id=<?php echo $course['course_id']; ?>"></a>
            </div>
            <div class="portfolio-card-body">
                <?php if ($course['active'] == 0) { ?>
                    <div class="alert alert-warning mb-0" role="alert">This course is currently inactive.</div>
                <?php } ?>
                <h3 class="h6 mt-0 mb-2">Course Description</h3>
                <p><?php echo $course['course_description']; ?></p>

                <h3 class="h6 mb-2">Course Emphasis</h3>
                <p><?php echo $course['course_emphasis']; ?></p>

                <h3 class="h6 mb-2">Course Books and Materials</h3>
                <p><?php echo $course['course_materials']; ?></p>
            </div>
        </section>

        <?php if ($course['active'] == 1) { ?>
        <section class="portfolio-card mb-4">
            <div class="portfolio-card-header-course">
                <h2 class="h5 mb-0">Course Learning Outcomes</h2>
            </div>
            <div class="portfolio-card-body">
                <?php echo $course['learning_outcomes']; ?>
            </div>
        </section>

        <section class="portfolio-card mb-4">
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
                $grammar = true;
                $speaking = true;
                $listening = true;
                $reading = true;
                $writing = true;
                $pronunciation = true;
                $vocabulary = true;
                $none = true;
                $listening_and_reading = true;
                echo "<ol>";
                while($le = $resultLe->fetch_assoc()){
                    if ($le['emphasis'] == "Speaking" && $speaking) {echo "</ol><h4>Speaking</h4><ol>"; $speaking=false;}
                    if ($le['emphasis'] == "Listening" && $listening) {echo "</ol><h4>Listening</h4><ol>"; $listening=false;}
                    if ($le['emphasis'] == "Pronunciation" && $pronunciation) {echo "</ol><h4>Pronunciation</h4><ol>"; $pronunciation=false;}
                    if ($le['emphasis'] == "Grammar" && $grammar) {echo "</ol><h4>Grammar</h4><ol>"; $grammar=false;}
                    if ($le['emphasis'] == "Reading" && $reading) {echo "</ol><h4>Reading</h4><ol>"; $reading=false;}
                    if ($le['emphasis'] == "Writing" && $writing) {echo "</ol><h4>Writing</h4><ol>"; $writing=false;}
                    if ($le['emphasis'] == "Vocabulary" && $vocabulary) {echo "</ol><h4>Vocabulary</h4><ol>"; $vocabulary=false;}
                    if ($le['emphasis'] == "None Specified" && $none) {echo "</ol><h4>None Specified</h4><ol>"; $none=false;}
                    if ($le['emphasis'] == "Listening and Reading" && $listening_and_reading) {echo "</ol><h4>Listening and Reading</h4><ol>"; $listening_and_reading=false;}

                    $le['short_description'] = strip_tags($le['short_description']);
                    $nameSplit = explode(". ", $le['name']);
                    if (isset($nameSplit[1])) {
                        $le['name'] = $nameSplit[1];
                    }
                    echo "<li><a class='le_link' href='learning_experience.php?id=".$le['learning_experience_id']."'>".$le['name']."</a>. ".$le['short_description']."</li><br />";
                }
                echo "</ol>";
                ?>
            </div>
        </section>

        <section class="portfolio-card mb-4">
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

    <footer>
        <?php include("content/footer.html"); ?>
    </footer>
</body>
</html>
