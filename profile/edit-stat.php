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

$stat_id=$_POST['stat_id'];
$stat_field = $_POST['field'];
$stat_value = $_POST['value'];

if ($stat_field == "semester") {
	switch($stat_value) {
		case "Fall":
			$stat_value = "3Fall";
			break;
		Case "Summer":
		$stat_value = "2Summer";
		break;
		Case "Winter":
			$stat_value = "1Winter	";
			break;
		default:
			$stat_value = "4".$stat_value;
			break;
		}

}

$query = $db_curriculum->prepare("UPDATE Statistics SET $stat_field = ? WHERE id= ?");
$query->bind_param("ss", $stat_value, $stat_id );
$query->execute();
$result = $query->get_result();

echo "Saved ".date('l jS \of F Y h:i:s A').".";










?>
