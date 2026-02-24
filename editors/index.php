<?php
session_start();
    require_once"../../../connectFiles/connect_cis.php";
    require_once"../cas-go.php";
    // require_once"../teachers.php";
    include_once("admins.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Curriculum Portfolio - English Language Center</title>

    <!--    Meta Information -->
    <meta charset="utf-8">
    <meta name="description" content="This section of the ELC website outlines the ELC curriculum." />
    <meta name="keywords" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="robots" content="ELC, BYU, ESL, Curriculum, Levels, Learning, Outcomes" />
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <?php include_once("styles_and_scripts.html"); ?>
</head>

<body>
    <a class="skip-link" href="#main-content">Skip to editor content</a>

    <?php require_once("../content/header-short.php"); 
    if ($message) {
	echo "<div class='container-md pt-4'><div class='alert alert-info' role='status'>".$message."</div></div>";
    
}

if ($auth && $access) { ?>
    <main id="main-content" class="container-md editor-main py-4">
        <h1 class="h3 mb-3">Curriculum Portfolio Editor</h1>
        <p class="mb-4">Select a level, then choose a course or learning experience to edit.</p>

        <?php
        $levelsNav = [];
        $query = $elc_db->prepare("Select Levels.level_id, Levels.level_name from Levels order by level_order ASC");
        $query->execute();
        $result = $query->get_result();
        while ($levelRow = $result->fetch_assoc()) {
            $levelsNav[] = [
                'id' => (int) $levelRow['level_id'],
                'name' => $levelRow['level_name']
            ];
        }
        $result->free();

        $courseCountResult = $elc_db->query("SELECT COUNT(*) AS total_courses FROM Courses");
        $courseCount = $courseCountResult ? (int) $courseCountResult->fetch_assoc()['total_courses'] : 0;
        $levelCount = count($levelsNav);
        $learningExperienceCountResult = $elc_db->query("SELECT COUNT(*) AS total_learning_experiences FROM Learning_experiences");
        $learningExperienceCount = $learningExperienceCountResult ? (int) $learningExperienceCountResult->fetch_assoc()['total_learning_experiences'] : 0;
        ?>
        <section class="editor-topbar sticky-top mb-4" aria-label="Top actions">
            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-outline-secondary" id="toPortfolio" href="../index.php">
                    <i class="bi bi-arrow-return-left"></i> Back to Portfolio
                </a>
                <a class="btn btn-outline-secondary" id="toUsers" href="users.php">
                    <i class="bi bi-table"></i> Access Table
                </a>
                <?php if (phpCAS::getUser() == "blm39") { ?>
                <a class="btn btn-outline-secondary" id="toProfileEditor" href="profile-editor.php">
                    <i class="bi bi-person-gear"></i> Edit Profile
                </a>
                <?php } ?>
            </div>
        </section>

        <section class="mb-4" aria-label="Editor summary">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="admin-card metric-card h-100">
                        <div class="admin-card-body">
                            <div class="metric-label">Levels</div>
                            <div class="metric-value"><?php echo $levelCount; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="admin-card metric-card h-100">
                        <div class="admin-card-body">
                            <div class="metric-label">Courses</div>
                            <div class="metric-value"><?php echo $courseCount; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="admin-card metric-card h-100">
                        <div class="admin-card-body">
                            <div class="metric-label">Learning Experiences</div>
                            <div class="metric-value"><?php echo $learningExperienceCount; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php foreach ($levelsNav as $levelData) {
                    $levelId = (int) $levelData['id'];
                    $levelName = htmlspecialchars($levelData['name'], ENT_QUOTES, 'UTF-8');
            $levelHeadingId = "level-title-" . $levelId;
            echo "<section id='level-".$levelId."' class='editor-level card mb-4' aria-labelledby='".$levelHeadingId."'>";
            echo "<div class='card-header d-flex flex-wrap justify-content-between align-items-center gap-2'>";
            echo "<h2 class='h5 mb-0' id='".$levelHeadingId."'>".$levelName."</h2>";
            echo "<a class='btn btn-outline-secondary btn-sm' href='level-edit.php?level_id=".$levelId."'><i class='bi bi-pencil-square'></i> Edit level</a>";
            echo "</div>";
            echo "<div class='card-body'><div class='row g-3'>";

            $course_query = "Select Courses.course_id, Courses.course_name, Courses.course_short_name, Courses.level_id from Courses where Courses.level_id=".$levelId." order by course_order ASC";
            if (!$course_result = $elc_db->query($course_query)) {
                die('There was an error running the query [' . $elc_db->error . ']');
            }

            while ($courses = $course_result->fetch_assoc()) {
                $courseId = (int) $courses['course_id'];
                $courseName = htmlspecialchars($courses['course_name'], ENT_QUOTES, 'UTF-8');
                $courseShortName = htmlspecialchars((string) $courses['course_short_name'], ENT_QUOTES, 'UTF-8');
                echo "<article class='col-12 col-md-6 col-xl-3'>";
                echo "<div class='admin-card h-100'>";
                echo "<div class='admin-card-header d-flex justify-content-between align-items-center gap-2'>";
                echo "<h3 id='course-".$courseId."' class='h6 mb-0 text-white' data-shortName='".$courseShortName."' data-name='".$courseName."'>".$courseName."</h3>";
                echo "<a class='text-white fs-5' aria-label='Edit course ".$courseName."' title='Edit course ".$courseName."' href='course-edit.php?course_id=".$courseId."'><i class='bi bi-pencil-square'></i></a>";
                echo "</div>";
                echo "<div class='admin-card-body'>";

                $learningExperienceQuery = $elc_db->prepare("Select Learning_experiences.learning_experience_id, Learning_experiences.name from Learning_experiences inner join LE_courses on Learning_experiences.learning_experience_id = LE_courses.learning_experience_id where LE_courses.course_id=? order by name ASC");
                $learningExperienceQuery->bind_param("s", $courses['course_id']);
                $learningExperienceQuery->execute();
                $learningExperienceResult = $learningExperienceQuery->get_result();

                echo "<p class='small fw-semibold mb-2'>Learning experiences</p>";
                $hasLearningExperience = false;
                echo "<ul class='list-group le-list'>";
                while ($le = $learningExperienceResult->fetch_assoc()) {
                    $hasLearningExperience = true;
                    $learningExperienceId = (int) $le['learning_experience_id'];
                    $learningExperienceName = htmlspecialchars($le['name'], ENT_QUOTES, 'UTF-8');
                    echo "<li class='list-group-item py-2'><a href='le-edit.php?learningExperienceId=".$learningExperienceId."'><i class='bi bi-pencil-square'></i> ".$learningExperienceName."</a></li>";
                }
                if (!$hasLearningExperience) {
                    echo "<li class='list-group-item text-muted small'>No learning experiences connected yet.</li>";
                }
                echo "</ul>";
                echo "</div>";
                echo "<div class='admin-card-footer d-grid'>";
                echo "<a class='btn btn-outline-primary btn-sm' href='le-edit.php?learningExperienceId=new&course_id=".$courseId."'><i class='bi bi-plus'></i> Add learning experience</a>";
                echo "</div>";
                echo "</div></article>";
            }
            echo "</div></div></section>";
        } ?>

        <?php if (phpCAS::getUser() == "blm39" || phpCAS::getUser() == "karimay") { ?>
        <section id="review-section" class="pt-2" aria-labelledby="review-heading">
            <h2 id="review-heading" class="h4 mb-3">Review Submitted Changes</h2>
            <ul class="list-group mb-3">
                <?php
                $review_query = $elc_db->prepare("Select *, Levels.level_name from Courses_review inner join Levels on Courses_review.level_id=Levels.level_id where needs_review = 1");
                $review_query->execute();
                $result = $review_query->get_result();
                $hasCourseReviews = false;
                while ($Courses_review = $result->fetch_assoc()) {
                    $hasCourseReviews = true;
                    $courseReviewName = htmlspecialchars($Courses_review['level_name']." - ".$Courses_review['course_name'], ENT_QUOTES, 'UTF-8');
                    echo "<li class='list-group-item'><a href='review-edits.php?course_id=".(int) $Courses_review['course_id']."'><i class='bi bi-card-list'></i> ".$courseReviewName."</a></li>";
                }
                if (!$hasCourseReviews) {
                    echo "<li class='list-group-item text-muted'>No course edit reviews pending.</li>";
                }
                ?>
            </ul>
            <ul class="list-group">
                <?php
                $review_level_query = $elc_db->prepare("Select * from Levels_review where needs_review = 1");
                $review_level_query->execute();
                $review_level_query_results = $review_level_query->get_result();
                $hasLevelReviews = false;
                while ($level_review = $review_level_query_results->fetch_assoc()) {
                    $hasLevelReviews = true;
                    $levelReviewName = htmlspecialchars($level_review['level_name'], ENT_QUOTES, 'UTF-8');
                    echo "<li class='list-group-item'><a href='review-level-edits.php?level_id=".(int) $level_review['level_id']."'><i class='bi bi-card-checklist'></i> ".$levelReviewName."</a></li>";
                }
                if (!$hasLevelReviews) {
                    echo "<li class='list-group-item text-muted'>No level edit reviews pending.</li>";
                }
                ?>
            </ul>
        </section>
        <?php } ?>
    </main>
    <footer>
        <?php include("../content/footer.html"); ?>
    </footer>
 <?php } ?>
</body>

</html>
