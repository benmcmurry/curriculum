<?php
		// include_once("../CASauthinator.php");

include_once("../../../connectFiles/connect_cis.php");
$stat_id=$_POST['stat_id'];
$field = $_POST['field'];
$value = $_POST['value'];

if ($field == "semester") {
	switch($value) {
		case "Fall":
			$value = "3Fall";
			break;
		Case "Summer":
		$value = "2Summer";
		break;
		Case "Winter":
			$value = "1Winter	";
			break;
		default:
			$value = "4".$value;
			break;
		}
	
}

$query = "UPDATE Statistics SET ".$field."='$value' WHERE id='$stat_id'";
	if(!$results = $db->query($query)){
	die('There was an error running the query [' . $db->error . ']');
	}
	else {
		echo "Saved ".date('l jS \of F Y h:i:s A').".";

	}








?>
