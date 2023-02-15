<?php
session_start();
    require_once"../../connectFiles/connect_cis.php";
    require_once"cas-go.php";
    require_once"teachers.php";
    $localpath=getenv("SCRIPT_NAME");
    $absolutepath=realpath($localPath);
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


<?php include_once("content/styles_and_scripts.html"); ?>
</head>
<body>

    

<?php require_once("content/header-short.php"); ?>
<?php
echo "LP: $localpath, AP: $absolutepath" 
?>
<div class="container-md pt-4">
    <h2> Levels and Courses </h2>
    <?php
    $query = $elc_db->prepare("Select Levels.level_id, Levels.level_name from Levels where active=1 order by level_order ASC");
    $query->execute();
    $result = $query->get_result();
    while ($levels = $result->fetch_assoc()) {
        echo "<div class='container-md mb-3 pt-2 bg-light border border-primary'>";
        echo "<div class='row m-1'><a class='col text-center btn btn-primary' href='level-edit.php?level_id=".$levels['level_id']."'><i class='bi bi-pencil-square'></i> ".$levels['level_name']."</a></div>";
        $course_query = "Select Courses.course_id, Courses.course_name,Courses.course_short_name, Courses.level_id from Courses where Courses.level_id=".$levels['level_id']." order by course_order ASC";      
        if (!$course_result = $elc_db->query($course_query)) {
            die('There was an error running the query [' . $elc_db->error . ']');
        }
        echo "<div class='row m-1 p-0 justify-content-between' id=''>";
        while ($courses = $course_result->fetch_assoc()) {
            echo "<div class='col p-1'> <div class='list-group'><a class='text-center list-group-item list-group-item-action active' id='course-".$courses['course_id']."' data-shortName='".$courses['course_short_name']."' data-name='".$courses['course_name']."' title='".$courses['course_name']."' href='editors/course-edit.php?course_id=".$courses['course_id']."'><i class='bi bi-pencil-square'></i> ".$courses['course_name']."</a>";
            $learningExperienceQuery = $elc_db->prepare("Select *, LE_courses.course_id from Learning_experiences inner join LE_courses on Learning_experiences.learning_experience_id = LE_courses.learning_experience_id where LE_courses.course_id=? order by name ASC");
            $learningExperienceQuery->bind_param("s", $courses['course_id']);
            $learningExperienceQuery->execute();
            $learningExperienceResult = $learningExperienceQuery->get_result();
            // echo "<div class='row'><div class='col'><div class='list-group'>";
            while ($le = $learningExperienceResult->fetch_assoc()) {
                echo "<a class='list-group-item list-group-item-action' href='editors/le-edit.php?learningExperienceId=".$le['learning_experience_id']."'><i class='bi bi-pencil-square'></i> ".$le['name']."</a>";
            }
            echo "<a id='new_le' class='list-group-item bg-info' href='editors/le-edit.php?learningExperienceId=new'><i class='bi bi-plus'></i> Learning
            Experience<a>";
            echo "</div></div>";
        }
        echo "</div></div>";
        
    }
    
        $result->free();
      
if (phpCAS::getUser() == "blm39"|| 'karimay') {
    ?>
            <div class="block">
                <h2> Review Submitted Changes </h2>
                <?php


        $review_query = $elc_db->prepare("Select *, Levels.level_name from Courses_review inner join Levels on Courses_review.level_id=Levels.level_id where needs_review = 1");
        // $review_query = $elc_db->prepare("Select * from Courses_review where needs_review = 1");
        $review_query->execute();
        $result = $review_query->get_result();
      while ($Courses_review = $result->fetch_assoc()) {
      echo "<a href='review-edits.php?course_id=".$Courses_review['course_id']."'>".$Courses_review['level_name']." - ".$Courses_review['course_name']."</a><br />";
      }

        $review_level_query = $elc_db->prepare("Select * from Levels_review where needs_review = 1");
        $review_level_query->execute();
        $review_level_query_results = $review_level_query->get_result();

      while ($level_review = $review_level_query_results->fetch_assoc()) {
      echo "<a href='review-level-edits.php?level_id=".$level_review['level_id']."'>".$level_review['level_name']."</a><br />";
      }

}

?>
            </div>
        </div>


</div>
<footer>
        <?php include("content/footer.html"); ?>
    </footer>

</body>
</html>