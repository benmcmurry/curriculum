<?php
		// include_once("../CASauthinator.php");

include_once("../../../connectFiles/connect_cis.php");



$query = "insert into Statistics (semester) values('0000')";
	if(!$results = $db->query($query)){
	die('There was an error running the query [' . $db->error . ']');
	}
	else {
		echo "<script>location.reload(true);</script>";

	}








?>
