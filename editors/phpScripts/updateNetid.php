<?php
include_once((getenv('APP_PRIVATE_ROOT') ? rtrim(trim((string) getenv('APP_PRIVATE_ROOT')), '/') : dirname(__DIR__, 4) . '/private-config') . '/connectFiles/connect_cis.php');

include_once("../../auth.php");
$id = $_POST['id'];
$net_id = $_POST['net_id'];

$query = $elc_db->prepare("Update User_access set net_id = ? where id = ?");
$query->bind_param("ss", $net_id, $id);
$query->execute();
$result = $query->get_result();
echo "Netid Updated!"





?>
