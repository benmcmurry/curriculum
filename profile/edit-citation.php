<?php

session_start();
include_once("../../connectFiles/connect_cis.php");
include_once("cas-go.php");
include_once("teachers.php");

$id=$_POST['id'];
$citation = $_POST['citation'];
$year = $_POST['year'];
$authors = $_POST['authors'];
$type = $_POST['type'];


echo "<script>console.log('it does not exist!');</script>";
$query = $elc_db->prepare("UPDATE Citations SET citation = ? , year = ?, authors = ?, type = ? WHERE id = ? ");
$query->bind_param("sssss", $citation, $year, $authors, $type, $id);
$query->execute();
$result = $query->get_result();

		echo "Saved ".date('l jS \of F Y h:i:s A').".";
		echo "<Script>close_popup();</script>";









?>
