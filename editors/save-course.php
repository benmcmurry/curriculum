<?php
include_once("../../../connectFiles/connect_cis.php");
$course_id = $_POST['course_id'];
$net_id =  $_POST['net_id'];
$course_name =  $_POST['course_name'];
$course_short_name =  $_POST['course_short_name'];
$course_description =  $_POST['course_description'];
$course_emphasis =  $_POST['course_emphasis'];
$course_materials =  $_POST['course_materials'];
$learning_outcomes =  $_POST['learning_outcomes'];
$google_drive_folder_id =  $_POST['google_drive_folder_id'];
$needs_review =  $_POST['needs_review'];


$query = $elc_db->prepare("UPDATE Courses_review SET needs_review=?, course_name=?, course_short_name=?, course_description=?, course_emphasis=?, course_materials=?, learning_outcomes=?,  updated_by=?, google_drive_folder_id=? WHERE course_id=?");
$query->bind_param("ssssssssss", $needs_review, $course_name, $course_short_name, $course_description, $course_emphasis, $course_materials, $learning_outcomes, $net_id, $google_drive_folder_id, $course_id);
$query->execute();
$result = $query->get_result();


			echo "Saved ".date('l jS \of F Y h:i:s A').".";

if ($needs_review == 0) {
	$query_final = $elc_db->prepare("UPDATE Courses SET course_name=?, course_short_name=?,course_description=?, course_emphasis=?,course_materials=?, learning_outcomes =?, updated_by=?, google_drive_folder_id=? WHERE course_id=?");
	$query_final->bind_param("sssssssss", $course_name, $course_short_name, $course_description, $course_emphasis, $course_materials, $learning_outcomes, $net_id, $google_drive_folder_id, $course_id);
	$query_final->execute();
	$result_final = $query_final->get_result();



}


$query_backup = $elc_db->prepare("Insert into Courses_backup (course_id, course_name, course_short_name,course_description, course_emphasis,course_materials, learning_outcomes, google_drive_folder_id, updated_on, updated_by) Values (?,?,?,?,?,?,?,?,?,?, now(), ? )");
$query_backup->bind_param("sssssssss", $course_name, $course_short_name, $course_description, $course_emphasis, $course_materials, $learning_outcomes, $net_id, $google_drive_folder_id, $course_id);
$query_backup->execute();
$result_backup = $query_backup->get_result();

?>
