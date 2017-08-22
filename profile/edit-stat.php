<?php

include_once("../../../connectFiles/connect_cis.php");
if ($local == 0) {
    include_once("../CASauthinator.php");
    $net_id = Authenticator::getUser();
} else {
    $net_id = "blm39";
}
if ($net_id == 'blm39') {echo "cleared!";}
else {exit();}

$stat_id=mysqli_real_escape_string($db, $_POST['stat_id']);
$field = mysqli_real_escape_string($db, $_POST['field']);
$value = mysqli_real_escape_string($db, $_POST['value']);

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
$query->bind_param("sss", $field, $value, $stat_id );
$query->execute();
$result = $query->get_result();

	if(!$results = $db->query($query)){
	die('There was an error running the query [' . $db->error . ']');
	}
	else {
		echo "Saved ".date('l jS \of F Y h:i:s A').".";

	}








?>
