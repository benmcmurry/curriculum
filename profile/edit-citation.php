<?php
		include_once("../CASauthinator.php");

include_once("../../../connectFiles/connect_cis.php");
$id=$_POST['id'];
$citation =$db->real_escape_string($_POST['citation']);
$year = $_POST['year'];
$authors = $_POST['authors'];
$type = $_POST['type'];


echo "<script>console.log('it does not exist!');</script>";
$query = "UPDATE Citations SET citation='$citation', year='$year', authors='$authors', type='$type' WHERE id='$id'";
	if(!$results = $db->query($query)){
	die('There was an error running the query [' . $db->error . ']');
	}
	else {
		echo "Saved ".date('l jS \of F Y h:i:s A').".";
		echo "<Script>close_popup();</script>";

	}








?>
