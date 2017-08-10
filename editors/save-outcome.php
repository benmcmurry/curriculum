<?php
include_once("../../../connectFiles/connect_cis.php");
$course_id = $_POST['course_id'];
$learning_outcomes = $_POST['learning_outcomes'];

$learning_outcomes = $db ->real_escape_string($learning_outcomes);


$query = "UPDATE Courses SET learning_outcomes ='$learning_outcomes' WHERE course_id=$course_id";
		if(!$result = $db->query($query)){
			die('There was an error running the query [' . $db->error . ']');
		} 
		else {
			echo "Saved ".date('l jS \of F Y h:i:s A').".";
		}




?>