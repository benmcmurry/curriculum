<?php
session_start();
include_once("../../../connectFiles/connect_cis.php");
include_once("cas-go.php");
include_once("admins.php");


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

$query = $elc_db->prepare("UPDATE Statistics SET $stat_field = ? WHERE id= ?");
$query->bind_param("ss", $stat_value, $stat_id );
$query->execute();
$result = $query->get_result();

echo "Saved ".date('l jS \of F Y h:i:s A').".";










?>
