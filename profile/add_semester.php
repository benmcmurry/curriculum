<?php
		// include_once("../CASauthinator.php");

include_once("../../../connectFiles/connect_cis.php");



$query = $db->prepare("insert into Statistics (semester) values('0000')");
$query->execute();
$result = $query->get_result();
		echo "<script>location.reload(true);</script>";









?>
