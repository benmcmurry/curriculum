<?php
include_once("../../../connectFiles/connect_cis.php");
$learningExperienceId = $_POST['learningExperienceId'];
$net_id =  $_POST['net_id'];
$learningExperienceId =  $_POST['learningExperienceId'];
$courseId = $_POST['id'];
$action =  $_POST['action'];

if ($action=="add") {
$query_backup = $elc_db->prepare("Insert into LE_Courses (learning_experience_id, course_id) Values (?,?)");
$query_backup->bind_param("ss", $learningExperienceId, $courseId);
$query_backup->execute();
$result_backup = $query_backup->get_result();
echo "added ".date('l jS \of F Y h:i:s A').".";
}

if ($action=="remove") {
    $query_backup = $elc_db->prepare("Delete from LE_Courses where learning_experience_id=? and course_id=?");
    $query_backup->bind_param("ss", $learningExperienceId, $courseId);
    $query_backup->execute();
    $result_backup = $query_backup->get_result();
    echo "removed ".date('l jS \of F Y h:i:s A').".";
    
}

