<?php
include_once("../../../connectFiles/connect_cis.php");
$course_id = $_POST['course_id'];
$net_id = mysqli_real_escape_string($db, $_POST['net_id']);
$course_name = mysqli_real_escape_string($db, $_POST['course_name']);
$course_short_name = mysqli_real_escape_string($db, $_POST['course_short_name']);
$course_description = mysqli_real_escape_string($db, $_POST['course_description']);
$course_emphasis = mysqli_real_escape_string($db, $_POST['course_emphasis']);
$course_materials = mysqli_real_escape_string($db, $_POST['course_materials']);
$learning_outcomes = mysqli_real_escape_string($db, $_POST['learning_outcomes']);
$assessment = mysqli_real_escape_string($db, $_POST['assessment']);
$learning_experiences = mysqli_real_escape_string($db, $_POST['learning_experiences']);
$google_drive_folder_id = mysqli_real_escape_string($db, $_POST['google_drive_folder_id']);
$needs_review = mysqli_real_escape_string($db, $_POST['needs_review']);


$query = $db->prepare("UPDATE Courses_Review SET needs_review= ?, course_name=?, course_short_name=?,course_description=?, course_emphasis=?,course_materials=?, learning_outcomes =?, assessment=?, learning_experiences=?, updated_by=?, google_drive_folder_id=? WHERE course_id=?");
$query->bind_param("ssssssssssss", $needs_review, $course_name, $course_short_name, $course_description, $course_emphasis, $course_materials, $learning_outcomes, $assessment, $learning_experiences, $net_id, $google_drive_folder_id, $course_id);
$query->execute();
$result = $query->get_result();


			echo "Saved ".date('l jS \of F Y h:i:s A').".";

if ($needs_review == 0) {
	$query_final = $db->prepare("UPDATE Courses SET course_name=?, course_short_name=?,course_description=?, course_emphasis=?,course_materials=?, learning_outcomes =?, assessment=?, learning_experiences=?, updated_by=?, google_drive_folder_id=? WHERE course_id=?");
	$query_final->bind_param("sssssssssss", $course_name, $course_short_name, $course_description, $course_emphasis, $course_materials, $learning_outcomes, $assessment, $learning_experiences, $net_id, $google_drive_folder_id, $course_id);
	$query_final->execute();
	$result_final = $query_final->get_result();



}


$query_backup = $db->prepare("Insert into Courses_backup (course_id, course_name, course_short_name,course_description, course_emphasis,course_materials, learning_outcomes, assessment, learning_experiences, google_drive_folder_id, updated_on, updated_by) Values (?,?,?,?,?,?,?,?,?,?, now(), ? )");
$query_backup->bind_param("sssssssssss", $course_name, $course_short_name, $course_description, $course_emphasis, $course_materials, $learning_outcomes, $assessment, $learning_experiences, $net_id, $google_drive_folder_id, $course_id);
$query_backup->execute();
$result_backup = $query_backup->get_result();

?>
