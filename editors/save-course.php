<?php
include_once("../../../connectFiles/connect_cis.php");
$course_id = $_POST['course_id'];
$net_id = $_POST['net_id'];
$course_name = $_POST['course_name'];
$course_short_name = $db ->real_escape_string($_POST['course_short_name']);
$course_description = $db ->real_escape_string($_POST['course_description']);
$course_emphasis = $db ->real_escape_string($_POST['course_emphasis']);
$course_materials = $db ->real_escape_string($_POST['course_materials']);
$learning_outcomes = $db ->real_escape_string($_POST['learning_outcomes']);
$assessment = $db ->real_escape_string($_POST['assessment']);
$learning_experiences = $db ->real_escape_string($_POST['learning_experiences']);
$google_drive_folder_id = $_POST['google_drive_folder_id'];
$needs_review = $_POST['needs_review'];


$query = "UPDATE Courses_Review SET needs_review='$needs_review', course_name='$course_name', course_short_name='$course_short_name',course_description='$course_description', course_emphasis='$course_emphasis',course_materials='$course_materials', learning_outcomes ='$learning_outcomes', assessment='$assessment', learning_experiences='$learning_experiences', updated_by='$net_id', google_drive_folder_id='$google_drive_folder_id' WHERE course_id=$course_id";
		if(!$result = $db->query($query)){
			die('There was an error running the query [' . $db->error . ']');
		}
		else {
			echo "Saved ".date('l jS \of F Y h:i:s A').".";
		}
if ($needs_review == 0) {
	$query_final = "UPDATE Courses SET course_name='$course_name', course_short_name='$course_short_name',course_description='$course_description', course_emphasis='$course_emphasis',course_materials='$course_materials', learning_outcomes ='$learning_outcomes', assessment='$assessment', learning_experiences='$learning_experiences', updated_by='$net_id', google_drive_folder_id='$google_drive_folder_id' WHERE course_id=$course_id";
			if(!$result_final = $db->query($query_final)){
				die('There was an error running the query [' . $db->error . ']');
			}
			else {
				
			}


}


$query_backup = "Insert into Courses_backup (course_id, course_name, course_short_name,course_description, course_emphasis,course_materials, learning_outcomes, assessment, learning_experiences, google_drive_folder_id, updated_on, updated_by) Values ('$course_id','$course_name','$course_short_name','$course_description','$course_emphasis','$course_materials','$learning_outcomes','$assessment','$learning_experiences','$google_drive_folder_id', now(), '$net_id' )";
if(!$result_backup = $db->query($query_backup)){
			die('There was an error running the query [' . $db->error . ']');
		}

?>
