<?php


include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 3) . '/private-config') . '/connectFiles/connect_cis.php');
// if ($local == 0) {
    include_once("../../../../auth.php");
    include_once("admins.php");

    // $net_id = Authenticator::getUser();
// } else {
    $net_id = "blm39";
// }
if ($net_id == 'blm39') {echo "cleared!";}
else {exit();}



$query = $elc_db->prepare("insert into Statistics (year) values('9999')");
$query->execute();
$result = $query->get_result();
		echo "<script>location.reload();</script>";









?>
