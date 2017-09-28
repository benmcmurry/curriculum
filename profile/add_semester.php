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



$query = $database_curriculum->prepare("insert into Statistics (semester) values('0000')");
$query->execute();
$result = $query->get_result();
		echo "<script>location.reload(true);</script>";









?>
