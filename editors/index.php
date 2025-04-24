<?php
session_start();
    require_once"../../../connectFiles/connect_cis.php";
    require_once"../cas-go.php";
    require_once"../teachers.php";
    
?>

<!DOCTYPE html>
<html lang="">

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



    <?php require_once("../content/header-short.php"); ?>
    <div id="title" class="container-fluid">
        Curriculum Portfolio Editor Menu
    </div>
    <div class="container-md sticky-top pt-5 mb-2">
        <div class="row justify-content-between">
            <div class="btn-group col-3" role="group">
            </div>
            <div class="btn-group col-3" role="group">
                <a type="button" class="btn btn-primary" id="toPortfolio" href="../index.php"><i class="bi bi-back"></i>
                    Back to the Portfolio </a>
            </div>
            <div class="btn-group col-3" role="group">
            </div>

        </div>

    </div>
    <div class="container-md pt-4">

    </div>
    <?php
    $query = $elc_db->prepare("Select Levels.level_id, Levels.level_name from Levels where active=1 order by level_order ASC");
    $query->execute();
    $result = $query->get_result();
    while ($levels = $result->fetch_assoc()) {
        echo "<div class='container-md mb-4 p-2 bg-light '>";
        echo "<div class='row m-1'><div class='col p-2'><a class='w-100 text-center btn btn-primary' href='level-edit.php?level_id=".$levels['level_id']."'><i class='bi bi-pencil-square'></i> ".$levels['level_name']."</a></div></div>";
        $course_query = "Select Courses.course_id, Courses.course_name,Courses.course_short_name, Courses.level_id from Courses where Courses.level_id=".$levels['level_id']." order by course_order ASC";      
        if (!$course_result = $elc_db->query($course_query)) {
            die('There was an error running the query [' . $elc_db->error . ']');
        }
        echo "<div class='row m-1 justify-content-between' id=''>";
        while ($courses = $course_result->fetch_assoc()) {
            echo "<div class='col p-2'>";
            echo "<a class='btn btn-primary mb-2 w-100' id='course-".$courses['course_id']."' data-shortName='".$courses['course_short_name']."' data-name='".$courses['course_name']."' title='".$courses['course_name']."' href='course-edit.php?course_id=".$courses['course_id']."'><i class='bi bi-pencil-square'></i> ".$courses['course_name']."</a>";
            $learningExperienceQuery = $elc_db->prepare("Select *, LE_courses.course_id from Learning_experiences inner join LE_courses on Learning_experiences.learning_experience_id = LE_courses.learning_experience_id where LE_courses.course_id=? order by name ASC");
            $learningExperienceQuery->bind_param("s", $courses['course_id']);
            $learningExperienceQuery->execute();
            $learningExperienceResult = $learningExperienceQuery->get_result();
           ?>
         <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Learning Experiences
            </button>
            <ul class="dropdown-menu">
            <?php
                while ($le = $learningExperienceResult->fetch_assoc()) {
                    echo "<li><a class='dropdown-item' href='le-edit.php?learningExperienceId=".$le['learning_experience_id']."'><i class='bi bi-pencil-square'></i> ".$le['name']."</a></li>";
                }
                echo "<li><a id='new_le' class='dropdown-item' href='le-edit.php?learningExperienceId=new'><i class='bi bi-plus'></i> Learning Experience<a></li>";
            echo "</ul></div></div>";
        }
        echo "</div></div>";
        
    }
    
        $result->free();
      
if (phpCAS::getUser() == "blm39"|| 'karimay') {
    ?>
            <div class="container-md pt-4">

            <h2> Review Submitted Changes </h2>
            <?php


        $review_query = $elc_db->prepare("Select *, Levels.level_name from Courses_review inner join Levels on Courses_review.level_id=Levels.level_id where needs_review = 1");
        // $review_query = $elc_db->prepare("Select * from Courses_review where needs_review = 1");
        $review_query->execute();
        $result = $review_query->get_result();
      while ($Courses_review = $result->fetch_assoc()) {
      echo "<a href='review-edits.php?course_id=".$Courses_review['course_id']."'><i class='bi bi-card-list'></i> ".$Courses_review['level_name']." - ".$Courses_review['course_name']."</a><br />";
      }

        $review_level_query = $elc_db->prepare("Select * from Levels_review where needs_review = 1");
        $review_level_query->execute();
        $review_level_query_results = $review_level_query->get_result();

      while ($level_review = $review_level_query_results->fetch_assoc()) {
      echo "<a href='review-level-edits.php?level_id=".$level_review['level_id']."'><i class='bi bi-card-checklist'></i> ".$level_review['level_name']."</a><br />";
      }

}

?>
        </div>
    </div>


    </div>
    <footer>
        <?php include("../content/footer.html"); ?>
    </footer>

</body>

</html>